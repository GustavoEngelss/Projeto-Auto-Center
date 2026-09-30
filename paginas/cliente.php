<?php 

    //se não tiver sessão aberta abre uma sessão
    if(session_status() === PHP_SESSION_NONE) session_start();

    //limpa a os dados quando iniciar uma nova sessão
    if(isset($_GET['novo'])){

        unset($_SESSION['pesquisa_cliente']);
        header('Location: cliente.php');
        exit;

    }

    require_once "../assets/menu.php";
    require_once "../conexao.php";
    require_once "../protec.php";

    //variaveis com nome menores para facilitar
    $pesquisa_cliente     = $_SESSION['pesquisa_cliente'] ?? [];
    $cliente_busca        = $pesquisa_cliente['cliente'] ?? [];


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
    <link rel="stylesheet" href="../assets/css/cliente.css">
    <link rel="stylesheet" href="../assets/css/menu.css">

    <title>G.A Pneus</title>
</head>
<body>
    <section class="conteudo">

        <header class="cabecalho-clientes">
            <h1>Selecionar Cliente</h1>
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

            <!--Pesquisa do cliente-->
            <div class="card">

                <div class="card-header">
                    <h4>Pesquisar Cliente</h4>
                </div>

                <div class="card-body">
                    <form action="../controller/acao.php" method="post">

                        <div class="mb-3 d-flex">

                            <input type="text" name="cliente" class="form-control" value="<?= $_SESSION['busca_cliente'] ?? '' ?>" placeholder="Digite o código, CPF, Nome, telefone ou CNPJ do cliente...">
                            
                            <button type="submit" name="busca_cliente" class="btn btn-primary float-right ml-2" >
                                Pesquisar
                            </button>

                        </div>

                    </form>
                </div>
            </div>
            <br>
            <!--Resultado da pesquisa-->
            <div class="card">
                <div class="card-header">
                    <h4>Clientes Encontrados</h4>
                </div>
                <div class="card_body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Telefone</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($cliente_busca) && count($cliente_busca) > 0):?>
                                <?php foreach($cliente_busca as $cliente): ?>
                                    <tr>
                                        <td><?= $cliente['id']?></td>
                                        <td><?= $cliente['nome']?></td>
                                        <td><?= $cliente['cpf']?></td>
                                        <td><?= $cliente['telefone']?></td>
                                        <td>
                                        <a href="../modelo/cliente-view.php?id=<?= $cliente['id'] ?>" class="btn btn-secondary btn-sm">Visualizar</a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <!--adicioar cliente-->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">

                    <div>
                        <h4 class="mb-1">Cliente não encontrado?</h4>
                        <p class="mb-0">Cadastre um novo Cliente para continuar.</p>
                    </div>

                    <form action="../modelo/new-cliente.php">
                        <button type="submit" class="btn btn-primary">
                            Cadastrar novo cliente
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </section>

    <script src="../assets/js/script.js"></script>
</body>
</html>