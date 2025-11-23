<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - HegiaSystem</title>
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

        /* Hero Section para Servicios */
        .services-hero {
            background: linear-gradient(rgba(44, 62, 80, 0.85), rgba(26, 188, 156, 0.7)), url('https://images.unsplash.com/photo-1541888946425-d81bb19240f5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 120px 0 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .services-hero::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: linear-gradient(transparent, var(--global-bg));
            z-index: 1;
        }

        .services-hero-content {
            position: relative;
            z-index: 2;
        }

        .services-hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        .services-hero p {
            font-size: 1.3rem;
            max-width: 700px;
            margin: 0 auto;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        /* Sección de servicios */
        .services-section {
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

        /* Tarjetas de servicios */
        .service-card {
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
            margin-bottom: 30px;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .service-card i {
            font-size: 3.5rem;
            color: var(--primary-color);
            margin-bottom: 25px;
            display: block;
        }

        .service-card h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: white;
        }

        .service-card p {
            font-size: 1rem;
            color: #bdc3c7;
            margin-bottom: 20px;
        }

        .service-features {
            list-style: none;
            padding: 0;
            margin: 20px 0;
            text-align: left;
        }

        .service-features li {
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: #bdc3c7;
        }

        .service-features li:last-child {
            border-bottom: none;
        }

        .service-features li i {
            font-size: 1rem;
            color: var(--primary-color);
            margin-right: 10px;
        }

        /* Sección de proceso */
        .process-section {
            padding: 80px 0;
            background-color: rgba(255, 255, 255, 0.03);
        }

        .process-step {
            text-align: center;
            padding: 20px;
        }

        .step-number {
            width: 60px;
            height: 60px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0 auto 20px;
        }

        .process-step h4 {
            font-size: 1.3rem;
            margin-bottom: 15px;
            color: white;
        }

        .process-step p {
            color: #bdc3c7;
        }

        /* Sección de CTA */
        .cta-section {
            padding: 80px 0;
            text-align: center;
        }

        .cta-box {
            background: linear-gradient(135deg, var(--primary-color) 0%, #16a085 100%);
            border-radius: 15px;
            padding: 60px 40px;
            color: white;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .cta-box h3 {
            font-size: 2.2rem;
            margin-bottom: 20px;
        }

        .cta-box p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .btn-cta {
            background-color: white;
            color: var(--primary-color);
            font-weight: bold;
            padding: 14px 40px;
            border-radius: 30px;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
        }

        .btn-cta:hover {
            background-color: #f8f9fa;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.4);
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
            .services-hero h1 {
                font-size: 2.5rem;
            }
            
            .services-hero p {
                font-size: 1.1rem;
            }
            
            .service-card {
                margin-bottom: 30px;
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
    <div class="services-hero">
        <div class="container services-hero-content">
            <h1>Nuestros Servicios</h1>
            <p>Soluciones integrales en productos prefabricados para construcción, diseñados para satisfacer las necesidades de tu proyecto</p>
        </div>
    </div>

    <!-- Sección de Servicios -->
    <div class="services-section">
        <div class="container">
            <div class="section-title">
                <h2>Servicios Especializados</h2>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="service-card">
                        <i class="fas fa-cubes"></i>
                        <h3>Fabricación de Bloques de Concreto</h3>
                        <p>Producimos bloques de alta calidad para todo tipo de construcción, garantizando durabilidad y resistencia.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> Variedad de tamaños y especificaciones</li>
                            <li><i class="fas fa-check"></i> Materiales de primera calidad</li>
                            <li><i class="fas fa-check"></i> Cumplimiento de normas técnicas</li>
                            <li><i class="fas fa-check"></i> Entrega puntual y confiable</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="service-card">
                        <i class="fas fa-fence"></i>
                        <h3>Provisión de Cercos de Concreto</h3>
                        <p>Ofrecemos cercos resistentes y duraderos para delimitar terrenos y propiedades con máxima seguridad.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> Diseños personalizados</li>
                            <li><i class="fas fa-check"></i> Instalación profesional</li>
                            <li><i class="fas fa-check"></i> Materiales de larga duración</li>
                            <li><i class="fas fa-check"></i> Resistencia a condiciones climáticas</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="service-card">
                        <i class="fas fa-tools"></i>
                        <h3>Alquiler de Maquinaria</h3>
                        <p>Contamos con maquinaria especializada para tus proyectos de construcción, disponible para alquiler.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> Equipos modernos y mantenidos</li>
                            <li><i class="fas fa-check"></i> Operadores capacitados</li>
                            <li><i class="fas fa-check"></i> Flexibilidad en plazos de alquiler</li>
                            <li><i class="fas fa-check"></i> Soporte técnico permanente</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="service-card">
                        <i class="fas fa-headset"></i>
                        <h3>Asesoría Técnica</h3>
                        <p>Brindamos soporte y asesoría técnica especializada para optimizar el uso de nuestros productos.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> Consultoría personalizada</li>
                            <li><i class="fas fa-check"></i> Soluciones a medida</li>
                            <li><i class="fas fa-check"></i> Análisis de proyectos</li>
                            <li><i class="fas fa-check"></i> Soporte post-venta</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Proceso -->
    <div class="process-section">
        <div class="container">
            <div class="section-title">
                <h2>Nuestro Proceso de Trabajo</h2>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="process-step">
                        <div class="step-number">1</div>
                        <h4>Consulta</h4>
                        <p>Analizamos tus necesidades y requerimientos específicos para ofrecerte la mejor solución.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="process-step">
                        <div class="step-number">2</div>
                        <h4>Cotización</h4>
                        <p>Preparamos una cotización detallada con precios competitivos y plazos de entrega.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="process-step">
                        <div class="step-number">3</div>
                        <h4>Producción</h4>
                        <p>Fabricamos tus productos con los más altos estándares de calidad y eficiencia.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="process-step">
                        <div class="step-number">4</div>
                        <h4>Entrega</h4>
                        <p>Realizamos la entrega puntual en tu obra, garantizando la satisfacción total.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección CTA -->
    <div class="cta-section">
        <div class="container">
            <div class="cta-box">
                <h3>¿Listo para comenzar tu proyecto?</h3>
                <p>Contáctanos hoy mismo y recibe una cotización personalizada para tus necesidades de construcción</p>
                <a href="contacto.php" class="btn btn-cta btn-lg">Solicitar Cotización</a>
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