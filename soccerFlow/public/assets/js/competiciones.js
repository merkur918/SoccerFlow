(() => {
  // El layout puede cargar scripts dos veces; este flag evita listeners duplicados.
  if (window.__competicionesInitialized) return;
  window.__competicionesInitialized = true;

  document.addEventListener("DOMContentLoaded", () => {
    // API pública alternativa:
    // https://www.thesportsdb.com
    // Endpoints usados:
    // - /all_leagues.php
    // - /lookuptable.php?l={idLeague}&s={season}
    // - /search_all_teams.php?l={leagueName}
    const API_BASE = "https://www.thesportsdb.com/api/v1/json/3";
    const QUALIFICATION_RULES = {
      // Reglas simplificadas de plazas europeas + descenso por liga.
      laliga: { ucl: [1, 4], uel: [5, 6], uecl: [7, 7], relegationSlots: 3 },
      premier: { ucl: [1, 4], uel: [5, 6], uecl: [7, 7], relegationSlots: 3 },
      seriea: { ucl: [1, 4], uel: [5, 6], uecl: [7, 7], relegationSlots: 3 },
      bundesliga: { ucl: [1, 4], uel: [5, 6], uecl: [7, 7], relegationSlots: 2 },
      ligue1: { ucl: [1, 3], uel: [4, 5], uecl: [6, 6], relegationSlots: 2 }
    };
    const EUROPEAN_PHASE_RULES = {
      // Formato de liga UEFA: top 8 directo + puestos 9-24 clasifican.
      ucl: { top8: [1, 8], playoff: [9, 24] },
      uel: { top8: [1, 8], playoff: [9, 24] },
      uecl: { top8: [1, 8], playoff: [9, 24] }
    };
    const COMPETITIONS_WHITELIST = [
      { key: "premier", label: "Premier League", patterns: [/premier league/] },
      { key: "laliga", label: "La Liga", patterns: [/spanish la liga/, /\bla liga\b/] },
      { key: "seriea", label: "Serie A", patterns: [/\bserie a\b/] },
      { key: "bundesliga", label: "Bundesliga", patterns: [/bundesliga/] },
      { key: "ligue1", label: "Ligue 1", patterns: [/ligue 1/] },
      { key: "ucl", label: "Champions League", patterns: [/champions league/, /uefa champions/] },
      { key: "uel", label: "Europa League", patterns: [/europa league/, /uefa europa/] },
      {
        key: "uecl",
        label: "Conference League",
        patterns: [/conference league/, /europa conference/, /uefa conference/]
      }
    ];

    const select = document.getElementById("competitionSelect");
    const status = document.getElementById("competitionsStatus");
    const qualificationLegend = document.getElementById("qualificationLegend");
    const qualificationLegendItems = qualificationLegend
      ? Array.from(qualificationLegend.querySelectorAll("[data-legend]"))
      : [];
    const standingsTable = document.getElementById("standingsTable");
    const standingsBody = document.getElementById("standingsBody");
    const teamsGrid = document.getElementById("teamsGrid");

    if (!select || !status || !standingsTable || !standingsBody || !teamsGrid) return;

    let leaguesCache = [];

    // Establecer límite por defecto (5 equipos)
    standingsTable.dataset.limit = "5";

    // Mensajería de estado para feedback visual rápido.
    const setStatus = (message, isError = false) => {
      status.textContent = message;
      status.classList.toggle("home-competitions__status--error", isError);
    };

    const clearStandings = () => {
      standingsBody.innerHTML = "";
      standingsTable.hidden = true;
      if (qualificationLegend) qualificationLegend.hidden = true;
    };

    const clearTeams = () => {
      teamsGrid.innerHTML = "";
    };

    const readNumberStat = (row, keys) => {
      for (const key of keys) {
        if (row?.[key] !== undefined && row?.[key] !== null && row?.[key] !== "") {
          return row[key];
        }
      }
      return "-";
    };

    const toRankNumber = (value) => {
      const n = Number(value);
      return Number.isFinite(n) ? n : null;
    };

    const getQualificationType = (rankNumber, leagueKey) => {
      const rules = QUALIFICATION_RULES[leagueKey];
      if (rankNumber === null) return "";

      if (rules) {
        if (rankNumber >= rules.ucl[0] && rankNumber <= rules.ucl[1]) return "ucl";
        if (rankNumber >= rules.uel[0] && rankNumber <= rules.uel[1]) return "uel";
        if (rankNumber >= rules.uecl[0] && rankNumber <= rules.uecl[1]) return "uecl";
      }

      const euroRules = EUROPEAN_PHASE_RULES[leagueKey];
      if (euroRules) {
        if (rankNumber >= euroRules.top8[0] && rankNumber <= euroRules.top8[1]) return "top8";
        if (rankNumber >= euroRules.playoff[0] && rankNumber <= euroRules.playoff[1]) return "playoff";
      }

      return "";
    };

    const getRelegationType = (rankNumber, leagueKey, totalTeams) => {
      const rules = QUALIFICATION_RULES[leagueKey];
      if (!rules || rankNumber === null) return "";

      const relegationSlots = Number(rules.relegationSlots || 0);
      if (relegationSlots <= 0 || !Number.isFinite(totalTeams)) return "";

      const firstRelegationPos = totalTeams - relegationSlots + 1;
      if (rankNumber >= firstRelegationPos && rankNumber <= totalTeams) return "relegation";

      return "";
    };

    const updateQualificationLegend = (leagueKey) => {
      if (!qualificationLegend) return;
      const domesticRules = QUALIFICATION_RULES[leagueKey];
      const europeanRules = EUROPEAN_PHASE_RULES[leagueKey];

      let visibleKeys = [];
      if (domesticRules) visibleKeys = ["ucl", "uel", "uecl", "relegation"];
      if (europeanRules) visibleKeys = ["top8", "playoff"];

      qualificationLegend.hidden = visibleKeys.length === 0;
      qualificationLegendItems.forEach((item) => {
        const key = item.dataset.legend || "";
        item.hidden = !visibleKeys.includes(key);
      });
    };

    const renderStandings = (rows, teamsMap = new Map(), leagueKey = "") => {
      standingsBody.innerHTML = "";
      updateQualificationLegend(leagueKey);
      
      // Obtener el límite actual del dataset
      const limit = Number(standingsTable?.dataset?.limit || 0);
      const rowsToRender = Number.isFinite(limit) && limit > 0
        ? rows.slice(0, limit)
        : rows;
      
      const totalTeams = Array.isArray(rowsToRender) ? rowsToRender.length : 0;

      rowsToRender.forEach((row) => {
        const tr = document.createElement("tr");
        const rank = readNumberStat(row, ["intRank", "strRank"]);
        const rankNumber = toRankNumber(rank);
        const qualificationType = getQualificationType(rankNumber, leagueKey);
        const relegationType = getRelegationType(rankNumber, leagueKey, totalTeams);
        if (qualificationType) tr.classList.add(`home-competitions__row--${qualificationType}`);
        if (!qualificationType && relegationType) tr.classList.add(`home-competitions__row--${relegationType}`);

        const team = row?.strTeam ?? "Equipo";
        const points = readNumberStat(row, ["intPoints", "strPoints"]);
        const played = readNumberStat(row, ["intPlayed", "intGamesPlayed", "strPlayed"]);
        const won = readNumberStat(row, ["intWin", "intWins", "strWin"]);
        const draw = readNumberStat(row, ["intDraw", "intDraws", "strDraw"]);
        const loss = readNumberStat(row, ["intLoss", "intLosses", "strLoss"]);
        const teamDetails = teamsMap.get(normalizeTeamName(team)) || {};
        const badge =
          teamDetails?.strBadge ||
          teamDetails?.strTeamBadge ||
          row?.strBadge ||
          row?.strTeamBadge ||
          "/assets/img/logo.png";

        tr.innerHTML = `
          <td>${rank}</td>
          <td>
            <div class="home-competitions__team-cell">
              <img class="home-competitions__table-badge" src="${badge}" alt="Escudo de ${team}" loading="lazy">
              <span>${team}</span>
            </div>
          </td>
          <td>${points}</td>
          <td>${played}</td>
          <td>${won}</td>
          <td>${draw}</td>
          <td>${loss}</td>
        `;

        standingsBody.appendChild(tr);
      });

      standingsTable.hidden = false;
    };

    const normalizeTeamName = (value) =>
      (value || "")
        .toLowerCase()
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .replace(/[^a-z0-9]/g, "");

    const renderTeams = (rankedTeams) => {
      clearTeams();

      rankedTeams.forEach((entry) => {
        const team = entry.teamDetails;
        const card = document.createElement("article");
        card.className = "home-competitions__team-card";

        const rankBadge = document.createElement("span");
        rankBadge.className = "home-competitions__team-rank";
        rankBadge.textContent = `#${entry.rank}`;

        const badge = document.createElement("img");
        badge.className = "home-competitions__team-badge";
        badge.src = team?.strBadge || team?.strTeamBadge || entry?.badge || "/assets/img/logo.png";
        badge.alt = `Escudo de ${entry.teamName ?? "equipo"}`;
        badge.loading = "lazy";

        const name = document.createElement("h3");
        name.className = "home-competitions__team-name";
        name.textContent = entry.teamName || "Equipo";

        const meta = document.createElement("p");
        meta.className = "home-competitions__team-meta";
        meta.textContent = `${team?.strCountry || "País desconocido"} · ${team?.strStadium || "Sin estadio"}`;

        const extra = document.createElement("p");
        extra.className = "home-competitions__team-meta";
        extra.textContent = `Fundado: ${team?.intFormedYear || "N/D"} · Puntos: ${entry.points}`;

        card.appendChild(rankBadge);
        card.appendChild(badge);
        card.appendChild(name);
        card.appendChild(meta);
        card.appendChild(extra);
        teamsGrid.appendChild(card);
      });
    };

    const fetchJson = async (url, errorMessage) => {
      const response = await fetch(url);
      if (!response.ok) throw new Error(errorMessage);
      return response.json();
    };

    const normalizeText = (value) =>
      String(value || "")
        .toLowerCase()
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "");

    const filterAllowedCompetitions = (rawLeagues) => {
      const source = Array.isArray(rawLeagues) ? rawLeagues : [];
      const soccerLeagues = source.filter((league) => league?.strSport === "Soccer" && league?.idLeague);

      // Conservamos orden fijo (5 grandes + UCL + UEL + UECL).
      return COMPETITIONS_WHITELIST.map((wanted) => {
        const found = soccerLeagues.find((league) => {
          const haystack = normalizeText(`${league?.strLeague || ""} ${league?.strLeagueAlternate || ""}`);
          return wanted.patterns.some((pattern) => pattern.test(haystack));
        });

        if (found) {
          return {
            ...found,
            __key: wanted.key,
            __label: wanted.label,
            __selectValue: `league-${found.idLeague}`
          };
        }

        // Si una competición no viene en TheSportsDB, la mantenemos para usar fallback ESPN.
        return {
          idLeague: "",
          strLeague: wanted.label,
          strLeagueAlternate: wanted.label,
          strSport: "Soccer",
          __key: wanted.key,
          __label: wanted.label,
          __fallbackOnly: true,
          __selectValue: `fallback-${wanted.key}`
        };
      });
    };

    // Para algunos torneos, TheSportsDB puede devolver una tabla parcial.
    // Si eso ocurre, intentamos completar con standings públicos de ESPN.
    const detectEspnLeagueCode = (league) => {
      const byKey = {
        laliga: "esp.1",
        premier: "eng.1",
        seriea: "ita.1",
        bundesliga: "ger.1",
        ligue1: "fra.1",
        ucl: "uefa.champions",
        uel: "uefa.europa",
        uecl: "uefa.europa.conf"
      };

      if (league?.__key && byKey[league.__key]) return byKey[league.__key];

      const text = `${league?.strLeague || ""} ${league?.strLeagueAlternate || ""}`.toLowerCase();

      if (text.includes("spanish") && text.includes("liga")) return "esp.1";
      if (text.includes("premier league")) return "eng.1";
      if (text.includes("serie a")) return "ita.1";
      if (text.includes("bundesliga")) return "ger.1";
      if (text.includes("ligue 1")) return "fra.1";

      return null;
    };

    const getEspnStatValue = (entry, names) => {
      const stats = Array.isArray(entry?.stats) ? entry.stats : [];
      const wanted = names.map((value) => value.toLowerCase());

      const stat = stats.find((item) => {
        const name = String(item?.name || "").toLowerCase();
        const abbr = String(item?.abbreviation || "").toLowerCase();
        return wanted.includes(name) || wanted.includes(abbr);
      });

      return stat?.value ?? stat?.displayValue ?? "-";
    };

    const toSportsDbLikeRow = (entry) => {
      const teamName =
        entry?.team?.displayName ||
        entry?.team?.shortDisplayName ||
        entry?.team?.name ||
        "Equipo";
      const espnBadge =
        entry?.team?.logos?.[0]?.href ||
        entry?.team?.logo ||
        "";

      return {
        strTeam: teamName,
        intRank: getEspnStatValue(entry, ["rank", "rk", "position"]),
        intPoints: getEspnStatValue(entry, ["points", "pts"]),
        intPlayed: getEspnStatValue(entry, ["gamesplayed", "played", "p", "gp"]),
        intWin: getEspnStatValue(entry, ["wins", "w"]),
        intDraw: getEspnStatValue(entry, ["ties", "draws", "d"]),
        intLoss: getEspnStatValue(entry, ["losses", "l"]),
        strBadge: espnBadge
      };
    };

    const fetchEspnStandings = async (leagueCode) => {
      if (!leagueCode) return [];

      const urls = [
        `https://site.api.espn.com/apis/site/v2/sports/soccer/${leagueCode}/standings`,
        `https://site.api.espn.com/apis/v2/sports/soccer/${leagueCode}/standings`
      ];

      for (const url of urls) {
        try {
          const payload = await fetchJson(url, "No se pudo cargar ranking alternativo.");
          const entries =
            payload?.children?.[0]?.standings?.entries ||
            payload?.standings?.entries ||
            [];

          if (Array.isArray(entries) && entries.length > 0) {
            return entries.map(toSportsDbLikeRow);
          }
        } catch (error) {
          // Intentamos el siguiente endpoint sin romper el flujo principal.
        }
      }

      return [];
    };

    const sortRowsByRank = (rows) => {
      const toNumber = (value) => {
        const n = Number(value);
        return Number.isFinite(n) ? n : 9999;
      };

      return [...rows].sort((a, b) => {
        const rankA = readNumberStat(a, ["intRank", "strRank"]);
        const rankB = readNumberStat(b, ["intRank", "strRank"]);
        return toNumber(rankA) - toNumber(rankB);
      });
    };

    // Formato de temporada tipo "2025-2026".
    const getCurrentSeason = () => {
      const now = new Date();
      const year = now.getFullYear();
      const month = now.getMonth() + 1;
      const startYear = month >= 7 ? year : year - 1;
      return `${startYear}-${startYear + 1}`;
    };

    const getPreviousSeason = () => {
      const current = getCurrentSeason();
      const start = parseInt(current.split("-")[0], 10);
      return `${start - 1}-${start}`;
    };

    const findDefaultSpanishLeague = () => {
      const byKey = leaguesCache.find((league) => league?.__key === "laliga");
      if (byKey) return byKey;

      const exact = leaguesCache.find((league) => league?.strLeague === "Spanish La Liga");
      if (exact) return exact;

      const byText = leaguesCache.find((league) => {
        const name = (league?.strLeague || "").toLowerCase();
        const alt = (league?.strLeagueAlternate || "").toLowerCase();
        return (
          (name.includes("spanish") && name.includes("liga")) ||
          alt.includes("la liga")
        );
      });

      return byText || leaguesCache[0] || null;
    };

   // ============ FUNCIONES DE NOTICIAS - SOLO API REAL ============

// Carga la última noticia de una competición - SIEMPRE DESDE LA API
const loadLatestNews = async (competitionKey) => {
    try {
        // Mapeo de keys a códigos de competición para Football-Data.org
        const competitionCodes = {
            'laliga': 'PD',
            'premier': 'PL',
            'seriea': 'SA',
            'bundesliga': 'BL1',
            'ligue1': 'FL1',
            'ucl': 'CL',
            'uel': 'EL',
            'uecl': 'UCL'
        };

        const code = competitionCodes[competitionKey];
        if (!code) {
            console.error('Código de competición no encontrado:', competitionKey);
            return;
        }

        // Mostrar estado de carga
        showNewsLoading();

        // Llamar a nuestra API para obtener el último partido REAL
        const response = await fetch(`/api/news?mode=latest&league=${code}&ts=${Date.now()}`);
        const data = await response.json();
        
        if (data.success && data.match) {
            // Tenemos datos REALES de la API
            updateNewsCard(data.match);
            console.log(`Noticia cargada: ${data.match.league} - ${data.match.home} vs ${data.match.away}`);
        } else {
            // La API devolvió error pero no tenemos placeholder
            console.error('No hay datos disponibles de la API:', data.error);
            showNewsError(`No hay partidos disponibles para esta competición`);
        }
    } catch (error) {
        console.error('Error cargando noticia desde API:', error);
        showNewsError('Error al cargar los datos. Inténtalo de nuevo.');
    }
};

// Muestra estado de carga en la tarjeta de noticias
const showNewsLoading = () => {
    const newsContent = document.getElementById('homeNewsContent');
    if (!newsContent) return;
    
    newsContent.innerHTML = `
        <div class="news__image-wrap news__image-wrap--teams">
            <div class="news__team">
                <img class="news__team-logo" src="/assets/img/logo.png" alt="Cargando..." loading="lazy">
                <span class="news__team-name">Cargando...</span>
            </div>
            <span class="news__vs">VS</span>
            <div class="news__team">
                <img class="news__team-logo" src="/assets/img/logo.png" alt="Cargando..." loading="lazy">
                <span class="news__team-name">Cargando...</span>
            </div>
        </div>
        <div class="news__content-inner">
            <h3 class="news__headline">Cargando última noticia...</h3>
            <p class="news__desc">Obteniendo datos de Football-Data.org</p>
            <div class="news__meta">
                <span class="news__date"></span>
                <span class="news__venue"></span>
            </div>
            <a class="home-news__link news__link" href="/noticias">Ver más resultados</a>
        </div>
    `;
};

// Muestra error en la tarjeta de noticias
const showNewsError = (errorMessage) => {
    const newsContent = document.getElementById('homeNewsContent');
    if (!newsContent) return;
    
    newsContent.innerHTML = `
        <div class="news__image-wrap news__image-wrap--teams">
            <div class="news__team">
                <img class="news__team-logo" src="/assets/img/logo.png" alt="Error" loading="lazy">
                <span class="news__team-name">Sin datos</span>
            </div>
            <span class="news__vs">-</span>
            <div class="news__team">
                <img class="news__team-logo" src="/assets/img/logo.png" alt="Error" loading="lazy">
                <span class="news__team-name">Sin datos</span>
            </div>
        </div>
        <div class="news__content-inner">
            <h3 class="news__headline">No hay partidos disponibles</h3>
            <p class="news__desc">${errorMessage || 'No se encontraron partidos para esta competición'}</p>
            <div class="news__meta">
                <span class="news__date"></span>
                <span class="news__venue"></span>
            </div>
            <a class="home-news__link news__link" href="/noticias">Ver otras competiciones</a>
        </div>
    `;
};

// Actualiza la tarjeta de noticias con datos REALES de la API
const updateNewsCard = (match) => {
    const newsContent = document.getElementById('homeNewsContent');
    if (!newsContent) return;

    // Determinar si hay marcador o es un próximo partido
    const hasScore = match.scoreHome !== null && match.scoreAway !== null && 
                    match.status === 'FINISHED';
    const scoreDisplay = hasScore ? `${match.scoreHome} - ${match.scoreAway}` : 'VS';

    // Formatear fecha en español
    let formattedDate = '';
    if (match.date) {
        try {
            const dateObj = new Date(match.date);
            formattedDate = dateObj.toLocaleDateString('es-ES', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        } catch (e) {
            formattedDate = match.date;
        }
    }

    // Construir HTML con los datos REALES de la API
    newsContent.innerHTML = `
        <div class="news__image-wrap news__image-wrap--teams">
            <div class="news__team">
                <img class="news__team-logo" 
                     src="${match.homeLogo || '/assets/img/logo.png'}" 
                     alt="${match.home || 'Local'}"
                     loading="lazy"
                     onerror="this.src='/assets/img/logo.png'">
                <span class="news__team-name">${match.home || 'Local'}</span>
            </div>
            <span class="news__vs">${scoreDisplay}</span>
            <div class="news__team">
                <img class="news__team-logo" 
                     src="${match.awayLogo || '/assets/img/logo.png'}" 
                     alt="${match.away || 'Visitante'}"
                     loading="lazy"
                     onerror="this.src='/assets/img/logo.png'">
                <span class="news__team-name">${match.away || 'Visitante'}</span>
            </div>
        </div>
        <div class="news__content-inner">
            <h3 class="news__headline">${match.league || 'Partido'}</h3>
            <p class="news__desc">
                ${match.home || ''} 
                ${hasScore ? `${match.scoreHome} - ${match.scoreAway}` : ''} 
                ${match.away || ''}
            </p>
            <div class="news__meta">
                ${formattedDate ? `
                    <span class="news__date">
                        📅 ${formattedDate}
                        ${match.time ? ` · ${match.time.substring(0, 5)}h` : ''}
                    </span>
                ` : ''}
                ${match.venue ? `
                    <span class="news__venue">
                        🏟️ ${match.venue}
                    </span>
                ` : ''}
            </div>
            <a class="home-news__link news__link" href="/noticias?league=${match.leagueCode || ''}">
                Ver más resultados
            </a>
        </div>
    `;
};

    // Función para cargar una competición específica desde los botones destacados
    const loadFeaturedCompetition = async (competitionKey) => {
      // Buscar la competición en el caché por su key
      const league = leaguesCache.find(item => item.__key === competitionKey);
      
      if (!league) {
        setStatus(`No se pudo cargar ${competitionKey}`, true);
        return;
      }

      // Actualizar el select para reflejar la competición seleccionada
      select.value = league.__selectValue;
      
      // Establecer límite de 4 equipos en la tabla
      if (standingsTable) {
        standingsTable.dataset.limit = "4";
      }
      
      // Cargar los datos de la competición (clasificación)
      await loadTeams(league);
      
      // CARGAR LA NOTICIA DE ESA MISMA COMPETICIÓN
      await loadLatestNews(competitionKey);
      
      // Scroll suave hacia la tabla de clasificación
      document.getElementById('home-standings')?.scrollIntoView({ 
        behavior: 'smooth' 
      });
    };

    // Configurar event listeners para los botones de competiciones destacadas
    const setupFeaturedButtons = () => {
      // Mapeo de IDs de botones a keys de competiciones
      const buttonMap = [
        { id: 'button-laLiga', key: 'laliga' },
        { id: 'button-premier', key: 'premier' },
        { id: 'button-serieA', key: 'seriea' },
        { id: 'button-bundes', key: 'bundesliga' },
        { id: 'button-ligue1', key: 'ligue1' },
        { id: 'button-champions', key: 'ucl' },
        { id: 'button-europa', key: 'uel' },
        { id: 'button-conference', key: 'uecl' }
      ];

      buttonMap.forEach(({ id, key }) => {
        const button = document.getElementById(id);
        if (button) {
          // Remover listeners anteriores para evitar duplicados
          button.removeEventListener('click', window[`__featured_${key}_handler`]);
          
          // Crear nuevo handler
          const handler = async (event) => {
            event.preventDefault();
            
            // Mostrar estado de carga
            setStatus(`Cargando clasificación de ${key}...`);
            
            // Asegurar que las competiciones estén cargadas
            if (leaguesCache.length === 0) {
              setStatus('Cargando competiciones...', false);
              await loadCompetitions();
            }
            
            // Cargar la competición destacada
            await loadFeaturedCompetition(key);
          };
          
          // Guardar referencia del handler
          window[`__featured_${key}_handler`] = handler;
          button.addEventListener('click', handler);
        }
      });
    };

const loadCompetitions = async () => {
    setStatus("Cargando competiciones...");
    select.disabled = true;
    clearStandings();
    clearTeams();

    try {
        const payload = await fetchJson(
            `${API_BASE}/all_leagues.php`,
            "No se pudieron cargar las competiciones."
        );

        leaguesCache = filterAllowedCompetitions(payload?.leagues);

        if (leaguesCache.length === 0) {
            throw new Error("No se pudieron encontrar las competiciones permitidas.");
        }

        select.innerHTML = '<option value="">Selecciona una competición</option>';
        leaguesCache.forEach((league) => {
            const option = document.createElement("option");
            option.value = league.__selectValue;
            option.textContent = league.__label || league.strLeague;
            select.appendChild(option);
        });

        select.disabled = false;
        
        // Configurar botones destacados
        setupFeaturedButtons();
        
        const defaultLeague = findDefaultSpanishLeague();
        if (defaultLeague) {
            select.value = defaultLeague.__selectValue;
            await loadTeams(defaultLeague);
            
            // CARGAR NOTICIA REAL DE LA LIGA DESDE LA API
            await loadLatestNews('laliga');
            return;
        }

        setStatus("Competiciones cargadas. Elige una para ver sus equipos.");
    } catch (error) {
        setStatus(error.message || "Error al cargar competiciones.", true);
    }
};

    const loadTeams = async (league) => {
      if (!league) return;
      const leagueName = league?.strLeague ?? "la competición";
      const leagueId = league?.idLeague;
      const namesToTry = [league?.strLeague, league?.strLeagueAlternate]
        .filter(Boolean)
        .filter((value, index, array) => array.indexOf(value) === index);
      const seasonsToTry = [getCurrentSeason(), getPreviousSeason()];
      const espnCode = detectEspnLeagueCode(league);

      clearStandings();
      clearTeams();
      setStatus(`Cargando ranking y equipos de ${leagueName}...`);
      
      try {
        let standingsRows = [];
        let seasonLoaded = "";

        if (leagueId) {
          for (const season of seasonsToTry) {
            try {
              const standingsPayload = await fetchJson(
                `${API_BASE}/lookuptable.php?l=${encodeURIComponent(leagueId)}&s=${encodeURIComponent(season)}`,
                "No se pudo cargar el ranking."
              );

              const rows = standingsPayload?.table;
              if (Array.isArray(rows) && rows.length > 0) {
                standingsRows = rows;
                seasonLoaded = season;
                break;
              }
            } catch (error) {
              // Continuar con la siguiente temporada
            }
          }
        }

        // Si no llega ranking por TheSportsDB, intentamos ESPN (útil para competiciones UEFA).
        if (!Array.isArray(standingsRows) || standingsRows.length === 0) {
          const espnRows = await fetchEspnStandings(espnCode);
          if (Array.isArray(espnRows) && espnRows.length > 0) {
            standingsRows = espnRows;
            seasonLoaded = "actual";
          }
        }

        if (!Array.isArray(standingsRows) || standingsRows.length === 0) {
          throw new Error("No hay ranking disponible para esta competición.");
        }

        // Si viene una tabla sospechosamente corta (ej: 5), intentamos ampliar con ESPN.
        if (standingsRows.length <= 5) {
          const espnRows = await fetchEspnStandings(espnCode);
          if (Array.isArray(espnRows) && espnRows.length > standingsRows.length) {
            standingsRows = espnRows;
            seasonLoaded = "actual";
          }
        }

        standingsRows = sortRowsByRank(standingsRows);

        let teams = [];
        if (leagueId && namesToTry.length > 0) {
          for (const name of namesToTry) {
            try {
              const payload = await fetchJson(
                `${API_BASE}/search_all_teams.php?l=${encodeURIComponent(name)}`,
                "No se pudieron cargar los equipos."
              );

              if (Array.isArray(payload?.teams) && payload.teams.length > 0) {
                teams = payload.teams;
                break;
              }
            } catch (error) {
              // Continuar con el siguiente nombre
            }
          }
        }

        const teamsMap = new Map(
          (Array.isArray(teams) ? teams : []).map((team) => [normalizeTeamName(team?.strTeam), team])
        );

        renderStandings(standingsRows, teamsMap, league.__key);

        const limit = Number(standingsTable?.dataset?.limit || 0);
        const limitedRows = Number.isFinite(limit) && limit > 0
          ? standingsRows.slice(0, limit)
          : standingsRows;

        const rankedTeams = limitedRows.map((row) => {
          const teamName = row?.strTeam || "Equipo";
          const rank = readNumberStat(row, ["intRank", "strRank"]);
          const points = readNumberStat(row, ["intPoints", "strPoints"]);
          const details = teamsMap.get(normalizeTeamName(teamName)) || {};

          return {
            teamName,
            rank,
            points,
            teamDetails: details,
            badge: row?.strBadge || row?.strTeamBadge || ""
          };
        });

        renderTeams(rankedTeams);
        
        if (teamsMap.size > 0) {
          setStatus(`Ranking y equipos cargados para ${leagueName} (${seasonLoaded}).`);
        } else {
          setStatus(`Ranking cargado para ${leagueName} (${seasonLoaded}).`);
        }
      } catch (error) {
        setStatus(error.message || "Error al cargar ranking/equipos.", true);
      }
    };

    // Event listener para el select
    select.addEventListener("change", (event) => {
      // Cuando se cambia manualmente desde el select, mostrar TODOS los equipos
      if (standingsTable) {
        standingsTable.dataset.limit = "0";
      }
      
      const league = leaguesCache.find((item) => item.__selectValue === event.target.value);
      if (!league) {
        clearStandings();
        clearTeams();
        setStatus("Selecciona una competición.");
        return;
      }
      loadTeams(league);
    });

    // Carga automática al entrar: competiciones + liga española por defecto.
    loadCompetitions();
  });
})();