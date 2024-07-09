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
            $_SESSION['status'] = $usuario['status'];

            if ($_SESSION['status'] != 1) {
                $mensagem = "Usuário desativado";
                header("location: index.php?mensagem=$mensagem");
            } else {
                header("location: home/relatorio.php");
            }

        } else {
            $mensagem = "Usuário/Senha inválidos";
            header("location: index.php?mensagem=$mensagem");
        }
    }
?>