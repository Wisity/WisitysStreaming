<?php
session_start(); // Inicia a sessão

// Verifica se o usuário é admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    die("Você não tem permissão para acessar esta página.");
}

// Conexão com o banco de dados
require_once 'dao.php';

// Verificar se o ID do episódio foi passado
if (!isset($_GET['episode_id'])) {
    die("ID do episódio não fornecido.");
}

$episode_id = intval($_GET['episode_id']);

// Buscar os dados do episódio
$sql = "SELECT title, url FROM episodes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $episode_id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar se o episódio foi encontrado
if ($result->num_rows === 0) {
    die("Episódio não encontrado.");
}

$episode = $result->fetch_assoc();

// Processar o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $url = trim($_POST['url']);

    // Validar os dados
    if (empty($title) || empty($url)) {
        $error_message = "Por favor, preencha todos os campos.";
    } else {
        // Atualizar os dados do episódio no banco de dados
        $sql_update = "UPDATE episodes SET title = ?, url = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("ssi", $title, $url, $episode_id);

        if ($stmt->execute()) {
            $success_message = "Episódio atualizado com sucesso!";
            // Redireciona de volta para a página dos episódios
            header("Location: series_episodes.php?id=" . $_GET['id']);
            exit;
        } else {
            $error_message = "Erro ao atualizar episódio: " . $stmt->error;
        }
    }
}

// Fechar a conexão
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Episódio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    <div class="container py-5">
        <h1 class="text-center text-primary mb-4">Editar Episódio</h1>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
        <?php elseif (isset($success_message)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success_message) ?></div>
        <?php endif; ?>

        <form action="edit_episode.php?episode_id=<?= $episode_id ?>" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Título do Episódio</label>
                <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($episode['title']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="url" class="form-label">URL do Episódio</label>
                <input type="url" id="url" name="url" class="form-control" value="<?= htmlspecialchars($episode['url']) ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Salvar Alterações</button>
            <a href="series_episodes.php?id=<?= $_GET['id'] ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
