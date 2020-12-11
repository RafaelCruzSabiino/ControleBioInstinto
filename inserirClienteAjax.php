<?php

include 'config.php';

$nome_cliente = $_POST['nome_cliente'];
$email_cliente = $_POST['email_cliente'];
$telefone_cliente = $_POST['telefone_cliente'];
$celular_cliente = $_POST['celular_cliente'];
$endereco_cliente = $_POST['endereco_cliente'];
$obs_cliente = $_POST['obs_cliente'];

$inserirCliente = "INSERT INTO clientes SET
            nome_cliente = '".utf8_decode($nome_cliente)."',
            email_cliente = '".utf8_decode($email_cliente)."', 
            telefone_cliente = '".$telefone_cliente."',
            celular_cliente = '".$celular_cliente."',
            endereco_cliente = '".utf8_decode($endereco_cliente)."',
            obs_cliente = '".utf8_decode($obs_cliente)."' ";
$returnInserirCliente = $mysqli->query($inserirCliente) or die(mysqli_error());

if($returnInserirCliente){
    echo 1;
}else{
    echo $returnInserirCliente;
}

?>