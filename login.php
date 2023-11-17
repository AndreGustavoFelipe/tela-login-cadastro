<?php

session_start();

require './classes/Usuario.php';

$u = new Usuario();

$usuario = new UsuarioModel();

if(isset($_POST['usuario']) && isset($_POST['senha'])){

    $usuario->usuario = trim($_POST['usuario']);
    $usuario->senha = trim($_POST['senha']);

    $result = $u->login($usuario);

    if($result){
        header('Location: pagInicial.html');
    }else{
        $_SESSION['login_error'] = $u->getErro();
        header('Location: index.php');
    }

}
else{
    die("Dados do formulário não recebidos corretamente.");
}


?>