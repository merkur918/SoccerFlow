(() => {
  if (window.__loginValidationInitialized) return;
  window.__loginValidationInitialized = true;

  const form = document.querySelector(".login__form");
  if (!form) return;

  const emailInput = form.querySelector('input[name="email"]');
  const passwordInput = form.querySelector('input[name="password"]');

  const getErrorNode = (field) =>
    form.querySelector(`[data-error-for="${field}"]`);

  const setFieldState = (input, field, message) => {
    const errorNode = getErrorNode(field);
    if (!errorNode) return;

    if (message) {
      input.classList.add("login__input--error");
      errorNode.textContent = message;
      return;
    }

    input.classList.remove("login__input--error");
    errorNode.textContent = "";
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
    return "";
  };

  const validateAll = () => {
    const errors = {
      email: validateEmail(),
      password: validatePassword(),
    };

    setFieldState(emailInput, "email", errors.email);
    setFieldState(passwordInput, "password", errors.password);

    return Object.values(errors).every((msg) => msg === "");
  };

  emailInput.addEventListener("blur", () => {
    setFieldState(emailInput, "email", validateEmail());
  });

  passwordInput.addEventListener("input", () => {
    setFieldState(passwordInput, "password", validatePassword());
  });

  form.addEventListener("submit", (event) => {
    if (!validateAll()) {
      event.preventDefault();
    }
  });
})();
