<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');  // Redirigir al login si no está logueado
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
    <style>
        /* Colores de la paleta */
        :root {
            --primary-color: #1abc9c;  /* Verde vibrante */
            --secondary-color: #f39c12;  /* Naranja */
            --background-color: #34495e;  /* Gris oscuro */
            --text-color: #ecf0f1;  /* Blanco grisáceo */
            --button-color: #e74c3c;  /* Rojo */
            --global-bg: #2c3e50; /* Fondo oscuro */
        }

        /* Fondo de toda la página */
        body {
            background-color: var(--global-bg);
            color: var(--text-color);
            font-family: 'Arial', sans-serif;
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

        /* Título del Dashboard */
        .container h2 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 30px;
        }

        /* Botones de acceso a los CRUD */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: bold;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #16a085; /* Verde más oscuro */
            border-color: #16a085;
        }

        .btn-lg {
            padding: 15px 30px;
            font-size: 1.25rem;
        }

        /* Estilo de las columnas */
        .row .col-md-4 {
            margin-bottom: 20px;
        }

    </style>
</head>
<body>

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">HegiaSystem</a>
        <a href="logout.php" class="btn btn-black-home">Cerrar sesión</a>

    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center text-success mb-4">Panel de Administración</h2>

    <!-- Botones de acceso a los CRUD -->
    <div class="row text-center">
        <div class="col-md-4">
            <a href="productos/index.php" class="btn btn-primary btn-lg w-100">Gestionar Productos</a>
        </div>
        <div class="col-md-4">
            <a href="categorias/index.php" class="btn btn-primary btn-lg w-100">Gestionar Categorías</a>
        </div>
        <div class="col-md-4">
            <a href="inventario/index.php" class="btn btn-primary btn-lg w-100">Gestionar Inventario</a>
        </div>
    </div>
</div>

</body>
</html>