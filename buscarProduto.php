<?php

include 'config.php';

$ocorrencia = $_POST['ocorrencia'];
$Id_produto = $_POST['Id_produto'];
$nome_produto = $_POST['nome_produto'];
$Id = 0;
$nome = "";

if($ocorrencia == 0){
     $buscarProduto = "SELECT nome_produto, Id_produto FROM produtos WHERE Id_produto =".$Id_produto;
     $resultBuscarProduto = $mysqli->query($buscarProduto);
    $arrayProduto = $resultBuscarProduto->fetch_array();


 
}else if($ocorrencia == 1){
    $buscarProduto = "SELECT nome_produto, Id_produto FROM produtos WHERE nome_produto LIKE '%".$nome_produto."%' ";
    $resultBuscarProduto = $mysqli->query($buscarProduto);
   $arrayProduto = $resultBuscarProduto->fetch_array();
}

$nome = $arrayProduto['nome_produto'];
$Id = $arrayProduto['Id_produto'];

?>


<input type="hidden" name="nome_produtos" id="nome_produtos" class="form-control" value="<?= $nome ?>">


<input type="hidden" name="Id_produtos" id="Id_produtos" class="form-control" value="<?= $Id ?>">
