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
        $stm = $this->pdo->prepare("
            SELECT i.*, p.nombre AS producto 
            FROM inventario i
            INNER JOIN productos p ON p.id_producto = i.id_producto
            ORDER BY i.fecha_movimiento DESC
        ");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    public function Registrar(Inventario $data)
    {
        $sql = "INSERT INTO inventario (id_producto, tipo_movimiento, cantidad, observacion)
                VALUES (?, ?, ?, ?)";
        $this->pdo->prepare($sql)->execute([
            $data->__GET('id_producto'),
            $data->__GET('tipo_movimiento'),
            $data->__GET('cantidad'),
            $data->__GET('observacion')
        ]);

        // Actualizar el stock del producto automáticamente
        $this->ActualizarStock($data->__GET('id_producto'), $data->__GET('tipo_movimiento'), $data->__GET('cantidad'));
    }

    private function ActualizarStock($id_producto, $tipo, $cantidad)
    {
        if ($tipo == 'Entrada') {
            $sql = "UPDATE productos SET stock = stock + ? WHERE id_producto = ?";
        } else {
            $sql = "UPDATE productos SET stock = stock - ? WHERE id_producto = ?";
        }
        $this->pdo->prepare($sql)->execute([$cantidad, $id_producto]);
    }

    public function Eliminar($id)
    {
        $stm = $this->pdo->prepare("DELETE FROM inventario WHERE id_movimiento = ?");
        $stm->execute([$id]);
    }
}
?>