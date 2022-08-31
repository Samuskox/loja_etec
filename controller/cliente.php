<?php
    header('Content-type: application/json');
    $dadosRecebidos = file_get_contents('php://input');

    $dadosRecebidos = json_decode($dadosRecebidos, true);

    require_once '../model/Cliente.php';
    if($dadosRecebidos['acao'] == 'cadastrar'){
        $adm = new Cliente();
        $adm->id = $dadosRecebidos['id'];
        $adm->email = $dadosRecebidos['email'];
        $adm->senha = $dadosRecebidos['senha'];
        $adm->nome = $dadosRecebidos['nome'];  
        $adm->endereco = $dadosRecebidos['endereco'];
        $adm->telefone = $dadosRecebidos['telefone'];

        $result = [
            'result' => $adm->cadastrar(),
            'dados' => $adm       
        ];
        echo json_encode($result);
    }
    elseif($dadosRecebidos['acao'] == 'consultarTodos'){
        $adm = new Cliente();
        $filtro = $dadosRecebidos['filtro'];
        $dados = $adm->consultarTodos($filtro);
        $result['result'] = false;                  
        $result['dados'] = "";                  
        if($dados){
            $result['result'] = true;
            $result['dados'] = $dados;
        }        
        echo json_encode($result);
    }
    elseif($dadosRecebidos['acao'] == 'consultarPorEmail'){
        $adm = new Cliente();
        $email = $dadosRecebidos['email'];        
        $result['result'] = false;                  
        $result['dados'] = "";                  
        if($adm->consultarPorEmail($email)){
            $result['result'] = true;
            $result['dados'] = $adm;
        }        
        echo json_encode($result);
    }
    elseif($dadosRecebidos['acao'] == 'consultarPorMatricula'){
        $adm = new Cliente();
        $id = $dadosRecebidos['id'];
        $result['result'] = false;                  
        $result['dados'] = "";                  
        if($adm->consultarPorMatricula($matric)){
            $result['result'] = true;
            $result['dados'] = $adm;
        }        
        echo json_encode($result);
    }
    elseif($dadosRecebidos['acao'] == 'logar'){
        $adm = new Cliente();
        $usuario = $dadosRecebidos['usuario'];
        $senha = $dadosRecebidos['senha'];
        $result['result'] = false;                  
        $result['dados'] = "";                  
        if($adm->login($usuario,$senha)){
            $result['result'] = true;
            $result['dados'] = $adm;
        }        
        echo json_encode($result);
    }elseif($dadosRecebidos['acao'] == 'deletar'){
        $adm = new Cliente();
        $adm->id = $dadosRecebidos['id'];
    }
