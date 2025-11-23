<?php
class Producto
{
    private $id_producto;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;
    private $unidad_medida;
    private $imagen;
    private $estado;
    private $id_categoria;

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