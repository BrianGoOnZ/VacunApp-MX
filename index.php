<?php 
session_start(); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VacunApp MX - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style/style-index.css">
</head>
<body>
    <header>
        <?php include 'vistas/componentes/navbar.php'; ?>
    </header>
    <main>
        <div class="bienvenida">¡Bienvenid@ a VacunApp MX!</div> 
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-md-8">
                    <div class="card-info">
                        <img src="img-medios-VApp/campana-vacunacion.webp" alt="campana de vacunacion" class="imagen-vacunacion">
                        <div class="info-campana">
                            <h3 class="titulo-campana">Campaña de Vacunación 2026</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-info d-flex flex-column justify-content-center">           
                        <?php if(isset($_GET['error']) && $_GET['error'] == 'acceso_denegado'): ?>
                            <div class="alert alert-danger text-center mb-3" style="border-radius: 10px; font-weight: bold; font-size: 0.85rem;">
                                <i class="fas fa-lock me-2"></i>Inicia sesión para acceder
                            </div>
                        <?php endif; ?>
                        <?php if(isset($_SESSION['usuario'])): ?>
                            <div class="user-logged py-3 text-center">
                                <h3 class="mb-2" style="color: #000291;">Hola, <br><strong><?php echo $_SESSION['usuario']; ?></strong></h3>
                                <p class="text-muted small mb-4">Sesión activa</p>
                                <a href="vistas/home.php" class="btn-iniciarsesion mb-2 d-block">Mi Perfil</a>
                                <a href="/VacunApp-MX/controladores/logout.php" class="btn-logout d-block">Cerrar Sesión</a>
                            </div>
                        <?php else: ?>
                            <a href="vistas/login.php" class="btn-iniciarsesion">Iniciar Sesión</a>
                            <a href="vistas/crear-perfil.php" class="btn-iniciarsesion">Registrarse</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div> 
            <div class="row g-4 mt-2 justify-content-center">
                <div class="col-md-4 col-sm-6">
                    <div class="card-info">
                        <img src="img-medios-VApp/nuevas-vacunas.webp" alt="vacunas" class="imagen-chica">
                        <h3 class="titulo-campana">Nuevas Vacunas Disponibles</h3>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="card-info">
                        <img src="img-medios-VApp/secre-salud.webp" alt="secretario" class="imagen-chica">
                        <h3 class="titulo-campana">Mensaje del Secretario de Salud</h3>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="card-info">
                        <img src="img-medios-VApp/nueva-gomez.webp" alt="clinica" class="imagen-chica">
                        <h3 class="titulo-campana">Clínica Nueva en Durango</h3>
                    </div>
                </div>
            </div>
        </div>
        <section class="info-educativa mt-5">
            <div class="container">
                <h2 class="titulo-seccion">Información Educativa</h2>
                <div class="row g-4 justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="card-educativa">
                            <div class="card-header"><span>COVID-19</span><button class="btn-cerrar">✕</button></div>
                            <img src="img-medios-VApp/cov-19.webp" alt="COVID-19" class="imagen-card">
                            <p class="texto-card">Contenido educativo sobre vacunas COVID-19.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card-educativa">
                            <div class="card-header"><span>Jornadas</span><button class="btn-cerrar">✕</button></div>
                            <img src="img-medios-VApp/clinica-dgo.webp" alt="Jornada" class="imagen-card">
                            <p class="texto-card">Información sobre campañas locales.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card-educativa">
                            <div class="card-header"><span>Prevención</span><button class="btn-cerrar">✕</button></div>
                            <img src="img-medios-VApp/prevencioncoronavirus-g.jpg" alt="Prevención" class="imagen-card">
                            <p class="texto-card">Consejos de cuidado comunitario.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card-educativa">
                            <div class="card-header"><span>Infantil</span><button class="btn-cerrar">✕</button></div>
                            <img src="img-medios-VApp/vacuna-nina.webp" alt="Niños" class="imagen-card">
                            <p class="texto-card">Guía sobre vacunas para niños.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card-educativa">
                            <div class="card-header"><span>Noticias</span><button class="btn-cerrar">✕</button></div>
                            <img src="img-medios-VApp/Noticias sobre clínicas y jornadas de vacunación..webp" alt="Noticias" class="imagen-card">
                            <p class="texto-card">Jornadas de vacunación actuales.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card-educativa ia-card">
                            <div class="card-header"><span>Asistente IA</span></div>
                            <div class="contenido-ia p-4 text-center">
                                <button class="btn-ia">¿En qué puedo ayudarte?</button>
                            </div>
                        </div>
                    </div>
                </div> 
            </div> 
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.btn-cerrar').forEach(boton => {
            boton.addEventListener('click', function() {
                this.closest('.col-lg-4').remove();
            });
        });
        setTimeout(function() {
            let alert = document.querySelector('.alert');
            if(alert) {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 5000);
            }
        }, 5000);
    </script>
</body>
</html>