<?php 
    session_start();

    require_once "../assets/menu.php";
    require_once "../conexao.php";
    require_once "../protec.php";

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/cliente.css">
    <link rel="stylesheet" href="../assets/css/menu.css">

    <title>G.A Pneus</title>
</head>
<body>

    <section class="conteudo">

        <header class="cabecalho-clientes">
            <h1>Atualizar dados do Cliente</h1>
        </header>

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Dados do cliente 
                                <a href="../paginas/cliente.php" class="btn btn-danger float-right">Voltar</a>
                            </h4>
                        </div>
                        <form method="POST" action="../controller/acao.php">

                            <div class="card-body">
                                <?php
                                    if(isset($_GET['id'])){
                                        $cliente_id = mysqli_real_escape_string($mysqli, $_GET['id']);
                                        $sql =
                                        "
                                            SELECT * FROM clientes
                                            WHERE id = '$cliente_id'
                                        ";
                                        $query = mysqli_query($mysqli, $sql);
                                        if(mysqli_num_rows($query) > 0){
                                            $cliente = mysqli_fetch_array($query);
                            
                                    ?>

                                    <input type="hidden" name="cliente_id" value="<?= $cliente['id'] ?>">


                                <div class="row">

                                    <div class="col-md-4">
                                        <label>Nome*</label>
                                        <p class="form-control"><?= $cliente['nome'] ?></p>
                                    </div>

                                    <div class="col-md-4">
                                        <label>CPF*</label>
                                        <p class="form-control"><?= preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cliente['cpf']) ?></p>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Telefone*</label>
                                        <input type="text" name="fone" class="form-control" value="<?= preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $cliente['telefone']) ?>">
                                        <br>
                                    </div>
                            
                                    <div class="col-md-4">
                                        <label>E-mail</label>
                                        <input type="text" name="email" class="form-control" value="<?= $cliente['email'] ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Data de nascimento*</label>
                                        <p class="form-control"><?= date('d/m/Y', strtotime($cliente['data_nascimento'])) ?></p>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Gênero</label>
                                        <p class="form-control"><?= $cliente['genero'] ?></p>
                                        <br><br>
                                    </div>
                                </div>
                                <div>Endereço <hr></div>
                            
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>CEP*</label>
                                            <input type="text" name="cep" class="form-control" value="<?= $cliente['cep'] ?>">
                                        </div>
                                        <div class="col-md-8">
                                            <label>Rua</label>
                                            <input type="text" name="rua" class="form-control" value="<?= $cliente['rua'] ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Número*</label>
                                            <input type="text" name="num" class="form-control" value="<?= $cliente['numero'] ?>">
                                            <br>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Bairro</label>
                                            <input type="text" name="bairro" class="form-control" value="<?= $cliente['bairro'] ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Cidade</label>
                                            <input type="text" name="cidade" class="form-control" value="<?= $cliente['cidade'] ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Estado</label>
                                            <input type="text" name="estado" class="form-control" value="<?= $cliente['estado'] ?>">
                                            <br>
                                        </div>
                            
                                        <div class="col-md-8">
                                            <label>Observação</label>
                                            <input type="text" name="obs" class="form-control" value="<?= $cliente['observacao'] ?>">
                                        </div>
                                        <button type="submit" class="btn btn-success float-right" name="update_cliente" >
                                            Salvar
                                        </button>
                                        <?php
                                            }else{
                                                echo "<h5>Usuário não encontrado</h5>";
                                            }
                                        }
                                        ?>
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