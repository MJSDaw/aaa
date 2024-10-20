<?php

    require_once __DIR__ . '/../vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load(); // Asegúrate de que esta línea esté presente

    /**
     * The function establishes a connection to a MySQL database using PDO in PHP.
     * 
     * @return The function `getConnection()` is returning a PDO (PHP Data Objects) connection to a
     * MySQL database.
     */

    function getConnection(){
        /* These lines of code are setting up variables with values that are used to
        establish a connection to a MySQL database using PDO in PHP. Here's what each variable
        represents: */
        $db = 'mysql';
        $host = 'localhost';
        $username = 'usuario';
        $password = 'clave';
        $dbname = 'proyecto';

        /* The code establishes a connection to a MySQL
        database using PDO (PHP Data Objects).*/
        try {
            $dsn = "$db:host=$host;dbname=$dbname;charset=utf8mb4";
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error de conexión a la base de datos']);
            exit;
        }
    }
?>