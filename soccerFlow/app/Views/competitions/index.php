<!-- Sección principal que muestra las competiciones, clasificaciones y equipos -->
<section class="home-competitions">
    <!-- Contenedor interno que agrupa todo el contenido de la sección -->
    <div class="home-competitions__box">

        <!-- Encabezado de la sección -->
        <h2 class="home-competitions__title">Competiciones</h2>
        <!-- Subtítulo explicativo para el usuario -->
        <p class="home-competitions__subtitle">
            Puedes cambiar de competición para ver sus equipos.
        </p>

        <!-- Contenedor para las acciones principales (selector de competiciones) -->
        <div class="home-competitions__actions">
            <!-- Selector de competiciones: inicialmente desactivado hasta que se carguen los datos
                 Se llenará dinámicamente con JavaScript -->
            <select id="competitionSelect" class="home-competitions__select" disabled>
                <option value="">Selecciona una competición</option>
            </select>
        </div>

        <!-- Área para mostrar mensajes de estado (cargando, errores, sin datos) -->
        <p id="competitionsStatus" class="home-competitions__status"></p>

        <!-- Leyenda que explica el significado de los colores/indicadores en la tabla
             Oculto inicialmente (hidden) y se mostrará cuando haya datos -->
        <div id="qualificationLegend" class="home-competitions__legend" hidden>
            <!-- Cada ítem representa una clasificación europea o situación en la liga -->
            <span class="home-competitions__legend-item home-competitions__legend-item--ucl" data-legend="ucl">Champions League</span>
            <span class="home-competitions__legend-item home-competitions__legend-item--uel" data-legend="uel">Europa League</span>
            <span class="home-competitions__legend-item home-competitions__legend-item--uecl" data-legend="uecl">Conference League</span>
            <span class="home-competitions__legend-item home-competitions__legend-item--relegation" data-legend="relegation">Descenso</span>
            <span class="home-competitions__legend-item home-competitions__legend-item--top8" data-legend="top8">Top 8</span>
            <span class="home-competitions__legend-item home-competitions__legend-item--playoff" data-legend="playoff">Clasifica (9-24)</span>
        </div>

        <!-- Contenedor con scroll para la tabla (útil en móviles si la tabla es ancha) -->
        <div class="home-competitions__table-wrapper">
            <!-- Tabla de clasificación: oculta inicialmente hasta que se carguen datos -->
            <table class="home-competitions__table" id="standingsTable" hidden>
                <!-- Cabecera de la tabla con las columnas de clasificación estándar -->
                <thead>
                    <tr>
                        <th>#</th> <!-- Posición -->
                        <th>Equipo</th> <!-- Nombre del equipo -->
                        <th>Puntos</th> <!-- Puntos totales -->
                        <th>PJ</th> <!-- Partidos jugados -->
                        <th>G</th> <!-- Partidos ganados -->
                        <th>E</th> <!-- Partidos empatados -->
                        <th>P</th> <!-- Partidos perdidos -->
                    </tr>
                </thead>
                <!-- Cuerpo de la tabla: se llenará dinámicamente con JavaScript -->
                <tbody id="standingsBody"></tbody>
            </table>
        </div>

        <!-- Título de la sección de equipos (visible siempre) -->
        <h3 class="home-competitions__section-title">Información de equipos</h3>

        <!-- Grid de tarjetas de equipos: se llena dinámicamente con JavaScript
             aria-live="polite" indica a lectores de pantalla que deben anunciar cambios
             sin interrumpir al usuario -->
        <div id="teamsGrid" class="home-competitions__teams" aria-live="polite">
            <!-- Aquí se insertarán las tarjetas de los equipos -->
        </div>
    </div>
</section>