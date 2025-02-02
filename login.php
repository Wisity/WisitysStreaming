<?php
session_start();

// Conexão com o banco de dados
require_once 'dao.php';

// Criação da instância do banco de dados
$database = new Database();
$conn = $database->getConnection(); // Obtém a conexão

// Verifica se o usuário está tentando se logar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_username = $_POST['username'] ?? '';
    $input_password = $_POST['password'] ?? '';

    // Verifica se a conexão foi estabelecida corretamente
    if (!$conn) {
        die("Erro na conexão com o banco de dados.");
    }

    // Preparar consulta para buscar o usuário e sua senha
    $stmt = $conn->prepare("SELECT password_hash, is_admin FROM users WHERE username = ?");
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $stmt->store_result();

    // Verifica se o usuário foi encontrado
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password, $is_admin);
        $stmt->fetch();

        // Verifica se a senha está correta
        if (password_verify($input_password, $hashed_password)) {
            // Cria a sessão de login
            $_SESSION['is_logged_in'] = true;
            $_SESSION['username'] = $input_username;
            $_SESSION['is_admin'] = $is_admin;  // Define se o usuário é admin

            // Redireciona para a página inicial
            header("Location: index.php");
            exit;
        } else {
            $error_message = "Senha incorreta.";
        }
    } else {
        $error_message = "Usuário não encontrado.";
    }

    // Fecha a consulta
    $stmt->close();
}

// Fecha a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Wisitys Streaming</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #1f1f1f;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-back {
            background-color: #6c757d;
            border-color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2 class="text-center">Login</h2>
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="username" class="form-label">Usuário</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>
            <div class="mt-3 text-center">
                <a href="index.php" class="btn btn-back">Voltar ao Início</a>
            </div>
        </div>
    </div>
</body>
</html>
