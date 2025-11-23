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
            $stm = $this->pdo->prepare("SELECT * FROM categorias ORDER BY id_categoria DESC");
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
            $sql = "INSERT INTO categorias (nombre, descripcion) VALUES (?, ?)";
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
            $sql = "UPDATE categorias SET 
                        nombre = ?, 
                        descripcion = ?
                    WHERE id_categoria = ?";
            $this->pdo->prepare($sql)
                ->execute([
                    $data->__GET('nombre'),
                    $data->__GET('descripcion'),
                    $data->__GET('id_categoria')
                ]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Eliminar($id)
    {
        try {
            $stm = $this->pdo->prepare("DELETE FROM categorias WHERE id_categoria = ?");
            $stm->execute([$id]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Obtener($id)
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM categorias WHERE id_categoria = ?");
            $stm->execute([$id]);
            $r = $stm->fetch(PDO::FETCH_OBJ);

            $cat = new Categoria();
            $cat->__SET('id_categoria', $r->id_categoria);
            $cat->__SET('nombre', $r->nombre);
            $cat->__SET('descripcion', $r->descripcion);
            $cat->__SET('fecha_creacion', $r->fecha_creacion);

            return $cat;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
?>
