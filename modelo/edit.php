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
    <link rel="stylesheet" href="../assets/css/menu.css">
    <link rel="stylesheet" href="../assets/css/usuario.css">


    <title>G.A Pneus</title>
</head>
<body>
    <section class="conteudo">

        <header class="cabecalho-usuario">
            <h1>Editar Usuário</h1>
        </header>

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Adicionar Usuário
                                <a href="../paginas/usuarios.php" class="btn btn-danger float-right">Voltar</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <?php 
                                if(isset($_GET['id'])){
                                $usuario_id =mysqli_real_escape_string($mysqli, $_GET['id']);
                                $sql = "SELECT * from usuarios WHERE id_usuario='$usuario_id'";
                                $query = mysqli_query($mysqli, $sql);

                                if(mysqli_num_rows($query) > 0){
                                    $usuario = mysqli_fetch_array($query);
                            ?>
                            <form action="../controller/acao.php" method="post">
                                <input type="hidden" name="usuario_id" value="<?= $usuario['id_usuario'] ?>">

                                <div class="mb-3">
                                    <label>Nome</label>
                                    <input type="text" name="nome" value="<?= $usuario['nome'] ?>" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="text" name="email" value="<?= $usuario['usuario'] ?>" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>Senha</label>
                                    <input type="text" name="senha" value="<?= $usuario['senha'] ?>" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <button type="submit" name="update_usuario" class="btn btn-primary">Salvar</button>
                                </div>
                            </form>
                            <?php 
                                }
                                }else{
                                    echo "<h5>Nenhum usuário encontrado.</h5>";
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