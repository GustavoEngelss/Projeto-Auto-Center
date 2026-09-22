<?php 
    session_start();
    require_once "../conexao.php";

    //criando usuario 
    if(isset($_POST['create_usuario'])){
        //pega os dados do forulario e joga para a variavel 
        $nome = mysqli_real_escape_string($mysqli, trim($_POST['nome']));
        $usuario = mysqli_real_escape_string($mysqli, trim($_POST['email']));
        $senha = isset($_POST['senha']) ?mysqli_real_escape_string($mysqli, trim($_POST['senha'])) : '';

        //validação campo vazio
        if(empty($nome) || empty($usuario) || empty($senha)){
            $_SESSION['mensagem'] = 'Preencha todos os campos!';
            header('Location: ../paginas/usuarios.php');
            exit;
        }

        $sql = "INSERT INTO usuarios (nome, usuario, senha) VALUES ('$nome', '$usuario', '$senha')";

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

    //editando usuario 
    if(isset($_POST['update_usuario'])){
        $usuario_id = mysqli_real_escape_string($mysqli, $_POST['usuario_id']);

        //pega os dados do forulario e joga para o banco 
        $nome = mysqli_real_escape_string($mysqli, trim($_POST['nome']));
        $usuario = mysqli_real_escape_string($mysqli, trim($_POST['email']));
        $senha = isset($_POST['senha']) ?mysqli_real_escape_string($mysqli, trim($_POST['senha'])) : '';

        //validação campo vazio
        if(empty($nome) || empty($usuario) || empty($senha)){
            $_SESSION['mensagem'] = 'Preencha todos os campos!';
            header('Location: ../paginas/usuarios.php');
            exit;
        }
        $sql = "UPDATE usuarios SET nome='$nome', usuario='$usuario', senha='$senha' WHERE id_usuario='$usuario_id'";
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

    //deletando o usuario
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

    //adiionando cliente
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

    //pesquisa cliente
    if(isset($_POST['select_cliente'])){

        $_SESSION['cliente_pesquisa_realizada'] = true;
        $cliente = mysqli_real_escape_string($mysqli, trim($_POST['cliente']));

        $sql = "SELECT * FROM clientes
            WHERE id LIKE '$cliente'
            OR nome LIKE '%$cliente%'
            OR cpf LIKE '$cliente'
            OR telefone LIKE '$cliente'
        ";
        $sql_query = $mysqli->query($sql) or die("Erro na consulta! " . $mysqli->error);

        if($sql_query->num_rows == 0){
            $_SESSION['cliente_busca'] = [];
            $_SESSION['mensagem'] = 'Nenhum resultado encontrado!';
            header('Location: ../paginas/cliente.php');
            exit;
        }else{
            $clientes = [];
            
            while($clienteEncontrado = $sql_query->fetch_assoc()){
                $clientes[] = $clienteEncontrado;
            }

            $_SESSION['cliente_busca'] = $clientes;

            // Marca que acabou de fazer uma pesquisa
            $_SESSION['pesquisa_realizada'] = true;

            header('Location: ../paginas/cliente.php');
            exit;
        }
            
    }

    // pesquisa produto
    if(isset($_POST['busca_produto'])){

        //salva os campos para deixar no input 
        $_SESSION['busca_largura'] = $_POST['largura'] ?? '';
        $_SESSION['busca_perfil'] = $_POST['perfil'] ?? '';
        $_SESSION['busca_aro'] = $_POST['aro'] ?? '';
        $_SESSION['busca_pesquisa'] = $_POST['pesquisa'] ?? '';
        $_SESSION['busca_categoria'] = $_POST['categoria'] ?? '';
        $_SESSION['busca_codigo'] = $_POST['id'] ?? '';
        $_SESSION['busca_pagamento'] = $_POST['pagamento'] ?? '';
        $_SESSION['busca_parcelas'] = $_POST['parcelas'] ?? '';


        //pega os dados para fazer a pesquisa
        $id = mysqli_real_escape_string($mysqli, trim($_POST['id']));
        $largura = mysqli_real_escape_string($mysqli, trim($_POST['largura']));
        $perfil = mysqli_real_escape_string($mysqli, trim($_POST['perfil']));
        $aro = mysqli_real_escape_string($mysqli, trim($_POST['aro']));
        $pesquisa = mysqli_real_escape_string($mysqli, trim($_POST['pesquisa']));

        $medida = '';
        //salva a medida para a consulta, exemplo 175/65R14
        if($largura != '' && $perfil != '' && $aro != ''){
            $medida = $largura . '/' . $perfil . 'R' . $aro;
        }

        // Busca pelo ID
        if($id != ''){

            $sql = "SELECT * FROM produtos
                    WHERE id = '$id'";

        // Busca pela medida
        } elseif($medida != ''){

            $sql = "SELECT * FROM produtos
                    WHERE nome LIKE '%$medida%'";
        }elseif ($pesquisa != ''){

            $sql = "SELECT * FROM produtos
                WHERE nome like '%$pesquisa%'";
        
        // Nenhum campo preenchido
        } else {

            $_SESSION['produtos'] = [];
            $_SESSION['mensagem'] = 'Informe o código ou a medida do produto!';
            header('Location: ../paginas/orcamento.php');
            exit;
        }

        $sql_query = $mysqli->query($sql) or die("Erro na consulta! " . $mysqli->error);

        if($sql_query->num_rows == 0){

            $_SESSION['produtos'] = [];
            $_SESSION['mensagem'] = 'Nenhum resultado encontrado!';

        } else {

            $produto = [];

            while($produtoEncontrado = $sql_query->fetch_assoc()){
                $produto[] = $produtoEncontrado;
            }

            $_SESSION['produtos'] = $produto;
            $_SESSION['pesquisa_realizada'] = true;
        }
        
        header('Location: ../paginas/orcamento.php');
        exit;
    }

    //adicionando o cliente na OS
    if(isset($_POST['cliente_os'])){

        $_SESSION['cliente_pesquisa_realizada'] = true;
        $cliente = mysqli_real_escape_string($mysqli, trim($_POST['cliente']));

        $sql = "SELECT * FROM clientes
            WHERE id LIKE '$cliente'
            OR nome LIKE '%$cliente%'
            OR cpf LIKE '$cliente'
            OR telefone LIKE '$cliente'
        ";

        $sql_query = $mysqli->query($sql) or die("Erro na consulta! " . $mysqli->error);

        if($sql_query->num_rows == 0){
            $_SESSION['cliente_os'] = [];
            $_SESSION['mensagem'] = 'Nenhum resultado encontrado!';
            header('Location: ../modelo/abrir-os.php');
            exit;
        }else{
            $clientes = [];
            
            while($clienteEncontrado = $sql_query->fetch_assoc()){
                $clientes[] = $clienteEncontrado;
            }

            $_SESSION['cliente_busca'] = $clientes;

            // Marca que acabou de fazer uma pesquisa
            $_SESSION['pesquisa_realizada'] = true;

            header('Location: ../modelo/abrir-os.php');
            exit;
        }


    }

    //selecionando modelo do carro para por O.S
    $id_marca = $_GET['marca'];

    $sql = "SELECT id, nome
            FROM modelos
            WHERE marcas_id = $id_marca
            ORDER BY nome";

    $resultado = mysqli_query($mysqli, $sql);

    while ($modelo = mysqli_fetch_assoc($resultado)){
        echo "<option value='{$modelo['id']}'> {$modelo['nome']}</option>";
    }

?>