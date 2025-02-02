<?php
// Conexão com o banco de dados
require_once 'dao.php';

if (isset($_GET['series_id'])) {
    $series_id = (int) $_GET['series_id'];

    // Consulta para obter as temporadas da série
    $sql = "SELECT * FROM seasons WHERE series_id = $series_id";
    $result = $conn->query($sql);

    // Criar um array para armazenar as temporadas
    $seasons = [];
    if ($result->num_rows > 0) {
        while ($season = $result->fetch_assoc()) {
            $seasons[] = $season;
        }
    }

    // Retornar as temporadas como JSON
    echo json_encode($seasons);
}

$conn->close();
?>
