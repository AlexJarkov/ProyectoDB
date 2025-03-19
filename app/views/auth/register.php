<?php require_once __DIR__ . '/../shared/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">🚀 Crear Cuenta</h1>
        
        <?php if (!empty($_SESSION['errors'])): ?>
            <div class="alert error">
                <?= implode('<br>', array_map('htmlspecialchars', $_SESSION['errors'])) ?>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <form class="auth-form" action="/register" method="POST">
            <div class="form-group">
                <label>Tipo de Cuenta</label>
                <select name="role" id="role" required>
                    <option value="">Selecciona...</option>
                    <option value="freelancer">Freelancer</option>
                    <option value="company">Empresa</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" minlength="6" required>
            </div>
            
            <div class="form-group">
                <label>Confirmar Contraseña</label>
                <input type="password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
        </form>
        
        <p class="auth-link">¿Ya tienes cuenta? <a href="/login">Inicia sesión aquí</a></p>
    </div>
</div>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>