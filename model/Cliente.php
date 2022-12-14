<?php
require_once 'Conexao.php';
class Cliente{    
    public $id;	
    public $email;	
    public $senha;	
    public $nome;
    public $endereco;
    public $telefone;

    public function cadastrar(){
        $cx = new Conexao();
        $cmdSql = 'INSERT INTO cliente(id,	email,	senha,	nome,	endereco,	telefone	) VALUES (:id, :email, :senha, :nome, :endereco, :telefone)';
        $dados = [
            ':matricula' => $this->matricula, 
            ':email' => $this->email, 
            ':senha' => $this->criptografarSenha($this->senha), 
            ':nome' => $this->nome,
            ':endereco' => $this->endereco,
            ':telefone' => $this->telefone
        ];

        if($cx->insert($cmdSql,$dados)){
            return true;
        }
        else{
            return false;
        }
    }

    public function consultarTodos($filtro=''){
        $cx = new Conexao();
        $cmdSql = "SELECT * FROM cliente WHERE cliente.nome LIKE concat('%',:filtro,'%') OR cliente.id LIKE concat('%',:filtro,'%') OR cliente.email LIKE concat('%',:filtro,'%') OR cliente.endereco LIKE concat('%',:filtro,'%') OR cliente.telefone LIKE concat('%',:filtro,'%');";
        $dados = [
            ':filtro' => $filtro            ];
        $result = $cx->select($cmdSql,$dados);
        if($result){
            return $result->fetchAll(PDO::FETCH_CLASS, 'Cliente');
        }
        return false;        
    }

    public function consultarPorEmail($email){
        $cx = new Conexao();
        $cmdSql = "SELECT * FROM cliente WHERE cliente.email = :email;";
        $dados = [
            ':email' => $email            
        ];
        $result = $cx->select($cmdSql,$dados);
        if($result){
            $result->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
            $adm = $result->fetch();
            $this->id = $adm->id;
            $this->email = $adm->email;	
            $this->senha = $adm->senha;	
            $this->nome = $adm->nome;
            $this->endereco = $adm->endereco;
            $this->telefone = $adm->telefone;
            return true;
        }
        return false;        
    }

    public function consultarPorMatricula($id){
        $cx = new Conexao();
        $cmdSql = "SELECT * FROM cliente WHERE cliente.id = :i;";
        $dados = [
            ':i' => $id           
        ];
        $result = $cx->select($cmdSql,$dados);
        if($result){
            $result->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
            $adm = $result->fetch();
            $this->id = $adm->id;
            $this->email = $adm->email;	
            $this->senha = $adm->senha;	
            $this->nome = $adm->nome;
            $this->endereco = $adm->endereco;
            $this->telefone = $adm->telefone;
            return true;
        }
        return false;        
    }

    private function criptografarSenha($senha): string{
        return password_hash($senha,PASSWORD_BCRYPT,['cost' => 12]);
    }

    private function decriptografarSenha($senha, $criptografia):bool{
        return password_verify($senha, $criptografia);
    }

    public function login($usuario,$senha):bool{
        if($this->consultarPorEmail($usuario) or $this->consultarPorMatricula($usuario)){
            return $this->decriptografarSenha($senha,$this->senha);
        }
        return false;
    }

    public function deletar($id){
    $cx = new Conexao();
     $cmdSql = "DELETE * FROM cliente WHERE id=:id";
     $dados = [
        ':id' => $id           
    ];
    if($cx->delete($cmdSql,$dados)){
        return true;
    }
    else{
        return false;
    }
    }
}