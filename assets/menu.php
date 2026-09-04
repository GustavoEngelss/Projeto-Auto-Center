<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        
        <link rel="stylesheet" href="./css/menu.css">
        <link rel="stylesheet" href="./css/global.css">

        <title>G.A Pneus</title>
    </head>
    <body class="corpo-menu">
        <!--Sessão de navegação-->
        <nav class="menu-lateral">
            <form method="POST" action="../controller/princupal.php">
                <div class="bnt-expandir">
                    <i class="bi bi-arrows" id="btn-expandir"></i>
                </div>
                <ul>
                    <li class="item-menu">
                        <a href="../paginas/ordem-servico.php" class="button-menu" type="submit">
                            <span class="icon"><i class="bi bi-list-check"></i></span>
                            <span class="txt-link">O.S</span>
                        </a>
                    </li>
                    <li class="item-menu">
                        <a href="../paginas/cliente.php" class="button-menu" type="submit">
                            <span class="icon"><i class="bi bi-person"></i></span>
                            <span class="txt-link">Cliente</span>
                        </a>
                    </li>
                     <li class="item-menu">
                        <a href="../paginas/orcamento.php" class="button-menu" type="submit">
                            <span class="icon"><i class="bi bi-search"></i></span>
                            <span class="txt-link">Orçamento</span>
                        </a>
                    </li>
                    <li class="item-menu">
                        <a href="../paginas/produtos.php" class="button-menu" type="submit">
                            <span class="icon"><i class="bi bi-box-seam"></i></span>
                            <span class="txt-link">Produtos</span>
                        </a>
                    </li>
                    <li class="item-menu">
                        <a href="../paginas/usuarios.php" class="button-menu" type="submit">
                            <span class="icon"><i class="bi bi-file-earmark-person"></i></span>
                            <span class="txt-link">Funcinário</span>
                        </a>
                    </li>
                    <li class="item-menu">
                        <a href="../paginas/relatorio.php" class="button-menu" type="submit">
                            <span class="icon"><i class="bi bi-file-earmark-bar-graph"></i></span>
                            <span class="txt-link">Relatório</span>   
                        </a>
                    </li>
                    <li class="item-menu">
                        <a href="../logout.php" class="button-menu" type="submit">
                            <span class="icon"><i class="bi bi-arrow-return-left"></i></span>
                            <span class="txt-link">Sair</span>
                        </a>
                    </li>
                </ul>
            </form>
        </nav>
        <script src="js/script.js"></script>
    <body> 
</html>