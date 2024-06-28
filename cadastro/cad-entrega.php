<?php
    require_once('../verifica-autenticacao.php');

    require_once('../conexao.php');

    $sql_usuario = "SELECT * FROM usuario WHERE id = " . $_SESSION['id'];
    $resultado_usuario = mysqli_query($conexao, $sql_usuario);
    $linha_usuario = mysqli_fetch_array($resultado_usuario);

    if (isset($_POST['cadastrar'])) {
        
        $usuario = $linha_usuario['id'];
        $data = new DateTime($_POST['data']);
        $chamado = $_POST['chamado'];
        $tecnico = $_POST['tecnico'];
        $recebedor = $_POST['recebedor'];
        $dataString = $data->format('d/m/Y');

        $sql = "INSERT INTO tabela (id_usuario, data, chamado, id_tecnico, recebedor) VALUES ('$usuario', '$dataString', '$chamado', '$tecnico', '$recebedor')";
        
        mysqli_query($conexao, $sql);

        $mensagem = "Cadastrado com sucesso!";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Entrega</title>
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
        <h1>Cadastro de Entrega</h1>
        <form method="post">
            <?php if (isset($mensagem)) { ?>
                <div id="mensagem" class="alert alert-success col-6">
                    <?= $mensagem ?>
                </div>
            <?php } ?>
            <div class="col-6">
                <label for="usuario">Usuário</label>
                <input type="text" class="form-control" name="usuario" id="usuario" value="<?= $linha_usuario['nome'] ?>" disabled>
            </div><br>
            <div class="row col-6">
                <div class="col">
                    <label for="data">Data</label>
                    <input type="date" class="form-control" name="data" id="data" required>
                </div>
                <div class="col">
                    <label for="chamado">Chamado</label>
                    <input type="number" class="form-control" name="chamado" id="chamado" required>
                </div>
            </div><br>
            <div class="col-6">
                <label for="tecnico">Técnico</label>
                <select name="tecnico" id="tecnico" class="form-control" required>
                    <option value="">Selecione</option>
                    <?php
                        $sql = "SELECT * FROM tecnico ORDER BY nome";
                        $resultado = mysqli_query($conexao, $sql);
                        while ($linha = mysqli_fetch_array($resultado)):
                            $id = $linha['id'];
                            $nome = $linha['nome'];

                            echo "<option value='{$id}'>{$nome}</option>";
                        endwhile;
                    ?>
                </select>
            </div><br>
            <div class="col-6">
                <label for="recebedor">Recebedor</label>
                <input type="text" class="form-control" name="recebedor" id="recebedor" required>
            </div><br>
            <button type="submit" class="btn btn-primary" name="cadastrar">Cadastrar</button>
        </form>
    </main>
</body>
</html>