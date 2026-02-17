<?php

class ApiNewsController extends ApiController
{
    private const BASE_URL = 'https://api.football-data.org/v4/';

    // GET /api/news
    // MODIFICA el método index() para aceptar el modo 'latest'
    public function index(): void
    {
        $this->requireMethod('GET');

        $mode = strtolower(trim($_GET['mode'] ?? 'events'));

        if ($mode === 'leagues') {
            $this->sendLeagues();
            return;
        }

        // NUEVO: Modo para última noticia
        if ($mode === 'latest') {
            $this->latest();
            return;
        }

        $leagueCode = trim($_GET['league'] ?? '');
        $type = strtolower(trim($_GET['type'] ?? 'next'));
        $seasonParam = trim($_GET['season'] ?? '');

        if ($leagueCode === '') {
            $this->fail('Liga requerida', 400);
        }

        $season = is_numeric($seasonParam) ? (int) $seasonParam : $this->defaultSeason();
        $events = $this->fetchLeagueEvents($leagueCode, $season, $type);

        if ($events === null) {
            $this->fail('No se pudieron obtener partidos del proveedor.', 502);
        }

        $this->json(['events' => $events], 200);
    }

    private function sendLeagues(): void
    {
        $season = $this->defaultSeason();

        $leagues = [
            [
                'idLeague' => 'PL',
                'strLeague' => 'Premier League',
                '__key' => 'premier',
                '__label' => 'Premier League',
                'season' => $season,
            ],
            [
                'idLeague' => 'PD',
                'strLeague' => 'La Liga',
                '__key' => 'laliga',
                '__label' => 'La Liga',
                'season' => $season,
            ],
            [
                'idLeague' => 'SA',
                'strLeague' => 'Serie A',
                '__key' => 'seriea',
                '__label' => 'Serie A',
                'season' => $season,
            ],
            [
                'idLeague' => 'BL1',
                'strLeague' => 'Bundesliga',
                '__key' => 'bundesliga',
                '__label' => 'Bundesliga',
                'season' => $season,
            ],
            [
                'idLeague' => 'FL1',
                'strLeague' => 'Ligue 1',
                '__key' => 'ligue1',
                '__label' => 'Ligue 1',
                'season' => $season,
            ],
            [
                'idLeague' => 'CL',
                'strLeague' => 'UEFA Champions League',
                '__key' => 'ucl',
                '__label' => 'Champions League',
                'season' => $season,
            ],
            [
                'idLeague' => 'EL',
                'strLeague' => 'UEFA Europa League',
                '__key' => 'uel',
                '__label' => 'Europa League',
                'season' => $season,
            ],
            [
                'idLeague' => 'UCL',
                'strLeague' => 'UEFA Conference League',
                '__key' => 'uecl',
                '__label' => 'Conference League',
                'season' => $season,
            ],
        ];

        $this->json(['leagues' => $leagues], 200);
    }

    private function fetchLeagueEvents(string $leagueCode, int $season, string $type): ?array
    {
        $payload = $this->fetchApi('competitions/' . rawurlencode($leagueCode) . '/matches', [
            'season' => $season,
        ]);

        if ($payload === null) {
            return null;
        }
        if (!empty($payload['__error'])) {
            $this->fail($payload['__error'], $payload['__status'] ?? 502);
        }

        $competition = $payload['competition'] ?? [];
        $matches = $payload['matches'] ?? [];
        if (!is_array($matches)) {
            return [];
        }

        $events = $this->normalizeMatches($matches, $competition);
        return $this->filterEventsByType($events, $type);
    }

    private function normalizeMatches(array $matches, array $competition): array
    {
        $normalized = [];

        foreach ($matches as $match) {
            if (!is_array($match)) {
                continue;
            }

            $utcDate = $match['utcDate'] ?? '';
            [$date, $time, $timestamp] = $this->parseDateTime($utcDate);
            $home = $match['homeTeam'] ?? [];
            $away = $match['awayTeam'] ?? [];
            $score = $match['score'] ?? [];
            $fullTime = $score['fullTime'] ?? [];

            $homeName = $home['name'] ?? '';
            $awayName = $away['name'] ?? '';

            $normalized[] = [
                'id' => $match['id'] ?? null,
                'title' => trim($homeName . ' vs ' . $awayName),
                'date' => $date,
                'time' => $time,
                'timestamp' => $timestamp,
                'venue' => $match['venue'] ?? '',
                'home' => $homeName,
                'away' => $awayName,
                'homeLogo' => $home['crest'] ?? '',
                'awayLogo' => $away['crest'] ?? '',
                'scoreHome' => array_key_exists('home', $fullTime) ? $fullTime['home'] : null,
                'scoreAway' => array_key_exists('away', $fullTime) ? $fullTime['away'] : null,
                'league' => $competition['name'] ?? '',
                'leagueLogo' => $competition['emblem'] ?? '',
                'status' => $match['status'] ?? '',
            ];
        }

        return $normalized;
    }

