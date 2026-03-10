<h2 class="section-title">Gestión de Usuarios</h2>

<div class="users-container">
    <?php foreach ($users as $user): ?>
    <div class="user-card">
        <div class="user-info">
            <div class="user-card-header">
                <span class="user-id-badge">ID: <?= htmlspecialchars($user['ID']) ?></span>
                <span class="user-role-badge <?= $user['rol'] === 'admin' ? 'admin' : 'user' ?>">
                    <?= htmlspecialchars($user['rol']) ?>
                </span>
            </div>
            
            <p><strong>Id:</strong> <?= htmlspecialchars($user['ID']) ?></p>
            <p><strong>Nombre:</strong> <?= htmlspecialchars($user['name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Rol:</strong> <?= htmlspecialchars($user['rol']) ?></p>
            <p><strong>Verificado:</strong> 
                <?= $user['email_verified_at'] ? '<span class="verified">Sí</span>' : '<span class="not-verified">No</span>' ?>
            </p>
        </div>

        <div class="user-actions">
            <button class="user-delete-btn" data-user-id="<?= $user['ID'] ?>">✖</button>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php if (empty($users)): ?>
<div class="cart__empty">
    <p>No hay usuarios registrados</p>
    <p class="cart__empty-sub">Comienza añadiendo usuarios desde el panel de registro</p>
</div>
<?php endif; ?>

<!-- Modal de confirmación -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <p>¿Estás seguro de que quieres eliminar este usuario?</p>
        <div class="modal-buttons">
            <button id="cancelBtn">Cancelar</button>
            <form id="deleteForm" method="POST" action="/admin/user/delete">
                <input type="hidden" name="id" id="deleteUserId">
                <button type="submit">Eliminar</button>
            </form>
        </div>
    </div>
</div>

<script src="/assets/js/adminUser.js"></script>