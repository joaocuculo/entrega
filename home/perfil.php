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
            // Evitar SQL injection usando prepared statements
            $stmt = $conexao->prepare("UPDATE usuario SET nome = ?, senha = ?, status = ? WHERE id = ?");
            $stmt->bind_param("ssii", $nome, $senha, $status, $id);
            $stmt->execute();

            $mensagem = "Alterado com sucesso!";

            header("Location: {$_SERVER['PHP_SELF']}?success=true");
            exit();
        } else {
            $mensagem = "As senhas inseridas são diferentes!";
        }    
    }

    // Verifica se houve sucesso na atualização para exibir a mensagem
    if (isset($_GET['success']) && $_GET['success'] == 'true') {
        $mensagem = "Alterado com sucesso!";
    }
    
    $sql = "SELECT * FROM usuario WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $linha = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
<body class="d-flex flex-column">
    <?php require_once("../template/menu01.php") ?>    

    <main class="container" style="margin-top: 100px;">
        <h1 class="text-center mb-4"><i class="bi bi-person-gear"></i> Editar Usuário</h1>
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
                            <button class="btn btn-outline-secondary" type="button" id="mostrar-senha"><i class="bi bi-eye-slash"></i></button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit-senha-conf" class="form-label">Confirme a senha</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="edit-senha-conf" id="edit-senha-conf" value="<?= $linha['senha'] ?>" required>
                            <button class="btn btn-outline-secondary" type="button" id="mostrar-senha-conf"><i class="bi bi-eye-slash"></i></button>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success" name="salvar">Salvar</button>
                </form>
            </div>
        </div>
    </main>

    <?php require_once("../template/rodape01.php") ?>   

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mostrarSenhaBtn = document.getElementById('mostrar-senha');
            const senhaInput = document.getElementById('edit-senha');

            mostrarSenhaBtn.addEventListener('click', function() {
                if (senhaInput.type === 'password') {
                    senhaInput.type = 'text';
                    mostrarSenhaBtn.innerHTML = '<i class="bi bi-eye"></i>';
                } else {
                    senhaInput.type = 'password';
                    mostrarSenhaBtn.innerHTML = '<i class="bi bi-eye-slash"></i>';
                }
            });

            const mostrarSenhaConfBtn = document.getElementById('mostrar-senha-conf');
            const senhaConfInput = document.getElementById('edit-senha-conf');

            mostrarSenhaConfBtn.addEventListener('click', function() {
                if (senhaConfInput.type === 'password') {
                    senhaConfInput.type = 'text';
                    mostrarSenhaConfBtn.innerHTML = '<i class="bi bi-eye"></i>';
                } else {
                    senhaConfInput.type = 'password';
                    mostrarSenhaConfBtn.innerHTML = '<i class="bi bi-eye-slash"></i>';
                }
            });
        });
    </script>
</body>
</html>
