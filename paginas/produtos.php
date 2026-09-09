<?php 
    require_once "../assets/menu.php";
    require_once "../protec.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/menu.css">
    <link rel="stylesheet" href="../assets/css/produtos.css">

    <title>G.A Pneus</title>
</head>
<body>
    <section class="conteudo">

        <header class="cabecalho-produto">
            <h1>Gerenciamento de Produtos</h1>
        </header>

        <div class="container mt-4">
            <!--Mensagem de erro ou sucesso-->
            <?php if(isset($_SESSION['mensagem'])): ?>

                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $_SESSION['mensagem']; ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <?php unset($_SESSION['mensagem']); ?>

            <?php endif; ?>
            <!--Pesquisa do produto-->
            <div class="card">
                <div class="card-header">
                    <h4>Pesquisar Produto</h4>
                </div>
                <div class="card-body">
                    <form action="../controller/acao.php" method="post">
                        <div class="mb-3 d-flex">
                            <input type="text" name="produto" class="form-control" placeholder="Digite o código ou o nome do produto ...">
                            <button type="submit" name="select_produto" class="btn btn-primary float-right ml-2">Pesquisar</button>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <!--Resultado da pesquisa-->
            <div class="card">
                <div class="card-header">
                    <h4>Produtos Encontrados</h4>
                </div>
                <div class="card_body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Qntd</th>
                            <th>Valor</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php 
                                // Se a página foi aberta, limpa a pesquisa anterior
                                if(!isset($_POST['select_produto']) && !isset($_SESSION['pesquisa_realizada'])){
                                    unset($_SESSION['pesquisa_produto']);
                                    unset($_SESSION['pesquisa_produto']);
                                }
                            ?>
                            <?php if(isset($_SESSION['pesquisa_produto']) && count($_SESSION['pesquisa_produto']) > 0):?>
                                <?php foreach($_SESSION['pesquisa_produto'] as $cliente): ?>
                            <tr>
                                <td><?= $cliente['id']?></td>
                                <td><?= $cliente['nome']?></td>
                                <td><?= $cliente['tipo']?></td>
                                <td><?= $cliente['qntd']?></td>
                                <td><?= $cliente['valor']?></td>
                                <td>
                                    <a href="" class="btn btn-secondary btn-sm">Editar</a>
                                </td>
                            </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <!--solicitar para adicionar produto-->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">

                    <div>
                        <h4 class="mb-1">Produto não encontrado?</h4>
                        <p class="mb-0">Faz a solicitação para cadastrar produto.</p>
                    </div>

                    <form action="">
                        <button type="submit" class="btn btn-primary">
                            Solicitar
                        </button>
                    </form>

                </div>
            </div>
        </div>

    </section>
    <script src="../assets/js/script.js"></script>
</body>
</html>