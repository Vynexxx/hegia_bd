<?php
// Conexión a la base de datos
$pdo = new PDO('mysql:host=localhost;dbname=hegia_bd', 'root', '');

// Obtener todas las categorías
$categorias = $pdo->query("SELECT * FROM categorias ORDER BY nombre ASC")->fetchAll(PDO::FETCH_OBJ);

// Verificar si se ha seleccionado una categoría
$productos = [];
$categoria_actual = null;
if (isset($_GET['categoria_id'])) {
    $categoria_id = $_GET['categoria_id'];
    // Obtener productos de la categoría seleccionada
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id_categoria = ?");
    $stmt->execute([$categoria_id]);
    $productos = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    // Obtener información de la categoría actual
    $stmt_cat = $pdo->prepare("SELECT * FROM categorias WHERE id_categoria = ?");
    $stmt_cat->execute([$categoria_id]);
    $categoria_actual = $stmt_cat->fetch(PDO::FETCH_OBJ);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos - HegiaSystem</title>
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

        .btn-catalog {
            background-color: white;
            color: var(--primary-color);
            font-weight: 600;
            padding: 8px 25px;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-catalog:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Hero Section para Catálogo */
        .catalog-hero {
            background: linear-gradient(rgba(44, 62, 80, 0.85), rgba(26, 188, 156, 0.7)), url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 120px 0 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .catalog-hero::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: linear-gradient(transparent, var(--global-bg));
            z-index: 1;
        }

        .catalog-hero-content {
            position: relative;
            z-index: 2;
        }

        .catalog-hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        .catalog-hero p {
            font-size: 1.3rem;
            max-width: 700px;
            margin: 0 auto;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        /* Sección de catálogo */
        .catalog-section {
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

        /* Filtros de categorías */
        .category-filters {
            background-color: var(--card-bg);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .category-btn {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 12px 25px;
            border-radius: 25px;
            margin: 8px;
            transition: all 0.3s ease;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }

        .category-btn:hover,
        .category-btn.active {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(26, 188, 156, 0.3);
        }

        /* Tarjetas de productos */
        .product-card {
            background-color: var(--card-bg);
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
            height: 100%;
        }

        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .product-img {
            height: 250px;
            width: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-img {
            transform: scale(1.05);
        }

        .product-info {
            padding: 25px;
        }

        .product-category {
            color: var(--primary-color);
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .product-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: white;
            line-height: 1.3;
        }

        .product-description {
            color: #bdc3c7;
            margin-bottom: 20px;
            font-size: 0.95rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 20px;
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .product-stock {
            color: #2ecc71;
            font-weight: 600;
        }

        .product-code {
            color: #bdc3c7;
            font-size: 0.9rem;
        }

        /* Botón de acción */
        .btn-product {
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
            text-align: center;
        }

        .btn-product:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26, 188, 156, 0.4);
            color: white;
        }

        /* Estado vacío */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: white;
        }

        .empty-state p {
            color: #bdc3c7;
            font-size: 1.1rem;
            max-width: 500px;
            margin: 0 auto;
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
            .catalog-hero h1 {
                font-size: 2.5rem;
            }
            
            .catalog-hero p {
                font-size: 1.1rem;
            }
            
            .product-card {
                margin-bottom: 25px;
            }
            
            .category-filters {
                text-align: center;
            }
            
            .category-btn {
                display: block;
                width: 100%;
                margin: 5px 0;
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
            <a href="../index.php" class="btn-catalog">Volver al inicio</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="catalog-hero">
        <div class="container catalog-hero-content">
            <h1>Nuestro Catálogo</h1>
            <p>Descubre nuestra amplia gama de productos prefabricados de alta calidad para construcción</p>
        </div>
    </div>

    <!-- Sección de Catálogo -->
    <div class="catalog-section">
        <div class="container">
            <div class="section-title">
                <h2>Productos Disponibles</h2>
            </div>

            <!-- Filtros de categorías -->
            <div class="category-filters">
                <h4 class="text-center mb-4">Filtrar por categoría</h4>
                <div class="text-center">
                    <a href="catalogo.php" class="btn category-btn <?php echo !isset($_GET['categoria_id']) ? 'active' : ''; ?>">
                        <i class="fas fa-th-large me-2"></i>Todas las categorías
                    </a>
                    <?php foreach ($categorias as $categoria): ?>
                        <a href="catalogo.php?categoria_id=<?php echo $categoria->id_categoria; ?>" 
                           class="btn category-btn <?php echo ($categoria_actual && $categoria_actual->id_categoria == $categoria->id_categoria) ? 'active' : ''; ?>">
                            <i class="fas fa-cube me-2"></i><?php echo $categoria->nombre; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Productos -->
            <?php if (!empty($productos)): ?>
                <div class="row">
                    <?php foreach ($productos as $producto): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="product-card">
                                <img src="../imagenes/<?php echo $producto->imagen; ?>" class="product-img" alt="<?php echo $producto->nombre; ?>">
                                <div class="product-info">
                                    <div class="product-category">
                                        <?php echo $categoria_actual ? $categoria_actual->nombre : 'Producto'; ?>
                                    </div>
                                    <h3 class="product-title"><?php echo $producto->nombre; ?></h3>
                                    <p class="product-description"><?php echo $producto->descripcion; ?></p>
                                    <div class="product-price">S/ <?php echo number_format($producto->precio, 2); ?></div>
                                    
                                    <div class="product-meta">
                                        <span class="product-stock">
                                            <i class="fas fa-check-circle me-1"></i>En stock
                                        </span>
                                        <span class="product-code">#<?php echo str_pad($producto->id_producto, 4, '0', STR_PAD_LEFT); ?></span>
                                    </div>
                                    
                                    <a href="../empresa/contacto.php" class="btn btn-product mt-3">
                                        <i class="fas fa-info-circle me-2"></i>Solicitar Información
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- Estado vacío -->
                <div class="empty-state">
                    <i class="fas fa-box-open"></i>
                    <h3>No hay productos disponibles</h3>
                    <p><?php echo $categoria_actual ? 
                        "Actualmente no tenemos productos en la categoría '{$categoria_actual->nombre}'." : 
                        "Selecciona una categoría para ver los productos disponibles."; ?>
                    </p>
                    <?php if (!$categoria_actual): ?>
                        <p class="mt-3">Utiliza los filtros de arriba para explorar nuestras categorías.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
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
</body>
</html>