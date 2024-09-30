<?php
    require_once('../verifica-autenticacao.php');
    require_once('../verifica-nivel.php');
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

    // Processamento dos botões Ativar e Desativar
    if (isset($_POST['desativar'])) {
        $idDesativar = $_POST['input-desativar'];

        $sql_desativar = "UPDATE usuario SET status = 2 WHERE id = $idDesativar";
        mysqli_query($conexao, $sql_desativar);
    }

    if (isset($_POST['ativar'])) {
        $idAtivar = $_POST['input-ativar'];

        $sql_ativar = "UPDATE usuario SET status = 1 WHERE id = $idAtivar";
        mysqli_query($conexao, $sql_ativar);
    }

    $itens_por_pagina = 15;

    $pagina = isset($_GET['page']) ? $_GET['page'] : 1;

    $offset = ($pagina - 1) * $itens_por_pagina;

    $sql_count = "SELECT COUNT(*) AS total FROM usuario WHERE 1 = 1 " . $V_WHERE . $S_WHERE . " AND nivel = 2";
    $resultado_count = mysqli_query($conexao, $sql_count);
    $linha_count = mysqli_fetch_assoc($resultado_count);
    $total_registros = $linha_count['total'];

    $total_paginas = ceil($total_registros / $itens_por_pagina);

    $sort_col = isset($_GET['sort_col']) ? $_GET['sort_col'] : 2;
    $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

    switch ($sort_col) {
        case 0:
            $sort_col = 'usuario.nome';
            break;
        case 1:
            $sort_col = 'usuario.status';
            break;
        default:
            $sort_col = 'usuario.status';
    }

    $sql = "SELECT * FROM usuario
              WHERE 1 = 1 AND usuario.nivel = 2 " . $V_WHERE . $S_WHERE . "
              ORDER BY $sort_col $sort_order
              LIMIT $itens_por_pagina OFFSET $offset";
    $resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Administradores</title>
    <link rel="shortcut icon" href="../assets/img/favicon-32x32.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function sortTable(columnIndex) {
            let currentSortCol = <?= isset($_GET['sort_col']) ? $_GET['sort_col'] : '2' ?>;
            let currentSortOrder = '<?= isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC' ?>';

            let sortOrder = 'DESC';
            if (currentSortCol == columnIndex) {
                sortOrder = currentSortOrder === 'DESC' ? 'ASC' : 'DESC';
            }

            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('sort_col', columnIndex);
            urlParams.set('sort_order', sortOrder);
            window.location.search = urlParams.toString();
        }

        document.addEventListener("DOMContentLoaded", function() {
            const currentSortCol = '<?= isset($_GET['sort_col']) ? $_GET['sort_col'] : '2' ?>';
            const currentSortOrder = '<?= isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC' ?>';

            const headers = document.querySelectorAll(".sortable");
            headers.forEach((header, index) => {
                if (index == currentSortCol) {
                    header.classList.add(currentSortOrder.toLowerCase());
                    const icon = header.querySelector('.sort-icon');
                    if (currentSortOrder === 'DESC') {
                        icon.classList.remove('bi-arrow-down');
                        icon.classList.add('bi-arrow-up');
                    } else {
                        icon.classList.remove('bi-arrow-up');
                        icon.classList.add('bi-arrow-down');
                    }
                }
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

        option {
            color: black;
        }

        .sort-icon {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            margin-left: 5px;
            opacity: 0.5;
            transition: opacity 0.3s ease;
        }
        .sortable {
            position: relative;
            cursor: pointer;
        }
        .sortable:hover .sort-icon {
            opacity: 1;
        }

        /* Estilo para botões de paginação */
        .pagination .page-link {
            color: #f8f9fa; /* Cor do texto dos botões */
            background-color: #343a40; /* Cor de fundo dos botões */
            border-color: #343a40; /* Cor da borda dos botões */
        }

        .pagination .page-link:hover {
            color: #f8f9fa; /* Cor do texto dos botões ao passar o mouse */
            background-color: #495057; /* Cor de fundo dos botões ao passar o mouse */
            border-color: #495057; /* Cor da borda dos botões ao passar o mouse */
        }

        .pagination .page-item.active .page-link {
            background-color: #495057; /* Cor de fundo do botão da página ativa */
            border-color: #495057; /* Cor da borda do botão da página ativa */
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d; /* Cor do texto dos botões desabilitados */
            pointer-events: none; /* Desabilita a ação de clique nos botões desabilitados */
            background-color: #343a40; /* Cor de fundo dos botões desabilitados */
            border-color: #343a40; /* Cor da borda dos botões desabilitados */
        }
    </style>
</head>
<body>
    <?php require_once("../template/menu01.php") ?>    

    <main class="container" style="margin-top: 100px;">
        <h1>Listagem de Administradores</h1>
        <div class="d-flex justify-content-between align-items-end mb-2">
            <form class="d-flex col-6 mt-2 mb-2" method="post" role="search">
                <input class="form-control me-2" type="search" name="search" placeholder="Pesquisar" aria-label="Search">
                <select class="form-select me-2" name="search-status" id="search-status">
                    <option selected value="">Status</option>
                    <option value="1">Ativo</option>
                    <option value="2">Inativo</option>
                </select>
                <button class="btn btn-light" type="submit" name="pesquisar"><i class="bi bi-search" style="color: black; "></i></button>
            </form>
            <a href="../cadastro/cad-adm.php" class="btn btn-success"><i class="bi bi-plus-lg"></i> Cadastrar Administrador</a>
        </div>
        <table class="table table-dark table-striped table-bordered">
            <thead>
                <tr>
                    <th id="header0" onclick="sortTable(0)" class="sortable asc col-6">Administradores <i class="bi bi-arrow-down sort-icon"></th>
                    <th id="header0" onclick="sortTable(1)" class="sortable col-4">Status <i class="bi bi-arrow-down sort-icon"></th>
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
                        <abbr title="Editar"><a class="btn btn-primary" href="../editar/edit-usuario.php?id=<?= $linha['id'] ?>"><i class="bi bi-pencil-fill"></i></a></abbr>
                        <form method="post">
                            <?php if ($status == "Ativo"): ?>
                                <abbr title="Desativar">
                                    <button type="submit" name="desativar" class="btn btn-danger">
                                        <i class="bi bi-dash-circle"></i>
                                    </button>
                                </abbr>
                            <?php else: ?>
                                <abbr title="Ativar">
                                    <button type="submit" name="ativar" class="btn btn-success">
                                        <i class="bi bi-plus-circle"></i>
                                    </button>
                                </abbr>
                            <?php endif; ?>
                            <input type="hidden" name="input-desativar" value="<?= $linha['id'] ?>">
                            <input type="hidden" name="input-ativar" value="<?= $linha['id'] ?>">
                        </form>
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