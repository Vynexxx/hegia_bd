<?php
session_start();

// Verificar si el administrador está logueado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');  // Redirigir al login si no está logueado
    exit;
}

require_once '../productos/producto.php';
require_once '../productos/producto.modelo.php';
require_once 'inventario.php';
require_once 'inventario.modelo.php';

$modelInv = new InventarioModelo();
$modelProd = new ProductoModelo();
$inv = new Inventario();

if (isset($_REQUEST['action'])) {
    switch ($_REQUEST['action']) {
        case 'registrar':
            $inv->__SET('id_producto', $_REQUEST['id_producto']);
            $inv->__SET('tipo_movimiento', $_REQUEST['tipo_movimiento']);
            $inv->__SET('cantidad', $_REQUEST['cantidad']);
            $inv->__SET('observacion', $_REQUEST['observacion']);
            $modelInv->Registrar($inv);
            header('Location: index.php');
            break;

        case 'eliminar':
            $modelInv->Eliminar($_REQUEST['id_movimiento']);
            header('Location: index.php');
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario - HegiaSystem</title>
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

        /* Barra de navegación */
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

        /* Estilo para los campos de formulario */
        .form-control, .form-select, textarea {
            background-color: white; /* Fondo blanco para el formulario */
            color: #2c3e50; /* Texto oscuro */
            border-radius: 8px;
            border: 1px solid #1abc9c; /* Borde verde */
        }

        .form-control:focus, .form-select:focus {
            border-color: #16a085; /* Borde verde más oscuro al enfocarse */
        }

        /* Estilo para las etiquetas */
        .form-label {
            color: #2c3e50; /* Color oscuro para las etiquetas */
        }

        /* Estilo de los botones */
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

        /* Estilo para la columna de descripción */
        td.descripcion {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        td.descripcion:hover {
            white-space: normal;
            overflow: visible;
            background-color: #f6fff6;
            position: relative;
            z-index: 10;
        }

        /* Botón Volver al inicio */
        .btn-back-home {
            background-color: #16a085; /* Verde oscuro */
            color: white;
            font-weight: bold;
            padding: 10px 30px;
            border-radius: 20px;
            text-decoration: none;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .btn-back-home:hover {
            background-color: #1abc9c; /* Verde claro */
        }

        /* Estilos de la tabla */
        table {
            background-color: #34495e;
            color: white;
        }

        thead {
            background-color: var(--primary-color);
        }

        tbody tr:nth-child(even) {
            background-color: #3a4a59; /* Gris más oscuro para filas pares */
        }

        tbody tr:hover {
            background-color: #16a085; /* Verde claro al pasar el ratón */
        }

    </style>
</head>

<body>

<!-- Botón Volver al inicio -->
<a href="../dashboard.php" class="btn btn-back-home">Volver al inicio</a>

<div class="container mt-4">
    <div class="card shadow p-4">
        <h2 class="text-center text-success mb-4">Control de Inventario</h2>

        <form action="?action=registrar" method="post" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Producto:</label>
                <select name="id_producto" class="form-select" required>
                    <option value="">Seleccione un producto</option>
                    <?php foreach ($modelProd->Listar() as $p): ?>
                        <option value="<?php echo $p->__GET('id_producto'); ?>">
                            <?php echo $p->__GET('nombre'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Movimiento:</label>
                <select name="tipo_movimiento" class="form-select">
                    <option value="Entrada">Entrada</option>
                    <option value="Salida">Salida</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Cantidad:</label>
                <input type="number" name="cantidad" class="form-control" required>
            </div>

            <div class="col-md-12">
                <label class="form-label">Observación:</label>
                <input type="text" name="observacion" class="form-control">
            </div>

            <div class="col-12 text-center">
                <button type="submit" class="btn btn-success px-5">Registrar movimiento</button>
            </div>
        </form>
    </div>

    <hr class="my-4">

    <div class="card shadow p-3">
        <h4 class="text-secondary mb-3">Historial de movimientos</h4>
        <table class="table table-hover align-middle">
            <thead class="table-success">
                <tr>
                    <th>Producto</th>
                    <th>Movimiento</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                    <th>Observación</th>
                    <th class="text-center">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($modelInv->Listar() as $r): ?>
                <tr>
                    <td><?php echo $r->producto; ?></td>
                    <td><?php echo $r->tipo_movimiento; ?></td>
                    <td><?php echo $r->cantidad; ?></td>
                    <td><?php echo $r->fecha_movimiento; ?></td>
                    <td><?php echo $r->observacion; ?></td>
                    <td class="text-center">
                        <a href="?action=eliminar&id_movimiento=<?php echo $r->id_movimiento; ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Seguro de eliminar este movimiento?');">
                           Eliminar
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>