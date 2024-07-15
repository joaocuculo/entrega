<?php
require_once('../verifica-autenticacao.php');
require_once('../conexao.php');

$mensagem = '';

if (isset($_POST['salvar'])) {
    $id = $_POST['id'];
    $nome = $_POST['edit-nome-usuario'];
    $senha = $_POST['edit-senha'];
    $senhaConf = $_POST['edit-senha-conf'];
    $status = 1;

    if ($senhaConf == $senha) {
        $sql = "UPDATE usuario SET nome = '$nome', senha = '$senha', status = '$status' WHERE id = $id";
        mysqli_query($conexao, $sql);
        $mensagem = "Alterado com sucesso!";
        header("Location: {$_SERVER['PHP_SELF']}?success=true");
        exit();
    } else {
        $mensagem = "As senhas inseridas são diferentes!";
    }    
}

if (isset($_GET['success']) && $_GET['success'] == 'true') {
    $mensagem = "Alterado com sucesso!";
}

$sql = "SELECT * FROM usuario WHERE id = " . $_SESSION['id'];
$resultado = mysqli_query($conexao, $sql);
$linha = mysqli_fetch_array($resultado);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mostrarSenhaBtn = document.getElementById('mostrar-senha');
            const senhaInput = document.getElementById('edit-senha');
            mostrarSenhaBtn.addEventListener('click', function() {
                senhaInput.type = senhaInput.type === 'password' ? 'text' : 'password';
                mostrarSenhaBtn.textContent = senhaInput.type === 'text' ? 'Esconder' : 'Mostrar';
            });

            const mostrarSenhaConfBtn = document.getElementById('mostrar-senha-conf');
            const senhaConfInput = document.getElementById('edit-senha-conf');
            mostrarSenhaConfBtn.addEventListener('click', function() {
                senhaConfInput.type = senhaConfInput.type === 'password' ? 'text' : 'password';
                mostrarSenhaConfBtn.textContent = senhaConfInput.type === 'text' ? 'Esconder' : 'Mostrar';
            });
        });

        setTimeout(function() {
            const mensagem = document.getElementById('mensagem');
            if (mensagem) {
                mensagem.style.display = 'none';
            }
        }, 3000);
    </script>
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
            flex: 1;
            margin-top: 100px; /* Espaço para a navbar */
        }
        p a {
            text-decoration: none;
            color: #000000;
        }
        p a:hover {
            text-decoration: underline;
            transition: 3s;
        }
        #sticky-footer {
            flex-shrink: 0;
            padding: 1rem;
            background-color: #343a40;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php require_once("../template/menu01.php") ?>    

    <main class="container">
        <h1 class="text-center mb-4">Cadastro de Usuário</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post">
                    <?php if (!empty($mensagem)) { ?>
                        <div id="mensagem" class="alert alert-success mb-3" style="background-color:#051B11; color:white;">
                            <?= $mensagem ?>
                        </div>
                    <?php } ?>  
                    <input type="hidden" name="id" value="<?= $linha['id'] ?>">
                    <div class="mb-3">
                        <label for="edit-nome-usuario" class="form-label">Nome</label>
                        <input type="text" class="form-control" name="edit-nome-usuario" id="edit-nome-usuario" value="<?= $linha['nome'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-senha" class="form-label">Senha</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="edit-senha" id="edit-senha" value="<?= $linha['senha'] ?>" required>
                            <button class="btn btn-outline-secondary" type="button" id="mostrar-senha">Mostrar</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit-senha-conf" class="form-label">Confirme a senha</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="edit-senha-conf" id="edit-senha-conf" value="<?= $linha['senha'] ?>" required>
                            <button class="btn btn-outline-secondary" type="button" id="mostrar-senha-conf">Mostrar</button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success" name="salvar">Salvar</button>
                </form>
            </div>
        </div>
    </main>

    <?php require_once("../template/rodape01.php") ?>   
</body>
</html>
