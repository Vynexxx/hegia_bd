<?php
session_start();

// Verificar si el administrador está logueado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');  // Redirigir al login si no está logueado
    exit;
}

require_once 'producto.php';
require_once 'producto.modelo.php';

$model = new ProductoModelo();
$prod = new Producto();

if (isset($_REQUEST['action'])) {
    switch ($_REQUEST['action']) {
        case 'registrar':
            $prod->__SET('nombre', $_REQUEST['nombre']);
            $prod->__SET('descripcion', $_REQUEST['descripcion']);
            $prod->__SET('precio', $_REQUEST['precio']);
            $prod->__SET('stock', $_REQUEST['stock']);
            $prod->__SET('unidad_medida', $_REQUEST['unidad_medida']);
            $prod->__SET('estado', $_REQUEST['estado']);
            $prod->__SET('id_categoria', $_REQUEST['id_categoria']);

            // Manejo de imagen
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $nombreArchivo = basename($_FILES['imagen']['name']);
                $rutaDestino = "../imagenes/" . $nombreArchivo;
                move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);
                $prod->__SET('imagen', $nombreArchivo);
            } else {
                $prod->__SET('imagen', '');
            }

            $model->Registrar($prod);
            header('Location: index.php');
            break;

        case 'editar':
            $prod = $model->Obtener($_REQUEST['id_producto']);
            break;

        case 'eliminar':
            $model->Eliminar($_REQUEST['id_producto']);
            header('Location: index.php');
            break;

        case 'actualizar':
            $prod->__SET('id_producto', $_REQUEST['id_producto']);
            $prod->__SET('nombre', $_REQUEST['nombre']);
            $prod->__SET('descripcion', $_REQUEST['descripcion']);
            $prod->__SET('precio', $_REQUEST['precio']);
            $prod->__SET('stock', $_REQUEST['stock']);
            $prod->__SET('unidad_medida', $_REQUEST['unidad_medida']);
            $prod->__SET('estado', $_REQUEST['estado']);
            $prod->__SET('id_categoria', $_REQUEST['id_categoria']);

            // Imagen (mantiene la anterior si no se sube nueva)
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $nombreArchivo = basename($_FILES['imagen']['name']);
                $rutaDestino = "../imagenes/" . $nombreArchivo;
                move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);
                $prod->__SET('imagen', $nombreArchivo);
            } else {
                $prod->__SET('imagen', $_REQUEST['imagen_actual']);
            }

            $model->Actualizar($prod);
            header('Location: index.php');
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos - HegiaSystem</title>
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
    </style>
</head>
<body>

<!-- Botón Volver al inicio -->
<a href="../dashboard.php" class="btn btn-back-home">Volver al inicio</a>

<div class="container mt-4">
    <div class="card shadow p-4">
        <h2 class="text-center text-success mb-4">Gestión de Productos</h2>

        <form action="?action=<?php echo $prod->id_producto > 0 ? 'actualizar' : 'registrar'; ?>" 
              method="post" enctype="multipart/form-data" class="row g-3">
            
            <input type="hidden" name="id_producto" value="<?php echo $prod->__GET('id_producto'); ?>">
            <input type="hidden" name="imagen_actual" value="<?php echo $prod->__GET('imagen'); ?>">

            <div class="col-md-6">
                <label class="form-label">Nombre:</label>
                <input type="text" name="nombre" class="form-control" 
                       value="<?php echo $prod->__GET('nombre'); ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Categoría:</label>
                <select name="id_categoria" class="form-select" required>
                    <option value="">Seleccione una categoría</option>
                    <?php
                    $pdo = new PDO('mysql:host=localhost;dbname=hegia_bd', 'root', '');
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stm = $pdo->prepare("SELECT * FROM categorias ORDER BY nombre ASC");
                    $stm->execute();
                    $categorias = $stm->fetchAll(PDO::FETCH_OBJ);

                    foreach ($categorias as $c): ?>
                        <option value="<?php echo $c->id_categoria; ?>"
                            <?php echo $prod->__GET('id_categoria') == $c->id_categoria ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($c->nombre); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-12">
                <label class="form-label">Descripción:</label>
                <textarea name="descripcion" class="form-control" rows="2"><?php echo $prod->__GET('descripcion'); ?></textarea>
            </div>

            <div class="col-md-3">
                <label class="form-label">Precio (S/):</label>
                <input type="number" step="0.01" name="precio" class="form-control" 
                       value="<?php echo $prod->__GET('precio'); ?>" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Stock:</label>
                <input type="number" name="stock" class="form-control" 
                       value="<?php echo $prod->__GET('stock'); ?>" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Unidad de medida:</label>
                <input type="text" name="unidad_medida" class="form-control" 
                       value="<?php echo $prod->__GET('unidad_medida'); ?>" placeholder="Ej: unidades, m², kg">
            </div>

            <div class="col-md-3">
                <label class="form-label">Estado:</label>
                <select name="estado" class="form-select">
                    <option value="Activo" <?php echo $prod->__GET('estado') == 'Activo' ? 'selected' : ''; ?>>Activo</option>
                    <option value="Inactivo" <?php echo $prod->__GET('estado') == 'Inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Imagen del producto:</label>
                <input type="file" name="imagen" class="form-control">
                <?php if ($prod->__GET('imagen')): ?>
                    <small class="text-muted">Actual: <?php echo $prod->__GET('imagen'); ?></small>
                <?php endif; ?>
            </div>

            <div class="col-12 text-center">
                <button type="submit" class="btn btn-success px-5">
                    <?php echo $prod->id_producto > 0 ? 'Actualizar' : 'Registrar'; ?>
                </button>
            </div>
        </form>
    </div>

    <hr class="my-4">

    <div class="card shadow p-3">
        <h4 class="text-secondary mb-3">Lista de productos registrados</h4>
        <table class="table table-hover align-middle">
            <thead class="table-success">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Unidad</th>
                    <th>Imagen</th>
                    <th>Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($model->Listar() as $r): ?>
                <tr>
                    <td><?php echo $r->id_producto; ?></td>
                    <td><?php echo htmlspecialchars($r->nombre); ?></td>
                    <td class="descripcion"><?php echo htmlspecialchars($r->descripcion); ?></td>
                    <td><?php echo htmlspecialchars($r->categoria ?? '-'); ?></td>
                    <td>S/ <?php echo number_format($r->precio, 2); ?></td>
                    <td><?php echo $r->stock; ?></td>
                    <td><?php echo htmlspecialchars($r->unidad_medida); ?></td>
                    <td>
                        <?php if (!empty($r->imagen)): ?>
                            <img src="../../imagenes/<?php echo htmlspecialchars($r->imagen); ?>"
                                alt="Imagen" style="width:70px; height:70px; border-radius:8px; object-fit:cover;">
                        <?php else: ?>
                            - 
                        <?php endif; ?>
                    </td>

                    <td><?php echo $r->estado; ?></td>
                    <td class="text-center">
                        <a href="?action=editar&id_producto=<?php echo $r->id_producto; ?>" 
                           class="btn btn-warning btn-sm">Editar</a>
                        <a href="?action=eliminar&id_producto=<?php echo $r->id_producto; ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Seguro de eliminar este producto?');">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>