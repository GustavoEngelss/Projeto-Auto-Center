<?php 
    require_once "../assets/menu.php";
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
    <link rel="stylesheet" href="../assets/css/relatorio.css">


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <title>G.A Pneus</title>
</head>
<body>
    <section class="conteudo">

        <header class="cabecalho-relatorio">
            <h1>Relatório</h1>
        </header>

        <div class="box-info">
            <div style="background:linear-gradient(45deg, #FF5370, #ff869a)" class="box-info-single">
                <div class="info-text">
                    <h3>Lucro Bruto</h3>
                    <h5>$40.000</h5>
                </div>
                <i class="bi bi-cash"></i>
            </div>

            <div style="background:linear-gradient(45deg, #2ed8b6, #59e0c5)" class="box-info-single">
                <div class="info-text">
                    <h3>Lucro Líquido</h3>
                    <h5>$25.000</h5>
                </div>
                <i class="bi bi-cash"></i>
            </div>

            <div style="background:linear-gradient(45deg, #4099ff, #73b4ff)" class="box-info-single">
                <div class="info-text">
                    <h3>Total de Pneus Vendidos </h3>
                    <h5>325</h5>
                </div>
                <i class="bi bi-car-front"></i>
            </div>
        </div>

        <div class="graficos">

            <div class="grafico-quadrado">
                <canvas id="meuGrafico"></canvas>
            </div>

            <div class="card-graficoR">
                <div class="topo">
                    <h4>Meta da Loja</h4>
                    <i class="bi bi-bar-chart-line-fill"></i>
                    <div class="porcentagem">
                        <span>78%</span>
                    </div>
                </div>
                <div class="desempenho">
                    <h2>Desempenho Mensal</h2>
                    <p>
                        Sua loja já atingiu 78% da meta mensal
                        de faturamento em serviços e vendas.
                    </p>
                    <a href="#" class="bnt-desempenho">
                        <i class="bi bi-graph-up"></i>
                        Ver Gráfico Pessoal
                    </a>
                </div>

            </div>
        </div>
            
    </section>
        
    <script>
        const ctx = document.getElementById("meuGrafico");
        new Chart(ctx, {
            type: "bar",
            data: {
                labels: [
                    "1","2","3","4","5","6","7","8","9","10",
                    "11","12","13","14","15","16","17","18","19","20",
                    "21","22","23","24","25","26","27","28","29","30"
                ],

                datasets: [
                    {
                        label: "Lucro Limpo",
                        data: [
                            1000,1500,1200,1800,2000,1700,1400,2300,2100,2600,
                            1900,2400,1600,2800,2200,2500,1800,2900,3100,2300,
                            1700,3300,2700,2100,4000,3200,1900,2600,3700,3500
                        ],
                        backgroundColor: "blue",
                        borderRadius: 5
                    },

                    {
                        label: "Lucro Bruto",
                        data: [
                            2000,2500,2200,2800,3000,2600,2400,3200,3100,3600,
                            2900,3400,2300,3900,3300,3500,2700,4100,4300,3200,
                            2600,4500,3700,3000,5000,4200,2800,3600,4800,4600
                        ],
                        backgroundColor: "red",
                        borderRadius: 5
                    }
                ]
            },

            options: {
                responsive: true,

                scales: {
                    y: {
                        beginAtZero: true,

                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString("pt-BR");
                            }
                        }
                    }
                }
            }
        });
    </script>
    <script src="../assets/js/script.js"></script>
</body>
</html>