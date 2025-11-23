<?php
session_start();

// Verificar si el administrador está logueado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
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
                $rutaDestino = "../../imagenes/" . $nombreArchivo;
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
                $rutaDestino = "../../imagenes/" . $nombreArchivo;
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

        /* Navbar */
        .admin-navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, #16a085 100%) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 15px 0;
        }

        .admin-navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            color: white;
        }

        .admin-navbar-brand i {
            margin-right: 10px;
            font-size: 1.3rem;
        }

        .btn-admin-back {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-admin-back:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            color: white;
        }

        /* Sección principal */
        .admin-section {
            padding: 40px 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
        }

        .section-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            display: inline-block;
            padding-bottom: 15px;
            position: relative;
        }

        .section-header h1::after {
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

        /* Tarjetas de formulario */
        .form-card {
            background-color: var(--card-bg);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            margin-bottom: 40px;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 25px;
            color: white;
            display: flex;
            align-items: center;
        }

        .form-title i {
            color: var(--primary-color);
            margin-right: 10px;
            font-size: 1.3rem;
        }

        /* Estilos para el formulario */
        .form-label {
            color: white;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control, .form-select, textarea {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 12px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus, textarea:focus {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: var(--primary-color);
            color: white;
            box-shadow: 0 0 0 0.2rem rgba(26, 188, 156, 0.25);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Botones personalizados */
        .btn-submit {
            background: linear-gradient(135deg, var(--primary-color) 0%, #16a085 100%);
            color: white;
            font-weight: bold;
            padding: 15px 40px;
            border-radius: 25px;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(26, 188, 156, 0.4);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26, 188, 156, 0.6);
            color: white;
        }

        /* Tabla de productos */
        .table-card {
            background-color: var(--card-bg);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .table-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
        }

        .table-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 25px;
            color: white;
            display: flex;
            align-items: center;
        }

        .table-title i {
            color: var(--secondary-color);
            margin-right: 10px;
            font-size: 1.3rem;
        }

        /* Estilos de tabla */
        .table {
            color: var(--text-color);
            margin-bottom: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary-color) 0%, #16a085 100%);
            color: white;
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .table tbody td {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.1);
            padding: 15px;
            vertical-align: middle;
        }

        .table tbody tr:hover td {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Botones de acción */
        .btn-action {
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
            border: none;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(243, 156, 18, 0.4);
            color: white;
        }

        .btn-delete {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            border: none;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.4);
            color: white;
        }

        /* Imagen del producto */
        .product-image {
            width: 70px;
            height: 70px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        /* Descripción con tooltip */
        .description-cell {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: help;
            position: relative;
        }

        .description-cell:hover::after {
            content: attr(data-fulltext);
            position: absolute;
            left: 0;
            top: 100%;
            background: var(--card-bg);
            border: 1px solid var(--primary-color);
            padding: 10px;
            border-radius: 8px;
            z-index: 1000;
            white-space: normal;
            width: 300px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        /* Estado del producto */
        .status-active {
            color: #2ecc71;
            font-weight: 600;
        }

        .status-inactive {
            color: #e74c3c;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-card, .table-card {
                padding: 25px 20px;
            }
            
            .section-header h1 {
                font-size: 2rem;
            }
            
            .btn-submit {
                width: 100%;
            }
            
            .table-responsive {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar admin-navbar">
        <div class="container">
            <a class="admin-navbar-brand" href="../dashboard.php">
                <i class="fas fa-arrow-left"></i>Panel de Control
            </a>
            <a href="../dashboard.php" class="btn-admin-back">
                <i class="fas fa-home me-2"></i>Volver al Dashboard
            </a>
        </div>
    </nav>

    <!-- Sección Principal -->
    <div class="admin-section">
        <div class="container">
            <div class="section-header">
                <h1>Gestión de Productos</h1>
            </div>

            <!-- Formulario de Producto -->
            <div class="form-card">
                <h2 class="form-title">
                    <i class="fas fa-<?php echo $prod->id_producto > 0 ? 'edit' : 'plus'; ?>"></i>
                    <?php echo $prod->id_producto > 0 ? 'Editar Producto' : 'Nuevo Producto'; ?>
                </h2>

                <form action="?action=<?php echo $prod->id_producto > 0 ? 'actualizar' : 'registrar'; ?>" 
                      method="post" enctype="multipart/form-data" class="row g-4">
                    
                    <input type="hidden" name="id_producto" value="<?php echo $prod->__GET('id_producto'); ?>">
                    <input type="hidden" name="imagen_actual" value="<?php echo $prod->__GET('imagen'); ?>">

                    <div class="col-md-6">
                        <label class="form-label">Nombre del Producto</label>
                        <input type="text" name="nombre" class="form-control" 
                               value="<?php echo $prod->__GET('nombre'); ?>" 
                               placeholder="Ingrese el nombre del producto" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Categoría</label>
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

                    <div class="col-12">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3" 
                                  placeholder="Describa las características del producto"><?php echo $prod->__GET('descripcion'); ?></textarea>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Precio (S/)</label>
                        <input type="number" step="0.01" name="precio" class="form-control" 
                               value="<?php echo $prod->__GET('precio'); ?>" 
                               placeholder="0.00" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" 
                               value="<?php echo $prod->__GET('stock'); ?>" 
                               placeholder="Cantidad" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Unidad de Medida</label>
                        <input type="text" name="unidad_medida" class="form-control" 
                               value="<?php echo $prod->__GET('unidad_medida'); ?>" 
                               placeholder="Ej: unidades, m², kg">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="Activo" <?php echo $prod->__GET('estado') == 'Activo' ? 'selected' : ''; ?>>Activo</option>
                            <option value="Inactivo" <?php echo $prod->__GET('estado') == 'Inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Imagen del Producto</label>
                        <input type="file" name="imagen" class="form-control" accept="image/*">
                        <?php if ($prod->__GET('imagen')): ?>
                            <small class="text-muted mt-2 d-block">
                                <i class="fas fa-image me-1"></i>Imagen actual: <?php echo $prod->__GET('imagen'); ?>
                            </small>
                        <?php endif; ?>
                    </div>

                    <div class="col-12 text-center pt-3">
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-<?php echo $prod->id_producto > 0 ? 'sync' : 'save'; ?> me-2"></i>
                            <?php echo $prod->id_producto > 0 ? 'Actualizar Producto' : 'Registrar Producto'; ?>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Lista de Productos -->
            <div class="table-card">
                <h2 class="table-title">
                    <i class="fas fa-list"></i>
                    Productos Registrados
                </h2>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
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
                                <td><strong>#<?php echo $r->id_producto; ?></strong></td>
                                <td><?php echo htmlspecialchars($r->nombre); ?></td>
                                <td class="description-cell" data-fulltext="<?php echo htmlspecialchars($r->descripcion); ?>">
                                    <?php echo htmlspecialchars($r->descripcion); ?>
                                </td>
                                <td><?php echo htmlspecialchars($r->categoria ?? '-'); ?></td>
                                <td><strong>S/ <?php echo number_format($r->precio, 2); ?></strong></td>
                                <td>
                                    <span class="<?php echo $r->stock < 10 ? 'text-warning' : ''; ?>">
                                        <?php echo $r->stock; ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($r->unidad_medida); ?></td>
                                <td>
                                    <?php if (!empty($r->imagen)): ?>
                                        <img src="../../imagenes/<?php echo htmlspecialchars($r->imagen); ?>"
                                            alt="Imagen" class="product-image">
                                    <?php else: ?>
                                        <span class="text-muted">Sin imagen</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="<?php echo $r->estado == 'Activo' ? 'status-active' : 'status-inactive'; ?>">
                                        <?php echo $r->estado; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="?action=editar&id_producto=<?php echo $r->id_producto; ?>" 
                                           class="btn btn-action btn-edit me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?action=eliminar&id_producto=<?php echo $r->id_producto; ?>" 
                                           class="btn btn-action btn-delete"
                                           onclick="return confirm('¿Está seguro de eliminar el producto <?php echo htmlspecialchars($r->nombre); ?>?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>