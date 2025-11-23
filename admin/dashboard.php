<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - HegiaSystem</title>
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
            min-height: 100vh;
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

        .btn-logout {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            font-weight: 600;
            padding: 8px 25px;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-logout:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            color: white;
        }

        /* Hero Section para Dashboard */
        .dashboard-hero {
            background: linear-gradient(rgba(44, 62, 80, 0.85), rgba(26, 188, 156, 0.7)), url('https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 100px 0 60px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .dashboard-hero::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: linear-gradient(transparent, var(--global-bg));
            z-index: 1;
        }

        .dashboard-hero-content {
            position: relative;
            z-index: 2;
        }

        .dashboard-hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        .dashboard-hero p {
            font-size: 1.3rem;
            max-width: 600px;
            margin: 0 auto;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        /* Sección de Dashboard */
        .dashboard-section {
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

        /* Tarjetas de módulos */
        .module-card {
            background-color: var(--card-bg);
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
            overflow: hidden;
        }

        .module-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .module-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .module-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #16a085 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            box-shadow: 0 8px 20px rgba(26, 188, 156, 0.4);
        }

        .module-icon i {
            font-size: 2rem;
            color: white;
        }

        .module-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: white;
        }

        .module-description {
            color: #bdc3c7;
            margin-bottom: 25px;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .btn-module {
            background: linear-gradient(135deg, var(--primary-color) 0%, #16a085 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            box-shadow: 0 4px 15px rgba(26, 188, 156, 0.3);
            text-decoration: none;
            display: block;
        }

        .btn-module:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26, 188, 156, 0.4);
            color: white;
        }

        /* Estadísticas rápidas */
        .stats-section {
            padding: 60px 0;
            background-color: rgba(255, 255, 255, 0.03);
        }

        .stat-card {
            background-color: var(--card-bg);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-left: 4px solid var(--primary-color);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .stat-label {
            color: #bdc3c7;
            font-size: 1rem;
            font-weight: 600;
        }

        /* Footer */
        footer {
            background-color: #1a252f;
            color: white;
            padding: 40px 0 20px;
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
            .dashboard-hero h1 {
                font-size: 2.5rem;
            }
            
            .dashboard-hero p {
                font-size: 1.1rem;
            }
            
            .module-card {
                margin-bottom: 25px;
            }
            
            .stat-card {
                margin-bottom: 20px;
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
            <a href="logout.php" class="btn btn-logout">
                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="dashboard-hero">
        <div class="container dashboard-hero-content">
            <h1>Panel de Administración</h1>
            <p>Gestiona todos los aspectos de tu negocio desde un solo lugar</p>
        </div>
    </div>

    <!-- Sección de Módulos -->
    <div class="dashboard-section">
        <div class="container">
            <div class="section-title">
                <h2>Módulos de Gestión</h2>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="module-card">
                        <div class="module-icon">
                            <i class="fas fa-cubes"></i>
                        </div>
                        <h3 class="module-title">Gestión de Productos</h3>
                        <p class="module-description">Administra el catálogo completo de productos, precios, descripciones e imágenes.</p>
                        <a href="productos/index.php" class="btn btn-module">
                            <i class="fas fa-cog me-2"></i>Gestionar Productos
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="module-card">
                        <div class="module-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <h3 class="module-title">Gestión de Categorías</h3>
                        <p class="module-description">Organiza tus productos en categorías para una mejor navegación.</p>
                        <a href="categorias/index.php" class="btn btn-module">
                            <i class="fas fa-cog me-2"></i>Gestionar Categorías
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="module-card">
                        <div class="module-icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <h3 class="module-title">Gestión de Inventario</h3>
                        <p class="module-description">Controla el stock, movimientos y alertas de productos en tiempo real.</p>
                        <a href="inventario/index.php" class="btn btn-module">
                            <i class="fas fa-cog me-2"></i>Gestionar Inventario
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Estadísticas -->
    <div class="stats-section">
        <div class="container">
            <div class="section-title">
                <h2>Resumen General</h2>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-number" id="total-products">0</div>
                        <div class="stat-label">Productos Totales</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-number" id="total-categories">0</div>
                        <div class="stat-label">Categorías</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-number" id="low-stock">0</div>
                        <div class="stat-label">Productos con Stock Bajo</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-number" id="active-products">0</div>
                        <div class="stat-label">Productos Activos</div>
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
                    <a href="../empresa/nosotros.php">Nosotros</a>
                    <a href="../empresa/servicios.php">Servicios</a>
                    <a href="../empresa/contacto.php">Contacto</a>
                </div>
            </div>
            <div class="copyright">
                <small>HegiaSystem © 2025 - Todos los derechos reservados</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simulación de datos estadísticos (puedes reemplazar con datos reales de tu BD)
        document.addEventListener('DOMContentLoaded', function() {
            // Simular carga de datos
            setTimeout(() => {
                document.getElementById('total-products').textContent = '45';
                document.getElementById('total-categories').textContent = '8';
                document.getElementById('low-stock').textContent = '3';
                document.getElementById('active-products').textContent = '42';
            }, 500);
        });
    </script>
</body>
</html>