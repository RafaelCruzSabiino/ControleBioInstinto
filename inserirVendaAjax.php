<?php

include 'config.php';

$ocorrencia = $_POST['ocorrencia'];
$Id_cliente = $_POST['Id_cliente'];
$Id_vendedor = $_POST['Id_vendedor'];
$Id_produto = $_POST['Id_produto'];
$quantidade_venda = $_POST['quantidade_venda'];
$Id_venda = $_POST['Id_venda'];
$status_venda = $_POST['status_venda'];
$tipo_venda = $_POST['tipo_venda'];
$nome_cliente = $_POST['nome_cliente'];
$quantidade = 0;
$valor_venda = 0;
$valor_total = 0;
$quantidade_produto = 0;
$quantidade_total = 0;
$vendida = 0;
$estoque = 0;


if($ocorrencia == 6 || $ocorrencia == 7){
    if($ocorrencia == 6){
        $buscarCliente = "SELECT Id_cliente, nome_cliente FROM clientes WHERE Id_cliente =".$Id_cliente;
        $resultBuscarCliente = $mysqli->query($buscarCliente);
        
    }else{
        $buscarCliente = "SELECT Id_cliente, nome_cliente FROM clientes WHERE nome_cliente LIKE '%".$nome_cliente."%' ";
        $resultBuscarCliente = $mysqli->query($buscarCliente);
    }

    $arrayCliente = $resultBuscarCliente->fetch_array();
?>

<input type="hidden" name="nome_clientes" id="nome_clientes" class="form-control" value="<?= $arrayCliente['nome_cliente'] ?>">
<input type="hidden" name="Id_clientes" id="Id_clientes" class="form-control" value="<?= $arrayCliente['Id_cliente'] ?>">


<?php
}else if($ocorrencia == 1){

    $buscarProduto = "SELECT quantidade_produto, preco_produto, preco_varejo_produto, estoque_produto FROM produtos WHERE Id_produto =".$Id_produto;
    $resultBuscarProduto = $mysqli->query($buscarProduto);
    $arrayProduto = $resultBuscarProduto->fetch_array();

    $quantidade = $arrayProduto['quantidade_produto'] + $quantidade_venda;
    $estoque = $arrayProduto['estoque_produto'] - $quantidade_venda;

    $altararProduto = "UPDATE produtos SET 
                quantidade_produto = ".$quantidade.",
                estoque_produto = ".$estoque." WHERE Id_produto =".$Id_produto;
    $resultAlterarProduto = $mysqli->query($altararProduto);

    if($tipo_venda == 'consumo'){
        $valor_venda = $arrayProduto['preco_produto'] * $quantidade_venda;
    }else{
        $valor_venda = $arrayProduto['preco_varejo_produto'] * $quantidade_venda;
    }

    $inserirSubVenda = "INSERT INTO sub_venda SET 
                Id_vendedor = ".$Id_vendedor.",
                Id_cliente = ".$Id_cliente.",
                Id_produto = ".$Id_produto.",
                quantidade_venda = ".$quantidade_venda.",
                valor_venda = ".$valor_venda.",
                tipo_venda = '".$tipo_venda."' ";
    $resultInserirVenda = $mysqli->query($inserirSubVenda);

}else if($ocorrencia == 3){

    $buscarVenda3 = "SELECT quantidade_venda FROM sub_venda WHERE Id_sub_venda =".$Id_venda;
    $resultBuscarVenda3 = $mysqli->query($buscarVenda3);
    $arrayVenda3 = $resultBuscarVenda3->fetch_array();
    $vendida = $arrayVenda3['quantidade_venda'];

    $buscarProduto = "SELECT quantidade_produto, estoque_produto FROM produtos WHERE Id_produto =".$Id_produto;
    $resultBuscarProduto = $mysqli->query($buscarProduto);
    $arrayProduto = $resultBuscarProduto->fetch_array();
    $quantidade_produto = $arrayProduto['quantidade_produto'];

    $quantidade_produto = $quantidade_produto - $vendida;
    $estoque = $arrayProduto['estoque_produto'] + $vendida;

    $alterarQuantidade ="UPDATE produtos SET 
                    quantidade_produto = ".$quantidade_produto.",
                    estoque_produto = ".$estoque." WHERE Id_produto =".$Id_produto;
    $resultAlterarQauntidade = $mysqli->query($alterarQuantidade);



    $excluirVenda = "DELETE FROM sub_venda WHERE Id_sub_venda =".$Id_venda;
    $resultExcluirVenda = $mysqli->query($excluirVenda);


}else if($ocorrencia == 4){


    $buscarSubVenda = "SELECT Id_vendedor, Id_cliente, Id_produto, valor_venda, quantidade_venda, tipo_venda FROM sub_venda";
    $resultBuscarSubVenda = $mysqli->query($buscarSubVenda);

    while($arraySubVenda = $resultBuscarSubVenda->fetch_array()){
        $inserirVenda = "INSERT INTO vendas SET 
                Id_vendedor = ".$arraySubVenda['Id_vendedor'].",
                Id_cliente = ".$arraySubVenda['Id_cliente'].",
                Id_produto = ".$arraySubVenda['Id_produto'].",
                valor_venda = ".$arraySubVenda['valor_venda'].",
                quantidade_venda = ".$arraySubVenda['quantidade_venda'].",
                data_venda = NOW(),
                status_venda = '".$status_venda."',
                tipo_venda = '".$arraySubVenda['tipo_venda']."'  ";
        $resultInserirVenda = $mysqli->query($inserirVenda);
    }


    $exluirSubVenda = "DELETE FROM sub_venda ";
    $resultEcxluirVenda = $mysqli->query($exluirSubVenda);

}else if($ocorrencia == 5){
    $buscarProduto = "SELECT estoque_produto FROM produtos WHERE Id_produto =".$Id_produto; 
    $resultBuscarProduto = $mysqli->query($buscarProduto);

    $getProduto = $resultBuscarProduto->fetch_array();

?>


<input type="hidden" name="estoque_produto" id="estoque_produto" class="form-control" value="<?= $getProduto['estoque_produto'] ?>">


<?php
}

?>