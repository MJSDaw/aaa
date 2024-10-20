<?php

/* The code snippet provided is setting HTTP headers in a PHP script.*/
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE");
header("Content-Type: application/json; charset=UTF-8");


/* The line `require_once '../db.php';` is including the PHP file `db.php` in the current script.*/
require_once '../db.php';

/* This part of the PHP script is handling the logic for processing a GET request. Here's a breakdown
of what it does: */
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM productos");
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($productos);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al obtener los productos']);
    }
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
?>
