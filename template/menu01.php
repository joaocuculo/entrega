<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggle de Mudança de Cor do Site</title>
    <style>
        /* Estilo padrão (tema escuro) */
        body {
            background: linear-gradient(to right, #000307, #000B18);
            color: #fff; /* Cor do texto para o tema escuro */
        }

        /* Tema claro */
        .theme-light {
            background: linear-gradient(to right, #ffffff, #ffffff);
            color: #333; /* Cor do texto para o tema claro */
        
        }
    </style>
</head>

    <header>
        <nav class="navbar fixed-top navbar-expand-lg" style="background: linear-gradient(to right, #000307, #00070E);" data-bs-theme="dark">
            <div class="container-fluid">
                <!-- Logo e Links -->
                <a class="navbar-brand" href="../home/relatorio.php">ＤＴＩ</a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="../home/relatorio.php"><i class="bi bi-house"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../home/perfil.php"><i class="bi bi-person-fill"></i> Perfil</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"  aria-expanded="false " >
                        <i class="bi bi-person-fill-add"></i> Cadastros
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../cadastro/cad-entrega.php">Entrega</a></li>
                            <!-- Mostrar apenas se o usuário tiver o nível adequado -->
                            <?php if ($_SESSION['nivel'] == 2): ?>
                                <li><a class="dropdown-item" href="../cadastro/cad-usuario.php">Usuário</a></li>
                                <li><a class="dropdown-item" href="../cadastro/cad-tecnico.php">Técnico</a></li>
                                <li><a class="dropdown-item" href="../cadastro/cad-adm.php">Administrador</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <!-- Mostrar apenas se o usuário tiver o nível adequado -->
                    <?php if ($_SESSION['nivel'] == 2): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-list-ul"></i>  Listagem
                        </a>
                        
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../listar/list-usuario.php">Usuário</a></li>
                            <li><a class="dropdown-item" href="../listar/list-tecnico.php">Técnico</a></li>
                            <li><a class="dropdown-item" href="../listar/list-adm.php">Administrador</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                </ul>
                 <div>
                     <a id="toggleButton"  style="cursor:pointer;margin-right: 1rem;">
                         <i class="bi bi-circle-half"></i> <!-- botao de alterar tema -->
                            </a>
                        
                        
                        <!-- botão Sair -->
                        <a class="navbar-brand ms-auto" href="../sair.php">Sair <i class="bi bi-box-arrow-in-left"></i></a>
                    </div>               
            </div>
        </nav>
    </header>

    

    <!-- js -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('toggleButton');
            const body = document.body;

            toggleButton.addEventListener('click', function() {
                body.classList.toggle('theme-light');
            });
        });
    </script>
</body>
</html>