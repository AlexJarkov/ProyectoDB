<?php require_once __DIR__ . '/../shared/header.php'; ?>

<div class="container">
    <h1 class="page-title">📊 Panel de Empresa</h1>
    
    <div class="grid-container">
        <!-- Sección Freelancers -->
        <section class="freelancers-section">
            <h2 class="section-title">🌟 Freelancers Disponibles</h2>
            
            <div class="freelancers-grid">
                <?php foreach ($freelancers as $freelancer): ?>
                <div class="freelancer-card card">
                    <div class="freelancer-header">
                        <h3 class="freelancer-name"><?= htmlspecialchars($freelancer['full_name']) ?></h3>
                        <span class="salary-badge">$<?= number_format($freelancer['expected_payment'], 2) ?> USD/h</span>
                    </div>
                    
                    <div class="freelancer-skills">
                        <?php $skills = explode(',', $freelancer['skills']); ?>
                        <?php foreach ($skills as $skill): ?>
                        <span class="skill-tag"><?= htmlspecialchars(trim($skill)) ?></span>
                        <?php endforeach; ?>
                    </div>
                    
                    <p class="freelancer-summary"><?= htmlspecialchars($freelancer['cv_summary']) ?></p>
                    
                    <form class="offer-form" action="/companies/send_offer" method="POST">
                        <input type="hidden" name="freelancer_id" value="<?= $freelancer['user_id'] ?>">
                        
                        <div class="form-group">
                            <label>Oferta Salarial (USD/h)</label>
                            <input type="number" name="proposed_payment" step="0.01" min="1" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Detalles del Proyecto</label>
                            <textarea name="details" rows="3" placeholder="Describe el proyecto..." required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">🚀 Enviar Oferta</button>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</div>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>