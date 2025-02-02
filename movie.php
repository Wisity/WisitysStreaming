<?php
session_start();

// Verifica se o administrador está logado
$is_admin = isset($_SESSION['is_admin']) ? $_SESSION['is_admin'] : false;

// Verifica se o nome de usuário está na sessão
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

// Inclui o arquivo DAO
require_once 'dao.php';

// Instancia a classe Database
$db = new Database();
$conn = $db->getConnection();

// Verifica se a variável de conexão foi inicializada corretamente
if (!$conn) {
    die("Erro ao conectar ao banco de dados.");
}

// Código para pegar detalhes do filme, ou outra lógica
$movie_id = $_GET['id'] ?? null;
if ($movie_id) {
    // Exemplo de consulta para pegar os detalhes de um filme
    $stmt = $conn->prepare("SELECT * FROM movies WHERE id = ?");
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $movie = $result->fetch_assoc();
    } else {
        echo "<p>Filme não encontrado.</p>";
    }

    $stmt->close();
} else {
    echo "<p>ID do filme não especificado.</p>";
}

// Fechar a conexão com o banco
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($movie['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #f0f0f0;
        }
        .navbar {
            background-color: #2c3e50;
        }
        .navbar-nav .nav-link {
            color: #ecf0f1 !important;
        }
        .navbar-nav .nav-link:hover {
            color: #3498db !important;
        }
        .container {
            margin-top: 40px;
        }
        .movie-detail iframe {
            border-radius: 8px;
        }
        .footer {
            background-color: #34495e;
            padding: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Wisitys Streaming</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Início</a></li>
                    <?php if ($is_admin): ?>
                        <li class="nav-item"><a class="nav-link" href="add_movie.php">Adicionar Filme</a></li>
                        <li class="nav-item"><a class="nav-link" href="add_series.php">Adicionar Série</a></li>
                        <li class="nav-item"><a class="nav-link" href="add_episode.php">Adicionar Episódio</a></li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form class="d-flex" action="search.php" method="GET">
                            <input class="form-control me-2" type="search" placeholder="Pesquisar filmes..." name="query" aria-label="Pesquisar">
                            <button class="btn btn-outline-light" type="submit">Pesquisar</button>
                        </form>
                    </li>
                    <?php if ($username): ?>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Sair</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-md-8 movie-detail">
                <h2><?= htmlspecialchars($movie['title']) ?></h2>
                <!-- Exibe o link do filme como iframe -->
                <?php if (!empty($movie['link'])): ?>
                    <iframe width="100%" height="500" src="<?= htmlspecialchars($movie['link']) ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                <?php else: ?>
                    <p class="text-warning">Link para assistir ao filme não disponível.</p>
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <h3>Detalhes</h3>
                <p><strong>Gênero:</strong> <?= htmlspecialchars($movie['genre']) ?></p>
                <p><strong>Ano:</strong> <?= htmlspecialchars($movie['year']) ?></p>
                <p><strong>Sinopse:</strong> <?= htmlspecialchars($movie['synopsis']) ?></p>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Wisitys Streaming. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
