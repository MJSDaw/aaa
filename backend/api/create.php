<?php
/* The code snippet you provided is setting HTTP headers in a PHP script.*/
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

/* The code snippet `if (['REQUEST_METHOD'] === 'OPTIONS') { exit(0); }` is checking if the
HTTP request method is 'OPTIONS'. */
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /* The line `require_once '../db.php';` is including the PHP file `db.php` in the current script.*/
    require_once '../db.php';

    /* The line ` = json_decode(file_get_contents('php://input'), true);` is reading the raw POST
    data from the request body and decoding it as a JSON object.*/
    $data = json_decode(file_get_contents('php://input'), true);

    /* The lines provided are initializing variables based on the values received from the decoded
    JSON data in the PHP script.*/
    $nombre = $data['nombre'] ?? '';
    $nombre_corto = $data['nombre_corto'] ?? '';
    $descripcion = $data['descripcion'] ?? '';
    $pvp = $data['pvp'] ?? 0;
    $familia = $data['familia'] ?? '';

    
    /* This part of the code is responsible for handling the logic of creating a new product in
    the database based on the data received from the POST request.*/
    if ($nombre && $nombre_corto && $pvp && $familia) {
        try {
            $pdo = getConnection();

            // Obtener el próximo ID disponible
            $query = "SELECT MIN(id) + 1 AS next_id FROM productos WHERE id + 1 NOT IN (SELECT id FROM productos)";
            $result = $pdo->query($query);
            $nextId = $result->fetch(PDO::FETCH_ASSOC)['next_id'];

            // Si no hay IDs disponibles, usar el mayor + 1
            if (is_null($nextId)) {
                $result = $pdo->query("SELECT MAX(id) AS max_id FROM productos");
                $nextId = $result->fetch(PDO::FETCH_ASSOC)['max_id'] + 1;
            }

            // Preparar la consulta para insertar el nuevo producto
            $stmt = $pdo->prepare("INSERT INTO productos (id, nombre, nombre_corto, descripcion, pvp, familia) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nextId, $nombre, $nombre_corto, $descripcion, $pvp, $familia]);

            // Ajustar el autoincremento si es necesario
            $pdo->query("ALTER TABLE productos AUTO_INCREMENT = (SELECT MAX(id) + 1 FROM productos)");

            echo json_encode(['message' => 'Producto creado exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error al crear el producto']);
        }
    } else {
        echo json_encode(['error' => 'Datos incompletos']);
    }
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
?>
