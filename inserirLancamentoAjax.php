<?php

include 'config.php';

$ocorrencia = $_POST['ocorrencia'];
$cod_lancamento = $_POST['cod_lancamento'];
$Id_produto = $_POST['Id_produto'];
$valor_lancamento = $_POST['valor_lancamento'];
$quantidade_lancamento = $_POST['quantidade_lancamento'];
$valor_total_lancamento = $_POST['valor_total_lancamento'];
$Id_sub_lancamento = $_POST['Id_sub_lancamento'];
$estoque = 0;

if($ocorrencia == 0){

    $buscarProduto = "SELECT estoque_produto FROM produtos WHERE Id_produto =".$Id_produto;
    $result = $mysqli->query($buscarProduto);
    $getEstoque = $result->fetch_array();

    $estoque = $getEstoque['estoque_produto'] + $quantidade_lancamento;

    $aleterarEstoque = "UPDATE produtos SET
                estoque_produto = ".$estoque.",
                entrada_produto = ".$valor_lancamento." WHERE Id_produto =".$Id_produto;
    $resultAlterarEstoque = $mysqli->query($aleterarEstoque);

    $inserirLancamento = "INSERT INTO sub_lancamentos SET 
                cod_sub_lancamento = '".$cod_lancamento."',
                Id_produto = ".$Id_produto.",
                valor_lancamento = ".$valor_lancamento.",
                quantidade_lancamento = ".$quantidade_lancamento.",
                valor_total_lancamento = ".$valor_total_lancamento." ";  
    $resultInserirLancamento = $mysqli->query($inserirLancamento) or die(mysqli_error());

    if ($resultInserirLancamento){
        echo 1;
    }else{
        echo $resultInserirLancamento;
    }

}else if($ocorrencia == 1){

    $buscarEstoque = "SELECT estoque_produto FROM produtos WHERE Id_produto=".$Id_produto;
    $resultBuscarEstoque = $mysqli->query($buscarEstoque);
    $arrayEstoque = $resultBuscarEstoque->fetch_array();

    $estoque = $arrayEstoque['estoque_produto'] - $quantidade_lancamento;

    $alterarEstoque = "UPDATE produtos SET 
                estoque_produto =".$estoque." WHERE Id_produto =".$Id_produto;
    $resultAlterarEstoque = $mysqli->query($alterarEstoque);

    $deleteSublancamento = "DELETE FROM sub_lancamentos WHERE Id_sub_lancamento =".$Id_sub_lancamento;
    $resultDeleteSubLancamento = $mysqli->query($deleteSublancamento);
}else if($ocorrencia == 2){
    
    $buscarSubLancamento = "SELECT * FROM sub_lancamentos";
    $resultBuscarSubLancamento = $mysqli->query($buscarSubLancamento);

    while($arrayLancamento = $resultBuscarSubLancamento->fetch_array()){
        $inserirLancamentoEfetivo = "INSERT INTO lancamentos SET
                cod_lancamento = ".$arrayLancamento['cod_sub_lancamento'].",
                Id_produto = ".$arrayLancamento['Id_produto'].",
                valor_lancamento = ".$arrayLancamento['valor_lancamento'].",
                quantidade_lancamento = ".$arrayLancamento['quantidade_lancamento'].",
                valor_total_lancamento = ".$arrayLancamento['valor_total_lancamento'].",
                data_lancamento = NOW() ";
        $resultInserirLancamentoEfetivo = $mysqli->query($inserirLancamentoEfetivo);
    }

    $deleteSub = "DELETE FROM sub_lancamentos";
    $resultDeleteSub = $mysqli->query($deleteSub);
}

?>