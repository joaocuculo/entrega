<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Entregas</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <style>
        .title-gradient {
            background: linear-gradient(90deg, #ffffff, #007bff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .box-login {
            background: #111212 !important; /* Cor preta (ou quase preta) com !important para ser prioridade e maior hierarquia */
            padding: 20px;
            border-radius: 8px;
            transform: scale(1.0); /* Zoom de 110% */
            transform-origin: center;
        }
        .form-control {
            background: none;
            border: none;
            border-bottom: 1px solid #000; /* Linha em vez de caixa */
            width: 100%;
            color: white; /* Cor do texto */
        }
        .form-control::placeholder {
            color: white; /* Cor do placeholder */
        }
        .form-control:focus {
            outline: none;
            border-bottom: 1px solid #007bff; /* Linha azul ao focar */
        }
        .password-container {
            position: absolute;
            display: flex;
            align-items: center;
        }
        .container {
            position: absolute;
            right: 0;
            cursor: pointer;
        }
        .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;

        }
        .container .eye,
        .container .eye-slash {
            position: relative;
            top: -20px; /* para o icone do olho ir para cima tem que por o numero do top no negativo */
            right: 0;
            height: 100%;
            width: 14px;
            fill: #a5a5b0;
            left: 105px; /* Muda a posição do icone para a direita (por algum motivo aqui o left representa direita) */
        }
        .container .eye-slash {
            display: none;
        }
        .container input:checked ~ .eye {
            display: none;
        }
        .container input:checked ~ .eye-slash {
            display: block;
        }
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 30px rgba(17, 18, 18, 0.98) inset;
        }
        input:-webkit-autofill {
            -webkit-text-fill-color: white !important;
        }
        #nome,
        #senha {
            width: 100%; /* ocupa todo o espaço disponível */
            color: white; /* Cor do texto */
            border: none; /* Remove a borda padrão */
            border-bottom: 1px solid #000; /* Adiciona linha inferior */
            background: none; /* Fundo transparente */
        }
        #nome::placeholder,
        #senha::placeholder {
            color: white; /* Cor do placeholder */
        }
        #nome:focus,
        #senha:focus {
            outline: none;
            border-bottom: 1px solid #007bff; /* Linha azul ao focar */
        }
        body {
            overflow: hidden; /* Para esconder a barra de rolagem */
            margin: 0; /* Remove margens padrão */
            padding: 0; /* Remove preenchimentos padrão */
            font-family: Arial, sans-serif; /* Define uma fonte padrão */
        }
        .bg-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            filter: blur(3px);
            background-image: url('https://portalumuaramanews.com.br/wp-content/uploads/2024/02/prefeitura-umuarama.jpg'); /* Substitua pelo caminho da sua imagem de fundo */
            background-size: cover;
            background-position: center;
        }
        .bg-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0, 0.4); /* preto com transparência de 40% */
            z-index: -1;
        }
    </style>
    </head>
<body>
    <div class="bg-image"></div>
    <div class="bg-overlay"></div>
    <div id="container">
        <div class="box-login">
            <h1 class="title-gradient">Painel de Saídas</h1>
            <form action="autenticacao.php" method="post" class="box">
                <?php if (!isset($_GET['mensagem']) || isset($_SESSION['id'])) { ?>
                    <div style="color: white;">Faça o login</div>
                <?php } else { ?>
                    <div id="mensagem" style="color:red; text-align:center;">
                        <?= $_GET['mensagem'] ?>
                    </div>
                <?php } ?>
                <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" required>
                <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha" required>
                <div class="password-container">
                    <label class="container">
                        <input type="checkbox" id="show-password">
                        <i class="bi bi-eye-fill eye"></i>
                        <i class="bi bi-eye-slash-fill eye-slash"></i>
                    </label>
                </div>
                <button type="submit" name="entrar">Entrar</button>
                <!-- Aqui está a imagem após o botão -->
                <img src="assets/img/dti-logo-branca.png" alt="Logo DTI" style="height: 55px;">
                
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var checkbox = document.getElementById('show-password');
            var senhaInput = document.getElementById('senha');

            checkbox.addEventListener('change', function() {
                senhaInput.type = this.checked ? 'text' : 'password';
                var eye = document.querySelector('.eye');
                var eyeSlash = document.querySelector('.eye-slash');
                eye.classList.toggle('d-none');
                eyeSlash.classList.toggle('d-none');
            });
        });
    </script>
</body>
</html>