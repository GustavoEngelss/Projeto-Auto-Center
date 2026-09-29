<?php

    if (session_status() === PHP_SESSION_NONE) session_start();

    // Só limpa quando abrir uma O.S NOVA 
    if (isset($_GET['novo'])) {

        unset($_SESSION['os']);
        header('Location: abrir-os.php');
        exit;

    }

    require_once "../assets/menu.php";
    require_once "../conexao.php";
    require_once "../protec.php";


    //variveis com nome menores para facilitar
    $os             = $_SESSION['os'] ?? [];
    $busca          = $os['busca'] ?? [];
    $cliente_busca  = $os['cliente'] ?? [];
    $produtos_busca = $os['produtos'] ?? [];
    $itens_os       = $os['itens'] ?? [];
    $veiculo        = $os['veiculo'] ?? [];
    $pagamento      = $os['pagamento'] ?? '';
    $parcelas       = $os['parcelas'] ?? '';
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
                
                <!--Cabeçalho ( 3 abas )-->
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

                                            <?php if (!empty($cliente_busca)): ?>
                                                <?php foreach ($cliente_busca as $cliente): ?>

                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-2 col-form-label">Cód:</label>
                                                        <div class="col-sm-10">
                                                            <p class="form-control border-0"><?= $cliente['id'] ?></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-2 col-form-label">Nome:</label>
                                                        <div class="col-sm-10">
                                                            <p class="form-control border-0"><?= $cliente['nome'] ?></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row mb-2">
                                                        <label class="col-sm-2 col-form-label">Telefone:</label>
                                                        <div class="col-sm-10">
                                                            <p class="form-control border-0"><?= $cliente['telefone'] ?></p>
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

                                                <option value="">Avulso</option>

                                                <?php
                                                    $sql = "SELECT id, nome FROM marcas ORDER BY nome";
                                                    $resultado = mysqli_query($mysqli, $sql);
                                                ?>

                                                <?php while ($marca = mysqli_fetch_assoc($resultado)): ?>

                                                    <option value="<?= $marca['id'] ?>"
                                                        <?= (($veiculo['marca'] ?? '') == $marca['id']) ? 'selected' : '' ?>>
                                                        <?= $marca['nome'] ?>
                                                    </option>

                                                <?php endwhile; ?>

                                            </select>

                                        </div>

                                        <div class="col-md-4">

                                            <label>Modelo</label>

                                            <select name="modelo" id="modelo" class="custom-select">

                                                <option value="">Avulso</option>

                                                <?php if (!empty($veiculo['marca'])): ?>

                                                    <?php
                                                        $id_marca = mysqli_real_escape_string($mysqli, $veiculo['marca']);
                                                        $sql = "SELECT id, nome FROM modelos WHERE marcas_id = '$id_marca' ORDER BY nome";
                                                        $res_modelos = mysqli_query($mysqli, $sql);
                                                    ?>

                                                    <?php while ($modelo = mysqli_fetch_assoc($res_modelos)): ?>

                                                        <option value="<?= $modelo['id'] ?>"
                                                            <?= (($veiculo['modelo'] ?? '') == $modelo['id']) ? 'selected' : '' ?>>
                                                            <?= $modelo['nome'] ?>
                                                        </option>

                                                    <?php endwhile; ?>

                                                <?php endif; ?>

                                            </select>

                                        </div>

                                        <div class="col-md-4">

                                            <label>Ano</label>
                                            <input type="text" name="ano" class="form-control" value="<?= htmlspecialchars($veiculo['ano'] ?? '') ?>">
                                            <br>

                                        </div>

                                        <div class="col-md-4">

                                            <label>Placa</label>
                                            <input type="text" name="placa" class="form-control" value="<?= htmlspecialchars($veiculo['placa'] ?? '') ?>">

                                        </div>

                                        <div class="col-md-4">

                                            <label>Quilometragem (KM)</label>
                                            <input type="text" name="km" class="form-control" value="<?= htmlspecialchars($veiculo['km'] ?? '') ?>">

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

                                                        <option value="Pneus"<?= (($busca['categoria'] ?? '') == 'Pneus') ? 'selected' : '' ?>>Pneus</option>

                                                        <option value="Peça"<?= (($busca['categoria'] ?? '') == 'Peça') ? 'selected' : '' ?>>Peça</option>

                                                        <option value="Serviço"<?= (($busca['categoria'] ?? '') == 'Serviço') ? 'selected' : '' ?>>Serviço</option>

                                                    </select>

                                                </div>
                                    
                                                <div class="col-md-6">

                                                    <label><i class="bi bi-upc-scan"></i> Código</label><br>

                                                    <input name="id" class="form-control" placeholder="código do produto" value="<?= $busca['codigo'] ?? '' ?>">

                                                </div>
                                    
                                            </div>

                                            <div class="card-body row">

                                                <div class="col-md-9">

                                                    <label>Pesquisa</label>

                                                    <div id="medida">

                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <input name="largura" type="text" class="form-control" value="<?= $busca['largura'] ?? '' ?>" placeholder="Largura">
                                                            </div>

                                                            <div class="col-md-4">
                                                                <input name="perfil" type="text" class="form-control" value="<?= $busca['perfil'] ?? '' ?>" placeholder="Perfil">
                                                            </div>

                                                            <div class="col-md-4">
                                                                <input name="aro" type="text" class="form-control" value="<?= $busca['aro'] ?? '' ?>" placeholder="Aro">
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="row" id="pesquisa" style="display: none;">

                                                        <div class="col-md-9">
                                                            <input type="text" name="pesquisa" class="form-control" value="<?= $busca['pesquisa'] ?? '' ?>" placeholder="Digite o nome do produto...">
                                                        </div>

                                                    </div>
                                                    
                                                </div>

                                                <div class="col-md-2 ml-4"> 

                                                    <label for=""></label>
                                                    <button type="submit" name="busca_produto" class="btn btn-outline-primary form-control mt-2"></i>Buscar</button>

                                                </div>

                                                <table class="table table-hover mt-4 bg-light">

                                                    <?php if(isset($produtos_busca) && count($produtos_busca) > 0):?>
                                                        <thead>
                                                            <tr>
                                                                
                                                                <th>Código</th>
                                                                <th>Nome</th>
                                                                <th>Unidades</th>
                                                                <th>Valor</th>
                                                                <th></th>

                                                            </tr>
                                                        </thead>
                                                        <?php foreach($produtos_busca as $produto): ?>
                                                    
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

                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="5" class="text-right">

                                                                        <button type="submit" name="adicionar_itens" class="btn btn-primary mt-3">
                                                                            Adicionar
                                                                        </button>

                                                                    </td>
                                                                </tr>
                                                            </tfoot>

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

                                                <?php $total_os = 0; ?>

                                                <?php foreach($itens_os as $produto): ?>

                                                    <?php
                                                        $qtd        = $produto['quantidade'] ?? 1;
                                                        $unitario   = $produto['valor_ofertado'] ?? $produto['valor'];
                                                        $total_item = $qtd * $unitario;
                                                        $total_os  += $total_item;
                                                    ?>

                                                    <tr>
                                                        <td><?= $produto['id'] ?></td>

                                                        <td><?= htmlspecialchars($produto['nome']) ?></td>

                                                        <td>
                                                            <input type="number" name="quantidade[<?= $produto['id'] ?>]"
                                                                value="<?= $qtd ?>" min="1"
                                                                class="form-control qntd-itens">
                                                        </td>

                                                        <td>
                                                           <input type="text" inputmode="decimal" name="valor[<?= $produto['id'] ?>]"
                                                                value="<?= number_format($unitario, 2, ',', '') ?>"
                                                                class="form-control valor-unitario">
                                                        </td>

                                                        <td>
                                                            R$ <span class="total-item"><?= number_format($total_item, 2, ',', '.') ?></span>
                                                        </td>

                                                        <td>
                                                            <button type="submit" name="remover_item" value="<?= $produto['id'] ?>" class="btn btn-sm btn-danger">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>

                                                <?php endforeach; ?>

                                            </tbody>
    
                                        </table>
                                    </div>

                                </div>
                                
                                <!--Valor-->
                                <div class="float-right ml-2">

                                    <label>Total: R$</label>
                                    <input type="text" id="total-geral" class="form-control" readonly
                                        value="<?= number_format($total_os ?? 0, 2, ',', '.') ?>">

                                </div>

                            </div>
                            
                            <!-- Aba Fechamento -->
                            <div class="tab-pane fade" id="fechamento">
                                <!--Forma de pagamento-->
                                <div>
                                    <div class="col-md-6">

                                        <h5><i class="bi bi-credit-card"></i> Condição Pagamento</h5><br>

                                        <select name="pagamento" id="pagamento" class="custom-select">

                                            <option value="avista"<?= (($pagamento ?? '') == 'avista') ? 'selected' : '' ?>>À vista</option>

                                            <option value="pix"<?= (($pagamento ?? '') == 'pix') ? 'selected' : '' ?>>Pix</option>

                                            <option value="dinheiro"<?= (($pagamento ?? '') == 'dinheiro') ? 'selected' : '' ?>>Dinheiro</option>

                                            <option value="credito"<?= (($pagamento ?? '') == 'credito') ? 'selected' : '' ?>>Crédito</option>

                                        </select>

                                        <div id="parcelas-container" style="display: none;" class="mt-3">

                                            <label>Quantidade de parcelas</label>

                                            <select name="parcelas" id="parcelas" class="custom-select">

                                                <?php for($i = 1; $i <= 12; $i++): ?>
                                                    
                                                    <option value="<?= $i ?>"
                                                        <?= (($busca['parcelas'] ?? '') == $i) ? 'selected' : '' ?>>
                                                        <?= $i ?>x
                                                    </option>

                                                <?php endfor; ?>

                                            </select>

                                        </div>

                                    </div>

                                    <div>
                                        <div class="float-right ml-2">

                                            <label>Total: R$</label>
                                            <input type="text" id="total-fechamento" class="form-control" readonly
                                                value="<?= number_format($total_os ?? 0, 2, ',', '.') ?>">

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
   <script>

        //redirecionamento para pagina
        if (window.location.hash) {
            $('a[href="' + window.location.hash + '"]').tab('show');
        }

    </script>
    <?php
        unset($_SESSION['pesquisa_realizada']);
    ?>
</body>
</html>