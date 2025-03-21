<?php require_once __DIR__ . '/../shared/header.php'; ?>

<h1>Mis Ofertas</h1>

<?php if (empty($offers)): ?>
    <p>No tienes ofertas aún.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Detalles</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($offers as $offer): ?>
                <tr>
                    <td><?= htmlspecialchars($offer['company_name']) ?></td>
                    <td><?= htmlspecialchars($offer['details']) ?></td>
                    <td>
                        <a href="#">Aceptar</a> | <a href="#">Rechazar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<a href="/freelancers/dashboard">Volver</a>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>
