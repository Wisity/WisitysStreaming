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

    // Obtém os dados da série
    $sql = "SELECT * FROM series WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $series_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $serie = $result->fetch_assoc();
    } else {
        die("Série não encontrada.");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $year = $_POST['year'];
    $genre = $_POST['genre'];
    $image_url = $_POST['image_url'];

    // Atualiza a série no banco de dados
    $sql = "UPDATE series SET title = ?, year = ?, genre = ?, image_url = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $title, $year, $genre, $image_url, $series_id);
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
    <title>Editar Série</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    <div class="container py-5">
        <h1 class="text-center text-primary mb-4">Editar Série</h1>
        <form action="edit_series.php?id=<?= $serie['id'] ?>" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($serie['title']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Ano</label>
                <input type="number" class="form-control" id="year" name="year" value="<?= htmlspecialchars($serie['year']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Gênero</label>
                <input type="text" class="form-control" id="genre" name="genre" value="<?= htmlspecialchars($serie['genre']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">URL da Imagem</label>
                <input type="text" class="form-control" id="image_url" name="image_url" value="<?= htmlspecialchars($serie['image_url']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
