<section aria-label="Home" class="home">
    <section class="home-hero">
        <div class="home-hero__overlay"></div>
        <div class="home-hero__content">
            <h1>Vive el fútbol al máximo</h1>
            <p>Competición, equipación y actualidad en un solo lugar. Descubre productos oficiales y las ligas más potentes del mundo.</p>
            <div class="home-hero__actions">
                <a class="home-btn home-btn--primary" href="#home-standings">Ver competiciones</a>
                <a class="home-btn home-btn--ghost" href="/productos">Ir a tienda</a>
            </div>
        </div>
    </section>

    <section class="home-featured" id="home-competitions">
        <div class="home-section__title home-section__title--left">
            <h2>Competiciones <span>destacadas</span></h2>
        </div>
        <div class="home-featured__grid">
            <article class="home-featured__card_LaLiga home-featured__card--laliga">
                <div class="home-featured__logo">LaLiga</div>
                <h3>La Liga</h3>
                <p>20 equipos</p>
                <a class="home-featured__link" href="#home-standings" id="button-laLiga">Ver clasificación</a>
            </article>
            <article class="home-featured__card_Premier home-featured__card--premier" >
                <div class="home-featured__logo">Premier</div>
                <h3>Premier League</h3>
                <p>20 equipos</p>
                <a class="home-featured__link" href="#home-standings" id="button-premier">Ver clasificación</a>
            </article>
            <article class="home-featured__card_SerieA home-featured__card--seriea" >
                <div class="home-featured__logo">Serie A</div>
                <h3>Serie A</h3>
                <p>20 equipos</p>
                <a class="home-featured__link" href="#home-standings" id="button-serieA">Ver clasificación</a>
            </article>
            <article class="home-featured__card_Bundes home-featured__card--bundes">
                <div class="home-featured__logo">Bundes</div>
                <h3>Bundesliga</h3>
                <p>18 equipos</p>
                <a class="home-featured__link" href="#home-standings" id="button-bundes">Ver clasificación</a>
            </article>
            <article class="home-featured__card_Ligue1 home-featured__card--
            ligue1">
            <div class="home-featured__logo">Ligue 1</div>
            <h3>Ligue 1</h3>
            <p>20 equipos</p>
            <a class="home-featured__link" href="#home-standings" id="button-ligue1">Ver clasificación</a>
        </article>
        <article class="home-featured__card_Champions home-featured__card--ucl">
            <div class="home-featured__logo">UCL</div>
            <h3>UEFA Champions</h3>
            <p>36 equipos</p>
            <a class="home-featured__link" href="#home-standings" id="button-champions">Ver clasificación</a>
        </article>
            <article class="home-featured__card_Europa home-featured__card--uel
