<?php

include 'config.php';

$ocorrencia = $_POST['ocorrencia'];
$Id_venda = $_POST['Id_venda'];
$quantidade_venda = $_POST['quantidade_venda'];
$Id_produto = $_POST['Id_produto'];
$Id_cliente = $_POST['Id_cliente'];
$data_inicio = $_POST['data_inicio'];
$data_fim = $_POST['data_fim'];
$valor_total = 0;
$valor_pagar = 0;
$valor_pago = 0;
$estoque = 0;
$quantidade = 0;
$data_certa = "";
$data = "";


if($ocorrencia == 0){

    if($Id_cliente == ""){
        return;
    }

    $buscarVenda = "SELECT c.nome_cliente, p.nome_produto, n.nome_vendedor, v.quantidade_venda, v.valor_venda, v.data_venda, v.status_venda, v.Id_venda, v.Id_produto, v.tipo_venda FROM vendas v
            INNER JOIN clientes c ON v.Id_cliente = c.Id_cliente
            INNER JOIN produtos p ON v.Id_produto = p.Id_produto
            INNER JOIN vendedor n ON v.Id_vendedor = n.Id_vendedor WHERE v.Id_cliente =".$Id_cliente." GROUP BY v.Id_venda ORDER BY v.Id_venda ASC";
    $resultBuscarVenda = $mysqli->query($buscarVenda);
    $resultBuscarVenda2 = $mysqli->query($buscarVenda);

    $buscarPagar = "SELECT valor_venda FROM vendas WHERE status_venda = 'pagar' AND Id_cliente =".$Id_cliente;
    $resultBuscarPagar = $mysqli->query($buscarPagar);

    while($arrayPagar = $resultBuscarPagar->fetch_array()){
        $valor_pagar += $arrayPagar['valor_venda'];
    }

    while($arrayValor = $resultBuscarVenda2->fetch_array()){
        $valor_total += $arrayValor['valor_venda'];
    }

    $valor_pago = $valor_total - $valor_pagar;

?>


<div class="table-responsive">
    <table class="table table-hover"  id="tableVendas">
        <thead>
            <tr>
                <th>Vendedor:</th>
                <th>Cliente:</th>
                <th>Produto:</th>
                <th>Quant.:</th>
                <th>Valor:</th>
                <th>Tipo:</th>
                <th>Data:</th>
                <th>Status:</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php while($arrayVenda = $resultBuscarVenda->fetch_array()) { $data = $arrayVenda['data_venda']; $data_certa = date('d/m/Y', strtotime($data)) ?>
            <tr>
                <td><?= utf8_encode($arrayVenda['nome_vendedor']) ?></td>
                <td><?= utf8_encode($arrayVenda['nome_cliente']) ?></td>
                <td><?= utf8_encode($arrayVenda['nome_produto']) ?></td>
                <td style="color: green;"><?= $arrayVenda['quantidade_venda'] ?></td>
                <td style="color: blue;">R$ <?= $arrayVenda['valor_venda'] ?></td>
                <td><?= $arrayVenda['tipo_venda'] ?></td>
                <td><?= $data_certa ?></td>
                <td><?= $arrayVenda['status_venda'] ?></td>
                <td><a style="color: red;" onclick="buscarVenda(3, <?= $arrayVenda['Id_venda'] ?>, <?= $arrayVenda['quantidade_venda'] ?>, <?= $arrayVenda['Id_produto'] ?>)">Excluir</a></td>
                <td><a style="color: black;" onclick="alterarVenda(0, <?= $arrayVenda['Id_venda'] ?>)">Alterar</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<br>
<div class="row">
    <div class="col-sm-4">
        <label>Valor Total:</label>        
        <input type="text" name="valor_total" id="valor_total" class="form-control" style="color: green;" value="R$ <?= $valor_total ?>">        
    </div>
    <div class="col-sm-4">
        <label>Valor Pago:</label>        
        <input type="text" name="valor_pago" id="valor_pago" class="form-control" style="color: blue;" value="R$ <?= $valor_pago ?>">        
    </div>
    <div class="col-sm-4">
        <label>Valor à Pagar:</label>        
        <input type="text" name="valor_pagar" id="valor_pagar" class="form-control" style="color: purple;" value="R$ <?= $valor_pagar ?>">        
    </div>
</div>


<?php
}else if($ocorrencia == 1){

    $buscarVenda = "SELECT c.nome_cliente, p.nome_produto, n.nome_vendedor, v.quantidade_venda, v.valor_venda, v.data_venda, v.status_venda, v.Id_venda, v.Id_produto, v.tipo_venda FROM vendas v
            INNER JOIN clientes c ON v.Id_cliente = c.Id_cliente
            INNER JOIN produtos p ON v.Id_produto = p.Id_produto
            INNER JOIN vendedor n ON v.Id_vendedor = n.Id_vendedor WHERE v.data_venda BETWEEN '".$data_inicio."' AND '".$data_fim."' GROUP BY v.Id_venda ORDER BY v.Id_venda ASC";
    $resultBuscarVenda = $mysqli->query($buscarVenda);
    $resultBuscarVenda2 = $mysqli->query($buscarVenda);

    $buscarPagar = "SELECT valor_venda FROM vendas WHERE status_venda = 'pagar' AND data_venda BETWEEN '".$data_inicio."' AND '".$data_fim."'";
    $resultBuscarPagar = $mysqli->query($buscarPagar);

    while($arrayPagar = $resultBuscarPagar->fetch_array()){
        $valor_pagar += $arrayPagar['valor_venda'];
    }

    while($arrayValor = $resultBuscarVenda2->fetch_array()){
        $valor_total += $arrayValor['valor_venda'];
    }

    $valor_pago = $valor_total - $valor_pagar;



?>

<div class="table-responsive">
    <table class="table table-hover" id="tableVendas">
        <thead>
            <tr> 
                <th>Vendedor:</th>
                <th>Cliente:</th>
                <th>Produto:</th>
                <th>Quant.:</th>
                <th>Valor:</th>
                <th>Tipo:</th>
                <th>Data:</th>
                <th>Status:</th>
            </tr>
        </thead>
        <tbody>
            <?php while($arrayVenda = $resultBuscarVenda->fetch_array()) { $data = $arrayVenda['data_venda']; $data_certa = date('d/m/Y', strtotime($data))?>
            <tr>
                <td><?= utf8_encode($arrayVenda['nome_vendedor']) ?></td>
                <td><?= utf8_encode($arrayVenda['nome_cliente']) ?></td>
                <td><?= utf8_encode($arrayVenda['nome_produto']) ?></td>
                <td style="color: green;"><?= $arrayVenda['quantidade_venda'] ?></td>
                <td style="color: blue;">R$ <?= $arrayVenda['valor_venda'] ?></td>
                <td><?= $arrayVenda['tipo_venda'] ?></td>
                <td><?= $data_certa ?></td>
                <td><?= $arrayVenda['status_venda'] ?></td>
                <td><a style="color: red;" onclick="buscarVenda(3, <?= $arrayVenda['Id_venda'] ?>, <?= $arrayVenda['quantidade_venda'] ?>, <?= $arrayVenda['Id_produto'] ?>)">Excluir</a></td>
                <td><a style="color: yellow;" onclick="alterarVenda(0, <?= $arrayVenda['Id_venda'] ?>)">Alterar</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<br>
<div class="row">
    <div class="col-sm-4">
        <label>Valor Total:</label>        
        <input type="text" name="valor_total" id="valor_total" class="form-control" style="color: green;" value="R$ <?= $valor_total ?>">        
    </div>
    <div class="col-sm-4">
        <label>Valor Pago:</label>        
        <input type="text" name="valor_pago" id="valor_pago" class="form-control" style="color: blue;" value="R$ <?= $valor_pago ?>">        
    </div>
    <div class="col-sm-4">
        <label>Valor à Pagar:</label>        
        <input type="text" name="valor_pagar" id="valor_pagar" class="form-control" style="color: purple;" value="R$ <?= $valor_pagar ?>">        
    </div>
</div>


<?php
}else if($ocorrencia == 2){

    $buscarVenda = "SELECT c.nome_cliente, p.nome_produto, n.nome_vendedor, v.quantidade_venda, v.valor_venda, v.data_venda, v.status_venda, v.Id_venda, v.Id_produto, v.tipo_venda FROM vendas v
            INNER JOIN clientes c ON v.Id_cliente = c.Id_cliente
            INNER JOIN produtos p ON v.Id_produto = p.Id_produto
            INNER JOIN vendedor n ON v.Id_vendedor = n.Id_vendedor WHERE v.Id_cliente =".$Id_cliente." AND v.data_venda BETWEEN '".$data_inicio."' AND '".$data_fim."' GROUP BY v.Id_venda ORDER BY v.Id_venda ASC";
    $resultBuscarVenda = $mysqli->query($buscarVenda);
    $resultBuscarVenda2 = $mysqli->query($buscarVenda);

    $buscarPagar = "SELECT valor_venda FROM vendas WHERE status_venda = 'pagar' AND Id_cliente =".$Id_cliente." AND data_venda BETWEEN '".$data_inicio."' AND '".$data_fim."'";
    $resultBuscarPagar = $mysqli->query($buscarPagar);

    while($arrayPagar = $resultBuscarPagar->fetch_array()){
        $valor_pagar += $arrayPagar['valor_venda'];
    }

    while($arrayValor = $resultBuscarVenda2->fetch_array()){
        $valor_total += $arrayValor['valor_venda'];
    }

    $valor_pago = $valor_total - $valor_pagar;


?>

<div class="table-responsive">
    <table class="table table-hover" id="tableVendas">
        <thead>
            <tr>
                <th>Vendedor:</th>
                <th>Cliente:</th>
                <th>Produto:</th>
                <th>Quant.:</th>
                <th>Valor:</th>
                <th>Tipo:</th>
                <th>Data:</th>
                <th>Status:</th>
            </tr>
        </thead>
        <tbody>
            <?php while($arrayVenda = $resultBuscarVenda->fetch_array()) { $data = $arrayVenda['data_venda']; $data_certa = date('d/m/Y', strtotime($data))?>
            <tr>             
                <td><?= utf8_encode($arrayVenda['nome_vendedor']) ?></td>                  
                <td><?= utf8_encode($arrayVenda['nome_cliente']) ?></td>
                <td><?= utf8_encode($arrayVenda['nome_produto']) ?></td>
                <td style="color: green;"><?= $arrayVenda['quantidade_venda'] ?></td>
                <td style="color: blue;">R$ <?= $arrayVenda['valor_venda'] ?></td>
                <td><?= $arrayVenda['tipo_venda'] ?></td>
                <td><?= $data_certa ?></td>
                <td><?= $arrayVenda['status_venda'] ?></td>
                <td><a style="color: red;" onclick="buscarVenda(3, <?= $arrayVenda['Id_venda'] ?>, <?= $arrayVenda['quantidade_venda'] ?>, <?= $arrayVenda['Id_produto'] ?>)">Excluir</a></td>
                <td><a style="color: yellow;" onclick="alterarVenda(0, <?= $arrayVenda['Id_venda'] ?>)">Alterar</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<br>
<div class="row">
    <div class="col-sm-4">
        <label>Valor Total:</label>        
        <input type="text" name="valor_total" id="valor_total" class="form-control" style="color: green;" value="R$ <?= $valor_total ?>">        
    </div>
    <div class="col-sm-4">
        <label>Valor Pago:</label>        
        <input type="text" name="valor_pago" id="valor_pago" class="form-control" style="color: blue;" value="R$ <?= $valor_pago ?>">        
    </div>
    <div class="col-sm-4">
        <label>Valor à Pagar:</label>        
        <input type="text" name="valor_pagar" id="valor_pagar" class="form-control" style="color: purple;" value="R$ <?= $valor_pagar ?>">        
    </div>
</div>



<?php
}else if($ocorrencia == 3){

    $buscarEstoque = "SELECT estoque_produto, quantidade_produto FROM produtos WHERE Id_produto =".$Id_produto;
    $resultbuscarEstoque = $mysqli->query($buscarEstoque);
    $arrayEstoque = $resultbuscarEstoque->fetch_array();

   $estoque = $arrayEstoque['estoque_produto'] + $quantidade_venda;
   $quantidade = $arrayEstoque['quantidade_produto'] - $quantidade_venda;

   $alterarEstoque = "UPDATE produtos SET 
            estoque_produto = ".$estoque.",
            quantidade_produto = ".$quantidade." WHERE Id_produto =".$Id_produto;
   $resultAlterarEstoque = $mysqli->query($alterarEstoque);

   $excluirVenda = "DELETE FROM vendas WHERE Id_venda =".$Id_venda;
   $resultExcluirVenda = $mysqli->query($excluirVenda);

}
?>