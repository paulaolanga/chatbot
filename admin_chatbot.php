<?php
// ConfiguraÃ§Ã£o do banco de dados
$servername = "localhost";
$username = "chatbot_user";
$password = "Ch@tBotPass123";
$dbname = "chatbot_db";

// ConexÃ£o com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("ConexÃ£o falhou: " . $conn->connect_error);
}

// Processar aÃ§Ãµes (adicionar, editar, excluir)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $question = $conn->real_escape_string($_POST['question']);
        $answer = $conn->real_escape_string($_POST['answer']);
        $sql = "INSERT INTO messages (question, answer) VALUES ('$question', '$answer')";
        $conn->query($sql);
    } elseif (isset($_POST['edit'])) {
        $id = intval($_POST['id']);
        $question = $conn->real_escape_string($_POST['question']);
        $answer = $conn->real_escape_string($_POST['answer']);
        $sql = "UPDATE messages SET question='$question', answer='$answer' WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['delete'])) {
        $id = intval($_POST['id']);
        $sql = "DELETE FROM messages WHERE id=$id";
        $conn->query($sql);
    }
}

// Buscar perguntas e respostas
$result = $conn->query("SELECT * FROM messages");

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdministraÃ§Ã£o do Chatbot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #28a745;
            color: white;
        }
        form {
            margin-bottom: 20px;
        }
        input, textarea, button {
            padding: 10px;
            margin: 5px 0;
            width: 100%;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>AdministraÃ§Ã£o do Chatbot</h1>

    <!-- FormulÃ¡rio para adicionar uma nova pergunta e resposta -->
    <form method="POST">
        <h2>Adicionar Nova Pergunta</h2>
        <input type="text" name="question" placeholder="Pergunta" required>
        <textarea name="answer" placeholder="Resposta" required></textarea>
        <button type="submit" name="add">Adicionar</button>
    </form>

    <!-- Tabela com perguntas e respostas existentes -->
    <h2>Gerenciar Perguntas e Respostas</h2>
    <table>
        <tr>
            <th>Pergunta</th>
            <th>Resposta</th>
            <th>AÃ§Ãµes</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <form method="POST">
                    <td>
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="text" name="question" value="<?php echo htmlspecialchars($row['question']); ?>" required>
                    </td>
                    <td>
                        <textarea name="answer" required><?php echo htmlspecialchars($row['answer']); ?></textarea>
                    </td>
                    <td>
                        <button type="submit" name="edit">Salvar</button>
                        <button type="submit" name="delete">Excluir</button>
                    </td>
                </form>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
