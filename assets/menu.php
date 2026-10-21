<?php
    // Inicia a sessão
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once __DIR__ . "/../conexao.php";

    // Recupera o ID 
    $id_usuario = $_SESSION['id'] ?? null;

    // Nome padrão caso não encontre o usuário
    $nome_usuario = 'Usuário';

    if ($id_usuario !== null) {

        // Busca os dados do usuário logado
        $sql = "
            SELECT nome
            FROM usuarios
            WHERE id_usuario = ?
        ";

        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_usuario);
        mysqli_stmt_execute($stmt);

        $resultado = mysqli_stmt_get_result($stmt);
        $usuario = mysqli_fetch_assoc($resultado);

        if ($usuario) {
            $nome_usuario = $usuario['nome'];
        }

        mysqli_stmt_close($stmt);
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        
        <title>G.A Pneus</title>
    </head>
    <body class="corpo-menu">
        <!--Sessão de navegação-->
        <nav class="menu-lateral">
            <form method="POST" action="../controller/princupal.php">

                <ul>

                    <li class="item-menu">
                        <a href="../paginas/ordem-servico.php" class="button-menu" >
                            <span class="icon"><i class="bi bi-list-check"></i></span>
                            <span class="txt-link">O.S</span>
                        </a>
                    </li>

                    <li class="item-menu">
                        <a href="../paginas/orcamento.php?novo=1" class="button-menu" >
                            <span class="icon"><i class="bi bi-search"></i></span>
                            <span class="txt-link">Orçamento</span>
                        </a>
                    </li>

                    <li class="item-menu">
                        <a href="../paginas/cliente.php?novo=1" class="button-menu" >
                            <span class="icon"><i class="bi bi-person"></i></span>
                            <span class="txt-link">Cliente</span>
                        </a>
                    </li>

                    <li class="item-menu">
                        <a href="../paginas/estoque.php" class="button-menu" >
                            <span class="icon"><i class="bi bi-cart-dash"></i></i></span>
                            <span class="txt-link">Compras</span>
                        </a>
                    </li>
                    
                    <li class="item-menu">
                        <a href="../paginas/usuarios.php" class="button-menu" >
                            <span class="icon"><i class="bi bi-file-earmark-person"></i></span>
                            <span class="txt-link">Funcinário</span>
                        </a>
                    </li>

                    <li class="item-menu">
                        <a href="../paginas/relatorio.php?novo=1" class="button-menu" >
                            <span class="icon"><i class="bi bi-file-earmark-bar-graph"></i></span>
                            <span class="txt-link">Relatório</span>   
                        </a>
                    </li>

                    <li class="item-menu">
                        <a href="../logout.php" class="button-menu" >
                            <span class="icon"><i class="bi bi-arrow-return-left"></i></span>
                            <span class="txt-link">Sair</span>
                        </a>
                    </li>

                    <li class="item-menu">
                        <div class="button-menu">
                            <i class="bi bi-person-circle" id="btn-expandir"></i>
                            <span class="txt-link">
                                <?= htmlspecialchars($nome_usuario, ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </div>
                    </li>

                </ul>
            </form>
        </nav>
    <body> 
</html>