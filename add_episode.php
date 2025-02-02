<?php
// Conexão com o banco de dados
$conn = new mysqli("sql107.infinityfree.com", "if0_38100723", "99094562wisi", "if0_38100723_wisitystreaming");

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Obter as séries existentes para o dropdown
$sql_series = "SELECT * FROM series";
$result_series = $conn->query($sql_series);

// Obter temporadas se uma série for selecionada
$seasons = [];
if (isset($_GET['series_id'])) {
    $series_id = $_GET['series_id'];
    $sql_seasons = "SELECT * FROM seasons WHERE series_id = ?";
    $stmt = $conn->prepare($sql_seasons);
    $stmt->bind_param("i", $series_id);
    $stmt->execute();
    $result_seasons = $stmt->get_result();

    while ($row = $result_seasons->fetch_assoc()) {
        $seasons[] = $row;
    }
    $stmt->close();
}

// Adicionar nova temporada
if (isset($_POST['add_season']) && isset($_POST['series_id'])) {
    $season_number = $_POST['new_season_number'];
    $series_id = $_POST['series_id'];

    $sql_add_season = "INSERT INTO seasons (series_id, season_number) VALUES (?, ?)";
    $stmt = $conn->prepare($sql_add_season);
    $stmt->bind_param("ii", $series_id, $season_number);

    if ($stmt->execute()) {
        // Exibir mensagem de sucesso
        echo "<div class='alert alert-success' role='alert'>
                <p style='text-align: center;'>Temporada adicionada com sucesso!</p>
              </div>";
        // Recarregar a página após adicionar a temporada
        header("Location: add_episode.php?series_id=$series_id");
        exit;
    } else {
        echo "Erro ao adicionar temporada: " . $stmt->error;
    }
    $stmt->close();
}

// Adicionar episódio
if (isset($_POST['add_episode'])) {
    $episode_title = $_POST['episode_title'];
    $episode_number = $_POST['episode_number'];
    $season_id = $_POST['season_id'];
    $episode_url = $_POST['episode_url'];

    $sql_add_episode = "INSERT INTO episodes (season_id, title, episode_number, url) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_add_episode);
    $stmt->bind_param("isis", $season_id, $episode_title, $episode_number, $episode_url);

    if ($stmt->execute()) {
        // Exibir mensagem de sucesso
        echo "<div class='alert alert-success' role='alert'>
                <p style='text-align: center;'>Episódio adicionado com sucesso!</p>
              </div>";
    } else {
        echo "Erro ao adicionar episódio: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Episódio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function fetchSeasons() {
            const seriesId = document.getElementById('series_id').value;
            if (seriesId) {
                window.location.href = `add_episode.php?series_id=${seriesId}`;
            }
        }
    </script>
</head>
<body class="bg-dark text-light">

    <!-- Barra de navegação -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Wisitys Streaming</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Página Inicial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_episode.php">Adicionar Episódio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="series.php">Gerenciar Séries</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <h1 class="text-center text-primary mb-4">Adicionar Episódio</h1>

        <!-- Formulário para selecionar série -->
        <form id="season_form" action="add_episode.php" method="GET">
            <div class="mb-3">
                <label for="series_id" class="form-label">Série</label>
                <select class="form-select" id="series_id" name="series_id" onchange="fetchSeasons()" required>
                    <option value="">Selecione uma Série</option>
                    <?php while ($row = $result_series->fetch_assoc()): ?>
                        <option value="<?= $row['id'] ?>" <?= isset($series_id) && $series_id == $row['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['title']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </form>

        <!-- Formulário para adicionar temporada -->
        <?php if (isset($series_id)): ?>
            <form action="add_episode.php" method="POST">
                <input type="hidden" name="series_id" value="<?= $series_id ?>">
                <div class="mb-3">
                    <label for="new_season_number" class="form-label">Número da Nova Temporada</label>
                    <input type="number" class="form-control" id="new_season_number" name="new_season_number" required>
                </div>
                <button type="submit" class="btn btn-secondary" name="add_season">Adicionar Temporada</button>
            </form>
        <?php endif; ?>

        <!-- Formulário para adicionar episódio -->
        <?php if (!empty($seasons)): ?>
            <form action="add_episode.php" method="POST">
                <div class="mb-3">
                    <label for="season_id" class="form-label">Temporada</label>
                    <select class="form-select" id="season_id" name="season_id" required>
                        <option value="">Selecione uma Temporada</option>
                        <?php foreach ($seasons as $season): ?>
                            <option value="<?= $season['id'] ?>">Temporada <?= $season['season_number'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="episode_title" class="form-label">Título do Episódio</label>
                    <input type="text" class="form-control" id="episode_title" name="episode_title" required>
                </div>

                <div class="mb-3">
                    <label for="episode_number" class="form-label">Número do Episódio</label>
                    <input type="number" class="form-control" id="episode_number" name="episode_number" required>
                </div>

                <div class="mb-3">
                    <label for="episode_url" class="form-label">URL do Episódio</label>
                    <input type="text" class="form-control" id="episode_url" name="episode_url" required>
                </div>

                <button type="submit" class="btn btn-primary" name="add_episode">Adicionar Episódio</button>
            </form>
        <?php else: ?>
            <p class="text-warning">Selecione uma série para listar as temporadas disponíveis.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
