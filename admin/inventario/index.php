<?php
session_start();

// Verificar si el administrador está logueado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../login.php');
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
    <title>Control de Inventario - HegiaSystem</title>
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

        /* Tabla de inventario */
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

        /* Badges para movimientos */
        .badge-entrada {
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .badge-salida {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        /* Cantidad destacada */
        .cantidad {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .cantidad.entrada {
            color: #2ecc71;
        }

        .cantidad.salida {
            color: #e74c3c;
        }

        /* Fecha estilizada */
        .date-badge {
            background-color: rgba(255, 255, 255, 0.1);
            color: #bdc3c7;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Observación con tooltip */
        .observacion-cell {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: help;
            position: relative;
        }

        .observacion-cell:hover::after {
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
            
            .btn-action {
                padding: 6px 10px;
                font-size: 0.8rem;
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
                <h1>Control de Inventario</h1>
            </div>

            <!-- Formulario de Movimiento -->
            <div class="form-card">
                <h2 class="form-title">
                    <i class="fas fa-exchange-alt"></i>
                    Registrar Movimiento de Inventario
                </h2>

                <form action="?action=registrar" method="post" class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Producto</label>
                        <select name="id_producto" class="form-select" required>
                            <option value="">Seleccione un producto</option>
                            <?php foreach ($modelProd->Listar() as $p): ?>
                                <option value="<?php echo $p->__GET('id_producto'); ?>">
                                    <?php echo $p->__GET('nombre'); ?> 
                                    (Stock: <?php echo $p->__GET('stock'); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tipo de Movimiento</label>
                        <select name="tipo_movimiento" class="form-select" required>
                            <option value="Entrada">Entrada</option>
                            <option value="Salida">Salida</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Cantidad</label>
                        <input type="number" name="cantidad" class="form-control" 
                               placeholder="Ingrese la cantidad" min="1" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Observación</label>
                        <input type="text" name="observacion" class="form-control" 
                               placeholder="Motivo del movimiento (opcional)">
                    </div>

                    <div class="col-12 text-center pt-3">
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-save me-2"></i>Registrar Movimiento
                        </button>
                    </div>
                </form>
            </div>

            <!-- Historial de Movimientos -->
            <div class="table-card">
                <h2 class="table-title">
                    <i class="fas fa-history"></i>
                    Historial de Movimientos
                </h2>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Tipo</th>
                                <th>Cantidad</th>
                                <th>Fecha</th>
                                <th>Observación</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($modelInv->Listar() as $r): ?>
                            <tr>
                                <td>
                                    <strong><?php echo $r->producto; ?></strong>
                                </td>
                                <td>
                                    <span class="<?php echo $r->tipo_movimiento == 'Entrada' ? 'badge-entrada' : 'badge-salida'; ?>">
                                        <i class="fas fa-<?php echo $r->tipo_movimiento == 'Entrada' ? 'arrow-down' : 'arrow-up'; ?> me-1"></i>
                                        <?php echo $r->tipo_movimiento; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="cantidad <?php echo strtolower($r->tipo_movimiento); ?>">
                                        <?php if($r->tipo_movimiento == 'Entrada'): ?>
                                            <i class="fas fa-plus me-1"></i>
                                        <?php else: ?>
                                            <i class="fas fa-minus me-1"></i>
                                        <?php endif; ?>
                                        <?php echo $r->cantidad; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="date-badge">
                                        <i class="fas fa-calendar me-1"></i>
                                        <?php echo $r->fecha_movimiento; ?>
                                    </span>
                                </td>
                                <td class="observacion-cell" data-fulltext="<?php echo htmlspecialchars($r->observacion); ?>">
                                    <?php echo $r->observacion ? htmlspecialchars($r->observacion) : '<span class="text-muted">Sin observación</span>'; ?>
                                </td>
                                <td class="text-center">
                                    <a href="?action=eliminar&id_movimiento=<?php echo $r->id_movimiento; ?>" 
                                       class="btn btn-action btn-delete"
                                       onclick="return confirm('¿Está seguro de eliminar este movimiento de inventario?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
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