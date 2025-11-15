<?php
    session_start();

    if (isset($_SESSION['id_proprietario'])) {
        header("Location: financeiro.php");
        exit;
    }
?>