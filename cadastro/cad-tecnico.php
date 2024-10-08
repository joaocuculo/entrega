<?php
    require_once('../verifica-autenticacao.php');
    require_once('../verifica-nivel.php');
    require_once('../conexao.php');

    $isInvalid = false;

    if (isset($_POST['cadastrar'])) {
        
        $nome = ucfirst($_POST['cad-nome-tecnico']);
        $status = 1;

        // Verifica se o nome existe no banco de dados
        $stmt = $conexao->prepare('SELECT COUNT(*) FROM tecnico WHERE nome = ?');
        $stmt->bind_param('s', $nome);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {

            $isInvalid = true;
            
        } else {

            $sql = "INSERT INTO tecnico (nome, status) VALUES ('$nome', '$status')";
            
            mysqli_query($conexao, $sql);

            $mensagem = "Cadastrado com sucesso!";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Técnico</title>
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
        <h1 class="text-center mb-4"> <i class="bi bi-person-gear"></i> Cadastrar Técnico</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post">
                    <?php if (isset($mensagem)) { ?>
                        <div id="mensagem" style="color:limegreen; text-align:center;">
                            <?= $mensagem ?>
                        </div>
                    <?php } ?>
                    <div class="mb-3">
                        <label for="cad-nome-tecnico" class="form-label">Nome do Técnico</label>
                        <input type="text" class="form-control <?= $isInvalid ? 'is-invalid' : '' ?>" name="cad-nome-tecnico" id="cad-nome-tecnico" required >
                        <?php if ($isInvalid) { ?>
                            <div class="invalid-feedback">
                                Este nome de técnico já existe.
                            </div>
                        <?php } ?>
                    </div>
                    <button type="submit" class="btn btn-primary" name="cadastrar">Cadastrar</button>
                </form>
            </div>
        </div>
    </main>

    <?php require_once("../template/rodape01.php") ?>   

</body>
</html>