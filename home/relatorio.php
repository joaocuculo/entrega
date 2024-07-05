<?php
    require_once('../verifica-autenticacao.php');
    require_once('../conexao.php');

    $V_WHERE = "";
    $T_WHERE = "";
    if (isset($_POST['pesquisar'])) {
        $search = $_POST['search'];
        $tecnico = $_POST['search-tec'];
        
        if (!empty($search)) {
            $V_WHERE = " AND (tabela.chamado LIKE '%$search%' OR tabela.data LIKE '%$search%')";
        }
        if (!empty($tecnico)) {
            $T_WHERE = " AND tabela.id_tecnico = '$tecnico'";
        }

    }

    $itens_por_pagina = 15;

    $pagina = isset($_GET['page']) ? $_GET['page'] : 1;

    $offset = ($pagina - 1) * $itens_por_pagina;

    $sql_count = "SELECT COUNT(*) AS total FROM tabela WHERE 1 = 1 " . $V_WHERE . $T_WHERE;
    $resultado_count = mysqli_query($conexao, $sql_count);
    $linha_count = mysqli_fetch_assoc($resultado_count);
    $total_registros = $linha_count['total'];

    $total_paginas = ceil($total_registros / $itens_por_pagina);

    $sql = "SELECT tabela.*, usuario.nome AS nome_usuario, tecnico.nome AS nome_tecnico
              FROM tabela
              INNER JOIN usuario ON tabela.id_usuario = usuario.id
              INNER JOIN tecnico ON tabela.id_tecnico = tecnico.id
              WHERE 1 = 1 " . $V_WHERE . $T_WHERE . "
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
        <h1>Relatório de Entrega</h1>
        <form class="d-flex col-6 mt-2 mb-2" method="post" role="search">
            <input class="form-control me-2" type="search" name="search" placeholder="Pesquisar" aria-label="Search">
            <select class="form-select me-2" name="search-tec" id="search-tec">
                <option selected value="">Selecionar técnico</option>
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
            <button class="btn btn-outline-success" type="submit" name="pesquisar">Pesquisar</button>
        </form>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Data da Entrega</th>
                    <th>Chamado</th>
                    <th>Técnico</th>
                    <th>Recebedor</th>
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