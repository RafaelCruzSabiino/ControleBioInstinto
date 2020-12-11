<?php

include 'config.php';

$ocorrencia = $_POST['ocorrencia'];
$Id_venda = $_POST['Id_venda'];
$Id_cliente = $_POST['Id_cliente'];
$Id_produto = $_POST['Id_produto'];
$tipo_venda = $_POST['tipo_venda'];
$quantidade_venda = $_POST['quantidade_venda'];
$valor_venda = $_POST['valor_venda'];
$total_novo = 0;
$preco_produto = 0;
$diferenca = 0; 
$estoque = 0;
$quantidade = 0;

if($ocorrencia == 0){

$buscarVenda = "SELECT c.nome_cliente, p.nome_produto, v.quantidade_venda, v.valor_venda, v.tipo_venda, v.Id_cliente, v.Id_produto, v.Id_venda FROM vendas v
        INNER JOIN clientes c ON v.Id_cliente = c.Id_cliente
        INNER JOIN produtos p ON v.Id_produto = p.Id_produto WHERE v.Id_venda = ".$Id_venda;
$resultBuscarVenda = $mysqli->query($buscarVenda);
$arrayVenda = $resultBuscarVenda->fetch_array();

$buscarCliente = "SELECT Id_cliente, nome_cliente FROM clientes GROUP BY nome_cliente ORDER BY nome_cliente";
$resultBuscarCliente = $mysqli->query($buscarCliente);

$buscarProduto = "SELECT Id_produto, nome_produto FROM produtos GROUP BY nome_produto ORDER BY nome_produto";
$resultBuscarProduto = $mysqli->query($buscarProduto);

?>

<div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-4">
        <label>Cliente:</label>        
        <select name="Id_clientes" id="Id_clientes" class="form-control">
            <option value="<?= $arrayVenda['Id_cliente'] ?>"><?= utf8_encode($arrayVenda['nome_cliente']) ?></option>
            <?php while($arrayCliente = $resultBuscarCliente->fetch_array()) { ?>
               <option value="<?= $arrayCliente['Id_cliente'] ?>"><?= utf8_encode($arrayCliente['nome_cliente']) ?></option>
            <?php }?>
        </select>    
    </div>
    <div class="col-sm-4">
        <label>Produto:</label>        
        <select name="Id_produto" id="Id_produto" class="form-control" onchange="alterarVenda(10, 0)">
            <option value="<?= $arrayVenda['Id_produto'] ?>"><?= utf8_encode($arrayVenda['nome_produto']) ?></option>
            <?php while($arrayProduto = $resultBuscarProduto->fetch_array()) { ?>
               <option value="<?= $arrayProduto['Id_produto'] ?>"><?= utf8_encode($arrayProduto['nome_produto']) ?></option>
            <?php }?>
        </select>    
    </div>
    <div class="col-sm-2"></div>
</div>
<br>
<div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-2">
        <label>Tipo:</label>        
        <select name="tipo_venda" id="tipo_venda" class="form-control" onchange="alterarVenda(10, 0)">
        <?php if($arrayVenda['tipo_venda'] == 'consumo'){?>
            <option value="<?= $arrayVenda['tipo_venda'] ?>"><?= $arrayVenda['tipo_venda'] ?></option>
            <option value="revenda">revenda</option>
        <?php }else{?>
            <option value="<?= $arrayVenda['tipo_venda'] ?>"><?= $arrayVenda['tipo_venda'] ?></option>
            <option value="consumo">consumo</option>
        <?php } ?>
        </select>    
    </div>
    <div class="col-sm-2">
        <label>Quantidade:</label>        
        <input type="number" name="quantidade_venda" id="quantidade_venda" class="form-control" value="<?= $arrayVenda['quantidade_venda'] ?>" min="0" onchange="alterarVenda(10, 0)">          
    </div>
    <div class="col-sm-4">
        <label>Valor Total:</label>        
        <input type="text" name="valor_venda" id="valor_venda" class="form-control" value="<?= $arrayVenda['valor_venda'] ?>" readonly>        
    </div>
    <div class="col-sm-2"></div>
</div>
<br>
<div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <center>
        <button type="button" class="btn btn-primary" onclick="alterarVenda(2, <?= $arrayVenda['Id_venda'] ?>)">Alterar</button>
        </center>
    </div>
    <div class="col-sm-4"></div>
</div>

<?php
}else if($ocorrencia == 10){
    if($tipo_venda == 'consumo'){
        $buscarProduto2 = "SELECT preco_produto FROM produtos WHERE Id_produto =".$Id_produto;
        $resultBuscarProduto2 = $mysqli->query($buscarProduto2);
        $arrayProduto2 = $resultBuscarProduto2->fetch_array();
        $preco_produto = $arrayProduto2['preco_produto'];
    }else{
        $buscarProduto2 = "SELECT preco_varejo_produto FROM produtos WHERE Id_produto =".$Id_produto;
        $resultBuscarProduto2 = $mysqli->query($buscarProduto2);
        $arrayProduto2 = $resultBuscarProduto2->fetch_array();
        $preco_produto = $arrayProduto2['preco_varejo_produto'];
    }

    $total_novo = $quantidade_venda * $preco_produto;
?>


<input type="hidden" name="total_novo" id="total_novo" class="form-control" value="<?= $total_novo ?>">

<?php
}else if($ocorrencia == 2){
    $selectEstoque = "SELECT quantidade_venda, Id_produto FROM vendas WHERE Id_venda =".$Id_venda;
    $resultSelectEstoque = $mysqli->query($selectEstoque);
    $arrayEstoque = $resultSelectEstoque->fetch_array();

    if($arrayEstoque['Id_produto'] == $Id_produto){

    $getEstoque = "SELECT estoque_produto, quantidade_produto FROM produtos WHERE Id_produto =".$Id_produto;
    $resultGetEstoque = $mysqli->query($getEstoque);
    $arrayGetEstoque = $resultGetEstoque->fetch_array();

    $diferenca = $quantidade_venda - $arrayEstoque['quantidade_venda'];

    $estoque = $arrayGetEstoque['estoque_produto'] - $diferenca;
    $quantidade = $diferenca + $arrayGetEstoque['quantidade_produto'];

    }else{

        $getEstoque = "SELECT estoque_produto, quantidade_produto FROM produtos WHERE Id_produto =".$Id_produto;
        $resultGetEstoque = $mysqli->query($getEstoque);
        $arrayGetEstoque = $resultGetEstoque->fetch_array();

        $estoque = $arrayGetEstoque['estoque_produto'] - $quantidade_venda;
        $quantidade = $arrayGetEstoque['quantidade_produto'] + $quantidade_venda;


        $getEstoque2 = "SELECT estoque_produto, quantidade_produto FROM produtos WHERE Id_produto =".$arrayEstoque['Id_produto'];
        $resultGetEstoque2 = $mysqli->query($getEstoque2);
        $arrayGetEstoque2 = $resultGetEstoque2->fetch_array();

        $estoque2 = $arrayGetEstoque2['estoque_produto'] + $arrayEstoque['quantidade_venda'];
        $quantidade2 = $arrayGetEstoque2['quantidade_produto'] - $arrayEstoque['quantidade_venda'];

        $aleterarEstoque2 = "UPDATE produtos SET 
            quantidade_produto = ".$quantidade2.",
            estoque_produto = ".$estoque2." WHERE Id_produto =".$arrayEstoque['Id_produto'];
        $resultAlterarEstoque2 = $mysqli->query($aleterarEstoque2);
    }

    $aleterarEstoque = "UPDATE produtos SET 
            quantidade_produto = ".$quantidade.",
            estoque_produto = ".$estoque." WHERE Id_produto =".$Id_produto;
    $resultAlterarEstoque = $mysqli->query($aleterarEstoque);

    $alterarVenda = "UPDATE vendas SET 
            Id_cliente = ".$Id_cliente.",
            Id_produto = ".$Id_produto.",
            valor_venda = ".$valor_venda.",
            quantidade_venda = ".$quantidade_venda.",
            tipo_venda = '".$tipo_venda."' WHERE Id_venda =".$Id_venda;
    $resultAlterarVenda = $mysqli->query($alterarVenda);
}

?>