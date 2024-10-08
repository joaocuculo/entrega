<?php
    require_once('../verifica-autenticacao.php');
    require_once('../verifica-nivel.php');
    require_once('../conexao.php');

    $mensagem = "";

    if (isset($_POST['salvar'])) {
        
        $id = $_POST['id'];
        $nome = ucfirst(trim($_POST['edit-nome-usuario']));
        $status = $_POST['edit-status'];
        $nivel = $_POST['edit-nivel'];

        // Verifica se o nome existe no banco de dados
        $stmt = $conexao->prepare('SELECT COUNT(*) FROM usuario WHERE nome = ? AND id != ?');
        $stmt->bind_param('si', $nome, $id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
 
        if ($count > 0) {

            header("Location: {$_SERVER['PHP_SELF']}?id=$id&success=false");
            exit();

        } else {

            $sql = "UPDATE usuario
                        SET nome = '$nome',
                            status = '$status',
                            nivel = '$nivel'
                        WHERE id = $id";

            mysqli_query($conexao, $sql);

            header("Location: {$_SERVER['PHP_SELF']}?id=$id&success=true");
            exit();

        }
        
    }

    if (isset($_POST['redefinir'])) {
        
        $id = $_POST['id'];
        $senha = '1234';

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "UPDATE usuario
                    SET senha = '$senhaHash'
                    WHERE id = $id";

        mysqli_query($conexao, $sql);

        header("Location: {$_SERVER['PHP_SELF']}?id=$id&reset=true");
        exit();
    }

    if (isset($_GET['success']) || isset($_GET['reset'])) {

        if ($_GET['success'] == 'true') {
            $_SESSION['mensagem'] = "Alterado com sucesso!";
        } elseif ($_GET['success'] == 'false') {
            $_SESSION['mensagem'] = "Esse nome de usuário já existe!";
        } elseif ($_GET['reset'] == 'true') {
            $_SESSION['mensagem'] = "Senha redefinida com sucesso.";
        }
        
        header("Location: {$_SERVER['PHP_SELF']}?id={$_GET['id']}");
        exit();
    }

    if (isset($_SESSION['mensagem'])) {
        $mensagem = $_SESSION['mensagem'];
        unset($_SESSION['mensagem']); // Remove a mensagem após exibi-la
    }
    
    $sql = "SELECT * FROM usuario WHERE id = " . $_GET['id'];
    $resultado = mysqli_query($conexao, $sql);
    $linha = mysqli_fetch_array($resultado);
    if ($linha['status'] == 1 ) {
        $inputStatus = "Ativo";
    } else {
        $inputStatus = "Inativo";
    }

    if ($linha['nivel'] == 2 ) {
        $inputNivel = "Administrador";
    } else {
        $inputNivel = "Usuário comum";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="shortcut icon" href="../assets/img/favicon-32x32.png" type="image/x-icon">
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

        a {
            color: white;
        }

        a:hover {
            color: #c9c9c9;
        }
        
        option {
            color: black;
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
        <h1 class="text-center mb-4">Editar Usuário</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post">
                    <?php if (!empty($mensagem)) { ?>
                        <div id="mensagem" style="color: <?php echo (strpos($mensagem, 'sucesso') !== false) ? 'limegreen;' : 'red;'; ?> text-align:center;">
                            <?= $mensagem ?>
                        </div>
                    <?php } ?>  
                    <input type="hidden" name="id" value="<?= $linha['id'] ?>">
                    <div class="mb-3">
                        <label for="edit-nome-usuario" class="form-label">Nome</label>
                        <input type="text" class="form-control" name="edit-nome-usuario" id="edit-nome-usuario" value="<?= $linha['nome'] ?>" required>
                    </div>
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="edit-status" class="form-label">Status</label>
                            <select class="form-select me-2" name="edit-status" id="edit-status">
                                <option selected value="<?= $linha['status'] ?>"><?= $inputStatus ?></option>
                                <?php if ($linha['status'] == 1) {
                                    echo "<option value='2'>Inativo</option>";
                                } else {
                                    echo "<option value='1'>Ativo</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="edit-nivel" class="form-label">Nível</label>
                            <select class="form-select me-2" name="edit-nivel" id="edit-nivel">
                                <option selected value="<?= $linha['nivel'] ?>"><?= $inputNivel ?></option>
                                <?php if ($linha['nivel'] == 1) {
                                    echo "<option value='2'>Administrador</option>";
                                } else {
                                    echo "<option value='1'>Usuário comum</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <button type="submit" class="btn btn-success" name="salvar">Salvar</button>
                        <span style="cursor:pointer;" id="redefinir-senha">Redefinir senha</span>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="modal-redefinir-senha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header" style="background: linear-gradient(to right, #000307, #00070E); border-bottom: 1px solid #000B18;">
                                    <h5 class="modal-title">Redefinir Senha</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="background-color: #000B18;">
                                    <div class="mb-3">
                                        <p>Você tem certeza que deseja redefinir a senha do usuário para a senha padrão?</p>
                                    </div>
                                </div>
                                <div class="modal-footer" style="background: linear-gradient(to right, #000307, #00070E); border-top: 1px solid #000B18;">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary" name="redefinir" id="redefinir">Redefinir</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php require_once("../template/rodape01.php") ?> 

    <script>
        const redefinirSenha = document.getElementById('redefinir-senha');
        var modal = new bootstrap.Modal(document.getElementById('modal-redefinir-senha'));

        redefinirSenha.addEventListener('click', function() {
            modal.show();
        })
    </script>

</body>
</html>