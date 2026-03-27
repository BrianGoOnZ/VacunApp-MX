<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - VacunApp MX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/css-login.css">
    <link rel="stylesheet" href="../style/style-index.css">
</head>
<body>
    <header>
        <?php include('componentes/navbar.php')?>
    </header>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card-custom">
            <h2 class="text-center mb-4">Iniciar Sesión</h2>
            <form action="../controladores/login_process.php" method="POST">
                <div class="mb-3">
                    <input type="text" name="usuario" class="form-control" placeholder="Usuario" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                </div>
                <button type="submit" class="btn-primary-custom w-100">
                    Iniciar Sesión
                </button>
                <div class="text-center mt-3">
                    <a href="recuperar.php" class="link-custom">¿Olvidaste tu contraseña?</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>