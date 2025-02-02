<?php
session_start();

// Verifica se o administrador está logado
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

// Inclui o arquivo DAO
require_once 'dao.php';

// Instancia a classe Database
$db = new Database();
$conn = $db->getConnection();

// Inicializa a variável de pesquisa
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Consulta para obter os filmes com base na pesquisa
$sql_filmes = "SELECT * FROM movies WHERE title LIKE '%$search_query%'";
$result_filmes = $conn->query($sql_filmes);

// Consulta para obter as séries com base na pesquisa
$sql_series = "SELECT * FROM series WHERE title LIKE '%$search_query%'";
$result_series = $conn->query($sql_series);
mysqli_set_charset($conn, "utf8");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WisitysStreaming</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #141414;
            color: #ffffff;
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background-color: #141414;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #e50914 !important;
        }

        .navbar-nav .nav-link {
            color: #ffffff !important;
            margin-right: 1rem;
        }

        .navbar-nav .nav-link:hover {
            color: #e50914 !important;
        }

        .category {
            margin-top: 2rem;
        }

        .category h2 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }

        .scrolling-wrapper {
            display: flex;
            overflow-x: auto;
            gap: 1rem;
            padding-bottom: 1rem;
        }

        .scrolling-wrapper::-webkit-scrollbar {
            height: 10px;
        }

        .scrolling-wrapper::-webkit-scrollbar-thumb {
            background-color: #e50914;
            border-radius: 10px;
        }

        .scrolling-wrapper::-webkit-scrollbar-track {
            background-color: #333;
        }

        .scrolling-wrapper .card {
            min-width: 200px;
            border: none;
        }

        .scrolling-wrapper .card img {
            border-radius: 0.5rem;
        }

        .footer {
            background-color: #141414;
            text-align: center;
            padding: 1rem 0;
        }

        .btn-primary {
            background-color: #e50914;
            border: none;
        }

        .btn-primary:hover {
            background-color: #f40612;
        }

        .search-bar {
            margin-top: 1rem;
            margin-bottom: 2rem;
        }

        .search-bar input {
            background-color: #333;
            color: #fff;
            border: 1px solid #e50914;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">Wisitys</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                   
                    <ul class="navbar-nav ms-auto">
                        <?php if ($is_admin): ?>
                            <li class="nav-item"><a class="nav-link" href="add_movie.php">Adicionar Filme</a></li>
                            <li class="nav-item"><a class="nav-link" href="add_series.php">Adicionar Série</a></li>
                            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Search Bar -->
    <div class="container search-bar">
        <form action="#" method="GET">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Pesquisar filmes e séries" name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="category">
            <h2>Filmes</h2>
            <div class="scrolling-wrapper">
                <?php if ($result_filmes && $result_filmes->num_rows > 0): ?>
                    <?php while ($filme = $result_filmes->fetch_assoc()): ?>
                        <div class="card bg-dark text-light">
                            <img src="<?= htmlspecialchars($filme['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($filme['title']) ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-center"><?= htmlspecialchars($filme['title']) ?></h5>
                                <a href="movie.php?id=<?= $filme['id'] ?>" class="btn btn-primary w-100 mt-auto">Assistir</a>
                                <?php if ($is_admin): ?>
                                    <a href="edit_movie.php?id=<?= $filme['id'] ?>" class="btn btn-warning w-100 mt-2">Editar</a>
                                    <a href="delete_movie.php?id=<?= $filme['id'] ?>" class="btn btn-danger w-100 mt-2">Excluir</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Nenhum filme encontrado.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="category">
            <h2>Séries</h2>
            <div class="scrolling-wrapper">
                <?php if ($result_series && $result_series->num_rows > 0): ?>
                    <?php while ($serie = $result_series->fetch_assoc()): ?>
                        <div class="card bg-dark text-light">
                            <img src="<?= htmlspecialchars($serie['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($serie['title']) ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-center"><?= htmlspecialchars($serie['title']) ?></h5>
                                <a href="series.php?id=<?= $serie['id'] ?>" class="btn btn-primary w-100 mt-auto">Assistir</a>
                                <?php if ($is_admin): ?>
                                    <a href="edit_series.php?id=<?= $serie['id'] ?>" class="btn btn-warning w-100 mt-2">Editar</a>
                                    <a href="delete_series.php?id=<?= $serie['id'] ?>" class="btn btn-danger w-100 mt-2">Excluir</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Nenhuma série encontrada.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php $conn->close(); ?>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 Wisitys Streaming. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
