<?php
    require_once('../verifica-autenticacao.php');

    require_once('../conexao.php');

    $mensagem = "";

    if (isset($_POST['salvar'])) {
        
        $id = $_POST['id'];
        $nome = $_POST['edit-nome-usuario'];
        $senha = $_POST['edit-senha'];
        $senhaConf = $_POST['edit-senha-conf'];
        $status = 1;

        if ($senhaConf == $senha) {
            $sql = "UPDATE usuario
                       SET nome = '$nome',
                          senha = '$senha',
                         status = '$status'
                     WHERE id = $id";

            mysqli_query($conexao, $sql);

            $mensagem = "Alterado com sucesso!";

            header("Location: {$_SERVER['PHP_SELF']}?id=$id&success=true");
            exit();
        } else {
            $mensagem = "As senhas inseridas são diferentes!";
        }    
    }

    // Verifica se houve sucesso na atualização para exibir a mensagem
    if (isset($_GET['success']) && $_GET['success'] == 'true') {
        $mensagem = "Alterado com sucesso!";
    }
    
    $sql = "SELECT * FROM usuario WHERE id = " . $_GET['id'];
    $resultado = mysqli_query($conexao, $sql);
    $linha = mysqli_fetch_array($resultado);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
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
        <h1 class="text-center mb-4">Editar Usuário</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post">
                    <?php if (!empty($mensagem)) { ?>
                        <div id="mensagem" class="alert alert-success mb-3">
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
                        <input type="password" class="form-control" name="edit-senha" id="edit-senha" value="<?= $linha['senha'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-senha-conf" class="form-label">Confirme a senha</label>
                        <input type="password" class="form-control" name="edit-senha-conf" id="edit-senha-conf" value="<?= $linha['senha'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success" name="salvar">Salvar</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>