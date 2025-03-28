<?php require_once __DIR__ . '/../shared/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">🔑 Iniciar Sesión</h1>

        <?php if (!empty($_SESSION['errors'])): ?>
            <div class="alert error">
                <?= htmlspecialchars($_SESSION['errors'][0]) ?>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <!-- Envía el formulario al archivo físico -->
        <form class="auth-form" action="/public/index.php" method="POST">
            <input type="hidden" name="action" value="login">
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
        </form>

        <p class="auth-link">¿No tienes cuenta? <a href="/app/views/auth/register.php">Regístrate aquí</a></p>
    </div>
</div>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>
