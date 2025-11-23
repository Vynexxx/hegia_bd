<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HegiaSystem - Página Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Colores de la paleta actualizada */
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

        .navbar .btn {
            border-radius: 20px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .navbar .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Hero Section mejorada */
        .hero {
            background: linear-gradient(rgba(44, 62, 80, 0.85), rgba(26, 188, 156, 0.7)), url('https://images.unsplash.com/photo-1504307651254-35680f356dfd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 150px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: linear-gradient(transparent, var(--global-bg));
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 30px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        /* Botones personalizados mejorados */
        .btn-custom {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #e67e22 100%);
            color: white;
            font-weight: bold;
            padding: 14px 40px;
            border-radius: 30px;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(243, 156, 18, 0.4);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0%;
            height: 100%;
            background: linear-gradient(135deg, #e67e22 0%, var(--secondary-color) 100%);
            transition: all 0.3s ease;
            z-index: -1;
        }

        .btn-custom:hover::before {
            width: 100%;
        }

        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(243, 156, 18, 0.6);
        }

        /* Sección de Información mejorada */
        .info-section {
            padding: 100px 0;
            background-color: var(--global-bg);
            position: relative;
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

        .info-card {
            background-color: var(--card-bg);
            border-radius: 15px;
            padding: 40px 30px;
            text-align: center;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .info-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .info-card i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 25px;
            display: block;
        }

        .info-card h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: white;
        }

        .info-card p {
            font-size: 1rem;
            color: #bdc3c7;
            margin-bottom: 25px;
        }

        .info-card .btn {
            border-radius: 20px;
            padding: 10px 25px;
            font-weight: 600;
        }

        /* Footer mejorado */
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

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            background-color: var(--primary-color);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
            color: #95a5a6;
        }

        /* Efectos de scroll suave */
        html {
            scroll-behavior: smooth;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1.1rem;
            }
            
            .info-card {
                margin-bottom: 30px;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-industry"></i>HegiaSystem
            </a>
            <div class="d-flex">
                <a href="productos/catalogo.php" class="btn btn-light me-2">Ver Catálogo</a>
                <a href="admin/login.php" class="btn btn-outline-light">Iniciar sesión</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="container hero-content">
            <h1>Bienvenido a HegiaSystem</h1>
            <p>Tu solución confiable en productos de prefabricados para construcción, con más de 20 años de experiencia en el mercado.</p>
            <a href="productos/catalogo.php" class="btn btn-custom btn-lg">Ver Catálogo</a>
        </div>
    </div>

    <!-- Información de la empresa -->
    <div class="info-section">
        <div class="container">
            <div class="section-title">
                <h2>Nuestros Servicios</h2>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="info-card">
                        <i class="fas fa-users"></i>
                        <h3>¿Quiénes somos?</h3>
                        <p>Somos una empresa líder en la fabricación de productos prefabricados para la construcción, con más de 20 años de experiencia en el mercado.</p>
                        <a href="empresa/nosotros.php" class="btn btn-custom">Más información</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="info-card">
                        <i class="fas fa-concierge-bell"></i>
                        <h3>Servicios</h3>
                        <p>Proveemos bloques de concreto, cercos, y más. Nuestros productos son ideales para proyectos de construcción de cualquier escala.</p>
                        <a href="empresa/servicios.php" class="btn btn-custom">Ver servicios</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="info-card">
                        <i class="fas fa-envelope"></i>
                        <h3>Contacto</h3>
                        <p>¿Tienes alguna consulta o deseas hacer un pedido? Contáctanos y nuestro equipo estará encantado de ayudarte.</p>
                        <a href="empresa/contacto.php" class="btn btn-custom">Contáctanos</a>
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
                    <a href="empresa/nosotros.php">Nosotros</a>
                    <a href="empresa/servicios.php">Servicios</a>
                    <a href="productos/catalogo.php">Catálogo</a>
                    <a href="empresa/contacto.php">Contacto</a>
                </div>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="copyright">
                <small>HegiaSystem © 2025 - Todos los derechos reservados</small>
            </div>
        </div>
    </footer>

</body>
</html>