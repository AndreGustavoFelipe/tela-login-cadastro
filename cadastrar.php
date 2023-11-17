<?php

require 'classes/Usuario.php';

$u = new Usuario();
$usuario = new UsuarioModel();

if(isset($_POST['usuario']) && isset($_POST['senha'])){

    $usuario->usuario = trim($_POST['usuario']);
    $usuario->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    if($usuario->usuario == "" || $usuario->senha == ""){
        header(('Location: cadastrar.php'));
        exit;
    }

    else{

        $u->cadastrar($usuario);

        header('Location: index.php');
        exit;

    }
    
}
else{
    die("Dados do formulário não informados corretamente.");
}

?>