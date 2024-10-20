<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once '../db.php';

    try {
        $pdo = getConnection();
        // Asegúrate de que la tabla se llama 'familias'
        $stmt = $pdo->prepare("SELECT cod, nombre FROM familias");
        $stmt->execute();
        $familias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($familias);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al obtener las familias: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
?>
