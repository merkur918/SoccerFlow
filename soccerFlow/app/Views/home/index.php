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
            <article class="home-featured__card home-featured__card--laliga">
                <div class="home-featured__logo">LaLiga</div>
                <h3>La Liga</h3>
                <p>20 equipos</p>
                <a class="home-featured__link" href="#home-standings">Ver clasificación</a>
            </article>
            <article class="home-featured__card home-featured__card--premier">
                <div class="home-featured__logo">Premier</div>
                <h3>Premier League</h3>
                <p>20 equipos</p>
                <a class="home-featured__link" href="#home-standings">Ver clasificación</a>
            </article>
            <article class="home-featured__card home-featured__card--ucl">
                <div class="home-featured__logo">UCL</div>
                <h3>UEFA Champions</h3>
                <p>36 equipos</p>
                <a class="home-featured__link" href="#home-standings">Ver clasificación</a>
            </article>
            <article class="home-featured__card home-featured__card--seriea">
                <div class="home-featured__logo">Serie A</div>
                <h3>Serie A</h3>
                <p>20 equipos</p>
                <a class="home-featured__link" href="#home-standings">Ver clasificación</a>
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
                    <table class="home-competitions__table" id="standingsTable" data-limit="4" hidden>
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
            <article class="home-news__card">
                <img src="/assets/img/Fondo.jpg" alt="Resumen jornada">
                <div class="home-news__card-body">
                    <h3>El Valencia gana 3-0 en casa</h3>
                    <p>Crónica de la jornada y destacados de los partidos más importantes.</p>
                    <a class="home-news__link" href="/noticias">Leer más</a>
                </div>
            </article>
        </div>
    </section>
</section>
