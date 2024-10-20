<?php

/* The code snippet you provided is setting HTTP response headers in PHP.*/
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

/* The code snippet `if (['REQUEST_METHOD'] === 'OPTIONS') { exit(0); }` is checking if the
HTTP request method is 'OPTIONS'. */
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}


if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    /* The code snippet `require_once '../db.php';` is including a PHP file named 'db.php' which likely
    contains the database connection logic or functions. */
    require_once '../db.php';
    /* The line ` = json_decode(file_get_contents('php://input'), true);` is reading the raw HTTP
    request body data sent to the server and decoding it as a JSON object in PHP.*/
    $data = json_decode(file_get_contents('php://input'), true);
    /* The line `  = intval(['id'] ?? 0);` is performing the following actions: */
    $id = intval($data['id'] ?? 0);

    /* This block of code is handling the DELETE request for deleting a product from a database table
    named 'productos'.*/
    if ($id) {
        try {
            $pdo = getConnection();
            $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['message' => 'Producto eliminado exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error al eliminar el producto']);
        }
    } else {
        echo json_encode(['error' => 'ID no proporcionado']);
    }
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
// ?>
