<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "condominio";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8");
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    error_log("Erro de conexão: " . $e->getMessage());
    die("Erro na conexão com o banco de dados");
}
?>
