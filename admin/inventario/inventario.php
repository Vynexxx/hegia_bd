<?php
class Inventario
{
    private $id_movimiento;
    private $id_producto;
    private $tipo_movimiento;
    private $cantidad;
    private $fecha_movimiento;
    private $observacion;

    public function __GET($x) { return $this->$x; }
    public function __SET($x, $y) { $this->$x = $y; }
}
?>