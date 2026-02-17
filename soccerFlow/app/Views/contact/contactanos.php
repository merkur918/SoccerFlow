<!-- Elemento principal que contiene toda la página de contacto -->
<main class="contacto">
    <!-- Contenedor principal que agrupa todo el contenido -->
    <div class="contacto__body">

        <!-- Encabezado de la página con título y subtítulo -->
        <div class="contacto__header">
            <h1 class="contacto__title">CONTÁCTANOS</h1>
            <p class="contacto__subtitle">¿Tienes alguna pregunta? ¡Estamos aquí para ayudarte!</p>
        </div>

        <!-- Contenedor de dos columnas: información de contacto (izquierda) y formulario (derecha) -->
        <div class="contacto__content">

            <!-- SECCIÓN IZQUIERDA: Información de contacto de la empresa -->
            <div class="contacto__info">
                <h2 class="contacto__info-title">Información de Contacto</h2>

                <!-- Cada ítem de información usa un icono SVG y texto -->
                <!-- Ítem de correo electrónico -->
                <div class="contacto__info-item">
                    <!-- Icono de sobre (email) -->
                    <svg class="contacto__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                    </svg>
                    <div class="contacto__info-text">
                        <strong>Email</strong>
                        info@soccerflow.com
                    </div>
                </div>

                <!-- Ítem de teléfono -->
                <div class="contacto__info-item">
                    <!-- Icono de teléfono -->
                    <svg class="contacto__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
                    </svg>
                    <div class="contacto__info-text">
                        <strong>Teléfono</strong>
                        +34 912 345 678
                    </div>
                </div>

                <!-- Ítem de dirección física -->
                <div class="contacto__info-item">
                    <!-- Icono de ubicación/marcador -->
                    <svg class="contacto__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                    </svg>
                    <div class="contacto__info-text">
                        <strong>Dirección</strong>
                        Calle del Fútbol, 123<br>
                        46011 Valencia, España
                    </div>
                </div>

                <!-- Ítem de horario de atención -->
                <div class="contacto__info-item">
                    <!-- Icono de reloj -->
                    <svg class="contacto__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                    </svg>
                    <div class="contacto__info-text">
                        <strong>Horario de Atención</strong>
                        Lunes a Viernes: 9:00 - 18:00<br>
                        Sábados: 10:00 - 14:00
                    </div>
                </div>
            </div>

            <!-- SECCIÓN DERECHA: Formulario de contacto -->
            <div class="contacto__form">
                <h2 class="contacto__info-title">Envíanos un Mensaje</h2>
                <!-- Formulario con ID "formContacto" que usa el script de validación visto anteriormente -->
                <form id="formContacto" method="post">

                    <!-- Grupo de campo: Nombre -->
                    <div class="contacto__form-group">
                        <label for="nombre" class="contacto__form-label">
                            Nombre <span class="contacto__form-required">*</span> <!-- * indica campo obligatorio -->
                        </label>
                        <input type="text" id="nombre" name="nombre" class="contacto__form-input"
                            placeholder="Tu nombre completo" required>
                    </div>

                    <!-- Grupo de campo: Email -->
                    <div class="contacto__form-group">
                        <label for="email" class="contacto__form-label">
                            Email <span class="contacto__form-required">*</span>
                        </label>
                        <input type="email" id="email" name="email" class="contacto__form-input"
                            placeholder="tu@email.com" required>
                    </div>

                    <!-- Grupo de campo: Asunto (select con opciones predefinidas) -->
                    <div class="contacto__form-group">
                        <label for="asunto" class="contacto__form-label">
                            Asunto <span class="contacto__form-required">*</span>
                        </label>
                        <select id="asunto" name="asunto" class="contacto__form-input" required>
                            <option value="">Selecciona un asunto</option>
                            <option value="consulta">Consulta general</option>
                            <option value="pedido">Información sobre pedidos</option>
                            <option value="devolucion">Devoluciones y cambios</option>
                            <option value="producto">Información sobre productos</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>

                    <!-- Grupo de campo: Mensaje (textarea para texto largo) -->
                    <div class="contacto__form-group">
                        <label for="mensaje" class="contacto__form-label">
                            Mensaje <span class="contacto__form-required">*</span>
                        </label>
                        <textarea id="mensaje" name="mensaje" class="contacto__form-textarea"
                            placeholder="Escribe tu mensaje aquí..." required></textarea>
                    </div>

                    <!-- Botón de envío del formulario -->
                    <button type="submit" class="contacto__form-submit">Enviar Mensaje</button>
                </form>
            </div>
        </div> <!-- Cierre de contacto__content -->

        <!-- SECCIÓN DE MAPA: Muestra la ubicación en Google Maps -->
        <div class="contacto__map">
            <!-- Iframe de Google Maps mostrando la ubicación del IES Abastos en Valencia -->
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7603.848690032771!2d-0.3936869099219587!3d39.46842559840074!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd604f46da4855e1%3A0x9c6c795bc92d164e!2sIES%20Abastos!5e1!3m2!1ses!2ses!4v1770068554225!5m2!1ses!2ses"
                width="600" height="450" style="border:0;"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div> <!-- Cierre de contacto__body -->
</main>

<!-- Mensaje flotante de éxito (oculto inicialmente, se muestra con JavaScript después de enviar el formulario) -->
<div id="mensajeExito" class="mensaje-exito">¡Mensaje enviado con éxito!</div>