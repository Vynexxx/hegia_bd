<?php
require_once 'categoria.php';

class CategoriaModelo
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

    public function Listar()
    {
        try {
            $result = array();
            // CORREGIDO: Solo 5 parámetros como requiere tu procedimiento
            $stm = $this->pdo->prepare("CALL PROC_MANTENIMIENTO_CATEGORIAS('listar', NULL, NULL, NULL, NULL)");
            $stm->execute();

            foreach ($stm->fetchAll(PDO::FETCH_OBJ) as $r) {
                $cat = new Categoria();
                $cat->__SET('id_categoria', $r->id_categoria);
                $cat->__SET('nombre', $r->nombre);
                $cat->__SET('descripcion', $r->descripcion);
                $cat->__SET('fecha_creacion', $r->fecha_creacion);
                $result[] = $cat;
            }

            return $result;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Registrar(Categoria $data)
    {
        try {
            // CORREGIDO: Solo 4 parámetros + el tipo de mantenimiento
            $sql = "CALL PROC_MANTENIMIENTO_CATEGORIAS('insertar', NULL, ?, ?, 1)";
            $this->pdo->prepare($sql)
                ->execute([
                    $data->__GET('nombre'),
                    $data->__GET('descripcion')
                ]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Actualizar(Categoria $data)
    {
        try {
            // CORREGIDO: Parámetros exactos que requiere tu procedimiento
            $sql = "CALL PROC_MANTENIMIENTO_CATEGORIAS('actualizar', ?, ?, ?, NULL)";
            $this->pdo->prepare($sql)
                ->execute([
                    $data->__GET('id_categoria'),
                    $data->__GET('nombre'),
                    $data->__GET('descripcion')
                ]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Eliminar($id)
    {
        try {
            // CORREGIDO: Solo el ID para eliminar
            $stm = $this->pdo->prepare("CALL PROC_MANTENIMIENTO_CATEGORIAS('eliminar', ?, NULL, NULL, NULL)");
            $stm->execute([$id]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Obtener($id)
    {
        try {
            // Para obtener una categoría específica, mantenemos consulta directa
            $stm = $this->pdo->prepare("SELECT * FROM categorias WHERE id_categoria = ? AND EstadoRegistro = 1");
            $stm->execute([$id]);
            $r = $stm->fetch(PDO::FETCH_OBJ);

            if ($r) {
                $cat = new Categoria();
                $cat->__SET('id_categoria', $r->id_categoria);
                $cat->__SET('nombre', $r->nombre);
                $cat->__SET('descripcion', $r->descripcion);
                $cat->__SET('fecha_creacion', $r->fecha_creacion);
                return $cat;
            } else {
                return null;
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // 🔍 MÉTODO PARA BÚSQUEDA POR NOMBRE
    public function Buscar($nombre)
    {
        try {
            $result = array();
            // CORREGIDO: Usando 'buscar_nombre' que existe en tu procedimiento
            $stm = $this->pdo->prepare("CALL PROC_MANTENIMIENTO_CATEGORIAS('buscar_nombre', NULL, ?, NULL, NULL)");
            $stm->execute([$nombre]);

            foreach ($stm->fetchAll(PDO::FETCH_OBJ) as $r) {
                $cat = new Categoria();
                $cat->__SET('id_categoria', $r->id_categoria);
                $cat->__SET('nombre', $r->nombre);
                $cat->__SET('descripcion', $r->descripcion);
                $cat->__SET('fecha_creacion', $r->fecha_creacion);
                $result[] = $cat;
            }

            return $result;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
?>