    private function filterEventsByType(array $events, string $type): array
    {
        $now = time();
        $filtered = array_filter($events, function (array $event) use ($type, $now) {
            $timestamp = $event['timestamp'];
            if ($timestamp === null) {
                $date = $event['date'] ?? '';
                $timestamp = $date ? strtotime($date . ' 00:00:00') : null;
            }

            if ($timestamp === null) {
                return false;
            }

            return $type === 'past' ? $timestamp <= $now : $timestamp >= $now;
        });

        $filtered = array_values($filtered);
        usort($filtered, function (array $a, array $b) {
            return ($a['timestamp'] ?? 0) <=> ($b['timestamp'] ?? 0);
        });

        if ($type === 'past') {
            $filtered = array_reverse($filtered);
        }

        return $filtered;
    }

    private function parseDateTime(string $date): array
    {
        if ($date === '') {
            return ['', '', null];
        }

        try {
            $dt = new DateTimeImmutable($date);
            return [$dt->format('Y-m-d'), $dt->format('H:i'), $dt->getTimestamp()];
        } catch (Exception $e) {
            return [substr($date, 0, 10), '', null];
        }
    }

    private function defaultSeason(): int
    {
        $year = (int) date('Y');
        $month = (int) date('n');
        return $month >= 7 ? $year : $year - 1;
    }

