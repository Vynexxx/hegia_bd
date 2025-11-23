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
            display: flex;
            flex-direction: column;
        }

        /* Hero Section para Login */
        .login-hero {
            background: linear-gradient(rgba(44, 62, 80, 0.85), rgba(26, 188, 156, 0.7)), url('https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 100px 0 60px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-hero::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: linear-gradient(transparent, var(--global-bg));
            z-index: 1;
        }

        .login-hero-content {
            position: relative;
            z-index: 2;
        }

        .login-hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        .login-hero p {
            font-size: 1.3rem;
            max-width: 600px;
            margin: 0 auto;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        /* Contenedor de login */
        .login-section {
            flex: 1;
            padding: 60px 0;
            display: flex;
            align-items: center;
        }

        .login-card {
            background-color: var(--card-bg);
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            max-width: 450px;
            margin: 0 auto;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .login-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #16a085 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: 0 8px 20px rgba(26, 188, 156, 0.4);
        }

        .login-icon i {
            font-size: 2rem;
            color: white;
        }

        .login-title {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 10px;
            color: white;
        }

        .login-subtitle {
            text-align: center;
            color: #bdc3c7;
            margin-bottom: 30px;
            font-size: 1.1rem;
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
            border-radius: 12px;
            padding: 15px 20px;
            transition: all 0.3s ease;
            font-size: 1rem;
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

        .input-group-text {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--primary-color);
        }

        /* Botón personalizado */
        .btn-login {
            background: linear-gradient(135deg, var(--primary-color) 0%, #16a085 100%);
            color: white;
            font-weight: bold;
            padding: 15px 30px;
            border-radius: 25px;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(26, 188, 156, 0.4);
            width: 100%;
            font-size: 1.1rem;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26, 188, 156, 0.6);
            color: white;
        }

        .btn-back {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 25px;
            transition: all 0.3s ease;
            width: 100%;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 15px;
        }

        .btn-back:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        /* Alerta de error */
        .alert-danger {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        /* Footer */
        footer {
            background-color: #1a252f;
            color: white;
            padding: 30px 0 20px;
            margin-top: auto;
        }

        .footer-content {
            text-align: center;
            margin-bottom: 20px;
        }

        .footer-logo {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-bottom: 20px;
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
            .login-hero h1 {
                font-size: 2.5rem;
            }
            
            .login-hero p {
                font-size: 1.1rem;
            }
            
            .login-card {
                padding: 40px 25px;
                margin: 20px;
            }
            
            .login-icon {
                width: 70px;
                height: 70px;
            }
            
            .login-icon i {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <div class="login-hero">
        <div class="container login-hero-content">
            <h1>Panel Administrativo</h1>
            <p>Accede al sistema de gestión de HegiaSystem</p>
        </div>
    </div>

    <!-- Sección de Login -->
    <div class="login-section">
        <div class="container">
            <div class="login-card">
                <div class="login-icon">
                    <i class="fas fa-lock"></i>
                </div>
                
                <h2 class="login-title">Iniciar Sesión</h2>
                <p class="login-subtitle">Ingresa tus credenciales para continuar</p>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-4">
                        <label for="usuario" class="form-label">Usuario</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" name="usuario" id="usuario" class="form-control" 
                                   placeholder="Ingresa tu usuario" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="contraseña" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-key"></i>
                            </span>
                            <input type="password" name="contraseña" id="contraseña" class="form-control" 
                                   placeholder="Ingresa tu contraseña" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                    </button>
                </form>

                <a href="../index.php" class="btn btn-back">
                    <i class="fas fa-arrow-left me-2"></i>Volver al Inicio
                </a>
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
</body>
</html>