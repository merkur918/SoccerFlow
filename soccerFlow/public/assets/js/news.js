// Este es un script autoejecutable que gestiona la visualización de partidos/noticias deportivas
(() => {
  // Prevenimos que el script se ejecute múltiples veces en la misma página
  if (window.__newsInitialized) return;
  window.__newsInitialized = true;

  // Esperamos a que el DOM esté completamente cargado antes de ejecutar el código principal
  document.addEventListener("DOMContentLoaded", () => {
    // Configuración inicial: URL de la API y límite de elementos a mostrar
    const API_URL = "/api/news";
    const MAX_ITEMS = Number.POSITIVE_INFINITY;

    // Obtenemos las referencias a los elementos del DOM que vamos a manipular
    const status = document.getElementById("newsStatus");
    const grid = document.getElementById("newsGrid");
    const leagueSelect = document.getElementById("matchesLeagueSelect");
    const tabs = document.querySelectorAll(".news__tab");

    // Si faltan elementos esenciales, detenemos la ejecución
    if (!status || !grid || !leagueSelect || tabs.length === 0) return;

    // Variable para controlar si mostramos partidos pasados o próximos
    let currentType = "next";

    // Función auxiliar para mostrar mensajes de estado con estilo
    const setStatus = (message, isError = false) => {
      status.textContent = message;
      status.classList.toggle("news__status--error", isError);
    };

    // Formatea la fecha para mostrarla en formato legible (ej: "15 mar 2024")
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

    // Convierte la fecha de un evento a timestamp para poder ordenarlos cronológicamente
    const normalizeTimestamp = (event) => {
      const dateValue = event?.date || event?.dateEvent;
      const timeValue = event?.time || event?.strTime;
      if (!dateValue) return null;
      const iso = timeValue ? `${dateValue}T${timeValue}` : dateValue;
      const date = new Date(iso);
      if (Number.isNaN(date.getTime())) return null;
      return date.getTime();
    };

    // Ordena los eventos según su fecha: ascendente para próximos, descendente para pasados
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

    // Crea las tarjetas visuales para cada partido y las inserta en el grid
    const renderMatches = (events) => {
      grid.innerHTML = "";

      events.slice(0, MAX_ITEMS).forEach((event) => {
        // Extraemos todos los datos del evento con valores por defecto
        const title = event?.title || event?.strEvent || event?.league || "Partido";
        const date = formatDate(event?.date || event?.dateEvent, event?.time || event?.strTime);
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

        // Estructura visual con logos de los equipos
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

        // Creamos la tarjeta completa con toda la información
        const card = document.createElement("article");
        card.className = "news__card";
        card.innerHTML = `
          ${imageMarkup}
          <div class="news__content">
            <h3 class="news__headline">${title}</h3>
            <p class="news__desc">${home} ${score} ${away}</p>
            <div class="news__meta">
              <span>${date}</span>
            </div>
          </div>
        `;

        grid.appendChild(card);
      });
    };

    // Procesa la respuesta de la API extrayendo los datos o lanzando errores
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

    // Carga las competiciones disponibles y selecciona una por defecto
    const loadLeagues = async () => {
      setStatus("Cargando competiciones...");
      leagueSelect.disabled = true;

      try {
        const response = await fetch(`${API_URL}?mode=leagues&ts=${Date.now()}`);
        const payload = await parseResponse(response, "No se pudieron cargar las competiciones.");

        const leagues = Array.isArray(payload?.leagues) ? payload.leagues : [];
        if (!leagues.length) throw new Error("No hay competiciones disponibles.");

        // Poblamos el select con las competiciones
        leagueSelect.innerHTML = '<option value="">Selecciona una competición</option>';
        leagues.forEach((league) => {
          const option = document.createElement("option");
          option.value = String(league.idLeague);
          option.textContent = league.__label || league.strLeague;
          if (league.season) option.dataset.season = String(league.season);
          leagueSelect.appendChild(option);
        });

        leagueSelect.disabled = false;
        // Seleccionamos LaLiga por defecto si existe, o la primera competición
        const defaultLeague = leagues.find((league) => league.__key === "laliga") || leagues[0];
        if (defaultLeague) {
          leagueSelect.value = String(defaultLeague.idLeague);
          await loadMatches(defaultLeague.idLeague, currentType, defaultLeague.season);
        }
      } catch (error) {
        setStatus(error.message || "Error al cargar competiciones.", true);
      }
    };

    // Carga los partidos de una competición específica
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

    // Obtiene la temporada seleccionada actualmente
    const getSelectedSeason = () => {
      const option = leagueSelect.selectedOptions[0];
      return option?.dataset?.season || "";
    };

    // Event listeners: manejamos los clics en las pestañas (próximos/pasados)
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

    // Event listener: al cambiar la competición seleccionada
    leagueSelect.addEventListener("change", async (event) => {
      const leagueId = event.target.value;
      const season = getSelectedSeason();
      if (leagueId) await loadMatches(leagueId, currentType, season);
    });

    // Iniciamos la carga de competiciones
    loadLeagues();
  });
})();