<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros - HegiaSystem</title>
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

        /* Hero Section para Nosotros */
        .about-hero {
            background: linear-gradient(rgba(44, 62, 80, 0.85), rgba(26, 188, 156, 0.7)), url('https://images.unsplash.com/photo-1504307651254-35680f356dfd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 120px 0 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .about-hero::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: linear-gradient(transparent, var(--global-bg));
            z-index: 1;
        }

        .about-hero-content {
            position: relative;
            z-index: 2;
        }

        .about-hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        .about-hero p {
            font-size: 1.3rem;
            max-width: 700px;
            margin: 0 auto;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        /* Sección de contenido */
        .about-content {
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

        .about-text {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 40px;
        }

        .highlight-box {
            background-color: var(--card-bg);
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
            border-left: 5px solid var(--primary-color);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* Tarjetas de valores */
        .values-section {
            padding: 80px 0;
            background-color: rgba(255, 255, 255, 0.03);
        }

        .value-card {
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

        .value-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .value-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .value-card i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 25px;
            display: block;
        }

        .value-card h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: white;
        }

        .value-card p {
            font-size: 1rem;
            color: #bdc3c7;
        }

        /* Timeline de historia */
        .timeline-section {
            padding: 80px 0;
        }

        .timeline {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
        }

        .timeline::after {
            content: '';
            position: absolute;
            width: 6px;
            background-color: var(--primary-color);
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -3px;
            border-radius: 3px;
        }

        .timeline-item {
            padding: 10px 40px;
            position: relative;
            width: 50%;
            box-sizing: border-box;
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            width: 25px;
            height: 25px;
            background-color: var(--global-bg);
            border: 4px solid var(--primary-color);
            border-radius: 50%;
            top: 15px;
            z-index: 1;
        }

        .left {
            left: 0;
        }

        .right {
            left: 50%;
        }

        .left::after {
            right: -13px;
        }

        .right::after {
            left: -13px;
        }

        .timeline-content {
            padding: 20px 30px;
            background-color: var(--card-bg);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .timeline-content h3 {
            margin-top: 0;
            color: var(--primary-color);
        }

        /* Equipo */
        .team-section {
            padding: 80px 0;
            background-color: rgba(255, 255, 255, 0.03);
        }

        .team-card {
            background-color: var(--card-bg);
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .team-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .team-img {
            height: 250px;
            background-size: cover;
            background-position: center;
        }

        .team-info {
            padding: 25px;
        }

        .team-info h4 {
            font-size: 1.5rem;
            margin-bottom: 5px;
            color: white;
        }

        .team-info p {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 15px;
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
            .about-hero h1 {
                font-size: 2.5rem;
            }
            
            .about-hero p {
                font-size: 1.1rem;
            }
            
            .timeline::after {
                left: 31px;
            }
            
            .timeline-item {
                width: 100%;
                padding-left: 70px;
                padding-right: 25px;
            }
            
            .timeline-item::after {
                left: 18px;
            }
            
            .right {
                left: 0;
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
    <div class="about-hero">
        <div class="container about-hero-content">
            <h1>¿Quiénes somos?</h1>
            <p>Conoce más sobre nuestra historia, valores y el equipo que hace posible nuestra excelencia</p>
        </div>
    </div>

    <!-- Sección de contenido principal -->
    <div class="about-content">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="section-title">Nuestra Historia</h2>
                    <p class="about-text">
                        En <strong>HegiaSystem</strong> somos una empresa líder en la fabricación de productos prefabricados para la construcción. Con más de 20 años de experiencia, proveemos soluciones confiables para proyectos de construcción de todo tipo.
                    </p>
                    <p class="about-text">
                        Fundada en el año 2000, hemos crecido de manera constante, expandiendo nuestras capacidades productivas y mejorando continuamente nuestros procesos para ofrecer la más alta calidad en cada uno de nuestros productos.
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="highlight-box">
                        <h3>Nuestra Misión</h3>
                        <p>Ofrecer productos de construcción prefabricados de alta calidad y eficiencia, con un enfoque en la sostenibilidad y el cumplimiento de plazos de entrega, contribuyendo al desarrollo de infraestructuras duraderas y confiables.</p>
                        
                        <h3>Nuestra Visión</h3>
                        <p>Ser reconocidos como la empresa líder en soluciones prefabricadas para construcción a nivel nacional, destacando por nuestra innovación, calidad y compromiso con el medio ambiente.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Valores -->
    <div class="values-section">
        <div class="container">
            <h2 class="section-title">Nuestros Valores</h2>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card">
                        <i class="fas fa-medal"></i>
                        <h3>Calidad</h3>
                        <p>Nos comprometemos con los más altos estándares de calidad en todos nuestros productos y procesos.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card">
                        <i class="fas fa-handshake"></i>
                        <h3>Compromiso</h3>
                        <p>Estamos dedicados a cumplir con las expectativas de nuestros clientes en cada proyecto.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card">
                        <i class="fas fa-leaf"></i>
                        <h3>Sostenibilidad</h3>
                        <p>Implementamos prácticas responsables con el medio ambiente en todos nuestros procesos.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Historia (Timeline) -->
    <div class="timeline-section">
        <div class="container">
            <h2 class="section-title">Nuestra Trayectoria</h2>
            <div class="timeline">
                <div class="timeline-item left">
                    <div class="timeline-content">
                        <h3>2000</h3>
                        <p>Fundación de HegiaSystem con una pequeña planta de producción y 10 empleados.</p>
                    </div>
                </div>
                <div class="timeline-item right">
                    <div class="timeline-content">
                        <h3>2005</h3>
                        <p>Expansión de nuestra línea de productos y apertura de una segunda planta de producción.</p>
                    </div>
                </div>
                <div class="timeline-item left">
                    <div class="timeline-content">
                        <h3>2010</h3>
                        <p>Certificación ISO 9001 por nuestros sistemas de gestión de calidad.</p>
                    </div>
                </div>
                <div class="timeline-item right">
                    <div class="timeline-content">
                        <h3>2015</h3>
                        <p>Lanzamiento de nuestra línea ecológica de productos sostenibles.</p>
                    </div>
                </div>
                <div class="timeline-item left">
                    <div class="timeline-content">
                        <h3>2020</h3>
                        <p>Celebramos 20 años en el mercado con más de 200 empleados y presencia nacional.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección del Equipo -->
    <div class="team-section">
        <div class="container">
            <h2 class="section-title">Nuestro Equipo Directivo</h2>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="team-card">
                        <div class="team-img" style="background-image: url('../imagenes/León.jpg');"></div>
                        <div class="team-info">
                            <h4>Carlos Rodríguez</h4>
                            <p>Director General</p>
                            <p>Más de 25 años de experiencia en el sector de la construcción.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="team-card">
                        <div class="team-img" style="background-image: url('https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=776&q=80');"></div>
                        <div class="team-info">
                            <h4>Ana Martínez</h4>
                            <p>Directora de Operaciones</p>
                            <p>Especialista en procesos de fabricación y optimización.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="team-card">
                        <div class="team-img" style="background-image: url('https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=761&q=80');"></div>
                        <div class="team-info">
                            <h4>Laura González</h4>
                            <p>Directora de Innovación</p>
                            <p>Responsable del desarrollo de nuevos productos y tecnologías.</p>
                        </div>
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
                    <a href="servicios.php">Servicios</a>
                    <a href="../productos/catalogo.php">Catálogo</a>
                    <a href="contacto.php">Contacto</a>
                </div>
            </div>
            <div class="copyright">
                <small>HegiaSystem © 2025 - Todos los derechos reservados</small>
            </div>
        </div>
    </footer>

</body>
</html>