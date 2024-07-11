<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Entregas</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/media.css">
    <script type="text/javascript" src="js/script.js"></script>
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
            transform: scale(1.1); /* Zoom de 110% */
            transform-origin: center;
        }
        .form-control {
            background: none;
            border: none;
            border-bottom: 1px solid #000; /* Linha em vez de caixa */
            width: 100%;
            padding: 8px 0;
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
            display: flex;
            align-items: center;
        }
        #senha {
            flex: 1; /* Ocupa todo o espaço disponível */
            margin-right: 10px; /* Espaço entre o campo de senha e o botão */
        }
        button#mostrar-senha {
            background-color: #007bff;
            color: white;
            border: 2px solid #007bff;
            border-radius: 4px;
            padding: 2px 4px; /* Ajuste o padding para diminuir o tamanho */
            width: auto; /* Remova o width para que o botão se ajuste ao conteúdo */
            font-size: 12px; /* Ajuste o tamanho da fonte */
        }
        button#mostrar-senha:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        body {
            overflow: hidden; /* Para esconder a barra de rolagem */
        }
        .bg-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            filter: blur(10px);
            background-image: url('assets/img/bg.jpg'); /* Substitua pelo caminho da sua imagem de fundo */
            background-size: cover;
            background-position: center;
        }
        .bg-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.4); /* Branco com transparência de 30% */
            z-index: -1;
        }
    </style>
    <script>
        setTimeout(function() {
            document.getElementById('mensagem').style.display = 'none';
        }, 3000);
    </script>
</head>
<body>
    <div class="bg-image"></div>
    <div class="bg-overlay"></div>
    <div id="container">
        <div class="box-login">
            <h1 class="title-gradient">Sistemas de Entregas</h1>
            <form action="autenticacao.php" method="post" class="box">
                <div style="color: white;">Faça o seu login</div>
                <?php if (isset($_GET['mensagem'])) { ?>
                    <div id="mensagem" style="width:100%; height:25px; color:black; background-color:#f8d7da; text-align:center; padding-top:10px; border:1px solid red; border-radius:6px;">
                        <?= $_GET['mensagem'] ?>
                    </div>
                <?php } ?>
                <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" required>
                <div class="password-container">
                    <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha" required>
                    <button type="button" id="mostrar-senha" class="btn btn-outline-secondary btn-sm">Mostrar</button>
                </div>
                <button type="submit" name="entrar">Entrar</button>

                <!-- Aqui está a imagem após o botão -->
                <img src="assets/img/logo-dti.png" alt="Descrição da imagem" style="height: 50px;">
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mostrarSenhaBtn = document.getElementById('mostrar-senha');
            const senhaInput = document.getElementById('senha');

            mostrarSenhaBtn.addEventListener('click', function() {
                if (senhaInput.type === 'password') {
                    senhaInput.type = 'text';
                    mostrarSenhaBtn.textContent = 'Esconder';
                } else {
                    senhaInput.type = 'password';
                    mostrarSenhaBtn.textContent = 'Mostrar';
                }
            });
        });
    </script>
</body>
</html>
