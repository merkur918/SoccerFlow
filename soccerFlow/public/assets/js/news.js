(() => {
  if (window.__newsInitialized) return;
  window.__newsInitialized = true;

  document.addEventListener("DOMContentLoaded", () => {
    const API_URL = "/api/news";
    const MAX_ITEMS = Number.POSITIVE_INFINITY;

    const status = document.getElementById("newsStatus");
    const grid = document.getElementById("newsGrid");
    const leagueSelect = document.getElementById("matchesLeagueSelect");
    const tabs = document.querySelectorAll(".news__tab");

    if (!status || !grid || !leagueSelect || tabs.length === 0) return;

    let currentType = "next";

    const setStatus = (message, isError = false) => {
      status.textContent = message;
      status.classList.toggle("news__status--error", isError);
    };

    const formatDate = (dateStr, timeStr) => {
      if (!dateStr) return "";
      const iso = timeStr ? `${dateStr}T${timeStr}` : dateStr;
      const date = new Date(iso);
      if (Number.isNaN(date.getTime())) return dateStr;
      return date.toLocaleDateString("es-ES", {
        year: "numeric",
        month: "short",
        day: "numeric"
      });
    };

    const normalizeTimestamp = (event) => {
      const dateValue = event?.date || event?.dateEvent;
      const timeValue = event?.time || event?.strTime;
      if (!dateValue) return null;
      const iso = timeValue ? `${dateValue}T${timeValue}` : dateValue;
      const date = new Date(iso);
      if (Number.isNaN(date.getTime())) return null;
      return date.getTime();
    };

    const sortEvents = (events, type) => {
      const sorted = [...events].sort((a, b) => {
        const timeA = normalizeTimestamp(a);
        const timeB = normalizeTimestamp(b);
        if (timeA === null && timeB === null) return 0;
        if (timeA === null) return 1;
        if (timeB === null) return -1;
        return timeA - timeB;
      });

      return type === "past" ? sorted.reverse() : sorted;
    };

    const renderMatches = (events) => {
      grid.innerHTML = "";

      events.slice(0, MAX_ITEMS).forEach((event) => {
        const title = event?.title || event?.strEvent || event?.league || "Partido";
        const date = formatDate(event?.date || event?.dateEvent, event?.time || event?.strTime);
        const venue = event?.venue || event?.strVenue || "Estadio desconocido";
        const home = event?.home || event?.strHomeTeam || "-";
        const away = event?.away || event?.strAwayTeam || "-";
        const homeLogo = event?.homeLogo || "/assets/img/logo.png";
        const awayLogo = event?.awayLogo || "/assets/img/logo.png";
        const score =
          event?.scoreHome !== null && event?.scoreAway !== null
            ? `${event.scoreHome} - ${event.scoreAway}`
            : event?.intHomeScore !== null && event?.intAwayScore !== null
              ? `${event.intHomeScore} - ${event.intAwayScore}`
              : "VS";
        const imageMarkup = `
          <div class="news__image-wrap news__image-wrap--teams">
            <div class="news__team">
              <img class="news__team-logo" src="${homeLogo}" alt="${home}" loading="lazy">
              <span class="news__team-name">${home}</span>
            </div>
            <span class="news__vs">VS</span>
            <div class="news__team">
              <img class="news__team-logo" src="${awayLogo}" alt="${away}" loading="lazy">
              <span class="news__team-name">${away}</span>
            </div>
          </div>
        `;

        const card = document.createElement("article");
        card.className = "news__card";
        card.innerHTML = `
          ${imageMarkup}
          <div class="news__content">
            <h3 class="news__headline">${title}</h3>
            <p class="news__desc">${home} ${score} ${away}</p>
            <div class="news__meta">
              <span>${date}</span>
              <span>${venue}</span>
            </div>
          </div>
        `;

        grid.appendChild(card);
      });
    };

    const parseResponse = async (response, fallbackMessage) => {
      let payload = null;
      try {
        payload = await response.json();
      } catch (error) {
        payload = null;
      }

      if (!response.ok) {
        const message = payload?.message || payload?.error || fallbackMessage;
        throw new Error(message);
      }

      return payload;
    };

    const loadLeagues = async () => {
      setStatus("Cargando competiciones...");
      leagueSelect.disabled = true;

      try {
        const response = await fetch(`${API_URL}?mode=leagues&ts=${Date.now()}`);
        const payload = await parseResponse(response, "No se pudieron cargar las competiciones.");

        const leagues = Array.isArray(payload?.leagues) ? payload.leagues : [];
        if (!leagues.length) throw new Error("No hay competiciones disponibles.");

        leagueSelect.innerHTML = '<option value="">Selecciona una competición</option>';
        leagues.forEach((league) => {
          const option = document.createElement("option");
          option.value = String(league.idLeague);
          option.textContent = league.__label || league.strLeague;
          if (league.season) option.dataset.season = String(league.season);
          leagueSelect.appendChild(option);
        });

        leagueSelect.disabled = false;
        const defaultLeague = leagues.find((league) => league.__key === "laliga") || leagues[0];
        if (defaultLeague) {
          leagueSelect.value = String(defaultLeague.idLeague);
          await loadMatches(defaultLeague.idLeague, currentType, defaultLeague.season);
        }
      } catch (error) {
        setStatus(error.message || "Error al cargar competiciones.", true);
      }
    };

    const loadMatches = async (leagueId, type, season) => {
      if (!leagueId) return;
      setStatus("Cargando partidos...");
      grid.innerHTML = "";

      try {
        const params = new URLSearchParams({
          league: leagueId,
          type
        });
        if (season) params.append("season", season);

        const response = await fetch(
          `${API_URL}?${params.toString()}&ts=${Date.now()}`
        );
        const payload = await parseResponse(response, "No se pudieron cargar los partidos.");
        const events = payload?.events || payload?.results || [];

        if (!Array.isArray(events) || events.length === 0) {
          setStatus("No hay partidos disponibles.", true);
          return;
        }

        const sortedEvents = sortEvents(events, type);
        renderMatches(sortedEvents);
        setStatus("");
      } catch (error) {
        setStatus(error.message || "Error al cargar partidos.", true);
      }
    };

    const getSelectedSeason = () => {
      const option = leagueSelect.selectedOptions[0];
      return option?.dataset?.season || "";
    };

    tabs.forEach((tab) => {
      tab.addEventListener("click", async () => {
        tabs.forEach((t) => t.classList.remove("news__tab--active"));
        tab.classList.add("news__tab--active");
        currentType = tab.dataset.type || "next";
        const leagueId = leagueSelect.value;
        const season = getSelectedSeason();
        if (leagueId) await loadMatches(leagueId, currentType, season);
      });
    });

    leagueSelect.addEventListener("change", async (event) => {
      const leagueId = event.target.value;
      const season = getSelectedSeason();
      if (leagueId) await loadMatches(leagueId, currentType, season);
    });

    loadLeagues();
  });
})();
