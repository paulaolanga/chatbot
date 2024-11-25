<?php
// ConfiguraÃ§Ã£o do banco de dados
$servername = "localhost";
$username = "chatbot_user";
$password = "Ch@tBotPass123";
$dbname = "chatbot_db";

// ConexÃ£o com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexÃ£o
if ($conn->connect_error) {
    die("ConexÃ£o falhou: " . $conn->connect_error);
}

// Processa a pergunta do usuÃ¡rio
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['question'])) {
    $question = $conn->real_escape_string($_POST['question']);

    // Busca a resposta no banco de dados
    $sql = "SELECT answer FROM messages WHERE question LIKE '%$question%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['answer'];
    } else {
        echo "Desculpe, nÃ£o encontrei uma resposta para sua pergunta.";
    }
}

$conn->close();
?>
