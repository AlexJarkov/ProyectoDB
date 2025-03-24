<?php
session_start();
require_once __DIR__ . '/../shared/header.php';
?>

<h1>Freelancer Dashboard</h1>

<?php if (isset($_SESSION['user'])): ?>
    <p>Bienvenido, <?= htmlspecialchars($_SESSION['user']['email'] ?? 'Usuario') ?></p>
    
    <ul>
        <li><a href="#">Ver Contratos</a></li>
        <li><a href="#">Ver Ofertas</a></li>
        <li><a href="/app/views/auth/logout.php">Cerrar sesión</a></li>
    </ul>

<?php else: ?>
    <p>No has iniciado sesión. <a href="/app/views/auth/login.php">Iniciar sesión</a></p>
<?php endif; ?>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>
