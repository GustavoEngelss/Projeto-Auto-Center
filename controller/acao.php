<?php 
    session_start();
    require_once "../conexao.php";

    //salva os dados digitado nas O.S a cada envio 
    if(($_POST['origem'] ?? '') === 'os'){

        $_SESSION['os']['pagamento'] = $_POST['pagamento'] ?? '';
        $_SESSION['os']['parcelas']  = $_POST['parcelas']  ?? '';

        // Veículo
        $_SESSION['os']['veiculo'] = [
            'marca'  => $_POST['marca']  ?? '',
            'modelo' => $_POST['modelo'] ?? '',
            'ano'    => $_POST['ano']    ?? '',
            'placa'  => $_POST['placa']  ?? '',
            'km'     => $_POST['km']     ?? '',
        ];

        // Quantidade e valor dos itens
        if(!empty($_SESSION['os']['itens']) && isset($_POST['quantidade'])){

            foreach($_SESSION['os']['itens'] as $i => $item){

                $id = $item['id'];

                if(isset($_POST['quantidade'][$id])){
                    $qtd = (int) $_POST['quantidade'][$id];
                    $_SESSION['os']['itens'][$i]['quantidade'] = max(1, $qtd);
                }

                if(isset($_POST['valor'][$id])){
                    $valor = (float) $_POST['valor'][$id];
                    $_SESSION['os']['itens'][$i]['valor_ofertado'] = max(0, $valor);
                }
            }
        }
    }

    //API 01 Criando usuario 
    if(isset($_POST['create_usuario'])){
        //pega os dados do forulario e joga para a variavel 
        $nome = mysqli_real_escape_string($mysqli, trim($_POST['nome']));
        $usuario = mysqli_real_escape_string($mysqli, trim($_POST['usuario']));
        $senha = trim($_POST['senha']);
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $fone = mysqli_real_escape_string($mysqli, trim($_POST['numero']));

        //validação campo vazio
        if(empty($nome) || empty($usuario) || empty($senha) || empty($fone)){
            $_SESSION['mensagem'] = 'Preencha todos os campos!';
            header('Location: ../paginas/usuarios.php');
            exit;
        }

        $sql = "INSERT INTO usuarios (nome, usuario, senha, numero, status) VALUES ('$nome', '$usuario', '$senha_hash', '$fone', 'Ativo')";

        mysqli_query($mysqli, $sql);

        //validação se deu certo volta automatico para a tela de usuarios e mensagem de sucesso ou de erro 
        if(mysqli_affected_rows($mysqli) > 0){
            $_SESSION['mensagem'] = 'Usuário criado com sucesso';
            header('Location: ../paginas/usuarios.php');
            exit;
        }else{
            $_SESSION['mensagem'] = 'Erro ao criar usuário';
            header('Location: ../paginas/usuarios.php');
            exit;
        }
    }

    //API 02 Editando usuario 
    if(isset($_POST['update_usuario'])){
        $usuario_id = mysqli_real_escape_string($mysqli, $_POST['usuario_id']);

        //pega os dados do forulario e joga para a variavel 
        $nome = mysqli_real_escape_string($mysqli, trim($_POST['nome']));
        $usuario = mysqli_real_escape_string($mysqli, trim($_POST['usuario']));
        $fone = mysqli_real_escape_string($mysqli, trim($_POST['numero']));


        //validação campo vazio
        if(empty($nome) || empty($usuario) || empty($fone)){
            $_SESSION['mensagem'] = 'Preencha todos os campos!';
            header('Location: ../paginas/usuarios.php');
            exit;
        }
        
        $sql = "UPDATE usuarios SET nome='$nome', usuario='$usuario', numero='$fone' WHERE id_usuario='$usuario_id'";
        mysqli_query($mysqli, $sql);

        //validação se deu certo volta automatico para a tela de usuarios e mensagem de sucesso ou de erro 
        if(mysqli_affected_rows($mysqli) > 0){
            $_SESSION['mensagem'] = 'Usuário atualizado com sucesso';
            header('Location: ../paginas/usuarios.php');
            exit;
        }else{
            $_SESSION['mensagem'] = 'Erro ao atualizar usuário';
            header('Location: ../paginas/usuarios.php');
            exit;
        }

    }

    //API 03 Deletando o usuario
    if(isset($_POST['delete_usuario'])){
        $usuario_id = mysqli_real_escape_string($mysqli, $_POST['delete_usuario']);
        $sql = "DELETE from usuarios WHERE id_usuario = '$usuario_id'";

        mysqli_query($mysqli, $sql);

        if(mysqli_affected_rows($mysqli) > 0){
            $_SESSION['mensagem'] = 'Usuário deletado com sucesso';
            header('Location: ../paginas/usuarios.php');
            exit;
        }else{
            $_SESSION['mensagem'] = 'Erro ao deletar usuário';
            header('Location: ../paginas/usuario.php');
            exit;
        }
    }

    //API 04 Adicionando cliente
    if(isset($_POST['new_cliente'])){
        $nome = mysqli_real_escape_string($mysqli, trim($_POST['nome']));
        $cpf = mysqli_real_escape_string($mysqli, trim($_POST['cpf']));
        $telefone = mysqli_real_escape_string($mysqli, trim($_POST['fone']));
        $email = mysqli_real_escape_string($mysqli, trim($_POST['email']));
        $data_nasc = mysqli_real_escape_string($mysqli, trim($_POST['data_nascimento']));
        $genero = mysqli_real_escape_string($mysqli, trim($_POST['genero']));
        $cep = mysqli_real_escape_string($mysqli, trim($_POST['cep']));
        $rua = mysqli_real_escape_string($mysqli, trim($_POST['rua']));
        $num = mysqli_real_escape_string($mysqli, trim($_POST['num']));
        $bairro = mysqli_real_escape_string($mysqli, trim($_POST['bairro']));
        $cidade = mysqli_real_escape_string($mysqli, trim($_POST['cidade']));
        $estado= mysqli_real_escape_string($mysqli, trim($_POST['estado']));
        $obs = mysqli_real_escape_string($mysqli, trim($_POST['obs']));

        if(empty($nome) || empty($cpf) || empty($telefone) || empty($data_nasc) || empty($genero) || empty($cep) || empty($rua) || empty($num) || empty($bairro) || empty($cidade) || empty($estado)){
            $_SESSION['mensagem'] = 'Preencha todos os campos obrigatorios (*)!';
            header('Location: ../modelo/new-cliente.php');
            exit;
        }

        $sql = "INSERT INTO clientes (nome, cpf, telefone, email, data_nascimento, genero, cep, rua, numero, bairro, cidade, estado, observacao) VALUES ('$nome', '$cpf', '$telefone', '$email', '$data_nasc', '$genero', '$cep', '$rua', '$num', '$bairro', '$cidade', '$estado', '$obs')";
        
        mysqli_query($mysqli, $sql);

        if(mysqli_affected_rows($mysqli) > 0){
            $_SESSION['mensagem'] = 'Cliente adicionado com sucesso';
            header('Location: ../paginas/cliente.php');
            exit;
        }else{
            $_SESSION['mensagem'] = 'Erro ao adicionar o cliente';
            header('Location: ../modelo/new-cliente.php');
            exit;
        }
    }

    //API 05 Pesquisa produto
    if(isset($_POST['busca_produto'])){

        //vê de qual das paginas que vem para fazer o retorno certo 
        $origem = ($_POST['origem'] ?? 'orcamento') === 'os' ? 'os' : 'orcamento';

        //para onde a pagina deve voltar 
        if($origem === 'os'){

            $voltar = '../modelo/abrir-os.php#itens';

        } else {

            $voltar = '../paginas/orcamento.php';

        }

        //guarda oque o usuario digitou na pagina
        $_SESSION[$origem]['busca'] = [

            'largura'   => $_POST['largura']   ?? '',
            'perfil'    => $_POST['perfil']    ?? '',
            'aro'       => $_POST['aro']       ?? '',
            'pesquisa'  => $_POST['pesquisa']  ?? '',
            'categoria' => $_POST['categoria'] ?? '',
            'codigo'    => $_POST['id']        ?? '',
            'pagamento' => $_POST['pagamento'] ?? '',
            'parcelas'  => $_POST['parcelas']  ?? '',

        ];

        // Pega os dados para pesquisar
        $id       = mysqli_real_escape_string($mysqli, trim($_POST['id'] ?? ''));
        $largura  = mysqli_real_escape_string($mysqli, trim($_POST['largura'] ?? ''));
        $perfil   = mysqli_real_escape_string($mysqli, trim($_POST['perfil'] ?? ''));
        $aro      = mysqli_real_escape_string($mysqli, trim($_POST['aro'] ?? ''));
        $pesquisa = mysqli_real_escape_string($mysqli, trim($_POST['pesquisa'] ?? ''));

        $medida = '';
        //salva a medida para a consulta
        if($largura != '' && $perfil != '' && $aro != ''){

            $medida = $largura . '/' . $perfil . 'R' . $aro;

        }

        // Escolhe qual consulta fazer
        if($id != ''){

            $sql = "SELECT * FROM produtos WHERE id = '$id'";

        } elseif($medida != ''){

            $sql = "SELECT * FROM produtos WHERE nome LIKE '%$medida%'";

        } elseif($pesquisa != ''){

            $sql = "SELECT * FROM produtos WHERE nome LIKE '%$pesquisa%'";

        } else {

            $_SESSION[$origem]['produtos'] = [];
            $_SESSION['mensagem'] = 'Informe o código ou a medida do produto!';
            header("Location: $voltar");
            exit;

        }

        $sql_query = $mysqli->query($sql) or die("Erro na consulta! " . $mysqli->error);

        $produtos = [];

        while($p = $sql_query->fetch_assoc()){

            $produtos[] = $p;

        }

        // Salva o resultado no armário DESTA página
        $_SESSION[$origem]['produtos'] = $produtos;

        if(empty($produtos)){
            $_SESSION['mensagem'] = 'Nenhum resultado encontrado!';
        }

        header("Location: $voltar");
        exit;
    }

    //API 06 Pesquisa cliente
    if(isset($_POST['busca_cliente'])){

        //origem da requisição
        $origem = ($_POST['origem'] ?? 'pesquisa_cliente') === 'os' ? 'os': 'pesquisa_cliente';

        //para qual pagina retornar
        if($origem === 'os'){

            $voltar = '../modelo/abrir-os.php#cliente';
        } else {

            $voltar = '../paginas/cliente.php';

        }

        $cliente = mysqli_real_escape_string($mysqli, trim($_POST['cliente']));

        $sql = "SELECT * FROM clientes
                WHERE id LIKE '$cliente'
                OR nome LIKE '%$cliente%'
                OR cpf LIKE '$cliente'
                OR telefone LIKE '$cliente'
        ";

        $sql_query = $mysqli->query($sql) or die("Erro na consulta! " . $mysqli->error);

        $clientes = [];

        while($c = $sql_query->fetch_assoc()){

            $clientes[] = $c;

        }

        //salva o resultado na sessão da requisição
        $_SESSION[$origem]['cliente'] = $clientes;

        if(empty($clientes)){
            $_SESSION['mensagem'] = 'Nenhum resultado encontrado!';
        }

        header("Location: $voltar");
        exit;
    }

    //API 07 Selecionando modelo do carro para por O.S
    if (isset($_GET['marca'])) {

        $id_marca = mysqli_real_escape_string($mysqli, $_GET['marca']);

        $sql = "SELECT id, nome
                FROM modelos
                WHERE marcas_id = '$id_marca'
                ORDER BY nome";

        $resultado = mysqli_query($mysqli, $sql);

        while ($modelo = mysqli_fetch_assoc($resultado)) {
            echo "<option value='{$modelo['id']}'>{$modelo['nome']}</option>";
        }

        exit;
    }

    //API 08 Seleciona os itens e retona na O.S
    if(isset($_POST['adicionar_itens'])){

        $produtos = $_POST['produtos'] ?? [];

        if(empty($produtos)){
            $_SESSION['mensagem'] = 'Nenhum item selecionado!';
            header('Location: ../modelo/abrir-os.php#itens');
            exit;
        }

        // Recupera os itens que já estão na O.S.
        $itens_os = $_SESSION['os']['itens'] ?? [];

        foreach ($produtos as $id){

            $id = mysqli_real_escape_string($mysqli, $id);

            // Verifica se já existe na O.S.
            $existe = false;

            foreach ($itens_os as $item) {

                if($item['id'] == $id){
                    $existe = true;
                    break;
                }

            }

            // Se já existe, não adiciona novamente
            if($existe){
                continue;
            }

            $sql = "SELECT * FROM produtos
                    WHERE id = '$id'";

            $sql_query = $mysqli->query($sql)
                or die("Erro na consulta! " . $mysqli->error);

            if($produto = $sql_query->fetch_assoc()){

                // Valor inicial vem do banco
                $produto['valor_ofertado'] = $produto['valor'];

                // Quantidade inicial
                $produto['quantidade'] = 1;

                $itens_os[] = $produto;
            }
        }

        $_SESSION['os']['itens'] = $itens_os;

        // Limpa a pesquisa: tabela e campos
        $_SESSION['os']['produtos'] = [];
        $_SESSION['os']['busca'] = [];

        header('Location: ../modelo/abrir-os.php#itens');
        exit;
    }

    //API 09 Deleta iten da o.s
    if(isset($_POST['remover_item'])){

        $id_produto = $_POST['remover_item'];

        $itens_os = $_SESSION['os']['itens'] ?? [];

        foreach($itens_os as $chave => $item){

            if($item['id'] == $id_produto){

                unset($itens_os[$chave]);

                break;
            }
        }

        $_SESSION['os']['itens'] = array_values($itens_os);

        header('Location: ../modelo/abrir-os.php#itens');
        exit;
    }

    //API 10 Atualiza quantidade e valor dos itens da O.S
    if(isset($_POST['atualizar_itens'])){

        // Quantidade e valor já foram salvos no bloco do início do arquivo
        header('Location: ../modelo/abrir-os.php#itens');
        exit;
    }


?>