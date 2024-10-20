<?php
/* The code snippet you provided is setting HTTP response headers.*/
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

/* The code snippet `if (['REQUEST_METHOD'] === 'OPTIONS') { exit(0); }` is checking if the
HTTP request method is 'OPTIONS'. */
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    /* The line `require_once '../db.php';` in the provided PHP code snippet is including the PHP file
    `db.php` into the current script.*/
    require_once '../db.php';
    
    /* The line ` = json_decode(file_get_contents('php://input'), true);` in the provided PHP code
    snippet is reading the raw HTTP request body data using `file_get_contents('php://input')`,
    which retrieves the raw POST data. */
    $data = json_decode(file_get_contents('php://input'), true);

    /* The code snippet you provided is initializing variables by extracting values from the decoded 
    JSON data received in the HTTP request body stored in the variable ``. */
    $id = intval($data['id'] ?? 0);
    $nombre = $data['nombre'] ?? '';
    $nombre_corto = $data['nombre_corto'] ?? '';
    $descripcion = $data['descripcion'] ?? '';
    $pvp = $data['pvp'] ?? 0;
    $familia = $data['familia'] ?? '';

    /* This `if` block in the provided PHP code snippet is responsible for updating a product in the
    database if all the required data fields are present and not empty.*/
    if ($id && $nombre && $nombre_corto && $pvp && $familia) {
        try {
            $pdo = getConnection();
            $stmt = $pdo->prepare("UPDATE productos SET nombre = ?, nombre_corto = ?, descripcion = ?, pvp = ?, familia = ? WHERE id = ?");
            $stmt->execute([$nombre, $nombre_corto, $descripcion, $pvp, $familia, $id]);
            echo json_encode(['message' => 'Producto actualizado exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error al actualizar el producto']);
        }
    } else {
        echo json_encode(['error' => 'Datos incompletos']);
    }
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
?>
