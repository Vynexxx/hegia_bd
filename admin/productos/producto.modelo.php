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

    // Listar todos los productos ACTIVOS
    public function Listar()
    {
        try {
            // CORREGIDO: Solo 10 parámetros (quitamos el último NULL)
            $stm = $this->pdo->prepare("CALL PROC_MANTENIMIENTO_PRODUCTOS('listar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
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
                $p->__SET('id_categoria', $r->id_categoria);
                $p->categoria = $r->categoria_nombre;
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
            // Consulta directa para obtener producto específico
            $stm = $this->pdo->prepare("SELECT * FROM productos WHERE id_producto = ? AND EstadoRegistro = 1");
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
            // CORREGIDO: Solo 9 parámetros + 'insertar' = 10 total
            $sql = "CALL PROC_MANTENIMIENTO_PRODUCTOS('insertar', NULL, ?, ?, ?, ?, ?, ?, ?, 1)";
            $this->pdo->prepare($sql)->execute([
                $data->__GET('nombre'),
                $data->__GET('descripcion'),
                $data->__GET('precio'),
                $data->__GET('stock'),
                $data->__GET('unidad_medida'),
                $data->__GET('imagen'),
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
                // Primero obtenemos la imagen actual
                $stm = $this->pdo->prepare("SELECT imagen FROM productos WHERE id_producto = ?");
                $stm->execute([$data->__GET('id_producto')]);
                $r = $stm->fetch(PDO::FETCH_OBJ);
                $imagen_actual = $r ? $r->imagen : '';
                
                // CORREGIDO: Solo 9 parámetros + 'actualizar' = 10 total
                $sql = "CALL PROC_MANTENIMIENTO_PRODUCTOS('actualizar', ?, ?, ?, ?, ?, ?, ?, ?, NULL)";
                $this->pdo->prepare($sql)->execute([
                    $data->__GET('id_producto'),
                    $data->__GET('nombre'),
                    $data->__GET('descripcion'),
                    $data->__GET('precio'),
                    $data->__GET('stock'),
                    $data->__GET('unidad_medida'),
                    $imagen_actual, // Mantener imagen actual
                    $data->__GET('id_categoria')
                ]);
            } else {
                // CORREGIDO: Solo 9 parámetros + 'actualizar' = 10 total
                $sql = "CALL PROC_MANTENIMIENTO_PRODUCTOS('actualizar', ?, ?, ?, ?, ?, ?, ?, ?, NULL)";
                $this->pdo->prepare($sql)->execute([
                    $data->__GET('id_producto'),
                    $data->__GET('nombre'),
                    $data->__GET('descripcion'),
                    $data->__GET('precio'),
                    $data->__GET('stock'),
                    $data->__GET('unidad_medida'),
                    $data->__GET('imagen'), // Nueva imagen
                    $data->__GET('id_categoria')
                ]);
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Eliminar producto (eliminación lógica - NO borra imagen)
    public function Eliminar($id)
    {
        try {
            // CORREGIDO: Solo 2 parámetros + 'eliminar' = 10 total (el resto NULL)
            $stm = $this->pdo->prepare("CALL PROC_MANTENIMIENTO_PRODUCTOS('eliminar', ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
            $stm->execute([$id]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // 🔍 MÉTODO PARA BÚSQUEDA POR NOMBRE
    public function BuscarPorNombre($nombre)
    {
        try {
            // CORREGIDO: Solo 3 parámetros + 'buscar_nombre' = 10 total (el resto NULL)
            $stm = $this->pdo->prepare("CALL PROC_MANTENIMIENTO_PRODUCTOS('buscar_nombre', NULL, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
            $stm->execute([$nombre]);

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
                $p->__SET('id_categoria', $r->id_categoria);
                $p->categoria = $r->categoria_nombre;
                $result[] = $p;
            }

            return $result;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
?>