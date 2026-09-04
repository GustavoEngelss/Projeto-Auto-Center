<?php 
    require_once "../assets/menu.php";
    require_once "../conexao.php";
    require_once "../protec.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                            <select name="categoria" class="custom-select">
                                <option>Selecione</option>
                                <option>Pneus</option>
                                <option>Peça</option>
                                <option>Serviço</option>
                            </select>
                        </div>
            
                        <div class="col-md-4">
                            <label><i class="bi bi-upc-scan"></i> Código</label><br>
                            <input name="id" class="form-control" placeholder="código do produto">
                        </div>
            
                    </div>
                    <div class="card-body row">
                        <div class="col-md-6">
                            <label>📏 Medida</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input name="largura" type="text" class="form-control" placeholder="Largura">
                                </div>
                                <div class="col-md-4">
                                    <input name="perfil" type="text" class="form-control" placeholder="Perfil">
                                </div>
                                <div class="col-md-4">
                                    <input name="aro" type="text" class="form-control" placeholder="Aro">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Condição Pagamento</label><br>
                            <select name="pagamento" id="pagamento" class="custom-select">
                                <option value="avista">À vista</option>
                                <option value="pix">Pix</option>
                                <option value="dinheiro">Dinheiro</option>
                                <option value="credito">Crédito</option>
                            </select>

                            <div id="parcelas-container" style="display: none;" class="mt-3">
                                <label>Quantidade de parcelas</label>
                                <select name="parcelas" id="parcelas" class="custom-select">
                                    <option value="1">1x</option>
                                    <option value="2">2x</option>
                                    <option value="3">3x</option>
                                    <option value="4">4x</option>
                                    <option value="5">5x</option>
                                    <option value="6">6x</option>
                                    <option value="7">7x</option>
                                    <option value="8">8x</option>
                                    <option value="9">9x</option>
                                    <option value="10">10x</option>
                                    <option value="11">11x</option>
                                    <option value="12">12x</option>
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
                                <th>Valor</th>
                                <th>condição</th>
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
    <!--quando seleciona a forma de pagamento aparece para selecionar a quantidade -->
    <script>
        const pagamento = document.getElementById('pagamento');
        const parcelasContainer = document.getElementById('parcelas-container');

        pagamento.addEventListener('change', function() {

            if(this.value === 'credito') {
                parcelasContainer.style.display = 'block';
            } else {
                parcelasContainer.style.display = 'none';
            }

        });
    </script>
    
    <script src="../assets/js/script.js"></script>
</body>
</html>