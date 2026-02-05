<section class="news">
    <div class="news__inner">
        <header class="news__header">
            <h2 class="news__title">Partidos</h2>
            <p class="news__subtitle">Próximos encuentros y resultados recientes de fútbol.</p>
        </header>

        <div class="news__filters">
            <select id="matchesLeagueSelect" class="news__select" disabled>
                <option value="">Selecciona una competición</option>
            </select>

            <div class="news__tabs">
                <button class="news__tab news__tab--active" data-type="next" type="button">Próximos</button>
                <button class="news__tab" data-type="past" type="button">Resultados</button>
            </div>
        </div>

        <p id="newsStatus" class="news__status"></p>

        <div id="newsGrid" class="news__grid" aria-live="polite"></div>
    </div>
</section>
