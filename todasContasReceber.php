<?php

include 'topo.php';
$valorTotal = 0;
$buscarConta = "SELECT c.nome_cliente, p.nome_produto, n.nome_vendedor, v.Id_cliente, v.valor_venda, v.quantidade_venda, v.data_venda, v.status_venda, v.Id_venda, v.tipo_venda FROM vendas v
            INNER JOIN clientes c ON v.Id_cliente = c.Id_cliente
            INNER JOIN produtos p ON v.Id_produto = p.Id_produto
            INNER JOIN vendedor n ON v.Id_vendedor = n.Id_vendedor WHERE v.status_venda = 'pagar' ";
$resultBuscarConta = $mysqli->query($buscarConta);
$getValor = $mysqli->query($buscarConta);

while($arrayValor = $getValor->fetch_array()){
    $valorTotal += $arrayValor['valor_venda'];
}


?>
<br>
<br>
<br>
<br>
<br>
<br>
<h1 class="text-center">Contas a Receber (Todas)</h1>
<br>
<br>
<div class="container">
<div class="table-responsive">
    <table class="display" id="tablePagarTodas">
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
            </tr>
        </tbody>
    </table>
</div>
</div>
<br>
<br>

<script>
$(document).ready( function () {
       $('#tablePagarTodas').DataTable({        
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                download: 'open'
                
            }
        ]
        
    });
    } );

</script>