<?php require_once __DIR__ . '/../shared/header.php'; ?>

<h1>Freelancer Dashboard</h1>

<?php if (isset($_SESSION['user'])): ?>
    <p>Bienvenido, <?= htmlspecialchars($_SESSION['user']['email'] ?? 'Usuario') ?></p>
    
    <ul>
        <li><a href="/freelancers/contracts">Ver Contratos</a></li>
        <li><a href="/freelancers/offers">Ver Ofertas</a></li>
    </ul>

<?php else: ?>
    <p>No has iniciado sesión. <a href="/login">Iniciar sesión</a></p>
<?php endif; ?>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>