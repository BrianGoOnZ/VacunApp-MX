<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VacunApp MX - Centros</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../style/style-index.css">
  <link rel="stylesheet" href="../style/centros.css">
</head>
<body>
  <header>
    <?php include('componentes/navbar.php')?>
  </header>
  <main>
    <div class="bienvenida text-center">CENTROS CERCANOS</div>
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
          <div class="card-info p-4 mb-4 shadow-sm border-0 rounded-4">
            <div class="row align-items-center">
              <div class="col-2 text-center">
                <div class="punto-decorativo"></div>
              </div>
              <div class="col-7">
                <h3 class="titulo-centro">Hospital General 450</h3>
                <p class="info-texto">Av. Universidad S/N, Durango, Dgo.</p>
                <p class="info-texto">Horario: 08:00 AM - 08:00 PM</p>
              </div>
              <div class="col-3 text-end d-flex flex-column gap-2">
                <span class="badge-vacunas">Vacunas Disponibles</span>
                <a href="https://www.google.com/maps/search/?api=1&query=Hospital+General+450+Durango" target="_blank" class="btn-mapa">Ver en Mapa</a>
              </div>
            </div>
          </div>
          <div class="card-info p-4 mb-4 shadow-sm border-0 rounded-4">
            <div class="row align-items-center">
              <div class="col-2 text-center">
                <div class="punto-decorativo"></div>
              </div>
              <div class="col-7">
                <h3 class="titulo-centro">Clínica IMSS No. 1</h3>
                <p class="info-texto">Predio Canoas, Durango, Dgo.</p>
                <p class="info-texto">Horario: 24 Horas</p>
              </div>
              <div class="col-3 text-end d-flex flex-column gap-2">
                <span class="badge-vacunas">Vacunas Disponibles</span>
                <a href="https://www.google.com/maps/search/?api=1&query=Clinica+IMSS+1+Durango+Canoas" target="_blank" class="btn-mapa">Ver en Mapa</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>