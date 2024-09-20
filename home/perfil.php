<?php
    require_once('../verifica-autenticacao.php');
    require_once('../conexao.php');

    $mensagem = "";

    if (isset($_POST['confirmar'])) {

        $id = $_POST['id'];
        $senhaAtual = $_POST['senha-atual'];

        require_once("../conexao.php");

        $sqlEdit = "SELECT * FROM usuario WHERE id = '{$id}'";
        $resposta = mysqli_query($conexao, $sqlEdit);
        
        if ($resposta && mysqli_num_rows($resposta) > 0) {
            
            $id = $_POST['id'];
            $nome = $_POST['edit-nome-usuario'];
            $senha = $_POST['edit-senha'];
            $senhaConf = $_POST['edit-senha-conf'];
            $status = 1;
            
            if ($senhaConf == $senha) {
                
                if ($senha === '' && $senhaConf === '') {

                    $stmt = $conexao->prepare("UPDATE usuario SET nome = ?, status = ? WHERE id = ?");
                    $stmt->bind_param("sii", $nome, $status, $id);
                    $stmt->execute();
                    
                } else {
                    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
                    
                    // Evitar SQL injection usando prepared statements
                    $stmt = $conexao->prepare("UPDATE usuario SET nome = ?, senha = ?, status = ? WHERE id = ?");
                    $stmt->bind_param("ssii", $nome, $senhaHash, $status, $id);
                    $stmt->execute();
                }
                    
                    $mensagem = "Alterado com sucesso!";
                    
                    header("Location: {$_SERVER['PHP_SELF']}?success=true");
                    exit();
            } else {
                $mensagem = "As senhas inseridas são diferentes!";
            }    
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var saveButton = document.getElementById('save-button');
            var form = document.getElementById('edit-form');
            
            saveButton.addEventListener('click', function(event) {
                
                event.preventDefault();
                
                var senha = document.getElementById('edit-senha').value.trim();
                var senhaConf = document.getElementById('edit-senha-conf').value.trim();
                
                if ((senha !== '' && senhaConf == '') || (senhaConf !== '' && senha == '')) {
                    alert('Por favor, preencha todos os campos de senha.');
                    return;
                }
                
                if (senha !== senhaConf) {
                    alert('As senhas não coincidem.');
                    return;
                }
                
                var modal = new bootstrap.Modal(document.getElementById('modal-nova-senha'));
                modal.show();
            });
        });
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
<body class="d-flex flex-column">
    <?php require_once("../template/menu01.php") ?>    

    <main class="container" style="margin-top: 100px;">
        <h1 class="text-center mb-4"><i class="bi bi-person-gear"></i> Perfil do Usuário</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form id="edit-form" method="post">
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
                        <label for="edit-senha" class="form-label">Nova senha</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="edit-senha" id="edit-senha">
                            <button class="btn btn-outline-secondary" type="button" id="mostrar-senha"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit-senha-conf" class="form-label">Confirme a nova senha</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="edit-senha-conf" id="edit-senha-conf">
                            <button class="btn btn-outline-secondary" type="button" id="mostrar-senha-conf"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-success" id="save-button">Salvar</button>


                    <!-- Modal -->
                    <div class="modal fade" id="modal-nova-senha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header" style="background: linear-gradient(to right, #000307, #00070E); border-bottom: 1px solid #000B18;">
                                    <h5 class="modal-title">Nova Senha</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="background-color: #000B18;">
                                    <div class="mb-3">
                                        <label for="senha-atual" class="form-label">Insira sua senha atual para validar a edição do perfil</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="senha-atual" id="senha-atual" required>
                                        </div>
                                        <p style="font-size: 13px; text-decoration: underline; cursor: pointer; display: inline-block;" id="esqueceu-senha">Esqueceu sua senha?</p>
                                    </div>
                                </div>
                                <div class="modal-footer" style="background: linear-gradient(to right, #000307, #00070E); border-top: 1px solid #000B18;">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary" name="confirmar" id="confirmar">Confirmar</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const mostrarSenhaBtn = document.getElementById('mostrar-senha');
            const senhaInput = document.getElementById('edit-senha');

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
            const senhaConfInput = document.getElementById('edit-senha-conf');

            mostrarSenhaConfBtn.addEventListener('click', function() {
                if (senhaConfInput.type === 'password') {
                    senhaConfInput.type = 'text';
                    mostrarSenhaConfBtn.innerHTML = '<i class="bi bi-eye-slash"></i>';
                } else {
                    senhaConfInput.type = 'password';
                    mostrarSenhaConfBtn.innerHTML = '<i class="bi bi-eye"></i>';
                }
            });

            const esqueceuSenha = document.getElementById('esqueceu-senha');

            esqueceuSenha.addEventListener('click', function() {
                alert('Contate o Administrador para redefinir sua senha.');
                return
            })
        });
    </script>
</body>
</html>
