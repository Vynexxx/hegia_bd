<?php
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>HegiaSystem - Panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container-fluid">
        <a class="navbar-brand" href="../dashboard.php">HegiaSystem</a>

        <div>
            <a href="../dashboard.php" class="btn btn-light btn-sm me-2">Inicio</a>
            <a href="../logout.php" class="btn btn-danger btn-sm">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
