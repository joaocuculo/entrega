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
        $recebedor = ucfirst($_POST['recebedor']);
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        setTimeout(function() {
            document.getElementById('mensagem').style.display = 'none';
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
        <h1 class="text-center mb-4" > <i class="bi bi-boxes"></i> Cadastro de Entrega</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post">
                    <?php if (isset($mensagem)) { ?>
                        <div id="mensagem" class="alert alert-success mb-3" style="background-color:#051B11; color:white;">
                            <?= $mensagem ?>
                        </div>
                    <?php } ?>
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuário</label>
                        <input type="text" class="form-control" name="usuario" id="usuario" value="<?= $linha_usuario['nome'] ?>" disabled>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="data" class="form-label">Data</label>
                            <input type="date" class="form-control" name="data" id="data" required>
                        </div>
                        <div class="col">
                            <label for="chamado" class="form-label">Chamado</label>
                            <input type="number" class="form-control" name="chamado" id="chamado" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="tecnico" class="form-label">Técnico</label>
                        <select name="tecnico" id="tecnico" class="form-control" required>
                            <option value="">Selecione</option>
                            <?php
                                $sql = "SELECT * FROM tecnico ORDER BY nome";
                                $resultado = mysqli_query($conexao, $sql);
                                while ($linhaTec = mysqli_fetch_array($resultado)):
                                    $id = $linhaTec['id'];
                                    $nome = $linhaTec['nome'];

                                    echo "<option value='{$id}' style='color:black;'>{$nome}</option>";
                                endwhile;
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="recebedor" class="form-label">Recebedor</label>
                        <input type="text" class="form-control" name="recebedor" id="recebedor" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="cadastrar">Cadastrar</button>
                </form>
            </div>
        </div>
    </main>

    <?php require_once("../template/rodape01.php") ?>   

</body>
</html>