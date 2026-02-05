<section class="home-competitions">
    <div class="home-competitions__box">
        <h2 class="home-competitions__title">Competiciones</h2>
        <p class="home-competitions__subtitle">
            Puedes cambiar de competición para ver sus equipos.
        </p>

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
            <table class="home-competitions__table" id="standingsTable" hidden>
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

        <h3 class="home-competitions__section-title">Información de equipos</h3>
        <div id="teamsGrid" class="home-competitions__teams" aria-live="polite">
        </div>
    </div>
</section>
