<?php 
    session_start();
    require_once "../conexao.php";

    //salva os dados digitado nas O.S a cada envio 
    if(($_POST['origem'] ?? '') === 'os'){

        $_SESSION['os']['pagamento'] = $_POST['pagamento'] ?? '';
        $_SESSION['os']['parcelas']  = $_POST['parcelas']  ?? '';

        // Veículo
        $_SESSION['os']['veiculo'] = [
            'marca'  => $_POST['marca_id']  ?? '',
            'modelo' => $_POST['modelo_id'] ?? '',
            'ano'    => $_POST['ano']       ?? '',
            'placa'  => $_POST['placa']     ?? '',
            'km'     => $_POST['km']        ?? '',
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
                    $valor = str_replace('.', '', $_POST['valor'][$id]);
                    $valor = (float) str_replace(',', '.', $valor);
                    $_SESSION['os']['itens'][$i]['valor_ofertado'] = max(0, $valor);
                }
            }
        }
    }

    //API 01 Criando usuario 
    if(isset($_POST['create_usuario'])){
        //pega os dados do forulario e joga para a variavel 
        $nome       = mysqli_real_escape_string($mysqli, trim($_POST['nome']));
        $usuario    = mysqli_real_escape_string($mysqli, trim($_POST['usuario']));
        $senha      = trim($_POST['senha']);
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $fone       = mysqli_real_escape_string($mysqli, trim($_POST['numero']));

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
        $nome       = mysqli_real_escape_string($mysqli, trim($_POST['nome']));
        $usuario    = mysqli_real_escape_string($mysqli, trim($_POST['usuario']));
        $fone       = mysqli_real_escape_string($mysqli, trim($_POST['numero']));


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

            $sql = "SELECT * FROM produtos 
                    WHERE id = '$id'
                    AND (qntd > 0 OR tipo = 'Serviço')";

        } elseif($medida != ''){

            $sql = "SELECT * FROM produtos 
                    WHERE nome LIKE '%$medida%'
                    AND (qntd > 0 OR tipo = 'Serviço')";

        } elseif($pesquisa != ''){

            $sql = "SELECT * FROM produtos 
                    WHERE nome LIKE '%$pesquisa%'
                    AND (qntd > 0 OR tipo = 'Serviço')";

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

        //limpa o resultado
        $_SESSION[$origem]['cliente'] = [];

        if($cliente === ''){

            $_SESSION['mensagem'] = 'Campo de pesquisa está vazio!';
            header("Location: $voltar");
            exit;

        } else{

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

    //API 11 Abri e edita O.S
    if(isset($_POST['abrir_os'])){

        $usuario_id = $_SESSION['id'];

        // Se veio da edição, a sessão guarda o id da O.S
        $os_id_edicao = !empty($_SESSION['os']['id']) ? (int) $_SESSION['os']['id'] : null;

        $cliente    = mysqli_real_escape_string($mysqli, trim($_POST['cliente_id']));
        $marca      = !empty($_POST['marca_id']) ? (int) $_POST['marca_id'] : null;
        $modelo     = !empty($_POST['modelo_id']) ? (int) $_POST['modelo_id'] : null;
        $ano        = !empty($_POST['ano']) ? (int) $_POST['ano'] : null;
        $placa      = !empty($_POST['placa']) ? mysqli_real_escape_string($mysqli, trim($_POST['placa'])) : 'AVU0000';
        $km         = !empty($_POST['km']) ? (int) $_POST['km'] : null;
        $pagamento  = mysqli_real_escape_string($mysqli, trim($_POST['pagamento']));
        $parcela    = mysqli_real_escape_string($mysqli, trim($_POST['parcelas']));

        $marca_sql  = $marca  === null ? "NULL" : $marca;
        $modelo_sql = $modelo === null ? "NULL" : $modelo;
        $ano_sql    = $ano    === null ? "NULL" : $ano;
        $km_sql     = $km     === null ? "NULL" : $km;

        if ($os_id_edicao) {

            //atualiza a O.S existente 
            $os_id = $os_id_edicao;

            $sql = "UPDATE ordem_servico SET
                        cliente_id = '$cliente',
                        marca_id   = $marca_sql,
                        modelo_id  = $modelo_sql,
                        ano        = $ano_sql,
                        placa      = '$placa',
                        km         = $km_sql,
                        pagamento  = '$pagamento',
                        parcelas   = '$parcela'
                    WHERE id = $os_id";
            $mysqli->query($sql);

            // Apaga os itens antigos; os atuais da tela são regravados abaixo
            $mysqli->query("DELETE FROM itens_os WHERE os_id = $os_id");

            $mensagem = "O.S atualizada com sucesso!";

        } else {

            //nova o.s
            $sql = "INSERT INTO ordem_servico
                    (cliente_id, usuario_id, marca_id, modelo_id, ano, placa, km, pagamento, parcelas)
                    VALUES
                    ('$cliente', '$usuario_id', $marca_sql, $modelo_sql, $ano_sql, '$placa', $km_sql, '$pagamento', '$parcela')";
            $mysqli->query($sql);

            $os_id = $mysqli->insert_id;
            $mensagem = "O.S criada com sucesso!";
        }

        //itens tando para editar e abrir
        $total = 0;

        $quantidades = $_POST['quantidade'] ?? [];
        $valores     = $_POST['valor'] ?? [];

        foreach($quantidades as $produto_id => $quantidade){

            $produto_id = (int) $produto_id;
            $quantidade = (int) $quantidade;

            $valor = $valores[$produto_id] ?? 0;
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '.', $valor);
            $valor = (float) $valor;

            $total += $quantidade * $valor;

            $mysqli->query("INSERT INTO itens_os (os_id, produto_id, quantidade, valor_unitario)
                            VALUES ('$os_id', '$produto_id', '$quantidade', '$valor')");
        }

        $mysqli->query("UPDATE ordem_servico SET total = '$total' WHERE id = '$os_id'");

        unset($_SESSION['os']);
        $_SESSION['mensagem'] = $mensagem;
        header("Location: ../paginas/ordem-servico.php");
        exit;
    }

    //API 12 Encerrando a O.S
    if(isset($_POST['encerrar_os'])){

        $id_os = $_POST['os_id'];

        // Busca os produtos da O.S. junto com o estoque atual
        $sql = $mysqli->query("
            SELECT 
                itens_os.produto_id,
                itens_os.quantidade,
                produtos.nome,
                produtos.tipo,
                produtos.qntd
            FROM itens_os
            INNER JOIN produtos 
                ON produtos.id = itens_os.produto_id
            WHERE itens_os.os_id = $id_os
        ");

        // Primeiro verifica se existe estoque suficiente
        while ($item = $sql->fetch_assoc()) {

            // Serviço não usa estoque
            if ($item['tipo'] == 'Serviço') {
                continue;
            }

            // Se a quantidade da O.S. for maior que o estoque
            if ($item['quantidade'] > $item['qntd']) {

                $_SESSION['mensagem'] = 
                    "Não foi possível encerrar a O.S. O produto {$item['nome']} possui apenas {$item['qntd']} unidades em estoque.";

                header('Location: ../paginas/ordem-servico.php');
                exit;
            }
        }

        // Busca novamente os itens para diminuir o estoque
        $sql = $mysqli->query("
            SELECT 
                itens_os.produto_id,
                itens_os.quantidade,
                produtos.tipo
            FROM itens_os
            INNER JOIN produtos 
                ON produtos.id = itens_os.produto_id
            WHERE itens_os.os_id = $id_os
        ");

        while ($item = $sql->fetch_assoc()) {

            // Serviço não diminui estoque
            if ($item['tipo'] == 'Serviço') {
                continue;
            }

            $produto_id = $item['produto_id'];
            $quantidade = $item['quantidade'];

            // Diminui a quantidade do estoque
            $mysqli->query("
                UPDATE produtos
                SET qntd = qntd - $quantidade
                WHERE id = $produto_id
            ");
        }

        // Encerra a O.S.
        $mysqli->query("
            UPDATE ordem_servico
            SET status = 'Encerrada'
            WHERE id = $id_os
        ");

        $_SESSION['mensagem'] = "O.S encerrada com sucesso.";

        unset($_SESSION['os']);

        header('Location: ../paginas/ordem-servico.php');
        exit;
    }
    
    //API 13 Abrir cotação
    if (isset($_POST['abrir_encomenda'])) {

        // Pega o ID do produto enviado pelo botão
        $produto = (int) $_POST['abrir_encomenda'];

        // Consulta o produto
        $sql = 
        "
            SELECT * FROM produtos 
            WHERE id = $produto
        ";
        $resultado = mysqli_query($mysqli, $sql);

        // Verifica se o produto existe
        if ($resultado && mysqli_num_rows($resultado) > 0) {

            // Cria a cotação
            $sql = 
            "
                INSERT INTO cotacoes 
                (tipo, status)
                VALUES 
                ('Reposição de estoque', 'Aberta')
            ";

            if (mysqli_query($mysqli, $sql)) {

                // Guarda o ID da cotação criada
                $id_cotacao = mysqli_insert_id($mysqli);

                $_SESSION['mensagem'] = "Solicitação de encomenda criada com sucesso!";

                header("Location: ../paginas/estoque.php");
                exit;

            } else {
                die("Erro ao criar cotação: " . mysqli_error($mysqli));
            }

        } else {
            $_SESSION['mensagem'] = "Produto não encontrado.";
            header("Location: ../paginas/estoque.php");
            exit;
        }
    }
?>