<?php
require_once 'categoria.php';
require_once 'categoria.modelo.php';

$model = new CategoriaModelo();
$cat = new Categoria();

if (isset($_REQUEST['action'])) {
    switch ($_REQUEST['action']) {
        case 'registrar':
            $cat->__SET('nombre', $_REQUEST['nombre']);
            $cat->__SET('descripcion', $_REQUEST['descripcion']);
            $model->Registrar($cat);
            header('Location: index.php');
            break;

        case 'editar':
            $cat = $model->Obtener($_REQUEST['id_categoria']);
            break;

        case 'actualizar':
            $cat->__SET('id_categoria', $_REQUEST['id_categoria']);
            $cat->__SET('nombre', $_REQUEST['nombre']);
            $cat->__SET('descripcion', $_REQUEST['descripcion']);
            $model->Actualizar($cat);
            header('Location: index.php');
            break;

        case 'eliminar':
            $model->Eliminar($_REQUEST['id_categoria']);
            header('Location: index.php');
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Categorías - HegiaSystem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Colores */
        :root {
            --global-bg: #2c3e50;
            --primary: #1abc9c;
            --primary-dark: #16a085;
            --text-light: #ecf0f1;
        }

        body {
            background-color: var(--global-bg);
            color: var(--text-light);
            font-family: Arial, sans-serif;
        }

        /* Botón Volver al inicio */
        .btn-back-home {
            background-color: var(--primary-dark);
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
            background-color: var(--primary);
        }

        /* Campos */
        .form-control, .form-select, textarea {
            background-color: white !important;
            color: #2c3e50 !important;
            border: 1px solid var(--primary);
            border-radius: 8px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-dark);
        }

        /* Etiquetas */
        .form-label {
            color: #2c3e50;
            font-weight: bold;
        }

        /* Tablas */
        .table {
            background-color: white;
        }
        .table td, .table th {
            color: #2c3e50;
        }
    </style>
</head>

<body>

<!-- BOTÓN VOLVER AL INICIO -->
<a href="../dashboard.php" class="btn btn-back-home">Volver al inicio</a>

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-center text-success mb-4">Gestión de Categorías</h2>

        <form action="?action=<?php echo $cat->__GET('id_categoria') ? 'actualizar' : 'registrar'; ?>" method="post" class="row g-3">
            <input type="hidden" name="id_categoria" value="<?php echo $cat->__GET('id_categoria'); ?>">

            <div class="col-md-6">
                <label class="form-label">Nombre de categoría:</label>
                <input type="text" name="nombre" value="<?php echo $cat->__GET('nombre'); ?>" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Descripción:</label>
                <input type="text" name="descripcion" value="<?php echo $cat->__GET('descripcion'); ?>" class="form-control">
            </div>

            <div class="col-12 text-center">
                <button type="submit" class="btn btn-success px-4">Guardar</button>
            </div>
        </form>
    </div>

    <hr class="my-4">

    <div class="card shadow p-3">
        <h4 class="text-secondary mb-3">Listado de Categorías</h4>
        <table class="table table-hover align-middle">
            <thead class="table-success">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha de Creación</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($model->Listar() as $r): ?>
                <tr>
                    <td><?php echo $r->__GET('id_categoria'); ?></td>
                    <td><?php echo $r->__GET('nombre'); ?></td>
                    <td><?php echo $r->__GET('descripcion'); ?></td>
                    <td><?php echo $r->__GET('fecha_creacion'); ?></td>
                    <td class="text-center">
                        <a href="?action=editar&id_categoria=<?php echo $r->__GET('id_categoria'); ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="?action=eliminar&id_categoria=<?php echo $r->__GET('id_categoria'); ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Deseas eliminar esta categoría?');">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>