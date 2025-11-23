<?php
class Categoria
{
    private $id_categoria;
    private $nombre;
    private $descripcion;
    private $fecha_creacion;

    public function __GET($prop)
    {
        return $this->$prop;
    }

    public function __SET($prop, $valor)
    {
        $this->$prop = $valor;
    }
}
?>
