<?php require_once __DIR__ . '/../shared/header.php'; ?>

<h1>Mis Contratos</h1>

<?php if (empty($contracts)): ?>
    <p>No tienes contratos aún.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Pago Propuesto</th>
                <th>Detalles</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contracts as $contract): ?>
                <tr>
                    <td><?= htmlspecialchars($contract['company_name']) ?></td>
                    <td>$<?= number_format($contract['proposed_payment'], 2) ?></td>
                    <td><?= htmlspecialchars($contract['details']) ?></td>
                    <td><?= ucfirst($contract['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<a href="/freelancers/dashboard">Volver</a>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>
