// Script autoejecutable para validar el formulario de registro en tiempo real
(() => {
  // Prevenimos que el script se ejecute múltiples veces en la misma página
  if (window.__registerValidationInitialized) return;
  window.__registerValidationInitialized = true;

  // Buscamos el formulario de registro en el DOM
  const form = document.querySelector(".register__form");
  if (!form) return; // Si no hay formulario, salimos

  // Obtenemos todos los campos del formulario por su atributo name
  const nombreInput = form.querySelector('input[name="nombre"]');
  const emailInput = form.querySelector('input[name="email"]');
  const passwordInput = form.querySelector('input[name="password"]');
  const confirmInput = form.querySelector('input[name="password_confirm"]');

  // Función auxiliar que encuentra el elemento donde se muestra el error para cada campo
  const getErrorNode = (field) =>
    form.querySelector(`[data-error-for="${field}"]`);

  // Actualiza el estado visual de un campo: añade clase de error y muestra mensaje
  const setFieldState = (input, field, message) => {
    const errorNode = getErrorNode(field);
    if (!errorNode) return;

    if (message) {
      // Si hay mensaje de error: resalta el campo y muestra el mensaje
      input.classList.add("register__input--error");
      errorNode.textContent = message;
      return;
    }

    // Si no hay error: quita el resaltado y limpia el mensaje
    input.classList.remove("register__input--error");
    errorNode.textContent = "";
  };

  // Validaciones individuales para cada campo
  const validateNombre = () => {
    const value = nombreInput.value.trim();
    if (!value) return "El nombre es obligatorio";
    if (value.length > 30) return "Máximo 30 caracteres";
    if (!/^[\p{L}\s]+$/u.test(value)) return "Solo letras y espacios"; // Acepta letras de cualquier idioma
    return "";
  };

  const validateEmail = () => {
    const value = emailInput.value.trim();
    if (!value) return "El email es obligatorio";
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) return "Email no válido"; // Validación básica de formato email
    return "";
  };

  const validatePassword = () => {
    const value = passwordInput.value;
    if (!value) return "La contraseña es obligatoria";
    if (value.length < 6) return "Mínimo 6 caracteres";
    if (!/[A-Z]/.test(value)) return "Debe incluir una mayúscula"; // Al menos una letra mayúscula
    if (!/[0-9]/.test(value)) return "Debe incluir un número"; // Al menos un número
    return "";
  };

  const validateConfirm = () => {
    const value = confirmInput.value;
    if (!value) return "Confirma la contraseña";
    if (value !== passwordInput.value) return "Las contraseñas no coinciden"; // Compara con el campo contraseña
    return "";
  };

  // Valida todos los campos a la vez y actualiza sus estados
  const validateAll = () => {
    const errors = {
      nombre: validateNombre(),
      email: validateEmail(),
      password: validatePassword(),
      password_confirm: validateConfirm(),
    };

    // Actualizamos el estado visual de cada campo
    setFieldState(nombreInput, "nombre", errors.nombre);
    setFieldState(emailInput, "email", errors.email);
    setFieldState(passwordInput, "password", errors.password);
    setFieldState(confirmInput, "password_confirm", errors.password_confirm);

    // Retorna true si todos los campos son válidos (sin mensajes de error)
    return Object.values(errors).every((msg) => msg === "");
  };

  // Event listeners para validación en tiempo real
  // Cuando el usuario sale de un campo (blur), validamos
  nombreInput.addEventListener("blur", () => {
    setFieldState(nombreInput, "nombre", validateNombre());
  });

  emailInput.addEventListener("blur", () => {
    setFieldState(emailInput, "email", validateEmail());
  });

  // Mientras el usuario escribe la contraseña, validamos y también verificamos confirmación si ya tiene texto
  passwordInput.addEventListener("input", () => {
    setFieldState(passwordInput, "password", validatePassword());
    if (confirmInput.value) {
      setFieldState(confirmInput, "password_confirm", validateConfirm());
    }
  });

  // Validamos la confirmación mientras el usuario escribe
  confirmInput.addEventListener("input", () => {
    setFieldState(confirmInput, "password_confirm", validateConfirm());
  });

  // Al enviar el formulario, validamos todo y prevenimos el envío si hay errores
  form.addEventListener("submit", (event) => {
    if (!validateAll()) {
      event.preventDefault(); // Evita que el formulario se envíe si hay errores
    }
  });
})();