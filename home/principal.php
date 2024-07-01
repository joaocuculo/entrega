<?php
    require_once('../verifica-autenticacao.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        p a {
            text-decoration: none;
            color: #000000;
        }

        p a:hover {
            text-decoration: underline;
            transition: 3s;
        }
    </style>
</head>
<body>
    <?php require_once("../template/menu01.php") ?>    

    <main class="container text-center mt-5">
        <div class="row">
            <div class="col">
                <h3>Cadastros</h3>
                <p><a href="../cadastro/cad-usuario.php">Cadastro de Usuário</a></p>
                <p><a href="../cadastro/cad-tecnico.php">Cadastro de Técnico</a></p>
                <p><a href="../cadastro/cad-entrega.php">Cadastro de Entrega</a></p>
            </div>
            
            <div class="col">
                <h3>Relatório</h3>
                <p><a href="relatorio.php">Relatório de Entregas</a></p>
            </div>
        </div>
    </main>
</body>
</html>