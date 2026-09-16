<?php 
    require_once "../assets/menu.php";
    require_once "../protec.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G.A Pneus</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/cliente.css">
    <link rel="stylesheet" href="../assets/css/menu.css">

</head>
<body>
    <section class="conteudo">

        <header class="cabecalho-clientes">
            <h1>Abrindo Ordem de Serviço</h1>
        </header>

        <div class="container mt-4">
            <!--Mensagem-->
            <?php if(isset($_SESSION['mensagem'])): ?>

                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $_SESSION['mensagem']; ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <?php unset($_SESSION['mensagem']); ?>

            <?php endif; ?>

            <div class="card">

                <div class="card-header">
                    <h4>Dados da O.S</h4>
                </div>

                <div class="card-body">

                    <form action="../controller/acao.php" method="post">
                        <div>
                            <div>
                                <!--Busca do Cliente-->
                                <h5><i class="bi bi-person-vcard"></i> Cliente</h5>
                                <div class="mb-3 d-flex">

                                    <input type="text" name="" class="form-control" placeholder="Digite o código, CPF, Nome, telefone ou CNPJ do cliente...">

                                    <button type="submit" name="select_cliente" class="btn btn-primary float-right ml-2" >Buscar</button>

                                </div>
                                <div class="row">

                                    <!-- Campos do cliente -->
                                    <div class="col-md-8">

                                        <div class="form-group row mb-2">
                                            <label class="col-sm-2 col-form-label">Cód:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control border-0">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-2">
                                            <label class="col-sm-2 col-form-label">Nome:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control border-0">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-2">
                                            <label class="col-sm-2 col-form-label">Telefone:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control border-0">
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Botão -->
                                    <div class="col-md-4 d-flex justify-content-end align-items-end">

                                        <button type="button" class="btn btn-success btn-sm mb-2">
                                            <i class="bi bi-person-plus-fill"></i>
                                            Novo cliente
                                        </button>

                                    </div>

                                </div>
                                <hr>

                                <!--Adicionar Carro-->
                                <div>
                                    <h5><i class="bi bi-car-front-fill"></i> Veiculo</h5>
                                    <br>

                                    <div class="row">

                                        <div class="col-md-4">

                                            <label>Marca</label>
                                            <input type="text" name="" class="form-control">

                                        </div>

                                        <div class="col-md-4">

                                            <label>Modelo</label>
                                            <input type="text" name="" class="form-control">

                                        </div>

                                        <div class="col-md-4">

                                            <label>Ano</label>
                                            <input type="text" name="" class="form-control">
                                            <br>

                                        </div>
                                        
                                        <div class="col-md-4">

                                            <label>Placa</label>
                                            <input type="text" name="" class="form-control">

                                        </div>

                                        <div class="col-md-4">

                                            <label>Quilometragem (KM)</label>
                                            <input type="text" name="" class="form-control">

                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <!--Adicionar Itens-->
                                <div>
                                    <h5><i class="bi bi-wrench"></i> Itens</h5>
                                    <!--Tabela Itens-->
                                    <div class="card_body">

                                        <table class="table table-hover">
                                            
                                            <thead>
                                            <tr>
                                                
                                                <th>Código</th>
                                                <th>Produto/Serviço</th>
                                                <th>Quantidade</th>
                                                <th>Unitário</th>
                                                <th>Total</th>
                                                <th></th>

                                            </tr>
                                            </thead>
                                            <tbody>

                                                <tr>

                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>

                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--botões-->
                                    <div>
                                        <button type="button" class="btn btn-outline-primary"><i class="bi bi-plus"></i> Adicionar</button>
                                    </div>
                                </div>
                                <hr>

                                <!--Forma de pagamento-->
                                <div>
                                    <div class="col-md-6">

                                        <h5><i class="bi bi-credit-card"></i> Condição Pagamento</h5><br>

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

                                    <div>
                                        <div class="float-right ml-2">
                                            <label> Total: R$</label>
                                            <input type="text">
                                        </div>
                                    </div><br>

                                </div>
                                <hr>

                                <!--Botões-->
                                <div class="col-md-2 d-flex float-right">

                                    <button class="btn btn-success mr-2 px-3" name="" >Salvar</button>
                                    <a href="../paginas/ordem-servico.php" class="btn btn-danger px-3">Voltar</a>

                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section> 
  
    <script src="../assets/js/script.js"></script> 
</body>
</html>