<?php
session_start(); // Inicia a sessão

require_once 'dao.php';

if (isset($_GET['id'])) {
    $movie_id = $_GET['id'];


    // Por fim, exclui da tabela 'movies'
    $sql_movies = "DELETE FROM movies WHERE id = ?";
    if ($stmt = $conn->prepare($sql_movies)) {
        $stmt->bind_param("i", $movie_id);
        if ($stmt->execute()) {
            header("Location: index.php");
        } else {
            echo "Erro ao excluir filme: " . $conn->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>
