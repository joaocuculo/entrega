<?php
    require_once('../verifica-autenticacao.php');

    require_once('../conexao.php');

    if (isset($_POST['cadastrar'])) {
        
        $nome = $_POST['cad-nome-usuario'];
        $senha = $_POST['cad-senha'];
        $senhaConf = $_POST['cad-senha-conf'];
        $status = 1;

        if ($senhaConf == $senha) {
            $sql = "INSERT INTO usuario (nome, senha, status) VALUES ('$nome', '$senha', '$status')";

            mysqli_query($conexao, $sql);

            $mensagem = "Cadastrado com sucesso!";
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
    <title>Cadastro de Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        setTimeout(function() {
            document.getElementById('mensagem').style.display = 'none';
        }, 3000);
    </script>
</head>
<body>
    <?php require_once("../template/menu01.php") ?>    

    <main class="container mt-5">
        <h1>Cadastro de Usuário</h1>
        <form method="post">
            <?php if (isset($mensagem)) { ?>
                <div id="mensagem" class="alert alert-success col-6">
                    <?= $mensagem ?>
                </div>
            <?php } ?>    
            <div>
                <div class="col-6">
                    <label for="cad-nome-usuario">Nome</label>
                    <input type="text" class="form-control" name="cad-nome-usuario" id="cad-nome-usuario" required>
                </div><br>
                <div class="col-6">
                    <label for="cad-senha">Senha</label>
                    <input type="password" class="form-control" name="cad-senha" id="cad-senha" required>
                </div><br>
                <div class="col-6">
                    <label for="cad-senha-conf">Confirme a senha</label>
                    <input type="password" class="form-control" name="cad-senha-conf" id="cad-senha-conf" required>
                </div><br>
                <button type="submit" class="btn btn-primary" name="cadastrar">Cadastrar</button>
            </div>
        </form>
    </main>
</body>
</html>