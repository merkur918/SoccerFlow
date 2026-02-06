/**
 * header.js
 * - Menú de usuario
 * - Tema oscuro con persistencia en cookie
 */

document.addEventListener("DOMContentLoaded", function () {
  const userBtn = document.getElementById("userMenuButton");
  const menu = document.getElementById("userDropdown");
  const themeBtn = document.querySelector(".theme-btn");
  const sunIcon = themeBtn?.querySelector(".sun-icon");
  const moonIcon = themeBtn?.querySelector(".moon-icon");
  const darkThemeCss = document.getElementById("dark-theme-css");

  const THEME_COOKIE = "sf_theme";
  const LIGHT_THEME = "light";
  const DARK_THEME = "dark";

  const getCookie = (name) => {
    const parts = document.cookie ? document.cookie.split("; ") : [];
    for (const part of parts) {
      const [key, value] = part.split("=");
      if (key === name) return decodeURIComponent(value || "");
    }
    return "";
  };

  const setCookie = (name, value, days = 365) => {
    const maxAge = days * 24 * 60 * 60;
    document.cookie = `${name}=${encodeURIComponent(value)}; path=/; max-age=${maxAge}; SameSite=Lax`;
  };

  const setThemeIcons = (isDark) => {
    if (sunIcon) sunIcon.style.display = isDark ? "none" : "block";
    if (moonIcon) moonIcon.style.display = isDark ? "block" : "none";
  };

  const applyTheme = (theme) => {
    const isDark = theme === DARK_THEME;
    if (darkThemeCss) {
      // Usamos `disabled` + `media` para máxima compatibilidad.
      darkThemeCss.disabled = !isDark;
      darkThemeCss.media = isDark ? "all" : "not all";
      if (isDark) {
        darkThemeCss.removeAttribute("disabled");
      } else {
        darkThemeCss.setAttribute("disabled", "disabled");
      }
    }
    document.documentElement.setAttribute("data-theme", isDark ? DARK_THEME : LIGHT_THEME);
    setThemeIcons(isDark);
  };

  // Aplicar tema inicial desde cookie.
  const savedTheme = getCookie(THEME_COOKIE);
  const initialTheme = savedTheme === DARK_THEME ? DARK_THEME : LIGHT_THEME;
  applyTheme(initialTheme);

  if (themeBtn) {
    themeBtn.addEventListener("click", function () {
      const currentTheme = document.documentElement.getAttribute("data-theme") || LIGHT_THEME;
      const nextTheme = currentTheme === DARK_THEME ? LIGHT_THEME : DARK_THEME;
      applyTheme(nextTheme);
      setCookie(THEME_COOKIE, nextTheme);
    });
  }

  // Menú desplegable de usuario.
  if (!userBtn || !menu) return;

  userBtn.addEventListener("click", function (e) {
    e.stopPropagation();
    menu.classList.toggle("show");
    userBtn.classList.toggle("active");
  });

  document.addEventListener("click", function () {
    menu.classList.remove("show");
    userBtn.classList.remove("active");
  });

  menu.addEventListener("click", function (e) {
    e.stopPropagation();
  });
});