">
                <div class="home-featured__logo">UEL</div>
                <h3>Europa League</h3>
                <p>32 equipos</p>
                <a class="home-featured__link" href="#home-standings" id="button-europa">Ver clasificación</a>
            </article>
            <article class="home-featured__card_Conference home-featured__card--uecl">
                <div class="home-featured__logo">UECL</div>
                <h3>Conference League</h3>
                <p>32 equipos</p>
                <a class="home-featured__link" href="#home-standings" id="button-conference">Ver clasificación</a>
            </article>
        </div>
    </section>

    <section class="home-products">
        <div class="home-section__title home-section__title--left">
            <h2>Productos <span>destacados</span></h2>
        </div>

        <?php if (!empty($productos)): ?>
            <?php
                $carouselItems = array_values($productos);
                $carouselItems = array_merge($carouselItems, $carouselItems);
            ?>
            <div class="home-products__carousel" aria-label="Carrusel de productos destacados">
                <div class="home-products__track">
                    <?php foreach ($carouselItems as $p): ?>
                        <?php
                            $id = $p['id'] ?? $p['ID'] ?? null;
                            $name = htmlspecialchars($p['name'] ?? 'Producto');
                            $price = number_format((float)($p['price'] ?? 0), 2);
                            $img = htmlspecialchars($p['image'] ?? '/assets/img/products/placeholder.png');
                            $category = htmlspecialchars($p['category'] ?? '');
                            $team = htmlspecialchars($p['team'] ?? '');
                            $brand = strtolower($p['brand'] ?? '');
                            $gender = htmlspecialchars($p['gender'] ?? '');
                            $meta = trim($brand . ' - ' . $category);
                            $sizes = htmlspecialchars($p['sizes'] ?? '');
                            $sizes = strtolower($sizes);
                        ?>
                        <article class="home-product-card">
                            <div class="home-product-card__media">
                                <img src="<?= $img ?>" alt="<?= $name ?>">
                            </div>
                            <div class="home-product-card__body">
                                <h3><?= $name ?></h3>
                                <?php if ($meta !== '' && $meta !== ' - '): ?>
                                    <p class="home-product-card__meta"><?= htmlspecialchars($meta) ?></p>
                                <?php endif; ?>
                                <p class="home-product-card__price">Precio: $<?= $price ?></p>
                                <a class="home-product-card__cta" href="/product-details?id=<?= $id ?>">Ver producto</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <p>No hay productos disponibles.</p>
        <?php endif; ?>
    </section>

    <section class="home-news">
        <div class="home-section__title home-section__title--left">
            <h2>Últimas <span>noticias</span></h2>
        </div>

        <div class="home-news__grid" id="home-standings">
            <div class="home-news__standings">
                <div class="home-news__standings-header">
                    <h3>Clasificación</h3>
                </div>
                <div class="home-competitions__actions">
                    <select id="competitionSelect" class="home-competitions__select" disabled>
                        <option value="">Selecciona una competición</option>
                    </select>
                </div>
                <p id="competitionsStatus" class="home-competitions__status"></p>
                <div id="qualificationLegend" class="home-competitions__legend" hidden>
                    <span class="home-competitions__legend-item home-competitions__legend-item--ucl" data-legend="ucl">Champions League</span>
                    <span class="home-competitions__legend-item home-competitions__legend-item--uel" data-legend="uel">Europa League</span>
                    <span class="home-competitions__legend-item home-competitions__legend-item--uecl" data-legend="uecl">Conference League</span>
                    <span class="home-competitions__legend-item home-competitions__legend-item--relegation" data-legend="relegation">Descenso</span>
                    <span class="home-competitions__legend-item home-competitions__legend-item--top8" data-legend="top8">Top 8</span>
                    <span class="home-competitions__legend-item home-competitions__legend-item--playoff" data-legend="playoff">Clasifica (9-24)</span>
                </div>
                <div class="home-competitions__table-wrapper">
                    <table class="home-competitions__table" id="standingsTable" data-limit="0" hidden>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Equipo</th>
                                <th>Puntos</th>
                                <th>PJ</th>
                                <th>G</th>
                                <th>E</th>
                                <th>P</th>
                            </tr>
                        </thead>
                        <tbody id="standingsBody"></tbody>
                    </table>
                </div>
                <div id="teamsGrid" class="home-competitions__teams" aria-live="polite"></div>
            </div>
 <!-- TARJETA DE NOTICIAS CON MISMO ESTILO QUE LA VISTA NEWS -->
        <article class="home-news__card news__card">
            <div id="homeNewsContent" class="news__content">
                <!-- El contenido se cargará dinámicamente con JavaScript -->
                <div class="news__image-wrap news__image-wrap--teams">
                    <div class="news__team">
                        <img class="news__team-logo" src="/assets/img/logo.png" alt="Local" loading="lazy">
                        <span class="news__team-name">Cargando...</span>
                    </div>
                    <span class="news__vs">VS</span>
                    <div class="news__team">
                        <img class="news__team-logo" src="/assets/img/logo.png" alt="Visitante" loading="lazy">
                        <span class="news__team-name">Cargando...</span>
                    </div>
                </div>
                <div class="news__content-inner">
                    <h3 class="news__headline">Cargando última noticia...</h3>
                    <p class="news__desc"></p>
                    <div class="news__meta">
                        <span class="news__date"></span>
                        <span class="news__venue"></span>
                    </div>
                    <a class="home-news__link news__link" href="/noticias">Ver más resultados</a>
                </div>
            </div>
        </article>
        </div>
    </section>
</section>
