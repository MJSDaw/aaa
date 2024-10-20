<?php
/* These lines of code are setting HTTP headers in a PHP script.*/
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

/* The line `require_once '../db.php';` is including the PHP script `db.php` into the current script.*/
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        try {
            /* This block of code is responsible for fetching a product from a database based on the
            provided ID.*/
            $pdo = getConnection();
            $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
            $stmt->execute([$id]);
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($producto) {
                echo json_encode($producto);
            } else {
                echo json_encode(['error' => 'Producto no encontrado']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error al obtener el producto']);
        }
    } else {
        echo json_encode(['error' => 'ID no proporcionado']);
    }
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
?>
