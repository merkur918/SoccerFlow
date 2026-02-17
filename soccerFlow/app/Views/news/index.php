<!-- Sección principal que muestra los partidos de fútbol (próximos y resultados) -->
<section class="news">
    <!-- Contenedor interno que centra y organiza el contenido -->
    <div class="news__inner">

        <!-- ENCABEZADO DE LA SECCIÓN -->
        <header class="news__header">
            <!-- Título principal de la sección -->
            <h2 class="news__title">Partidos</h2>
            <!-- Subtítulo descriptivo -->
            <p class="news__subtitle">Próximos encuentros y resultados recientes de fútbol.</p>
        </header>

        <!-- FILTROS: Selector de competición y pestañas de tipo de partido -->
        <div class="news__filters">

            <!-- SELECTOR DE COMPETICIÓN -->
            <!-- Inicialmente deshabilitado hasta que se carguen los datos mediante JavaScript -->
            <select id="matchesLeagueSelect" class="news__select" disabled>
                <option value="">Selecciona una competición</option>
                <!-- Las opciones se llenarán dinámicamente con JS -->
            </select>

            <!-- PESTAÑAS para alternar entre próximos partidos y resultados pasados -->
            <div class="news__tabs">
                <!-- Pestaña activa por defecto: "Próximos" (data-type="next") -->
                <button class="news__tab news__tab--active" data-type="next" type="button">Próximos</button>
                <!-- Pestaña "Resultados" (data-type="past") -->
                <button class="news__tab" data-type="past" type="button">Resultados</button>
            </div>
        </div>

        <!-- ÁREA DE ESTADO: Muestra mensajes de carga, errores o "sin resultados" -->
        <p id="newsStatus" class="news__status"></p>

        <!-- GRID DE PARTIDOS: Contenedor donde se renderizarán las tarjetas de partidos -->
        <!-- aria-live="polite" indica a lectores de pantalla que anuncien cambios sin interrumpir -->
        <div id="newsGrid" class="news__grid" aria-live="polite">
            <!-- Las tarjetas de partidos se insertarán aquí dinámicamente con JavaScript -->
        </div>
    </div>
</section>