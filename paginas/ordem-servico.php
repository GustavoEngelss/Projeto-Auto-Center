<?php 
    require_once "../assets/menu.php";
    require_once "../protec.php";
    require_once "../conexao.php";

?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/menu.css">
    <link rel="stylesheet" href="../assets/css/ordem-servico.css">


    <title>G.A Pneus</title>
</head>
<body>
    <section class="conteudo">

        <header class="cabecalho-servicos">

            <h1>Ordem de Serviço</h1>
            <form class="acao" method="POST"  action="../modelo/abrir-os.php">
                
                <a href="../modelo/abrir-os.php?novo=1" class="bnt-os" name="acao">Nova O.S</a>
                <input type="text" class="input-busca" placeholder="Pesquisar O.S...">

            </form>

        </header>
        
        <div class="p-3">
    
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

                <table class="table table-hover text-center">

                    <thead class="thead-light">
                        <tr>
                            <th>Nº O.S</th>
                            <th>Cliente</th>
                            <th>Carro</th>
                            <th>Placa</th>
                            <th>Vendedor</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    
                    <!--Consulta para o resultado-->
                    <?php

                        $sql = "SELECT 
                                    os.id,
                                    c.nome AS cliente,
                                    m.nome AS marca,
                                    mo.nome AS modelo,
                                    os.placa,
                                    u.nome AS vendedor,
                                    os.total,
                                    os.status,
                                    os.criado_em
                                FROM ordem_servico os

                                INNER JOIN clientes c
                                    ON c.id = os.cliente_id

                                LEFT JOIN usuarios u
                                ON u.id_usuario = os.usuario_id

                                LEFT JOIN marcas m
                                    ON m.id = os.marca_id

                                LEFT JOIN modelos mo
                                    ON mo.id = os.modelo_id

                                WHERE os.status = 'Aberta'

                                ORDER BY os.id DESC";

                        $resultado = $mysqli->query($sql);

                    ?>

                    <tbody>

                        <?php while($os = $resultado->fetch_assoc()): ?>

                            <tr>

                                <!-- Nº O.S -->
                                <td>
                                    <a href="../modelo/abrir-os.php?id=<?= (int) $os['id'] ?>" class="text-decoration-none"><?= $os['id'] ?></a>
                                </td>

                                <!-- Cliente -->
                                <td>
                                    <?= htmlspecialchars($os['cliente']) ?>
                                </td>

                                <!-- Carro -->
                                <td>
                                    <?php if($os['marca'] && $os['modelo']): ?>

                                        <?= htmlspecialchars($os['marca']) ?>/<?= htmlspecialchars($os['modelo']) ?>

                                    <?php else: ?>

                                        Avulso

                                    <?php endif; ?>
                                </td>

                                <!-- Placa -->
                                <td>
                                    <?= htmlspecialchars($os['placa']) ?>
                                </td>

                                <!-- Vendedor -->
                                <td>
                                    <?= htmlspecialchars($os['vendedor']) ?>
                                </td>

                                <!-- Valor -->
                                <td>
                                    R$ <?= number_format($os['total'], 2, ',', '.') ?>
                                </td>

                                <!-- Status -->
                                <td>
                                    <?= htmlspecialchars($os['status']) ?>
                                </td>

                                <!-- Data -->
                                <td>
                                    <?= date('d/m/Y', strtotime($os['criado_em'])) ?>
                                </td>

                            </tr>

                        <?php endwhile; ?>

                    </tbody>

                </table>
            </div>
    </section>

    <script src="../assets/js/script.js"></script>
</body>
</html>