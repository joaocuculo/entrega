<?php
require_once('../verifica-autenticacao.php');
require_once('../conexao.php');

$mensagem = '';

if (isset($_POST['cadastrar'])) {
    $nome = $_POST['cad-nome-adm'];
    $senha = $_POST['cad-senha'];
    $senhaConf = $_POST['cad-senha-conf'];
    $status = 1;
    $nivel = 2;

    if ($senhaConf == $senha) {
        $nome = mysqli_real_escape_string($conexao, $nome);
        $senha = mysqli_real_escape_string($conexao, $senha);
        
        $sql = "INSERT INTO usuario (nome, senha, status, nivel) VALUES ('$nome', '$senha', '$status', '$nivel')";

        if (mysqli_query($conexao, $sql)) {
            $mensagem = "Cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar usuário: " . mysqli_error($conexao);
        }
    } else {
        $mensagem = "As senhas inseridas são diferentes!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        * {
            color: white;
        }
        body {
            background-color: #000B18;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1; /* Faz com que o conteúdo ocupe o espaço restante vertical */
        }

        p a {
            text-decoration: none;
            color: #000000;
        }

        p a:hover {
            text-decoration: underline;
            transition: 3s;
        }

        /* Estilos para o Sticky Footer */
        #sticky-footer {
            flex-shrink: 0; /* Evita que o footer seja reduzido */
            padding: 1rem;
            background-color: #343a40;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php require_once("../template/menu01.php") ?>    

    <main class="container" style="margin-top: 100px;">
        <h1 class="text-center mb-4">Cadastro de Administrador</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post">
                    <?php if (!empty($mensagem)) { ?>
                        <div id="mensagem" class="alert alert-<?php echo (strpos($mensagem, 'sucesso') !== false) ? 'success' : 'danger'; ?> mb-3" style="background-color:#051B11; color:white;">
                            <?= $mensagem ?>
                        </div>
                    <?php } ?>    
                    <div class="mb-3">
                        <label for="cad-nome-adm" class="form-label">Nome</label>
                        <input type="text" class="form-control" name="cad-nome-adm" id="cad-nome-adm" required>
                    </div>
                    <div class="mb-3">
                        <label for="cad-senha" class="form-label">Senha</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="cad-senha" id="cad-senha" required>
                            <button class="btn btn-outline-secondary" type="button" id="mostrar-senha"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="cad-senha-conf" class="form-label">Confirme a senha</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="cad-senha-conf" id="cad-senha-conf" required>
                            <button class="btn btn-outline-secondary" type="button" id="mostrar-senha-conf"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                    <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
                </form>
            </div>
        </div>
    </main>

    <?php require_once("../template/rodape01.php") ?>   

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mostrarSenhaBtn = document.getElementById('mostrar-senha');
            const senhaInput = document.getElementById('cad-senha');

            mostrarSenhaBtn.addEventListener('click', function() {
                if (senhaInput.type === 'password') {
                    senhaInput.type = 'text';
                    mostrarSenhaBtn.innerHTML = '<i class="bi bi-eye-slash"></i>';
                } else {
                    senhaInput.type = 'password';
                    mostrarSenhaBtn.innerHTML = '<i class="bi bi-eye"></i>';
                }
            });

            const mostrarSenhaConfBtn = document.getElementById('mostrar-senha-conf');
            const senhaConfInput = document.getElementById('cad-senha-conf');

            mostrarSenhaConfBtn.addEventListener('click', function() {
                if (senhaConfInput.type === 'password') {
                    senhaConfInput.type = 'text';
                    mostrarSenhaConfBtn.innerHTML = '<i class="bi bi-eye-slash"></i>';
                } else {
                    senhaConfInput.type = 'password';
                    mostrarSenhaConfBtn.innerHTML = '<i class="bi bi-eye"></i>';
                }
            });
        });
    </script>
</body>
</html>
