<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña - VacunApp MX</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/recuperar.css.css">
    <link rel="stylesheet" href="../style/style-index.css">
</head>
<body class="bg-light">
    <header class="vapp-navbar-main">
        <div class="container-fluid p-3">
            <a href="../index.php" class="logo text-decoration-none">
                VacunApp <span class="mx">MX</span>
            </a>
        </div>
    </header>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card-recuperar shadow-sm p-4 bg-white rounded" style="max-width: 450px; width: 100%;">
            <h2 class="text-center mb-3">Recuperar contraseña</h2>
            <?php if(isset($_GET['status'])): ?>
                <div class="mb-3">
                    <?php if($_GET['status'] == 'enviado'): ?>
                        <div class="alert alert-success small p-2 text-center" role="alert">
                            <i class="fas fa-check-circle me-1"></i> ¡Enlace enviado! Revisa tu correo.
                        </div>
                    <?php elseif($_GET['status'] == 'no_encontrado'): ?>
                        <div class="alert alert-danger small p-2 text-center" role="alert">
                            <i class="fas fa-exclamation-circle me-1"></i> El correo no está registrado.
                        </div>
                    <?php elseif($_GET['status'] == 'error'): ?>
                        <div class="alert alert-warning small p-2 text-center" role="alert">
                            <i class="fas fa-user-shield me-1"></i> Hubo un error. Intenta más tarde.
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <p class="text-muted text-center mb-4">Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>       
            <form action="../controladores/recuperar_controller.php" method="POST">
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
                </div>
                <button type="submit" class="btn-azul w-100">Enviar enlace</button>
            </form>      
            <div class="text-center mt-4">
                <a href="../index.php" class="volver text-decoration-none">
                    <i class="fas fa-arrow-left me-1"></i> Volver al inicio
                </a>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>