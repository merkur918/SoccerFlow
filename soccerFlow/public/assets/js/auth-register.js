(() => {
  if (window.__registerValidationInitialized) return;
  window.__registerValidationInitialized = true;

  const form = document.querySelector(".register__form");
  if (!form) return;

  const nombreInput = form.querySelector('input[name="nombre"]');
  const emailInput = form.querySelector('input[name="email"]');
  const passwordInput = form.querySelector('input[name="password"]');
  const confirmInput = form.querySelector('input[name="password_confirm"]');

  const getErrorNode = (field) =>
    form.querySelector(`[data-error-for="${field}"]`);

  const setFieldState = (input, field, message) => {
    const errorNode = getErrorNode(field);
    if (!errorNode) return;

    if (message) {
      input.classList.add("register__input--error");
      errorNode.textContent = message;
      return;
    }

    input.classList.remove("register__input--error");
    errorNode.textContent = "";
  };

  const validateNombre = () => {
    const value = nombreInput.value.trim();
    if (!value) return "El nombre es obligatorio";
    if (value.length > 30) return "Máximo 30 caracteres";
    if (!/^[\p{L}\s]+$/u.test(value)) return "Solo letras y espacios";
    return "";
  };

  const validateEmail = () => {
    const value = emailInput.value.trim();
    if (!value) return "El email es obligatorio";
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) return "Email no válido";
    return "";
  };

  const validatePassword = () => {
    const value = passwordInput.value;
    if (!value) return "La contraseña es obligatoria";
    if (value.length < 6) return "Mínimo 6 caracteres";
    if (!/[A-Z]/.test(value)) return "Debe incluir una mayúscula";
    if (!/[0-9]/.test(value)) return "Debe incluir un número";
    return "";
  };

  const validateConfirm = () => {
    const value = confirmInput.value;
    if (!value) return "Confirma la contraseña";
    if (value !== passwordInput.value) return "Las contraseñas no coinciden";
    return "";
  };

  const validateAll = () => {
    const errors = {
      nombre: validateNombre(),
      email: validateEmail(),
      password: validatePassword(),
      password_confirm: validateConfirm(),
    };

    setFieldState(nombreInput, "nombre", errors.nombre);
    setFieldState(emailInput, "email", errors.email);
    setFieldState(passwordInput, "password", errors.password);
    setFieldState(confirmInput, "password_confirm", errors.password_confirm);

    return Object.values(errors).every((msg) => msg === "");
  };

  nombreInput.addEventListener("blur", () => {
    setFieldState(nombreInput, "nombre", validateNombre());
  });
  emailInput.addEventListener("blur", () => {
    setFieldState(emailInput, "email", validateEmail());
  });
  passwordInput.addEventListener("input", () => {
    setFieldState(passwordInput, "password", validatePassword());
    if (confirmInput.value) {
      setFieldState(confirmInput, "password_confirm", validateConfirm());
    }
  });
  confirmInput.addEventListener("input", () => {
    setFieldState(confirmInput, "password_confirm", validateConfirm());
  });

  form.addEventListener("submit", (event) => {
    if (!validateAll()) {
      event.preventDefault();
    }
  });
})();
