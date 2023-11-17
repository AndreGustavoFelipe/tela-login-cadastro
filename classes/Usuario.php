<?php

require 'Conexao.php';
require 'Models/UsuarioModel.php';

class Usuario{

    private $erro;
    private $conexao;

    public function __construct()
    {
        $con = new Conexao();
        $this->conexao = $con->getConexao();
    }

    public function mapear($q)
    {

        $listaDeUsuarios = [];

        foreach ($q as $dados) {

            $usuario = new UsuarioModel();

            $usuario->usuario = $dados['usuario'];
            $usuario->senha = $dados['senha'];

            $listaDeUsuarios[] = $usuario;

        }

        return $listaDeUsuarios;

    }

    public function cadastrar($usuario){

        $sql = 
        "insert into cadastros(usuario, senha_hashed) 
        values(LOWER(:usuario), :senha);";

        $q = $this->conexao->prepare($sql);

        $q -> bindParam(":usuario", $usuario->usuario);
        $q -> bindParam(":senha", $usuario->senha);

        $q -> execute();

    }

    public function getErro(){

        return $this->erro;

    }

    public function login($usuario){

        $sql = "select * from cadastros where usuario = :usuario";
        
        $q = $this->conexao->prepare($sql);
        $q->bindParam(":usuario", $usuario->usuario);
        $q->execute();
    
        $row = $q->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            // Verificando se a senha fornecida é válida
            if (password_verify($usuario->senha, $row['senha_hashed'])) {
                return true; // Senha está correta
            } else {
                $this->erro = "  Senha incorreta!";
                return false; // Senha incorreta
            }
        } else {
            $this->erro = "  Usuario não encontrado!";
            return false; // Usuário não encontrado
        }
    }

}

?>