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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/menu.css">
    <link rel="stylesheet" href="../assets/css/usuario.css">

    <title>G.A Pneus</title>
</head>
<body>
    <section class="conteudo">

        <header class="cabecalho-usuario">
            <h1>Visualizar dados do Cliente</h1>
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
                        <div class="card-body">
                            <?php 

                                if(isset($_GET['id'])){
                                    $cliente_id = mysqli_real_escape_string($mysqli, $_GET['id']);
                                    $sql = "SELECT * FROM clientes WHERE id='$cliente_id'";        
                                    $query = mysqli_query($mysqli, $sql);

                                    if(mysqli_num_rows($query) > 0){
                                        $cliente = mysqli_fetch_array($query);
                                    
                                ?>
                                        <div class="row">
                            <div class="col-md-4">
                                <label>Nome*</label>
                                <p class="form-control"><?= $cliente['nome'] ?></p>
                            </div>

                            <div class="col-md-4">
                                <label>CPF*</label>
                                <p class="form-control"><?= $cliente['cpf'] ?></p>
                            </div>

                            <div class="col-md-4">
                                <label>Telefone*</label>
                                <p class="form-control"><?= $cliente['telefone'] ?></p>
                                <br>
                            </div>
                            
                            <div class="col-md-4">
                                <label>E-mail</label>
                                <p class="form-control"><?= $cliente['email'] ?></p>
                            </div>

                            <div class="col-md-4">
                                <label>Data de nascimento*</label>
                                <p class="form-control"><?= $cliente['data_nascimento'] ?></p>
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
                                    <p class="form-control"><?= $cliente['cep'] ?></p>
                                </div>

                                <div class="col-md-8">
                                    <label>Rua</label>
                                    <p class="form-control"><?= $cliente['rua'] ?></p>
                                </div>

                                <div class="col-md-2">
                                    <label>Número*</label>
                                    <p class="form-control"><?= $cliente['numero'] ?></p>
                                    <br>
                                </div>

                                <div class="col-md-4">
                                    <label>Bairro</label>
                                    <p class="form-control"><?= $cliente['bairro'] ?></p>
                                </div>

                                <div class="col-md-4">
                                    <label>Cidade</label>
                                    <p class="form-control"><?= $cliente['cidade'] ?></p>
                                </div>

                                <div class="col-md-4">
                                    <label>Estado</label>
                                    <p class="form-control"><?= $cliente['estado'] ?></p>
                                    <br>
                                </div>
                                
                                <div class="col-md-8">
                                    <label>Observação</label>
                                    <p class="form-control"><?= $cliente['observacao'] ?></p>
                                </div>
                                    <?php 
                                        }else{
                                            echo "<h5>Usuário não encontrado</h5>";
                                        }
                                    }
                                ?>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="../assets/js/script.js"></script>
</body>
</html>