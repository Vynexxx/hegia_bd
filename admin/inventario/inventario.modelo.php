<?php
require_once '../productos/producto.php';
require_once '../productos/producto.modelo.php';
require_once 'inventario.php';

class InventarioModelo
{
    private $pdo;

    public function __CONSTRUCT()
    {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=hegia_bd', 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }

    public function Listar()
    {
        try {
            $stm = $this->pdo->prepare("CALL PROC_MANTENIMIENTO_INVENTARIO('listar', NULL, NULL, NULL, NULL, NULL, NULL)");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }

    public function Registrar(Inventario $data)
    {
        try {
            $sql = "CALL PROC_MANTENIMIENTO_INVENTARIO('insertar', NULL, ?, ?, ?, ?, 1)";
            $this->pdo->prepare($sql)->execute([
                $data->__GET('id_producto'),
                $data->__GET('tipo_movimiento'),
                $data->__GET('cantidad'),
                $data->__GET('observacion')
            ]);
            
            // EL PROCEDIMIENTO YA ACTUALIZA EL STOCK AUTOMÁTICAMENTE
            // Ya no necesitamos llamar a ActualizarStock() manualmente
            
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }

    public function Eliminar($id)
    {
        try {
            // Ahora es eliminación lógica - el procedimiento revierte el stock automáticamente
            $stm = $this->pdo->prepare("CALL PROC_MANTENIMIENTO_INVENTARIO('eliminar', ?, NULL, NULL, NULL, NULL, NULL)");
            $stm->execute([$id]);
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }

    // 🔍 MÉTODOS DE BÚSQUEDA NUEVOS
    public function BuscarPorProducto($id_producto)
    {
        try {
            $stm = $this->pdo->prepare("CALL PROC_MANTENIMIENTO_INVENTARIO('buscar_por_producto', NULL, ?, NULL, NULL, NULL, NULL)");
            $stm->execute([$id_producto]);
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }

    public function BuscarPorFecha($fecha)
    {
        try {
            $stm = $this->pdo->prepare("CALL PROC_MANTENIMIENTO_INVENTARIO('buscar_por_fecha', NULL, NULL, NULL, NULL, ?, NULL)");
            $stm->execute([$fecha]);
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }

    // 📊 MÉTODO PARA OBTENER MOVIMIENTOS RECIENTES (opcional)
    public function MovimientosRecientes($limite = 10)
    {
        try {
            $stm = $this->pdo->prepare("
                SELECT i.id_movimiento, i.id_producto, p.nombre as producto_nombre,
                       i.tipo_movimiento, i.cantidad, i.fecha_movimiento, i.observacion
                FROM inventario i
                INNER JOIN productos p ON i.id_producto = p.id_producto
                WHERE i.EstadoRegistro = 1
                ORDER BY i.fecha_movimiento DESC
                LIMIT ?
            ");
            $stm->execute([$limite]);
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }
}
?>