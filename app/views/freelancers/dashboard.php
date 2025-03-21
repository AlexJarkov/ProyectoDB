<?php require_once __DIR__ . '/../shared/header.php'; ?>

<h1>Freelancer Dashboard</h1>
<p>Bienvenido, <?= htmlspecialchars($_SESSION['user']['email']) ?>.</p>

<ul>
    <li><a href="/freelancers/contracts">Ver Contratos</a></li>
    <li><a href="/freelancers/offers">Ver Ofertas</a></li>
</ul>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>
