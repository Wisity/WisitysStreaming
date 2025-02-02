<?php
session_start(); // Inicia a sessão

// Inclui o arquivo que contém a classe Database
require_once 'dao.php'; 

// Cria uma instância da classe Database e obtém a conexão
$database = new Database();
$conn = $database->getConnection();

// Verificar se o ID da série foi passado
if (!isset($_GET['id'])) {
    die("ID da série não fornecido.");
}

$series_id = intval($_GET['id']);

// Consulta para obter os episódios da série, agrupados por temporada
$sql = "
    SELECT e.title AS episode_title, e.episode_number, e.url, 
           s.season_number, s.id AS season_id, e.id AS episode_id
    FROM episodes e
    INNER JOIN seasons s ON e.season_id = s.id
    WHERE s.series_id = ?
    ORDER BY s.season_number, e.episode_number
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $series_id);
$stmt->execute();
$result = $stmt->get_result();

// Agrupar episódios por temporada
$episodes_by_season = [];
while ($row = $result->fetch_assoc()) {
    $episodes_by_season[$row['season_number']][] = $row;
}

// Fechar a conexão
$stmt->close();

// Função para excluir um episódio
if (isset($_GET['delete_episode_id'])) {
    $episode_id = intval($_GET['delete_episode_id']);
    
    // Verifica se o usuário é admin antes de permitir a exclusão
    if ($_SESSION['is_admin'] === 1) {
        $sql_delete = "DELETE FROM episodes WHERE id = ?";
        $stmt = $conn->prepare($sql_delete);
        $stmt->bind_param("i", $episode_id);

        if ($stmt->execute()) {
            echo "Episódio excluído com sucesso!";
            // Recarregar a página após a exclusão
            header("Location: series_episodes.php?id=$series_id");
            exit;
        } else {
            echo "Erro ao excluir episódio: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Você não tem permissão para excluir episódios.";
    }
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Episódios da Série</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: white;
        }

        h1, h2 {
            color: #00bcd4; /* Azul Neon */
        }

        .episode-item {
            background-color: #333;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .episode-item a {
            color: #00bcd4;
        }

        .episode-item a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .btn-custom {
            background-color: #00bcd4;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #008c99;
        }

        .list-group-item {
            background-color: #333;
            border: none;
        }
    </style>
    <script>
        // Função para mostrar o iframe abaixo do episódio selecionado
        function showIframe(episodeId, url) {
            // Esconde o iframe anterior, se houver
            const existingIframe = document.getElementById('iframe-' + episodeId);
            if (existingIframe) {
                existingIframe.remove();
            }

            // Cria um novo iframe para o episódio selecionado
            const iframe = document.createElement('iframe');
            iframe.id = 'iframe-' + episodeId;
            iframe.src = url;
            iframe.width = "100%";
            iframe.height = "400px";
            iframe.frameBorder = "0";
            iframe.allowFullscreen = true; // Permite fullscreen no iframe

            // Cria o botão de tela cheia
            const fullscreenButton = document.createElement('button');
            fullscreenButton.classList.add('btn', 'btn-secondary', 'mt-2');
            fullscreenButton.innerText = "Tela Cheia";
            fullscreenButton.onclick = function() {
                // Coloca o iframe em modo tela cheia
                const iframeElement = document.getElementById('iframe-' + episodeId);
                if (iframeElement.requestFullscreen) {
                    iframeElement.requestFullscreen();
                } else if (iframeElement.mozRequestFullScreen) { // Para Firefox
                    iframeElement.mozRequestFullScreen();
                } else if (iframeElement.webkitRequestFullscreen) { // Para Chrome, Safari
                    iframeElement.webkitRequestFullscreen();
                } else if (iframeElement.msRequestFullscreen) { // Para IE/Edge
                    iframeElement.msRequestFullscreen();
                }
            };

            // Insere o iframe e o botão logo abaixo do episódio
            const episodeElement = document.getElementById('episode-' + episodeId);
            episodeElement.appendChild(iframe);
            episodeElement.appendChild(fullscreenButton);
        }
    </script>
</head>
<body>
    <div class="container py-5">
        <h1 class="text-center mb-4">Episódios da Série</h1>

        <?php if (empty($episodes_by_season)): ?>
            <p class="text-center">Nenhum episódio encontrado para esta série.</p>
        <?php else: ?>
            <!-- Exibe um aviso se houver apenas uma temporada -->
            <?php if (count($episodes_by_season) == 1): ?>
                <div class="alert alert-info text-center">
                    <strong>Aviso:</strong> Esta janela irá conter apenas uma temporada, mas todas elas estão na janela abaixo.
                </div>
            <?php endif; ?>

            <?php foreach ($episodes_by_season as $season_number => $episodes): ?>
                <h2 class="text-warning">Janela Unica</h2>
                <ul class="list-group mb-4">
                    <?php foreach ($episodes as $episode): ?>
                        <li class="list-group-item episode-item" id="episode-<?= $episode['episode_id'] ?>">
                            <strong>Assistir Serie ...</strong> 
                            
                            <a href="javascript:void(0);" onclick="showIframe(<?= $episode['episode_id'] ?>, '<?= htmlspecialchars($episode['url']) ?>')" 
                               class="btn btn-custom btn-sm float-end">Assistir</a>

                            <!-- Exibe os botões de edição e exclusão somente para o admin -->
                            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1): ?>
                                <a href="edit_episode.php?episode_id=<?= $episode['episode_id'] ?>" class="btn btn-warning btn-sm float-end me-2">Editar</a>
                                <a href="?id=<?= $series_id ?>&delete_episode_id=<?= $episode['episode_id'] ?>" 
                                   onclick="return confirm('Tem certeza que deseja excluir este episódio?')" 
                                   class="btn btn-danger btn-sm float-end me-2">Excluir</a>                          
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
