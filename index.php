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
        button {
            background-color: #007bff;
            color: white;
            border: 2px solid #007bff;
            border-radius: 4px;
            padding: 8px 12px;
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
            background-color: rgba(255, 255, 255, 0.3); /* Branco com transparência de 30% */
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
                <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha" required>

                <button type="submit" name="entrar">Entrar</button>

                <!-- Aqui está a imagem após o botão -->
                <img src="assets/img/logo-dti.png" alt="Descrição da imagem" style="height: 50px;">
            </form>
        </div>
    </div>
</body>
</html>
