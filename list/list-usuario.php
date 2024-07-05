<?php
    require_once('../verifica-autenticacao.php');
    require_once('../conexao.php');

    $V_WHERE = "";
    $S_WHERE = "";
    if (isset($_POST['pesquisar'])) {
        $search = $_POST['search'];
        $searchStatus = intval($_POST['search-status']);
        
        if (!empty($search)) {
            $V_WHERE = " AND usuario.nome LIKE '%$search%'";
        }
        if (!empty($searchStatus)) {
            $S_WHERE = " AND usuario.status = '$searchStatus'";
        }
    }

    $itens_por_pagina = 15;

    $pagina = isset($_GET['page']) ? $_GET['page'] : 1;

    $offset = ($pagina - 1) * $itens_por_pagina;

    $sql_count = "SELECT COUNT(*) AS total FROM usuario WHERE 1 = 1 " . $V_WHERE . $S_WHERE;
    $resultado_count = mysqli_query($conexao, $sql_count);
    $linha_count = mysqli_fetch_assoc($resultado_count);
    $total_registros = $linha_count['total'];

    $total_paginas = ceil($total_registros / $itens_por_pagina);

    $sql = "SELECT * FROM usuario
              WHERE 1 = 1 " . $V_WHERE . $S_WHERE . "
              LIMIT $itens_por_pagina OFFSET $offset";
    $resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1; /* Faz com que o conteúdo ocupe o espaço restante vertical */
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

    <main class="container mt-5">
        <h1>Listagem de Usuários</h1>
        <form class="d-flex col-6 mt-2 mb-2" method="post" role="search">
            <input class="form-control me-2" type="search" name="search" placeholder="Pesquisar" aria-label="Search">
            <select class="form-select me-2" name="search-status" id="search-status">
                <option selected value="">Status</option>
                <option value="1">Ativo</option>
                <option value="2">Inativo</option>
            </select>
            <button class="btn btn-outline-success" type="submit" name="pesquisar">Pesquisar</button>
        </form>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="col-6">Usuário</th>
                    <th class="col-4">Status</th>
                    <th class="d-flex justify-content-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($linha = mysqli_fetch_array($resultado)) {
                        if ($linha['status'] == 1) {
                            $status = "Ativo";
                        } else {
                            $status = "Inativo";
                        }
                ?>
                <tr>
                    <td><?= $linha['nome'] ?></td>
                    <td><?= $status ?></td>
                    <td class="d-flex justify-content-center gap-2">
                        <abbr title="Editar"><a class="btn btn-warning" href="../editar/edit-usuario.php?id=<?= $linha['id'] ?>"><i class="bi bi-pencil-fill"></i></a></abbr>
                        <abbr title="Desativar"><a class="btn btn-danger"><i class="bi bi-person-dash-fill"></i></a></abbr>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <!-- Paginação -->
        <nav aria-label="Paginação">
            <ul class="pagination justify-content-center">
                <?php if ($pagina > 1): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $pagina - 1 ?>">Anterior</a></li>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <li class="page-item <?= ($pagina == $i) ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                <?php endfor; ?>

                <?php if ($pagina < $total_paginas): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $pagina + 1 ?>">Próxima</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </main>
    <?php require_once("../template/rodape01.php") ?>  
</body>
</html>