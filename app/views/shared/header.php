<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelance System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-content">
                <a href="/" class="logo">FreelanceHub</a>
                <div class="nav-links">
                    <?php if (isset($_SESSION['user'])): ?>
                        <span>Bienvenido, <?= htmlspecialchars($_SESSION['user']['email']) ?></span>
                        <a href="/logout" class="btn btn-primary">Cerrar Sesión</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>