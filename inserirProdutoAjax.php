<?php

include 'config.php';

$nome_produto = $_POST['nome_produto'];
$descricao_produto = $_POST['descricao_produto'];
$preco_produto = $_POST['preco_produto'];
$preco_varejo_produto = $_POST['preco_varejo_produto'];
$status_produto = 'ativado';


$inserirProduto = "INSERT INTO produtos SET 
            nome_produto = '".utf8_decode($nome_produto)."',  
            descricao_produto = '".utf8_decode($descricao_produto)."',
            preco_produto = ".$preco_produto.",
            preco_varejo_produto = ".$preco_varejo_produto.",
            status_produto = '".$status_produto."' ";
$resultInserirProduto = $mysqli->query($inserirProduto) or die(mysqli_error());

if($resultInserirProduto){
    echo 1;
}else{
    echo $resultInserirProduto;
}

?>