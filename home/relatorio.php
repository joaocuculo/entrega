<?php
    require_once('../verifica-autenticacao.php');
    require_once('../conexao.php');

  
    $V_WHERE = "";
    $T_WHERE = "";
    if (isset($_POST['pesquisar'])) {
        $search = $_POST['search'];
        $tecnico = $_POST['search-tec'];

        if (!empty($search)) {
            $V_WHERE = " AND (tabela.chamado LIKE '%$search%' OR tabela.data LIKE '%$search%' OR usuario.nome LIKE '%$search%' OR tabela.recebedor LIKE '%$search%')";
        }
        if (!empty($tecnico)) {
            $T_WHERE = " AND tabela.id_tecnico = '$tecnico'";
        }
    }

    if (isset($_GET['id'])) {
        $sql = "DELETE FROM tabela WHERE id = " . $_GET['id'];
        mysqli_query($conexao, $sql);
        $mensagem = "Exclusão realizada com sucesso!";
    }

    $itens_por_pagina = 15;
    $pagina = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($pagina - 1) * $itens_por_pagina;

    $sql_count = "SELECT COUNT(*) AS total, usuario.nome AS nome_usuario 
                    FROM tabela 
                    INNER JOIN usuario ON tabela.id_usuario = usuario.id 
                    WHERE 1 = 1 " . $V_WHERE . $T_WHERE;
    $resultado_count = mysqli_query($conexao, $sql_count);
    $linha_count = mysqli_fetch_assoc($resultado_count);
    $total_registros = $linha_count['total'];
    $total_paginas = ceil($total_registros / $itens_por_pagina);

    $sort_col = isset($_GET['sort_col']) ? $_GET['sort_col'] : 1;
    $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'DESC';

    switch ($sort_col) {
        case 0:
            $sort_col = 'usuario.nome';
            break;
        case 1:
            $sort_col = 'STR_TO_DATE(tabela.data, "%d/%m/%Y")';
            break;
        case 2:
            $sort_col = 'tabela.chamado';
            break;
        case 3:
            $sort_col = 'tecnico.nome';
            break;
        case 4:
            $sort_col = 'tabela.recebedor';
            break;
        default:
            $sort_col = 'STR_TO_DATE(tabela.data, "%d/%m/%Y")';
    }

    $sql = "SELECT tabela.*, usuario.nome AS nome_usuario, tecnico.nome AS nome_tecnico
            FROM tabela
            INNER JOIN usuario ON tabela.id_usuario = usuario.id
            INNER JOIN tecnico ON tabela.id_tecnico = tecnico.id
            WHERE 1 = 1 " . $V_WHERE . $T_WHERE . "
            ORDER BY $sort_col $sort_order
            LIMIT $itens_por_pagina OFFSET $offset";

    $resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Entrega</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        setTimeout(function() {
            document.getElementById('mensagem').style.display = 'none';
        }, 3000);

        function sortTable(columnIndex) {
            let currentSortCol = <?= isset($_GET['sort_col']) ? $_GET['sort_col'] : '1' ?>;
            let currentSortOrder = '<?= isset($_GET['sort_order']) ? $_GET['sort_order'] : 'DESC' ?>';

            let sortOrder = 'ASC';
            if (currentSortCol == columnIndex) {
                sortOrder = currentSortOrder === 'ASC' ? 'DESC' : 'ASC';
            }

            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('sort_col', columnIndex);
            urlParams.set('sort_order', sortOrder);
            window.location.search = urlParams.toString();
        }

        document.addEventListener("DOMContentLoaded", function() {
            const currentSortCol = '<?= isset($_GET['sort_col']) ? $_GET['sort_col'] : '1' ?>';
            const currentSortOrder = '<?= isset($_GET['sort_order']) ? $_GET['sort_order'] : 'DESC' ?>';

            const headers = document.querySelectorAll(".sortable");
            headers.forEach((header, index) => {
                if (index == currentSortCol) {
                    header.classList.add(currentSortOrder.toLowerCase());
                    const icon = header.querySelector('.sort-icon');
                    if (currentSortOrder === 'ASC') {
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

        a {
            color: white;
        }

        a:hover {
            color: #c9c9c9;
        }
        
        option {
            color: black;
        }

        th, td {
            text-align: left;
            position: relative;
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
        
        /* Estilos para o Sticky Footer */
        #sticky-footer {
            flex-shrink: 0; /* Evita que o footer seja reduzido */
            padding: 1rem;
            background-color: #343a40;
            color: white;
            text-align: center;
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
            color: #6c757d; /* Cor do texto dos botões desligados */
            pointer-events: none; /* Desabilita a ação de clique nos botões desligados */
            background-color: #343a40; /* Cor de fundo dos botões desligados */
            border-color: #343a40; /* cor da borda dos boteos desligados */
        }
    </style>
</head>
<body>
    <?php require_once("../template/menu01.php") ?>    

    <main class="container" style="margin-top: 100px;">
        <?php if (!empty($mensagem)) { ?>
            <div id="mensagem" class="alert alert-<?php echo (strpos($mensagem, 'sucesso') !== false) ? 'success' : 'danger'; ?> mb-3" style="background-color:#051B11; color:white;">
                <?= $mensagem ?>
            </div>
        <?php } ?>   
        <?php if (isset($_GET['mensagem'])) { ?>
            <div id="mensagem" class="alert alert-danger mb-3" style="background-color:red; color:white; border:1px solid #8f0909;">
                <?= $_GET['mensagem'] ?>
            </div>
        <?php } ?>   
        <h1>Relatório de Entrega</h1>
        <div class="d-flex justify-content-between align-items-end mb-2">
            <form class="d-flex col-6 mt-2 mb-2" method="post" role="search">
                <input class="form-control me-2" type="search" name="search" placeholder="Pesquisar" aria-label="Search">
                <select class="form-select me-2" name="search-tec" id="search-tec">
                    <option selected value="" style="color: black;">Selecionar técnico</option>
                    <?php
                        $sql = "SELECT * FROM tecnico ORDER BY nome";
                        $resultadoTec = mysqli_query($conexao, $sql);
                        while ($linha = mysqli_fetch_array($resultadoTec)):
                            $id = $linha['id'];
                            $nome = $linha['nome'];
                            echo "<option value='{$id}'>{$nome}</option>";
                        endwhile;
                    ?>
                </select>
                <button class="btn btn-light" type="submit" name="pesquisar"><i class="bi bi-search" style="color: black; "></i></button>
            </form>
            <a href="../cadastro/cad-entrega.php" class="btn btn-success"><i class="bi bi-plus-lg"></i> Cadastrar Entrega</a>
        </div>
        <table id="tabela" class="table table-dark table-striped table-bordered">
            <thead> 
                <tr>
                    <th id="header0" onclick="sortTable(0)" class="sortable asc">Usuário <i class="bi bi-arrow-down sort-icon"></th>
                    <th id="header1" onclick="sortTable(1)" class="sortable">Data da Entrega <i class="bi bi-arrow-down sort-icon"></th>
                    <th id="header2" onclick="sortTable(2)" class="sortable">Chamado <i class="bi bi-arrow-down sort-icon"></th>
                    <th id="header3" onclick="sortTable(3)" class="sortable">Técnico <i class="bi bi-arrow-down sort-icon"></th>
                    <th id="header4" onclick="sortTable(4)" class="sortable">Recebedor <i class="bi bi-arrow-down sort-icon"></th>
                    <th class="d-flex justify-content-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($linha = mysqli_fetch_array($resultado)) {
                ?>
                <tr>
                    <td><?= $linha['nome_usuario'] ?></td>
                    <td><?= $linha['data'] ?></td>
                    <td><a href="http://sup.umuarama.pr.gov.br/scp/tickets.php?id=<?= $linha['chamado'] ?>" target="_blank"><?= $linha['chamado'] ?></a></td>
                    <td><?= $linha['nome_tecnico'] ?></td>
                    <td><?= $linha['recebedor'] ?></td>
                    <td class="d-flex justify-content-center gap-2">
                        <abbr title="Editar"><a class="btn btn-primary" href="../editar/edit-entrega.php?id=<?= $linha['id'] ?>"><i class="bi bi-pencil-fill"></i></a></abbr>
                        <?php if ($_SESSION['nivel'] == 2): ?>
                            <abbr title="Deletar"><a class="btn btn-danger"  onclick="return confirm('Confirmar exclusão?')" href="relatorio.php?id=<?= $linha['id'] ?>"><i class="bi bi-trash-fill"></i></a></abbr>
                        <?php endif; ?>    
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <!-- Paginação -->
        <nav aria-label="Paginação">
            <ul class="pagination justify-content-center">
                <?php if ($pagina > 1): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $pagina - 1 ?>&sort_col=<?= isset($_GET['sort_col']) ? $_GET['sort_col'] : '1' ?>&sort_order=<?= isset($_GET['sort_order']) ? $_GET['sort_order'] : 'DESC' ?>">Anterior</a></li>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <li class="page-item <?= ($pagina == $i) ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>&sort_col=<?= isset($_GET['sort_col']) ? $_GET['sort_col'] : '1' ?>&sort_order=<?= isset($_GET['sort_order']) ? $_GET['sort_order'] : 'DESC' ?>"><?= $i ?></a></li>
                <?php endfor; ?>

                <?php if ($pagina < $total_paginas): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $pagina + 1 ?>&sort_col=<?= isset($_GET['sort_col']) ? $_GET['sort_col'] : '1' ?>&sort_order=<?= isset($_GET['sort_order']) ? $_GET['sort_order'] : 'DESC' ?>">Próxima</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </main>

    <?php require_once("../template/rodape01.php") ?>  
    
</body>
</html>