// Script autoejecutable para validar el formulario de login en tiempo real
(() => {
  // Prevenimos que el script se ejecute múltiples veces en la misma página
  if (window.__loginValidationInitialized) return;
  window.__loginValidationInitialized = true;

  // Buscamos el formulario de login en el DOM
  const form = document.querySelector(".login__form");
  if (!form) return; // Si no hay formulario, salimos

  // Obtenemos los campos del formulario por su atributo name
  const emailInput = form.querySelector('input[name="email"]');
  const passwordInput = form.querySelector('input[name="password"]');

  // Función auxiliar que encuentra el elemento donde se muestra el error para cada campo
  const getErrorNode = (field) =>
    form.querySelector(`[data-error-for="${field}"]`);

  // Actualiza el estado visual de un campo: añade clase de error y muestra mensaje
  const setFieldState = (input, field, message) => {
    const errorNode = getErrorNode(field);
    if (!errorNode) return;

    if (message) {
      // Si hay mensaje de error: resalta el campo y muestra el mensaje
      input.classList.add("login__input--error");
      errorNode.textContent = message;
      return;
    }

    // Si no hay error: quita el resaltado y limpia el mensaje
    input.classList.remove("login__input--error");
    errorNode.textContent = "";
  };

  // Validación del campo email
  const validateEmail = () => {
    const value = emailInput.value.trim();
    if (!value) return "El email es obligatorio";
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) return "Email no válido"; // Validación básica de formato email
    return "";
  };

  // Validación del campo contraseña (solo verifica que no esté vacía)
  const validatePassword = () => {
    const value = passwordInput.value;
    if (!value) return "La contraseña es obligatoria";
    return "";
  };

  // Valida todos los campos a la vez y actualiza sus estados
  const validateAll = () => {
    const errors = {
      email: validateEmail(),
      password: validatePassword(),
    };

    // Actualizamos el estado visual de cada campo
    setFieldState(emailInput, "email", errors.email);
    setFieldState(passwordInput, "password", errors.password);

    // Retorna true si todos los campos son válidos (sin mensajes de error)
    return Object.values(errors).every((msg) => msg === "");
  };

  // Event listeners para validación en tiempo real
  // Cuando el usuario sale del campo email, validamos
  emailInput.addEventListener("blur", () => {
    setFieldState(emailInput, "email", validateEmail());
  });

  // Mientras el usuario escribe la contraseña, validamos que no esté vacía
  passwordInput.addEventListener("input", () => {
    setFieldState(passwordInput, "password", validatePassword());
  });

  // Al enviar el formulario, validamos todo y prevenimos el envío si hay errores
  form.addEventListener("submit", (event) => {
    if (!validateAll()) {
      event.preventDefault(); // Evita que el formulario se envíe si hay errores
    }
  });
})();