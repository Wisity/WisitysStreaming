<?php
session_start();

// Verifica se o administrador está logado
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

if (!$is_admin) {
    header("Location: index.php");
    exit();
}

// Conexão com o banco de dados
require_once 'dao.php';

if (isset($_GET['id'])) {
    $series_id = $_GET['id'];

    // Exclui a série
    $sql = "DELETE FROM series WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $series_id);
    $stmt->execute();

    header("Location: index.php");
    exit();
}

$conn->close();
?>
