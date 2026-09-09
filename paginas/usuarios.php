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

        <div class="container mt-5">

            <?php if(isset($_SESSION['mensagem'])): ?>

                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $_SESSION['mensagem']; ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <?php unset($_SESSION['mensagem']); ?>

            <?php endif; ?>

            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Loguin</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                    $sql = 'SELECT * FROM usuarios';
                    $usuarios = mysqli_query($mysqli, $sql);
                    foreach($usuarios as $usuarios){
                ?>
                    <tr>
                        <td><?=$usuarios['id_usuario']?></td>
                        <td><?=$usuarios['nome']?></td>
                        <td><?=$usuarios['usuario']?></td>
                        <td>
                            <a href="../modelo/usuario-view.php?id=<?= $usuarios['id_usuario'] ?>" class="btn btn-secondary btn-sm">Visualizar</a>
                            <a href="../modelo/edit.php?id=<?= $usuarios['id_usuario'] ?>" class="btn btn-success btn-sm">Editar</a>
                            <form action="../controller/acao.php" method="post" class="d-inline">
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
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>
</html>