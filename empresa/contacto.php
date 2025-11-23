<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $mensaje = $_POST['mensaje'];
    
    // Aquí puedes agregar el código para enviar el correo
    // mail("tu@email.com", "Nuevo mensaje de contacto", $mensaje, "From: $correo");
    
    $mensaje_exito = "¡Gracias por tu mensaje, $nombre! Nos pondremos en contacto contigo pronto.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - HegiaSystem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Colores de la paleta */
        :root {
            --primary-color: #1abc9c;  /* Verde vibrante */
            --secondary-color: #f39c12;  /* Naranja */
            --background-color: #34495e;  /* Gris oscuro */
            --text-color: #ecf0f1;  /* Blanco grisáceo */
            --button-color: #e74c3c;  /* Rojo */
            --global-bg: #2c3e50; /* Fondo oscuro */
            --card-bg: #3a506b; /* Fondo de tarjetas */
            --accent-color: #3498db; /* Azul para acentos */
        }

        /* Fondo de toda la página */
        body {
            background-color: var(--global-bg);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }

        /* Navbar mejorada */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, #16a085 100%) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            margin-right: 10px;
            font-size: 1.5rem;
        }

        .btn-back-home {
            background-color: white;
            color: var(--primary-color);
            font-weight: 600;
            padding: 8px 25px;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-back-home:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Hero Section para Contacto */
        .contact-hero {
            background: linear-gradient(rgba(44, 62, 80, 0.85), rgba(26, 188, 156, 0.7)), url('https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 120px 0 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .contact-hero::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: linear-gradient(transparent, var(--global-bg));
            z-index: 1;
        }

        .contact-hero-content {
            position: relative;
            z-index: 2;
        }

        .contact-hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        .contact-hero p {
            font-size: 1.3rem;
            max-width: 700px;
            margin: 0 auto;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        /* Sección de contacto */
        .contact-section {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            display: inline-block;
            padding-bottom: 15px;
            position: relative;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        /* Tarjeta de formulario */
        .form-card {
            background-color: var(--card-bg);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        /* Estilos para el formulario */
        .form-label {
            color: white;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: var(--primary-color);
            color: white;
            box-shadow: 0 0 0 0.2rem rgba(26, 188, 156, 0.25);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Botón personalizado */
        .btn-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, #16a085 100%);
            color: white;
            font-weight: bold;
            padding: 14px 35px;
            border-radius: 30px;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(26, 188, 156, 0.4);
            width: 100%;
            margin-top: 10px;
        }

        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(26, 188, 156, 0.6);
            color: white;
        }

        /* Información de contacto */
        .contact-info {
            background-color: var(--card-bg);
            border-radius: 15px;
            padding: 40px;
            height: 100%;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 30px;
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #16a085 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .contact-icon i {
            font-size: 1.2rem;
            color: white;
        }

        .contact-details h4 {
            font-size: 1.2rem;
            margin-bottom: 5px;
            color: white;
        }

        .contact-details p {
            color: #bdc3c7;
            margin-bottom: 0;
        }

        /* Mapa */
        .map-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin-top: 30px;
        }

        .map-container iframe {
            width: 100%;
            height: 300px;
            border: none;
        }

        /* Alerta de éxito */
        .alert-success {
            background: linear-gradient(135deg, var(--primary-color) 0%, #16a085 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(26, 188, 156, 0.3);
        }

        /* Footer */
        footer {
            background-color: #1a252f;
            color: white;
            padding: 50px 0 20px;
        }

        .footer-content {
            text-align: center;
            margin-bottom: 30px;
        }

        .footer-logo {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }

        .copyright {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
            color: #95a5a6;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .contact-hero h1 {
                font-size: 2.5rem;
            }
            
            .contact-hero p {
                font-size: 1.1rem;
            }
            
            .contact-item {
                flex-direction: column;
                text-align: center;
            }
            
            .contact-icon {
                margin-right: 0;
                margin-bottom: 15px;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-industry"></i>HegiaSystem
            </a>
            <a href="../index.php" class="btn-back-home">Volver al inicio</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="contact-hero">
        <div class="container contact-hero-content">
            <h1>Contáctanos</h1>
            <p>Estamos aquí para ayudarte. Escríbenos y te responderemos a la brevedad</p>
        </div>
    </div>

    <!-- Sección de Contacto -->
    <div class="contact-section">
        <div class="container">
            <div class="section-title">
                <h2>Ponte en Contacto</h2>
            </div>

            <?php if (isset($mensaje_exito)): ?>
                <div class="alert alert-success text-center" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?php echo $mensaje_exito; ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <!-- Formulario de contacto -->
                <div class="col-lg-8 mb-4">
                    <div class="form-card">
                        <h3 class="mb-4">Envía tu mensaje</h3>
                        <form action="contacto.php" method="post">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label">Nombre completo *</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Tu nombre completo" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="correo" class="form-label">Correo electrónico *</label>
                                    <input type="email" name="correo" id="correo" class="form-control" placeholder="tu@email.com" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="mensaje" class="form-label">Mensaje *</label>
                                <textarea name="mensaje" id="mensaje" class="form-control" rows="5" placeholder="Describe tu consulta, proyecto o solicitud..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-custom">
                                <i class="fas fa-paper-plane me-2"></i>Enviar mensaje
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Información de contacto -->
                <div class="col-lg-4 mb-4">
                    <div class="contact-info">
                        <h3 class="mb-4">Información de contacto</h3>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Dirección</h4>
                                <p>Av. Constructores 123<br>Lima, Perú</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Teléfono</h4>
                                <p>+51 987 654 321<br>+51 123 456 789</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Email</h4>
                                <p>info@hegiasystem.com<br>ventas@hegiasystem.com</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Horario de atención</h4>
                                <p>Lun - Vie: 8:00 - 18:00<br>Sáb: 8:00 - 13:00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mapa -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3901.948646822866!2d-77.04224842477645!3d-12.04691894071974!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c5f619ee3ec7%3A0x14206cb9cc452b4a!2sLima!5e0!3m2!1ses!2spe!4v1690834257173!5m2!1ses!2spe" 
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">HegiaSystem</div>
                <div class="footer-links">
                    <a href="../index.php">Inicio</a>
                    <a href="nosotros.php">Nosotros</a>
                    <a href="servicios.php">Servicios</a>
                    <a href="../productos/catalogo.php">Catálogo</a>
                </div>
            </div>
            <div class="copyright">
                <small>HegiaSystem © 2025 - Todos los derechos reservados</small>
            </div>
        </div>
    </footer>

</body>
</html>