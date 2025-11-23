<?php
// Conexión a la base de datos
$pdo = new PDO('mysql:host=localhost;dbname=hegia_bd', 'root', '');

// Obtener todas las categorías
$categorias = $pdo->query("SELECT * FROM categorias ORDER BY nombre ASC")->fetchAll(PDO::FETCH_OBJ);

// Verificar si se ha seleccionado una categoría
$productos = [];
if (isset($_GET['categoria_id'])) {
    $categoria_id = $_GET['categoria_id'];
    // Obtener productos de la categoría seleccionada
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id_categoria = ?");
    $stmt->execute([$categoria_id]);
    $productos = $stmt->fetchAll(PDO::FETCH_OBJ);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: var(--global-bg); /* Fondo oscuro similar al index */
            color: var(--text-color);  /* Color de texto similar al index */
            font-family: 'Arial', sans-serif;
        }

        /* Colores de la paleta */
        :root {
            --primary-color: #1abc9c;  /* Verde vibrante */
            --secondary-color: #f39c12;  /* Naranja */
            --background-color: #34495e;  /* Gris oscuro */
            --text-color: #ecf0f1;  /* Blanco grisáceo */
            --button-color: #e74c3c;  /* Rojo */
            --global-bg: #2c3e50; /* Fondo oscuro */
        }

        /* Navbar */
        nav.navbar {
            background-color: var(--primary-color); /* Verde de la página principal */
        }

        nav.navbar .navbar-brand,
        nav.navbar .btn {
            color: white;
        }

        nav.navbar .btn:hover {
            background-color: #16a085; /* Verde más oscuro */
        }

        /* Estilo para el botón de categorías */
        .dropdown-toggle {
            background-color: var(--primary-color); /* Verde de la página principal */
            color: white;
            border: none;
            font-weight: bold;
        }

        .dropdown-toggle:hover {
            background-color: #16a085; /* Verde más oscuro cuando se pasa el mouse */
        }

        .category-section {
            padding: 50px 0;
            background-color: var(--global-bg); /* Fondo oscuro similar al index */
        }

        .category-section h2 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            color: var(--primary-color); /* Título en verde */
        }

        /* Card styling */
        .product-card {
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            background-color: #34495e; /* Fondo oscuro para las cards */
        }

        .product-card img {
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .product-card-body {
            padding: 15px;
        }

        .product-card-body h5 {
            font-size: 1.25rem;
            margin-bottom: 10px;
            color: white; /* Título del producto en blanco */
        }

        .product-card-body p {
            font-size: 1rem;
            color: #95a5a6; /* Color gris claro para la descripción */
        }

        .btn-custom {
            background-color: var(--secondary-color); /* Naranja como botón */
            color: white;
            font-weight: bold;
            padding: 10px 30px;
            border-radius: 20px;
            text-decoration: none;
        }

        .btn-custom:hover {
            background-color: #d35400; /* Naranja más oscuro */
        }

        /* Botón de "Volver al inicio" */
        .btn-back-home {
            background-color: #16a085; /* Verde oscuro */
            color: white;
            font-weight: bold;
            padding: 10px 30px;
            border-radius: 20px;
            text-decoration: none;
        }

        .btn-back-home:hover {
            background-color: #1abc9c; /* Verde claro */
        }

        /* Footer */
        footer {
            background-color: var(--background-color); /* Gris oscuro como en el index */
            color: white;
            padding: 30px 0;
            text-align: center;
        }

        footer small {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">HegiaSystem</a>
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                Categorías
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?php foreach ($categorias as $categoria): ?>
                    <li><a class="dropdown-item" href="catalogo.php?categoria_id=<?php echo $categoria->id_categoria; ?>"><?php echo $categoria->nombre; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Categorías y Productos -->
<div class="container category-section">
    <h2 class="text-center">Productos</h2>
    <div class="row">
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $producto): ?>
                <div class="col-md-3 mb-4">
                    <div class="card product-card">
                        <img src="imagenes/<?php echo $producto->imagen; ?>" class="card-img-top" alt="Imagen del producto">
                        <div class="product-card-body">
                            <h5 class="card-title"><?php echo $producto->nombre; ?></h5>
                            <p class="card-text"><?php echo $producto->descripcion; ?></p>
                            <p><strong>Precio:</strong> S/ <?php echo number_format($producto->precio, 2); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay productos disponibles para esta categoría.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Botón Volver al inicio -->
<div class="text-center mb-4">
    <a href="../index.php" class="btn btn-back-home">Volver al inicio</a>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-4">
    <small>HegiaSystem © 2025 - Todos los derechos reservados</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>