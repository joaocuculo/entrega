<?php
    require_once('../verifica-autenticacao.php');

    require_once('../conexao.php');
    
    if (isset($_POST['salvar'])) {
        
        $id = $_POST['id'];
        $usuario = $linha_usuario['id'];
        $data = new DateTime($_POST['data']);
        $chamado = $_POST['chamado'];
        $tecnico = $_POST['tecnico'];
        $recebedor = $_POST['recebedor'];
        $dataString = $data->format('d/m/Y');
        
        $sql = "UPDATE usuario
                   SET id_usuario = '$usuario',
                             data = '$dataString',
                          chamado = '$chamado',
                       id_tecnico = '$tecnico',
                        recebedor = '$recebedor',
                           status = '$status'
                 WHERE id = $id";
        
        mysqli_query($conexao, $sql);
        
        $mensagem = "Alterado com sucesso!";
    }
    
    $sql = "SELECT * FROM tabela WHERE id = " . $_GET['id'];
    $resultado = mysqli_query($conexao, $sql);
    $linha = mysqli_fetch_array($resultado);
    
    $sql_usuario = "SELECT * FROM usuario WHERE id = " . $linha['id_usuario'];
    $resultado_usuario = mysqli_query($conexao, $sql_usuario);
    $linha_usuario = mysqli_fetch_array($resultado_usuario);
    
    $sql_tecnico = "SELECT * FROM tecnico WHERE id = " . $linha['id_tecnico'];
    $resultado_tecnico = mysqli_query($conexao, $sql_tecnico);
    $linha_tecnico = mysqli_fetch_array($resultado_tecnico);
    
    $dateObj = DateTime::createFromFormat('d/m/Y', $linha['data']);
    $dataFormatada = $dateObj->format('Y-m-d');

    ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Entrega</title>
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
        <h1 class="text-center mb-4">Editar Entrega</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post">
                    <?php if (isset($mensagem)) { ?>
                        <div id="mensagem" class="alert alert-success mb-3">
                            <?= $mensagem ?>
                        </div>
                    <?php } ?>
                    <input type="hidden" name="id" value="<?= $linha['id'] ?>">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuário</label>
                        <input type="text" class="form-control" name="usuario" id="usuario" value="<?= $linha_usuario['nome'] ?>" disabled>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="data" class="form-label">Data</label>
                            <input type="date" class="form-control" name="data" id="data" value="<?= $dataFormatada ?>" required>
                        </div>
                        <div class="col">
                            <label for="chamado" class="form-label">Chamado</label>
                            <input type="number" class="form-control" name="chamado" id="chamado" value="<?= $linha['chamado'] ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="tecnico" class="form-label">Técnico</label>
                        <select name="tecnico" id="tecnico" class="form-control" required>
                            <option value="<?= $linha['id_tecnico'] ?>"><?= $linha_tecnico['nome'] ?></option>
                            <?php
                                $sql = "SELECT * FROM tecnico ORDER BY nome";
                                $resultado = mysqli_query($conexao, $sql);
                                while ($linhaTec = mysqli_fetch_array($resultado)):
                                    $id = $linhaTec['id'];
                                    $nome = $linhaTec['nome'];

                                    echo "<option value='{$id}'>{$nome}</option>";
                                endwhile;
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="recebedor" class="form-label">Recebedor</label>
                        <input type="text" class="form-control" name="recebedor" id="recebedor" value="<?= $linha['recebedor'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success" name="salvar">Salvar</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
