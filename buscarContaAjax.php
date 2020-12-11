<?php

include 'config.php';

$ocorrencia = $_POST['ocorrencia'];
$Id_cliente = $_POST['Id_cliente5'];
$Id_venda = $_POST['Id_venda'];
$pesquisa_nome = $_POST['pesquisa_nome'];
$valorTotal = 0;
$status = "";
$data = "";
$data_certa = "";
$nome_pesquisa = "";

if($ocorrencia == 0){

$buscarConta = "SELECT c.nome_cliente, p.nome_produto, n.nome_vendedor, v.Id_cliente, v.valor_venda, v.quantidade_venda, v.data_venda, v.status_venda, v.Id_venda, v.tipo_venda FROM vendas v
            INNER JOIN clientes c ON v.Id_cliente = c.Id_cliente
            INNER JOIN produtos p ON v.Id_produto = p.Id_produto
            INNER JOIN vendedor n ON v.Id_vendedor = n.Id_vendedor WHERE v.status_venda = 'pagar' AND v.Id_cliente =".$Id_cliente;
$resultBuscarConta = $mysqli->query($buscarConta);
$resultBuscarConta2 = $mysqli->query($buscarConta);
$resultBuscarConta3 = $mysqli->query($buscarConta);

$getVenda = $resultBuscarConta3->fetch_array();

$nome_pesquisa = utf8_encode($getVenda['nome_cliente']);

while($arrayValor = $resultBuscarConta2->fetch_array()){

      $valorTotal += $arrayValor['valor_venda'];
}

?>
<br>
<div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">         
           <input type="text" name="pesquisa_nome" id="pesquisa_nome" class="form-control" value="<?= $nome_pesquisa ?>">           
        </div>
        <div class="col-sm-4"></div>
    </div>
    <br>
    <br>
<div class="table-responsive">
    <table class="display" id="tablePagar">
        <thead>
            <tr>
                <th>Vendedor:</th>
                <th>Cod Cli.:</th>
                <th>Nome:</th>
                <th>Produto:</th>
                <th>Valor:</th>
                <th>Quant.:</th>
                <th>Tipo:</th>
                <th>Data:</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php while($arrayConta = $resultBuscarConta->fetch_array()) { $data = $arrayConta['data_venda']; $data_certa = date('d/m/Y', strtotime($data))?>
            <tr>                    
                <td><?= utf8_encode($arrayConta['nome_vendedor']) ?></td>
                <td><?= $arrayConta['Id_cliente'] ?></td>
                <td><?= utf8_encode($arrayConta['nome_cliente']) ?></td>
                <td><?= utf8_encode($arrayConta['nome_produto']) ?></td>
                <td style="color: blue;">R$ <?= $arrayConta['valor_venda'] ?></td>
                <td style="color: green;"><?= $arrayConta['quantidade_venda'] ?></td>
                <td><?= $arrayConta['tipo_venda'] ?></td>
                <td><?= $data_certa ?></td>
                <td><a style="color: red;" onclick="buscarContas(1, <?= $arrayConta['Id_cliente']?>, <?= $arrayConta['Id_venda'] ?>)">Pagar</a></td>
            </tr>
            <?php } ?>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th style="color: purple;">Valor Total:</th>
                <th style="color: red;">R$ <?= $valorTotal ?></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tbody>
    </table>
</div>
<br>
<div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <label><b>Valor à Pagar:</b></label>        
        <input type="text" name="" id="input" class="form-control" style="color: red;" value="R$ <?= $valorTotal ?>">        
    </div>
    <div class="col-sm-4">   
        <br>     
        <button type="button" class="btn btn-danger" onclick="buscarContas(1, <?= $getVenda['Id_cliente']?>, 0)">Pagar</button>        
    </div>
</div>


<?php
}else if($ocorrencia == 1){
   if($Id_venda == 0){
       $status = 'pago';
       $alterarVenda = "UPDATE vendas SET 
                status_venda = '".$status."' WHERE Id_cliente =".$Id_cliente;
        $resultAlterarVenda = $mysqli->query($alterarVenda);
   }else{
    $status = 'pago';
    $alterarVenda = "UPDATE vendas SET 
             status_venda = '".$status."' WHERE Id_cliente =".$Id_cliente." AND Id_venda =".$Id_venda;
     $resultAlterarVenda = $mysqli->query($alterarVenda);
   }

}else if($ocorrencia == 12){
    $buscarCliente = "SELECT c.nome_cliente, v.Id_cliente, SUM(v.valor_venda) as valor_venda FROM vendas v
                INNER JOIN clientes c ON v.Id_cliente = c.Id_cliente WHERE v.status_venda = 'pagar' AND c.nome_cliente LIKE '%".$pesquisa_nome."%' GROUP BY v.Id_cliente ORDER BY v.Id_cliente";
    $resultBuscarCliente = $mysqli->query($buscarCliente);


?>

<?php while($arrayCliente = $resultBuscarCliente->fetch_array()) { ?>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-2">        
            <input type="text" name="Id_cliente" id="Id_cliente" class="form-control" value="<?= $arrayCliente['Id_cliente'] ?>">            
        </div>
        <div class="col-sm-4">            
            <input type="text" name="nome_cliente" id="nome_cliente" class="form-control" style="color: green;" value="<?= utf8_encode($arrayCliente['nome_cliente']) ?>">
        </div>
        <div class="col-sm-2">         
            <input type="text" name="valor_vendas" id="valor_vendas" class="form-control" style="color: red;" value="R$ <?= utf8_encode($arrayCliente['valor_venda']) ?>">          
        </div>
        <div class="col-sm-2">      
            <button type="button" class="btn btn-primary" onclick="buscarContas(0, <?= $arrayCliente['Id_cliente'] ?>, 0)">Info</button></center> 
        </div>
    </div>
    <div class="col-sm-1"></div>
    <br> 
<?php } ?>

<?php
}
?>

