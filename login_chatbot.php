<?php
session_start();

// Verifica se o usuÃ¡rio jÃ¡ estÃ¡ logado, se sim, redireciona para o painel de administraÃ§Ã£o
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin_chatbot.php');
    exit;
}

// Se o formulÃ¡rio for enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Defina a senha e o nome de usuÃ¡rio para o login
    $username = 'admin'; // Nome de usuÃ¡rio fixo
    $password = 'senha123'; // Senha fixa (vocÃª pode alterar conforme necessÃ¡rio)

    // ObtÃ©m os dados do formulÃ¡rio
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Verifica se as credenciais estÃ£o corretas
    if ($input_username === $username && $input_password === $password) {
        $_SESSION['admin_logged_in'] = true; // Marca a sessÃ£o como logada
        header('Location: admin_chatbot.php'); // Redireciona para o painel de administraÃ§Ã£o
        exit;
    } else {
        $error_message = "Credenciais invÃ¡lidas!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Chatbot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
        }
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Chatbot</h2>
        <?php if (isset($error_message)): ?>
            <div class="error"><?= $error_message ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="UsuÃ¡rio" required><br>
            <input type="password" name="password" placeholder="Senha" required><br>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
