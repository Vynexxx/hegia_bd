<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener las credenciales de login
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Compara con los datos del admin (puedes hacer una consulta a la base de datos si es necesario)
    if ($usuario == "admin" && $contraseña == "12345") {  // Cambia esto por un sistema real de login
        $_SESSION['logged_in'] = true;
        header('Location: dashboard.php');  // Redirigir al dashboard
        exit;
    } else {
        $error = "Credenciales incorrectas";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - HegiaSystem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Diseño similar al de la página principal */
        body {
            background-color: #2c3e50;
            color: #ecf0f1;
        }

        .hero {
            background: url('https://via.placeholder.com/1600x800') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: bold;
        }

        .hero p {
            font-size: 1.2rem;
        }

        .btn-custom {
            background-color: #f39c12;
            color: white;
            font-weight: bold;
            padding: 12px 30px;
            border-radius: 20px;
            width: 100%;
        }

        .btn-custom:hover {
            background-color: #e67e22;
        }

        .login-container {
            background-color: #34495e;
            padding: 40px;
            border-radius: 10px;
            max-width: 500px;
            margin: 50px auto;  /* Aumentar el margen superior */
        }

        footer {
            margin-top: 30px;  /* Asegurar que no se pegue al pie */
        }
    </style>
</head>

<body>

    <!-- Hero Section -->
    <div class="hero">
        <h1>Bienvenido a HegiaSystem</h1>
        <p>Por favor, ingresa tus credenciales para acceder al panel administrativo.</p>
    </div>

    <!-- Login Form -->
    <div class="container mt-5">
        <div class="login-container">
            <h2 class="text-center text-success mb-4">Iniciar sesión</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario:</label>
                    <input type="text" name="usuario" id="usuario" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="contraseña" class="form-label">Contraseña:</label>
                    <input type="password" name="contraseña" id="contraseña" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-custom">Iniciar sesión</button>
            </form>
            <br>
            <a href="../index.php" class="btn btn-outline-light w-100">Volver al inicio</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
        <small>HegiaSystem © 2025 - Todos los derechos reservados</small>
    </footer>

</body>
</html>