<?php
    if (isset($_POST['entrar'])) { 
        
        $nome = $_POST['nome'];
        $senha = $_POST['senha'];

        require_once("conexao.php");

        // Protege contra SQL Injection
        $nome = mysqli_real_escape_string($conexao, $nome);

        // Busca o usuário no banco de dados
        $sql = "SELECT * FROM usuario WHERE nome = '{$nome}'";
        $resultado = mysqli_query($conexao, $sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $usuario = mysqli_fetch_array($resultado);

            // Verifica se a senha fornecida corresponde ao hash armazenado
            if (password_verify($senha, $usuario['senha'])) {
                session_start();
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['nome'] = $usuario['nome'];
                $_SESSION['status'] = $usuario['status'];
                $_SESSION['nivel'] = $usuario['nivel'];

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
        } else {
            $mensagem = "Usuário/Senha inválidos";
            header("location: index.php?mensagem=$mensagem");
        }
    }
?>
