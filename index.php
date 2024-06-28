<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Entregas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">Sistema de Entregas</span>
            </div>
        </nav>
    </header>
    <main class="container text-center mt-5">
        <h2 class="mb-3">Login</h2>
        <form action="autenticacao.php" method="post" style="max-width: 300px; margin: auto;">
            <?php if (isset($_GET['mensagem'])) { ?>
                <div>
                    <?= $_GET['mensagem'] ?>
                </div>
            <?php } ?>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="nome" id="nome" required>
                <label for="nome">Nome</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="senha" id="senha" required>
                <label for="senha">Senha</label>
            </div>
            <button class="btn btn-primary" type="submit" name="entrar">Entrar</button>
        </form>
    </main>
</body>
</html>