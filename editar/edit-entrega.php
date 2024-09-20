<?php
    require_once('../verifica-autenticacao.php');

    require_once('../conexao.php');
    
    $mensagem = "";
        
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

    if (isset($_POST['salvar'])) {
        
        $id = $_POST['id'];
        $usuario = $linha_usuario['id'];
        $data = new DateTime($_POST['edit-data']);
        $chamado = $_POST['edit-chamado'];
        $tecnico = $_POST['edit-tecnico'];
        $recebedor = ucfirst($_POST['edit-recebedor']);
        $dataString = $data->format('d/m/Y');
        
        $sql = "UPDATE tabela
                   SET id_usuario = '$usuario',
                             data = '$dataString',
                          chamado = '$chamado',
                       id_tecnico = '$tecnico',
                        recebedor = '$recebedor'
                 WHERE id = $id";
        
        mysqli_query($conexao, $sql);
        
        $mensagem = "Alterado com sucesso!";

        header("Location: {$_SERVER['PHP_SELF']}?id=$id&success=true");
        exit();
    }

    // Verifica se houve sucesso na atualização para exibir a mensagem
    if (isset($_GET['success']) && $_GET['success'] == 'true') {
        $mensagem = "Alterado com sucesso!";
    }

    ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Entrega</title>
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

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Estilos para o Sticky Footer */
        #sticky-footer {
            flex-shrink: 0; /* Evita que o footer seja reduzido */
            padding: 1rem;
            background-color: #343a40;
            color: white;
            text-align: center;
        }
                
        option {
            color: black;
        }
    </style>
</head>
<body>
    <?php require_once("../template/menu01.php") ?>    

    <main class="container" style="margin-top: 100px;">
        <h1 class="text-center mb-4">Editar Entrega</h1>
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
                        <label for="edit-usuario" class="form-label">Usuário</label>
                        <input type="text" class="form-control" name="edit-usuario" id="edit-usuario" value="<?= $linha_usuario['nome'] ?>" disabled>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="edit-data" class="form-label">Data</label>
                            <input type="date" class="form-control" name="edit-data" id="edit-data" value="<?= $dataFormatada ?>" required>
                        </div>
                        <div class="col">
                            <label for="edit-chamado" class="form-label">Chamado</label>
                            <input type="number" class="form-control" name="edit-chamado" id="edit-chamado" value="<?= $linha['chamado'] ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit-tecnico" class="form-label">Técnico</label>
                        <select name="edit-tecnico" id="edit-tecnico" class="form-control" required>
                            <option value="<?= $linha['id_tecnico'] ?>"><?= $linha_tecnico['nome'] ?></option>
                            <?php
                                $sql = "SELECT * FROM tecnico ORDER BY nome";
                                $resultado = mysqli_query($conexao, $sql);
                                while ($linhaTec = mysqli_fetch_array($resultado)):

                                    if ($linhaTec['id'] != $linha['id_tecnico']) {
                                        $id = $linhaTec['id'];
                                        $nome = $linhaTec['nome'];
                                        
                                        echo "<option value='{$id}'>{$nome}</option>";
                                    }
                                    
                                endwhile;
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-recebedor" class="form-label">Recebedor</label>
                        <input type="text" class="form-control" name="edit-recebedor" id="edit-recebedor" value="<?= $linha['recebedor'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success" name="salvar">Salvar</button>
                </form>
            </div>
        </div>
    </main>

    <?php require_once("../template/rodape01.php") ?> 

</body>
</html>