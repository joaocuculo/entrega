<header>
    <nav class="navbar fixed-top navbar-expand-lg" style="background: linear-gradient(to right, #000307, #00070E);" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../home/relatorio.php">DTI</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../home/relatorio.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../home/perfil.php">Perfil</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Cadastros
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../cadastro/cad-entrega.php">Entrega</a></li>
                        <?php if ($_SESSION['nivel'] == 2): ?>
                            <li><a class="dropdown-item" href="../cadastro/cad-usuario.php">Usuário</a></li>
                            <li><a class="dropdown-item" href="../cadastro/cad-tecnico.php">Técnico</a></li>
                            <li><a class="dropdown-item" href="../cadastro/cad-adm.php">Administrador</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Listagem
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../listar/list-usuario.php">Usuário</a></li>
                        <li><a class="dropdown-item" href="../listar/list-tecnico.php">Técnico</a></li>
                        <?php if ($_SESSION['nivel'] == 2): ?>
                            <li><a class="dropdown-item" href="../listar/list-adm.php">Administrador</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>
            </div>
            <a class="navbar-brand" href="../sair.php">Sair</a>
        </div>
    </nav>
</nav>
</header>