    private function fetchApi(string $endpoint, array $params = []): ?array
    {
        $token = $this->env('FOOTBALL_DATA_TOKEN');
        if (!$token) {
            $this->fail('Configura FOOTBALL_DATA_TOKEN en el .env.', 500);
        }

        $query = $params ? '?' . http_build_query($params) : '';
        $url = self::BASE_URL . ltrim($endpoint, '/') . $query;

        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'timeout' => 12,
                'ignore_errors' => true,
                'header' => implode("\r\n", [
                    'User-Agent: SoccerFlow/1.0',
                    'Accept: application/json',
                    'X-Auth-Token: ' . $token,
                ]) . "\r\n",
            ]
        ]);

        $response = @file_get_contents($url, false, $context);
        $statusCode = $this->extractStatusCode($http_response_header ?? []);

        if ($response === false) {
            return [
                '__error' => 'No se pudo conectar con el proveedor.',
                '__status' => $statusCode ?: 502,
            ];
        }

        $data = json_decode($response, true);
        if (!is_array($data)) {
            return [
                '__error' => 'Respuesta inválida del proveedor.',
                '__status' => $statusCode ?: 502,
            ];
        }

        if ($statusCode >= 400) {
            $message = $data['message'] ?? $data['error'] ?? 'Error del proveedor.';
            return [
                '__error' => $message,
                '__status' => $statusCode,
            ];
        }

        return $data;
    }

    private function extractStatusCode(array $headers): int
    {
        $first = $headers[0] ?? '';
        if ($first && preg_match('/\\s(\\d{3})\\s/', $first, $matches)) {
            return (int) $matches[1];
        }

        return 0;
    }

    public function latest(): void
    {
        $this->requireMethod('GET');

        $league = trim($_GET['league'] ?? '');
        if ($league === '') {
            $this->json(['success' => false, 'error' => 'Liga requerida'], 400);
            return;
        }

        $token = $this->env('FOOTBALL_DATA_TOKEN');
        if (!$token) {
            $this->json(['success' => false, 'error' => 'Token no configurado'], 500);
            return;
        }

        try {
            // PRIMERO: Intentar obtener TODOS los partidos FINALIZADOS de la temporada actual
            $season = $this->defaultSeason();
            $url = "https://api.football-data.org/v4/competitions/{$league}/matches?status=FINISHED&season={$season}";

            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'timeout' => 8,
                    'header' => implode("\r\n", [
                        'User-Agent: SoccerFlow/1.0',
                        'Accept: application/json',
                        'X-Auth-Token: ' . $token,
                    ]) . "\r\n",
                ]
            ]);

            $response = @file_get_contents($url, false, $context);

            if ($response !== false) {
                $data = json_decode($response, true);
                $matches = $data['matches'] ?? [];

                if (!empty($matches)) {
                    // ORDENAR POR FECHA DESCENDENTE (más reciente primero)
                    usort($matches, function ($a, $b) {
                        return strtotime($b['utcDate'] ?? '') - strtotime($a['utcDate'] ?? '');
                    });

                    // Tomar el PRIMERO (más reciente)
                    $match = $matches[0];
                    $home = $match['homeTeam'] ?? [];
                    $away = $match['awayTeam'] ?? [];
                    $score = $match['score'] ?? [];
                    $fullTime = $score['fullTime'] ?? [];
                    $competition = $data['competition'] ?? [];

                    $this->json([
                        'success' => true,
                        'match' => [
                            'title' => ($home['name'] ?? 'Local') . ' vs ' . ($away['name'] ?? 'Visitante'),
                            'date' => substr($match['utcDate'] ?? '', 0, 10),
                            'time' => substr($match['utcDate'] ?? '', 11, 5),
                            'home' => $home['name'] ?? 'Local',
                            'away' => $away['name'] ?? 'Visitante',
                            'homeLogo' => $home['crest'] ?? '',
                            'awayLogo' => $away['crest'] ?? '',
                            'scoreHome' => $fullTime['home'] ?? null,
                            'scoreAway' => $fullTime['away'] ?? null,
                            'venue' => $match['venue'] ?? '',
                            'league' => $competition['name'] ?? '',
                            'leagueCode' => $league,
                            'status' => $match['status'] ?? 'FINISHED',
                            'season' => $season,
                            'matchday' => $match['matchday'] ?? null
                        ]
                    ], 200);
                    return;
                }
            }

            // SEGUNDO: Si no hay finalizados, intentar con el PRÓXIMO PARTIDO
            $url = "https://api.football-data.org/v4/competitions/{$league}/matches?status=SCHEDULED&season={$season}&limit=1";
            $response = @file_get_contents($url, false, $context);

            if ($response !== false) {
                $data = json_decode($response, true);
                $matches = $data['matches'] ?? [];

                if (!empty($matches)) {
                    // ORDENAR POR FECHA ASCENDENTE (más próximo primero)
                    usort($matches, function ($a, $b) {
                        return strtotime($a['utcDate'] ?? '') - strtotime($b['utcDate'] ?? '');
                    });

                    $match = $matches[0];
                    $home = $match['homeTeam'] ?? [];
                    $away = $match['awayTeam'] ?? [];
                    $competition = $data['competition'] ?? [];

                    $this->json([
                        'success' => true,
                        'match' => [
                            'title' => ($home['name'] ?? 'Local') . ' vs ' . ($away['name'] ?? 'Visitante'),
                            'date' => substr($match['utcDate'] ?? '', 0, 10),
                            'time' => substr($match['utcDate'] ?? '', 11, 5),
                            'home' => $home['name'] ?? 'Local',
                            'away' => $away['name'] ?? 'Visitante',
                            'homeLogo' => $home['crest'] ?? '',
                            'awayLogo' => $away['crest'] ?? '',
                            'scoreHome' => null,
                            'scoreAway' => null,
                            'venue' => $match['venue'] ?? '',
                            'league' => $competition['name'] ?? '',
                            'leagueCode' => $league,
                            'status' => $match['status'] ?? 'SCHEDULED',
                            'season' => $season,
                            'matchday' => $match['matchday'] ?? null
                        ]
                    ], 200);
                    return;
                }
            }

            // TERCERO: Intentar con la temporada anterior si no hay partidos en la actual
            $season = $this->defaultSeason() - 1;
            $url = "https://api.football-data.org/v4/competitions/{$league}/matches?status=FINISHED&season={$season}&limit=50";
            $response = @file_get_contents($url, false, $context);

            if ($response !== false) {
                $data = json_decode($response, true);
                $matches = $data['matches'] ?? [];

                if (!empty($matches)) {
                    // ORDENAR POR FECHA DESCENDENTE (más reciente primero)
                    usort($matches, function ($a, $b) {
                        return strtotime($b['utcDate'] ?? '') - strtotime($a['utcDate'] ?? '');
                    });

                    $match = $matches[0];
                    $home = $match['homeTeam'] ?? [];
                    $away = $match['awayTeam'] ?? [];
                    $score = $match['score'] ?? [];
                    $fullTime = $score['fullTime'] ?? [];
                    $competition = $data['competition'] ?? [];

                    $this->json([
                        'success' => true,
                        'match' => [
                            'title' => ($home['name'] ?? 'Local') . ' vs ' . ($away['name'] ?? 'Visitante'),
                            'date' => substr($match['utcDate'] ?? '', 0, 10),
                            'time' => substr($match['utcDate'] ?? '', 11, 5),
                            'home' => $home['name'] ?? 'Local',
                            'away' => $away['name'] ?? 'Visitante',
                            'homeLogo' => $home['crest'] ?? '',
                            'awayLogo' => $away['crest'] ?? '',
                            'scoreHome' => $fullTime['home'] ?? null,
                            'scoreAway' => $fullTime['away'] ?? null,
                            'venue' => $match['venue'] ?? '',
                            'league' => $competition['name'] ?? '',
                            'leagueCode' => $league,
                            'status' => $match['status'] ?? 'FINISHED',
                            'season' => $season,
                            'matchday' => $match['matchday'] ?? null
                        ]
                    ], 200);
                    return;
                }
            }

            // Si no hay ningún partido, devolver error 404
            $this->json(['success' => false, 'error' => "No hay partidos disponibles para esta competición"], 404);
        } catch (Exception $e) {
            $this->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
