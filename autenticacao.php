<?php
    if (isset($_POST['entrar'])) {
        
        $nome = $_POST['nome'];
        $senha = $_POST['senha'];

        $sql = "SELECT * FROM usuario 
                        WHERE nome = '{$nome}' 
                          AND senha = '{$senha}'";

        require_once("conexao.php");
        $resultado = mysqli_query($conexao, $sql);
        $registros = mysqli_num_rows($resultado);

        if ($registros > 0) {
            $usuario = mysqli_fetch_array($resultado);

            session_start();
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            header("location: home/principal.php");
        } else {
            $mensagem = "Usuário/Senha inválidos";
            header("location: index.php?mensagem=$mensagem");
        }
    }
?>