<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Perfil - VacunApp MX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/crear-perfil.css">
</head>
<body>
  <header>
    <div class="container-fluid">
      <div class="logo">
        VacunApp <span class="mx">MX</span>
      </div>
    </div>
  </header>
    <div class="container d-flex justify-content-center py-5">
        <div class="card-custom">
            <h2 class="text-center mb-4">Crear Nuevo Perfil</h2>
            <form action="../controladores/registro_process.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="nombre" class="form-control mb-3" placeholder="Nombre(s)" required>
                <input type="text" name="apellido_mat" class="form-control mb-3" placeholder="Apellido materno" required>
                <input type="text" name="apellido_pat" class="form-control mb-3" placeholder="Apellido paterno" required>
                <label class="form-label text-muted ms-1">Fecha de Nacimiento:</label>
                <input type="date" name="fecha_nac" class="form-control mb-3" required>
                <input type="text" name="curp" class="form-control mb-3" placeholder="CURP" required>
                <input type="text" name="usuario" class="form-control mb-3" placeholder="Crea un nombre de usuario" required>
                <input type="password" name="password" class="form-control mb-3" placeholder="Contraseña" required>
                <div class="mb-3">
                    <label class="form-label text-muted ms-1">Foto de perfil:</label>
                    <input class="form-control" type="file" name="foto_perfil" accept="image/*">
                </div>
                <button type="submit" class="btn-primary-custom w-100">
                    Registrarse
                </button>
            </form>
        </div>
    </div>
</body>
</html>