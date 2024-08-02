<?php
    if ($_SESSION['nivel'] != 2) {
        $mensagem = "Você não tem permissão de administrador.";
        header("location: ../home/relatorio.php?mensagem={$mensagem}");
    }
?>