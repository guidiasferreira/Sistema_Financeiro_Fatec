<?php
    $hostname = "localhost";
    $user = "root";
    $password = "";
    $bd = "pi";

    try {
        $conn = new PDO("mysql:host=$hostname;dbname=$bd", $user, $password);
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        die("Erro na conexão com o banco de dados: " . $e->getMessage());
    }
?>	