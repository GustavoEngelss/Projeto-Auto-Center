<?php 
    require_once "../assets/menu.php";
    require_once "../conexao.php";
    require_once "../protec.php";
?>
<!--Zera a pesquisa-->
<?php
    if (!isset($_SESSION['pesquisa_realizada'])) {

        unset($_SESSION['produtos']);
        unset($_SESSION['busca_largura']);
        unset($_SESSION['busca_perfil']);
        unset($_SESSION['busca_aro']);
        unset($_SESSION['busca_categoria']);
        unset($_SESSION['busca_codigo']);
        unset($_SESSION['busca_pagamento']);
        unset($_SESSION['busca_parcelas']);

    }
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
    <link rel="stylesheet" href="../assets/css/orcamento.css">


    <title>G.A Pneus</title>
</head>
<body>
    <section class="conteudo">

        <header class="cabecalho-orcamento">

            <h1>Orçamento</h1>
            <p>Busque o produto para montar o orçamento</p>

        </header>

        <form action="../controller/acao.php" method="post">

            <!--Salva a origem-->
            <input type="hidden" name="origem" value="orcamento">

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

                <!--tipo de produto-->
                <div class="card">

                    <div class="card-body row">

                        <div class="col-md-4">

                            <label><i class="bi bi-tag"></i> Categoria</label><br>

                            <select name="categoria" id="categoria" class="custom-select">

                                <option value="">Selecione</option>

                                <option value="Pneus"<?= (($_SESSION['busca_categoria'] ?? '') == 'Pneus') ? 'selected' : '' ?>>Pneus</option>

                                <option value="Peça"<?= (($_SESSION['busca_categoria'] ?? '') == 'Peça') ? 'selected' : '' ?>>Peça</option>

                                <option value="Serviço"<?= (($_SESSION['busca_categoria'] ?? '') == 'Serviço') ? 'selected' : '' ?>>Serviço</option>

                            </select>

                        </div>
            
                        <div class="col-md-4">

                            <label><i class="bi bi-upc-scan"></i> Código</label><br>

                            <input name="id" class="form-control" placeholder="código do produto" value="<?= $_SESSION['busca_codigo'] ?? '' ?>">

                        </div>
            
                    </div>

                    <div class="card-body row">

                        <div class="col-md-6">

                            <label>Pesquisa</label>
                            <div id="medida">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input name="largura" type="text" class="form-control" value="<?= $_SESSION['busca_largura'] ?? '' ?>" placeholder="Largura">
                                    </div>
                                    <div class="col-md-4">
                                        <input name="perfil" type="text" class="form-control" value="<?= $_SESSION['busca_perfil'] ?? '' ?>" placeholder="Perfil">
                                    </div>
                                    <div class="col-md-4">
                                        <input name="aro" type="text" class="form-control" value="<?= $_SESSION['busca_aro'] ?? '' ?>" placeholder="Aro">
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="pesquisa" style="display: none;">

                                <div class="col-md-9">
                                    <input type="text" name="pesquisa" class="form-control" value="<?= $_SESSION['buscar_pesquisa'] ?? '' ?>" placeholder="Digite o nome do produto...">
                                </div>

                            </div>
                            
                        </div>
                        
                        <div class="col-md-6">

                            <label>Condição Pagamento</label><br>

                            <select name="pagamento" id="pagamento" class="custom-select">

                                <option value="avista"<?= (($_SESSION['busca_pagamento'] ?? '') == 'avista') ? 'selected' : '' ?>>À vista</option>

                                <option value="pix"<?= (($_SESSION['busca_pagamento'] ?? '') == 'pix') ? 'selected' : '' ?>>Pix</option>

                                <option value="dinheiro"<?= (($_SESSION['busca_pagamento'] ?? '') == 'dinheiro') ? 'selected' : '' ?>>Dinheiro</option>

                                <option value="credito"<?= (($_SESSION['busca_pagamento'] ?? '') == 'credito') ? 'selected' : '' ?>>Crédito</option>

                            </select>

                            <div id="parcelas-container" style="display: none;" class="mt-3">

                                <label>Quantidade de parcelas</label>

                                <select name="parcelas" id="parcelas" class="custom-select">

                                    <?php for($i = 1; $i <= 12; $i++): ?>
                                        
                                        <option value="<?= $i ?>"
                                            <?= (($_SESSION['busca_parcelas'] ?? '') == $i) ? 'selected' : '' ?>>
                                            <?= $i ?>x
                                        </option>

                                    <?php endfor; ?>

                                </select>

                            </div>

                        </div>

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
                                <th>Unidades</th>
                                <th>Valor</th>
                                <th></th>

                            </tr>
                            </thead>
                            <tbody>

                                <?php
                                    // Se a página foi aberta, limpa a pesquisa anterior
                                    if(!isset($_POST['select_cliente']) && !isset($_SESSION['pesquisa_realizada'])){
                                        unset($_SESSION['produtos']);
                                        unset($_SESSION['produto_pesquisado']);
                                    }
                                ?>
                                <?php if(isset($_SESSION['produtos']) && count($_SESSION['produtos']) > 0):?>
                                    <?php foreach($_SESSION['produtos'] as $cliente): ?>
                                <tr>
                                    <td><?= $cliente['id']?></td>
                                    <td><?= $cliente['nome']?></td>
                                    <td><?= $cliente['qntd']?></td>
                                    <td><?= $cliente['valor']?></td>
                                </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <!--Cotação-->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">Produto não encontrado?</h4>
                            <p class="mb-0">Faz a solicitação na pagina do compras!</p>
                        </div>
                        
                        <button name="busca_produto" type="submit" class="btn btn-primary">
                            Buscar
                        </button>
                        
                    </div>
                </div>
            </div>
        </form>
    </section>    
    <script src="../assets/js/script.js"></script>
    <?php
        unset($_SESSION['pesquisa_realizada']);
    ?>
</body>
</html>