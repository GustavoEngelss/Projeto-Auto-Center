<?php 
    require_once "../assets/menu.php";
    require_once "../protec.php";
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
            <h1>Cadastrar novo Cliente</h1>
        </header>

        <div class="container mt-4">
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
                    <h4>Dados do Cliente</h4>
                </div>
                <div class="card-body">
                    <form action="../controller/acao.php" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Nome*</label>
                                <input type="text" name="nome" class="form-control" placeholder="Digite o nome completo">
                            </div>

                            <div class="col-md-4">
                                <label>CPF*</label>
                                <input type="text" name="cpf" class="form-control" placeholder="000.000.000-00">
                            </div>

                            <div class="col-md-4">
                                <label>Telefone*</label>
                                <input type="text" name="fone" class="form-control" placeholder="(00) 00000-0000">
                                <br>
                            </div>
                            
                            <div class="col-md-4">
                                <label>E-mail</label>
                                <input type="text" name="email" class="form-control" placeholder="email@exemplo.com">
                            </div>

                            <div class="col-md-4">
                                <label>Data de nascimento*</label>
                                <input type="date" name="data_nascimento" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>Gênero</label>
                                <select class="custom-select" name="genero">
                                    <option value="">Selecione</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Feminino">Feminino</option>
                                    <option value="Outros">Outros</option>
                                </select>
                                <br><br>
                            </div>
                        </div>
                        <div>Endereço <hr></div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                <label>CEP*</label>
                                <input type="text" name="cep" class="form-control" placeholder="00000-000" id="cep" onblur="pesquisacep(this.value);">
                            </div>

                            <div class="col-md-8">
                                <label>Rua</label>
                                <input type="text" name="rua" class="form-control" placeholder="Digite sua Rua" id="rua">
                            </div>

                            <div class="col-md-2">
                                <label>Número*</label>
                                <input type="text" name="num" class="form-control" placeholder="N°">
                                <br>
                            </div>

                            <div class="col-md-4">
                                <label>Bairro</label>
                                <input type="text" name="bairro" class="form-control" placeholder="Digite o bairro" id="bairro">
                            </div>

                            <div class="col-md-4">
                                <label>Cidade</label>
                                <input type="text" name="cidade" class="form-control" placeholder="Digite o cidade" id="cidade">
                            </div>

                            <div class="col-md-4">
                                <label>Estado</label>
                                <input type="text" name="estado" class="form-control" placeholder="Digite o estado" id="uf">
                                <br>
                            </div>
                            
                            <div class="col-md-8">
                                <label>Observação</label>
                                <textarea name="obs" class="form-control" rows="2" placeholder="Observações adicionais (opcional)"></textarea>
                            </div>
                            <div class="col-md-4 d-flex justify-content-center align-items-center">
                                <a href="" class="btn btn-secondary mr-2 px-3">
                                    Limpar
                                </a>

                                <button class="btn btn-success mr-2 px-3" name="new_cliente" >Salvar</button>

                                <a href="../paginas/cliente.php" class="btn btn-danger px-3">
                                    Voltar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section> 
    <!--Consulta do Cep-->
    <script>
    
        function limpa_formulário_cep() {
                //Limpa valores do formulário de cep.
                document.getElementById('rua').value=("");
                document.getElementById('bairro').value=("");
                document.getElementById('cidade').value=("");
                document.getElementById('uf').value=("");
        }

        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                //Atualiza os campos com os valores.
                document.getElementById('rua').value=(conteudo.logradouro);
                document.getElementById('bairro').value=(conteudo.bairro);
                document.getElementById('cidade').value=(conteudo.localidade);
                document.getElementById('uf').value=(conteudo.uf);
            } //end if.
            else {
                //CEP não Encontrado.
                limpa_formulário_cep();
                alert("CEP não encontrado.");
            }
        }
            
        function pesquisacep(valor) {

            //Nova variável "cep" somente com dígitos.
            var cep = valor.replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if(validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    document.getElementById('rua').value="...";
                    document.getElementById('bairro').value="...";
                    document.getElementById('cidade').value="...";
                    document.getElementById('uf').value="...";
                    //Cria um elemento javascript.
                    var script = document.createElement('script');

                    //Sincroniza com o callback.
                    script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                    //Insere script no documento e carrega o conteúdo.
                    document.body.appendChild(script);

                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        };

    </script>
    <script src="../assets/js/script.js"></script> 
</body>
</html>