<?php

include 'config.php';

$data_inicio = $_POST['data_inicio'];
$data_fim = $_POST['data_fim'];
$valor_venda = 0;
$valor_conta = 0;
$lucro = 0;

$buscarVenda = "SELECT valor_venda FROM vendas WHERE data_venda BETWEEN '".$data_inicio."' AND '".$data_fim."' ";
$resultBuscarVenda = $mysqli->query($buscarVenda);

while($arrayVenda = $resultBuscarVenda->fetch_array()){

    $valor_venda += $arrayVenda['valor_venda'];
}

$buscarConta = "SELECT valor_total_lancamento FROM lancamentos WHERE data_lancamento BETWEEN '".$data_inicio."' AND '".$data_fim."' ";
$resultBuscarConta = $mysqli->query($buscarConta);

while($arrayConta = $resultBuscarConta->fetch_array()){

    $valor_conta += $arrayConta['valor_total_lancamento'];
}

    $lucro = $valor_venda - $valor_conta;

?>


<div class="row">
    <div class="col-sm-4">
        <label>Valor Vendas:</label>        
        <input type="text" name="valor_venda" id="valor_venda" class="form-control" style="color: green;" value="R$ <?= $valor_venda ?>">        
    </div>
    <div class="col-sm-4">
        <label>Valor Contas:</label>        
        <input type="text" name="valor_contas" id="valor_contas" class="form-control" style="color: red;" value="R$ <?= $valor_conta ?>">        
    </div>
    <div class="col-sm-4">
        <label>Lucro:</label>        
        <input type="text" name="lucro" id="lucro" class="form-control" style="color: blue;" value="R$ <?= $lucro ?>">        
    </div>
</div>