<?php
session_start(); // Inicia a sessão

// Conexão com o banco de dados
require_once 'dao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $title = $_POST['title'];
    $year = $_POST['year'];
    $genre = $_POST['genre'];
    $image_url = $_POST['image_url'];

    // Insere os dados da série no banco de dados
    $sql = "INSERT INTO series (title, year, genre, image_url) VALUES ('$title', '$year', '$genre', '$image_url')";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success' role='alert'>
                    <p style='text-align: center;'>SÉRIE ADICIONADA</p>
                </div>";
    } else {
        echo "Erro: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Série - Wisitys Streaming</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    <!-- Barra de Navegação -->
    <header class="bg-primary py-3">
        <div class="container">
            <h1 class="text-light">Wisitys Streaming</h1>
            <nav class="navbar navbar-expand-lg navbar-dark">
                <a class="navbar-brand" href="index.php">Início</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"><a class="nav-link" href="add_movie.php">Adicionar Filme</a></li>
                        <li class="nav-item"><a class="nav-link" href="add_series.php">Adicionar Série</a></li>
                        <li class="nav-item"><a class="nav-link" href="add_episode.php">Adicionar Episódio</a></li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.php">Registrar</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <div class="container py-5">
        <h3 class="mb-4">Adicionar Série</h3>
        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Ano</label>
                <input type="number" class="form-control" id="year" name="year" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Gênero</label>
                <input type="text" class="form-control" id="genre" name="genre" required>
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">URL da Imagem</label>
                <input type="text" class="form-control" id="image_url" name="image_url" required>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar Série</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
