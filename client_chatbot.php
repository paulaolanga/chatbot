<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Simples</title>
    <style>
        /* Estilo do Chatbot */  
        #chatbot {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 350px;
            background: linear-gradient(135deg, #8BC34A, #388E3C); /* Fundo com gradiente verde */
            border: 1px solid #2C6B2F;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            font-family: Arial, sans-serif;
            display: none; /* Inicialmente escondido */
            overflow: hidden; 
        }
        #chatbot-header {
            background-color: #2C6B2F; /* Cor escura para o cabeÃ§alho */
            color: white;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            text-align: center;
            font-weight: bold;
        }
        #chatbot-messages {
            padding: 10px;
            height: 220px;
            overflow-y: auto;
            border-bottom: 1px solid #4CAF50;
            background-color: #F1F8E9; /* Fundo mais claro para as mensagens */
        }
        #chatbot-input {
            display: flex;
            padding: 10px;
            background-color: #E8F5E9; /* Fundo suave para o campo de entrada */
            border-top: 1px solid #4CAF50;
        }
        #chatbot-input input {
            flex: 1;
            padding: 10px;
            border: 1px solid #4CAF50;
            border-radius: 8px;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        #chatbot-input button {
            padding: 10px 15px;
            background-color: #388E3C; /* BotÃ£o verde */
            color: white;
            border: none;
            border-radius: 8px;
            margin-left: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        #chatbot-input button:hover {
            background-color: #2C6B2F; /* Muda a cor quando o botÃ£o Ã© pressionado */
        }

        /* Estilo do BotÃ£o de Ajuda */
        #help-button {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: #2C6B2F;
            color: white;
            padding: 10px 15px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        #help-button:hover {
            background-color: #388E3C; /* Efeito de hover */
        }

        /* Estilo para perguntas em bloco */
        .question-block {
            margin: 10px 0;
            background-color: #388E3C;
            color: white;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .question-block:hover {
            background-color: #2C6B2F; /* Escurece ao passar o mouse */
        }

        /* Respostas do Bot */
        .bot-response {
            background-color: #C8E6C9; /* Fundo suave para as respostas */
            padding: 12px;
            border-radius: 8px;
            margin: 8px 0;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Resposta do usuÃ¡rio */
        .user-response {
            background-color: #E8F5E9; /* Fundo suave para as respostas do usuÃ¡rio */
            padding: 12px;
            border-radius: 8px;
            margin: 8px 0;
            font-size: 14px;
            text-align: right;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

    </style>
    <script>
        // FunÃ§Ã£o para abrir e fechar o chatbot
        function toggleChatbot() {
            var chatbot = document.getElementById("chatbot");
            if (chatbot.style.display === "none") {
                chatbot.style.display = "block";
                loadQuestions(); // Carrega as perguntas ao abrir o chat
            } else {
                chatbot.style.display = "none";
            }
        }

        // FunÃ§Ã£o para enviar a pergunta selecionada ou texto livre
        function sendMessage() {
            var userInput = document.getElementById("chatbot-input-field").value.trim();

            // Verifica se hÃ¡ algo no campo de entrada
            if (userInput !== "") {
                var messagesContainer = document.getElementById("chatbot-messages");
                var userMessage = document.createElement("div");
                userMessage.className = "user-response";
                userMessage.textContent = "VocÃª: " + userInput;
                messagesContainer.appendChild(userMessage);

                // Envia a mensagem para o servidor via AJAX
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "chatbot.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var botResponse = document.createElement("div");
                        botResponse.className = "bot-response";
                        botResponse.textContent = "Bot: " + xhr.responseText;
                        messagesContainer.appendChild(botResponse);

                        // Rola a janela para a Ãºltima mensagem
                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    }
                };
                xhr.send("question=" + encodeURIComponent(userInput));

                // Limpa o campo de entrada apÃ³s enviar
                document.getElementById("chatbot-input-field").value = "";
            }
        }

        // FunÃ§Ã£o para carregar perguntas da base de dados
        function loadQuestions() {
            var questions = [
                "Qual Ã© o horÃ¡rio de atendimento?",
                "Como posso resetar minha senha?",
                "Como faÃ§o para abrir um ticket?",
                "Quais sÃ£o os serviÃ§os oferecidos?",
                "Posso alterar meu endereÃ§o de e-mail?",
                "onde fica administracao ?",
            ];

            var questionsContainer = document.getElementById("question-blocks");
            questionsContainer.innerHTML = ''; // Limpa as perguntas antigas

            // Cria blocos de perguntas clicÃ¡veis
            questions.forEach(function(question) {
                var questionBlock = document.createElement("div");
                questionBlock.className = "question-block";
                questionBlock.textContent = question;
                questionBlock.onclick = function() { sendQuestion(question); };
                questionsContainer.appendChild(questionBlock);
            });
        }

        // FunÃ§Ã£o para enviar a pergunta selecionada
        function sendQuestion(question) {
            var messagesContainer = document.getElementById("chatbot-messages");
            var userMessage = document.createElement("div");
            userMessage.className = "user-response";
            userMessage.textContent = "VocÃª: " + question;
            messagesContainer.appendChild(userMessage);

            // Envia a pergunta para o servidor via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "chatbot.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var botResponse = document.createElement("div");
                    botResponse.className = "bot-response";
                    botResponse.textContent = "Bot: " + xhr.responseText;
                    messagesContainer.appendChild(botResponse);

                    // Rola a janela para a Ãºltima mensagem
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            };
            xhr.send("question=" + encodeURIComponent(question));
        }
    </script>
</head>
<body>
    <!-- BotÃ£o de Ajuda -->
    <div id="help-button" onclick="toggleChatbot()">Precisa de ajuda?</div>

    <!-- Chatbot -->
    <div id="chatbot">
        <div id="chatbot-header">Ajuda UEM</div>
        <div id="chatbot-messages">
            <!-- Mensagens do chatbot vÃ£o aparecer aqui -->
        </div>
        <div id="question-blocks">
            <!-- Blocos de perguntas predefinidas -->
        </div>
        <div id="chatbot-input">
            <input type="text" id="chatbot-input-field" placeholder="Digite sua mensagem..." onkeydown="if(event.key === 'Enter'){sendMessage();}">
            <button onclick="sendMessage()">Enviar</button>
        </div>
    </div>
</body>
</html>

</div>

<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>
