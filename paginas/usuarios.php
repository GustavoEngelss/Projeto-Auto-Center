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

            <h1>Lista de Usuários</h1>
            <form action="../modelo/add-usuario.php" class="acao">
                <button class="bnt-usuario">Adicionar Loguin</button>
            </form>
        </header>

        <div class="card-header d-flex justify-content-between align-items-center">
            
            <!--Titulo do header-->
            <div class="d-flex align-items-center ml-4">

                <div class="mr-3 mt-0">
                    <i class="bi bi-people-fill" style="font-size: 58px;"></i>
                </div>
                
                <div>

                    <h2 class="mt-3 mb-0 font-weight-bold">Funcionários</h2>
                    <p>Gerencimaneto de Funcionários</p>

                </div>

            </div>

            <!--Botão-->
            <a href="../modelo/add-usuario.php" class="btn btn-primary">

                <i class="bi bi-plus-lg"></i> Novo Funcioário

            </a>

        </div>

        <div class="card-body container mt-2">

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

            <!--Pesquisa e resultado-->
            <div class="card-body">
                
                <!--Pesquisa-->
                <form action="" method="post">

                    <div class="input-group">

                        <div class="input-group-prepend">

                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i>
                            </span>

                        </div>

                        <input type="text" name="usuario" class="form-control" value="<?= $_SESSION[''] ?? '' ?>" placeholder="Digite o código, Nome ou telefone...">
                        
                        <div class="input-group-append">

                            <button type="submit" name="select_cliente" class="btn btn-primary px-4">
                                Pesquisar
                            </button>

                        </div>

                    </div>

                </form>

                <!--tabela-->
                <div class="table-responsive mt-3">

                    <table class="table table-hover mb-0">

                        <thead class="thead-light">

                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Usuário</th>
                                <th>Telefone</th>
                                <th>Status</th>
                                <th></th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php 
                                $sql = 'SELECT * FROM usuarios';
                                $usuarios = mysqli_query($mysqli, $sql);
                                foreach($usuarios as $usuarios){
                            ?>

                                <tr>

                                    <td class="text-center"><?=$usuarios['id_usuario']?></td>
                                    <td class="text-center"><?=$usuarios['nome']?></td>
                                    <td class="text-center"><?=$usuarios['usuario']?></td>
                                    <td class="text-center"><?=$usuarios['numero']?></td>
                                    <td class="text-center">
                                        <span class="badge badge-success"><?=$usuarios['status']?></span>
                                    </td>
                                    <td class="text-center">

                                        <a href="../modelo/edit.php?id=<?= $usuarios['id_usuario'] ?>" class="btn btn-success btn-sm mx-2">Editar</a>

                                        <form action="../controller/acao.php" method="post" class="d-inline mx-2">
                                            <button type="submit" onclick="return confirm('Tem certaza que deseja excluir?')" name="delete_usuario" value="<?= $usuarios['id_usuario'] ?>" class="btn btn-danger btn-sm">Excluir</button>
                                        </form>

                                    </td>

                                </tr>

                            <?php 
                                }
                            ?>
                            
                        </tbody>
                    </table>

                </div>

            </div>

        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>
</html>