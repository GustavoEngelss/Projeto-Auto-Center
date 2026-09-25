<?php 
    require_once "../assets/menu.php";
    require_once "../conexao.php";
    require_once "../protec.php";
?>
<?php
    if (!isset($_SESSION['cliente_pesquisa_realizada'])) {

        unset($_SESSION['cliente_busca']);
        unset($_SESSION['busca_cliente']);
        unset($_SESSION['cliente_pesquisado']);

    }
    unset($_SESSION['cliente_pesquisa_realizada']);

    //limpa os campos 
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

                    <ul class="nav nav-tabs card-header-tabs">

                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#cliente">
                                Cliente e veículo
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#itens">
                                Itens e valores
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#fechamento">
                                Fechamento
                            </a>
                        </li>
                        
                    </ul>

                </div>

                <div class="card-body">

                    <form action="../controller/acao.php" method="post">

                        <!--Salva a origem-->
                        <input type="hidden" name="origem" value="os">
                            
                        <div class="tab-content">

                            <!-- Aba Cliente -->
                            <div class="tab-pane fade show active" id="cliente">

                                <!-- cadastro do cliente -->
                                <div>

                                    <h5><i class="bi bi-person-vcard"></i> Cliente</h5>
                                    
                                    <div class="mb-3 d-flex align-items-end">

                                        <div class="flex-grow-1">

                                            <label>Cliente</label>

                                            <input type="text" name="cliente" class="form-control" placeholder="Digite o código, CPF, Nome, telefone ou CNPJ do cliente...">

                                        </div>

                                        <button type="submit" name="cliente_os" class="btn btn-primary ml-2">
                                            Buscar
                                        </button>

                                        <a href="../modelo/new-cliente.php" class="btn btn-success ml-2">
                                            <i class="bi bi-person-plus-fill"></i>
                                            Novo cliente
                                        </a>

                                    </div>
                                    
                                    <div class="row">

                                        <div class="col-md-8">

                                            <?php if (isset($_SESSION['cliente_busca']) && !empty($_SESSION['cliente_busca'])): ?>
                                                <?php foreach ($_SESSION['cliente_busca'] as $cliente): ?>

                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-2 col-form-label">Cód:</label>
                                                        <div class="col-sm-10">
                                                            <p class="form-control border-0"><?= $cliente['id']?></p>
                                                        </div>
                                                    </div>

                                                <?php endforeach; ?>
                                            <?php endif; ?>

                                            <?php if (isset($_SESSION['cliente_busca']) && !empty($_SESSION['cliente_busca'])): ?>
                                                <?php foreach ($_SESSION['cliente_busca'] as $cliente): ?>

                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-2 col-form-label">Nome:</label>
                                                        <div class="col-sm-10">
                                                            <p class="form-control border-0"><?= $cliente['nome']?></p>
                                                        </div>
                                                    </div>

                                                <?php endforeach; ?>
                                            <?php endif; ?>

                                            <?php if (isset($_SESSION['cliente_busca']) && !empty($_SESSION['cliente_busca'])): ?>
                                                <?php foreach ($_SESSION['cliente_busca'] as $cliente): ?>

                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-2 col-form-label">Telefone:</label>
                                                        <div class="col-sm-10">
                                                            <p class="form-control border-0"><?= $cliente['telefone']?></p>
                                                        </div>
                                                    </div>

                                                <?php endforeach; ?>
                                            <?php endif; ?>

                                        </div>

                                    </div>

                                </div>

                                <!-- add veiculo -->
                                <div>

                                    <h5><i class="bi bi-car-front-fill"></i> Veiculo</h5>
                                    <br>

                                    <div class="row">

                                        <div class="col-md-4">

                                            <label>Marca</label>

                                            <select name="marca" id="marca" class="custom-select">

                                                <option>Avulso</option>

                                                <?php 

                                                    $sql=
                                                    "   SELECT id, nome 
                                                        FROM marcas 
                                                        ORDER BY nome"
                                                    ;
                                                    $resultado = mysqli_query($mysqli, $sql);

                                                ?>

                                                <?php while ($marca = mysqli_fetch_assoc($resultado)): ?>

                                                    <option value="<?= $marca['id'] ?>">
                                                        <?= $marca['nome'] ?>
                                                    </option>

                                                <?php endwhile; ?>

                                            </select>

                                        </div>

                                        <div class="col-md-4">

                                            <label>Modelo</label>

                                            <select name="modelo" id="modelo" class="custom-select">

                                                <option>Avulso</option>

                                            </select>

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

                            </div>

                            <!-- Aba Itens -->
                            <div class="tab-pane fade" id="itens">

                                <!--Adicionar Itens-->
                                <div>

                                    <h5><i class="bi bi-wrench"></i> Itens</h5>

                                    <!--Tabela Itens-->
                                    <div class="card_body">

                                        <div class="card">

                                            <div class="card-body row">

                                                <div class="col-md-6">

                                                    <label><i class="bi bi-tag"></i> Categoria</label><br>

                                                    <select name="categoria" id="categoria" class="custom-select">

                                                        <option value="">Selecione</option>

                                                        <option value="Pneus"<?= (($_SESSION['busca_categoria'] ?? '') == 'Pneus') ? 'selected' : '' ?>>Pneus</option>

                                                        <option value="Peça"<?= (($_SESSION['busca_categoria'] ?? '') == 'Peça') ? 'selected' : '' ?>>Peça</option>

                                                        <option value="Serviço"<?= (($_SESSION['busca_categoria'] ?? '') == 'Serviço') ? 'selected' : '' ?>>Serviço</option>

                                                    </select>

                                                </div>
                                    
                                                <div class="col-md-6">

                                                    <label><i class="bi bi-upc-scan"></i> Código</label><br>

                                                    <input name="id" class="form-control" placeholder="código do produto" value="<?= $_SESSION['busca_codigo'] ?? '' ?>">

                                                </div>
                                    
                                            </div>

                                            <div class="card-body row">

                                                <div class="col-md-9">

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

                                                <div class="col-md-2 ml-4"> 

                                                    <label for=""></label>
                                                    <button type="submit" name="busca_produto" class="btn btn-outline-primary form-control mt-2"></i>Buscar</button>

                                                </div>

                                                <?php
                                                    // Se a página foi aberta, limpa a pesquisa anterior
                                                    if(!isset($_POST['select_cliente']) && !isset($_SESSION['pesquisa_realizada'])){
                                                        unset($_SESSION['produtos']);
                                                        unset($_SESSION['produto_pesquisado']);
                                                    }
                                                ?>
                                                <table class="table table-hover mt-4 bg-light">

                                                    <?php if(isset($_SESSION['produtos']) && count($_SESSION['produtos']) > 0):?>
                                                        <thead>
                                                            <tr>
                                                                
                                                                <th>Código</th>
                                                                <th>Nome</th>
                                                                <th>Unidades</th>
                                                                <th>Valor</th>
                                                                <th></th>

                                                            </tr>
                                                        </thead>
                                                        <?php foreach($_SESSION['produtos'] as $produto): ?>
                                                    
                                                            <tbody>
                                                                <tr>
                                                                    <td><?= $produto['id']?></td>
                                                                    <td><?= $produto['nome']?></td>
                                                                    <td><?= $produto['qntd']?></td>
                                                                    <td><?= $produto['valor']?></td>
                                                                    <td><input type="checkbox" name="produtos[]" value="<?= $produto['id'] ?>"></td>
                                                                </tr>
                                                            </tbody>
                                                        <?php endforeach; ?>

                                                        <button type="submit" name="adicionar_itens" class="btn btn-primary">
                                                            Adicionar
                                                        </button>

                                                    <?php endif; ?>
                                                </table>

                                            </div>

                                        </div>
                                        
                                        <!--Itens da O.S-->
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

                                                <?php $itens_os = $_SESSION['itens_os'] ?? [];?>

                                                <?php foreach($itens_os as $produto):?>

                                                    <tr>

                                                        <td>
                                                            <?= $produto['id'] ?>
                                                        </td>

                                                        <td>
                                                            <?= htmlspecialchars($produto['nome']) ?>
                                                        </td>

                                                        <td>
                                                            <input type="number" name="quantidade[<?= $produto['id'] ?>]" value="1" min="1" class="form-control qntd-itens">
                                                        </td>

                                                        <td>
                                                            <input type="number" step="0.01" name="valor[<?= $produto['id'] ?>]" value="<?= $produto['valor'] ?>" class="form-control valor-unitario">
                                                        </td>

                                                        <td>
                                                            R$ <span class="total-item">0,00</span>
                                                        </td>

                                                        <td>
                                                            <button type="submit" name="remover_item" value="<?= $produto['id'] ?>" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                                        </td>

                                                    </tr>

                                                <?php endforeach; ?>

                                            </tbody>
    
                                        </table>
                                    </div>

                                </div>
                                
                                <!--Valor-->
                                <div>

                                    <div class="float-right ml-2">
                                        <label>R$</label>
                                        <input type="text">
                                    </div>
                                    
                                </div><br>

                            </div>
                            
                            <!-- Aba Fechamento -->
                            <div class="tab-pane fade" id="fechamento">
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

                                </div><br>

                                <!--Botões-->
                                <div class="col-md-3 d-flex float-right">

                                    <button class="btn btn-success mr-2 px-3" name="" >Abrir O.S</button>

                                    <a href="../paginas/ordem-servico.php" class="btn btn-danger px-3">Fechar a O.S</a>

                                </div>
                            
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section> 
    <script src="../assets/js/script.js"></script> 
    <?php
        unset($_SESSION['pesquisa_realizada']);
    ?>
</body>
</html>