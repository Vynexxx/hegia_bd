<?php
class Conexion {
    public static function conectar() {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=hegia_bd;charset=utf8", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (Exception $e) {
            die("ERROR DE CONEXIÓN: " . $e->getMessage());
        }
    }
}
