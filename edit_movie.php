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
    $movie_id = $_GET['id'];

    // Obtém os dados do filme
    $sql = "SELECT * FROM movies WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $movie = $result->fetch_assoc();
    } else {
        die("Filme não encontrado.");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $year = $_POST['year'];
    $genre = $_POST['genre'];
    $image_url = $_POST['image_url'];
    $synopsis = $_POST['synopsis']; // Sinopse

    // Atualiza o filme no banco de dados
    $sql = "UPDATE movies SET title = ?, year = ?, genre = ?, image_url = ?, synopsis = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $title, $year, $genre, $image_url, $synopsis, $movie_id);
    $stmt->execute();

    header("Location: index.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Filme</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    <div class="container py-5">
        <h1 class="text-center text-primary mb-4">Editar Filme</h1>
        <form action="edit_movie.php?id=<?= $movie['id'] ?>" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($movie['title']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Ano</label>
                <input type="number" class="form-control" id="year" name="year" value="<?= htmlspecialchars($movie['year']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Gênero</label>
                <input type="text" class="form-control" id="genre" name="genre" value="<?= htmlspecialchars($movie['genre']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">URL da Imagem</label>
                <input type="text" class="form-control" id="image_url" name="image_url" value="<?= htmlspecialchars($movie['image_url']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="synopsis" class="form-label">Sinopse</label>
                <textarea class="form-control" id="synopsis" name="synopsis" rows="4" required><?= htmlspecialchars($movie['synopsis']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
