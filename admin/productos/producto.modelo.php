<?php
require_once 'producto.php';

class ProductoModelo
{
    private $pdo;

    public function __CONSTRUCT()
    {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=hegia_bd', 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Listar todos los productos
    public function Listar()
{
    try {
        $stm = $this->pdo->prepare("
            SELECT p.id_producto,
                   p.nombre,
                   p.descripcion,
                   p.precio,
                   p.stock,
                   p.unidad_medida,
                   p.imagen,
                   p.estado,
                   p.id_categoria,
                   c.nombre AS categoria
            FROM productos p
            LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
            ORDER BY p.id_producto DESC
        ");
        $stm->execute();

        $result = array();
        foreach ($stm->fetchAll(PDO::FETCH_OBJ) as $r) {
            $p = new Producto();
            $p->__SET('id_producto', $r->id_producto);
            $p->__SET('nombre', $r->nombre);
            $p->__SET('descripcion', $r->descripcion);
            $p->__SET('precio', $r->precio);
            $p->__SET('stock', $r->stock);
            $p->__SET('unidad_medida', $r->unidad_medida);
            $p->__SET('imagen', $r->imagen);
            $p->__SET('estado', $r->estado);
            $p->__SET('id_categoria', $r->id_categoria);
            $p->categoria = $r->categoria;
            $result[] = $p;
        }

        return $result;
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

    // Obtener un producto específico
    public function Obtener($id)
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM productos WHERE id_producto = ?");
            $stm->execute([$id]);
            $r = $stm->fetch(PDO::FETCH_OBJ);

            if (!$r) return null;

            $p = new Producto();
            $p->__SET('id_producto', $r->id_producto);
            $p->__SET('nombre', $r->nombre);
            $p->__SET('descripcion', $r->descripcion);
            $p->__SET('precio', $r->precio);
            $p->__SET('stock', $r->stock);
            $p->__SET('unidad_medida', $r->unidad_medida);
            $p->__SET('imagen', $r->imagen);
            $p->__SET('estado', $r->estado);
            $p->__SET('id_categoria', $r->id_categoria);

            return $p;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Registrar nuevo producto
    public function Registrar(Producto $data)
    {
        try {
            $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, unidad_medida, imagen, estado, id_categoria)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $this->pdo->prepare($sql)->execute([
                $data->__GET('nombre'),
                $data->__GET('descripcion'),
                $data->__GET('precio'),
                $data->__GET('stock'),
                $data->__GET('unidad_medida'),
                $data->__GET('imagen'),
                $data->__GET('estado'),
                $data->__GET('id_categoria')
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Actualizar producto existente
    public function Actualizar(Producto $data)
    {
        try {
            // Si el usuario no sube nueva imagen, se conserva la anterior
            if ($data->__GET('imagen') == '' || $data->__GET('imagen') == null) {
                $sql = "UPDATE productos SET 
                        nombre = ?, descripcion = ?, precio = ?, stock = ?, 
                        unidad_medida = ?, estado = ?, id_categoria = ?
                        WHERE id_producto = ?";
                $this->pdo->prepare($sql)->execute([
                    $data->__GET('nombre'),
                    $data->__GET('descripcion'),
                    $data->__GET('precio'),
                    $data->__GET('stock'),
                    $data->__GET('unidad_medida'),
                    $data->__GET('estado'),
                    $data->__GET('id_categoria'),
                    $data->__GET('id_producto')
                ]);
            } else {
                $sql = "UPDATE productos SET 
                        nombre = ?, descripcion = ?, precio = ?, stock = ?, 
                        unidad_medida = ?, imagen = ?, estado = ?, id_categoria = ?
                        WHERE id_producto = ?";
                $this->pdo->prepare($sql)->execute([
                    $data->__GET('nombre'),
                    $data->__GET('descripcion'),
                    $data->__GET('precio'),
                    $data->__GET('stock'),
                    $data->__GET('unidad_medida'),
                    $data->__GET('imagen'),
                    $data->__GET('estado'),
                    $data->__GET('id_categoria'),
                    $data->__GET('id_producto')
                ]);
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Eliminar producto (también borra la imagen del servidor)
    public function Eliminar($id)
    {
        try {
            // Buscar imagen asociada para borrarla
            $stm = $this->pdo->prepare("SELECT imagen FROM productos WHERE id_producto = ?");
            $stm->execute([$id]);
            $img = $stm->fetch(PDO::FETCH_OBJ);

            if ($img && !empty($img->imagen) && file_exists('../imagenes/' . $img->imagen)) {
                unlink('../imagenes/' . $img->imagen);
            }

            $stm = $this->pdo->prepare("DELETE FROM productos WHERE id_producto = ?");
            $stm->execute([$id]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
?>