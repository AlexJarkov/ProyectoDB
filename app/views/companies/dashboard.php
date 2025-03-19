<?php require_once __DIR__ . '/../shared/header.php'; ?>

<div class="container">
    <h1>Dashboard de Empresas</h1>
    <h2>Freelancers Disponibles</h2>
    <div class="freelancers-list">
        <?php foreach ($freelancers as $freelancer): ?>
            <div class="freelancer-card">
                <h3><?= htmlspecialchars($freelancer['full_name']) ?></h3>
                <p>Habilidades: <?= htmlspecialchars($freelancer['skills']) ?></p>
                <p>Expectativa salarial: $<?= $freelancer['expected_payment'] ?> USD</p>
                <form action="/companies/send_offer" method="POST">
                    <input type="hidden" name="freelancer_id" value="<?= $freelancer['user_id'] ?>">
                    <input type="number" name="proposed_payment" step="0.01" required>
                    <textarea name="details" placeholder="Detalles del trabajo" required></textarea>
                    <button type="submit">Enviar Oferta</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>