<?php 
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }

    function exigirAcesso(array $niveisPermitidos): void{

        if(!isset($_SESSION['nivel_acesso']) || !in_array($_SESSION['nivel_acesso'], $niveisPermitidos, true)){

            http_response_code(403);
            require_once __DIR__ . "/assets/menu.php";
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

            <div class="container-fluid d-flex align-items-center justify-content-center" style="min-height: 75vh;">

                <div class="card shadow text-center border-0"
                    style="max-width: 500px; width: 100%;">

                    <div class="card-body p-5">

                        <div class="mb-4 text-danger">
                            <i class="bi bi-shield-lock-fill"
                            style="font-size: 60px;"></i>
                        </div>

                        <h3 class="font-weight-bold mb-3">
                            Acesso restrito
                        </h3>

                        <p class="text-muted mb-4">
                            Você não tem permissão para acessar esta página.
                            Entre em uma página permitida pelo seu nível de acesso.
                        </p>

                    </div>

                    <div class="card-footer bg-white text-muted small">
                        G.A Pneus
                    </div>

                </div>

            </div>

            </body>
            </html>
                

<?php
        exit;
        }
}
?>
