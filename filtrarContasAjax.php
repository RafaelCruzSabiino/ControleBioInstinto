<?php

include 'config.php';

$ocorrencia = $_POST['ocorrencia'];
$quantidade = $_POST['quantidade'];
$Id_lancamento = $_POST['Id_lancamento'];
$data_inicio = $_POST['data_inicio'];
$data_fim = $_POST['data_fim'];
$Id_produto = $_POST['Id_produto'];
$cod_lancamento = $_POST['cod_lancamento'];
$valor = 0;
$estoque = 0;
$data = "";
$data_certa = "";


if($ocorrencia == 0){

    if($Id_produto == ""){
        return;
    }

    $buscarContas = "SELECT p.nome_produto, l.valor_lancamento, l.quantidade_lancamento, l.valor_total_lancamento, l.data_lancamento, l.Id_lancamento, l.Id_produto, l.cod_lancamento FROM lancamentos l
                INNER JOIN produtos p ON l.Id_produto = p.Id_produto WHERE l.Id_produto =".$Id_produto." GROUP BY l.Id_lancamento ORDER BY l.Id_lancamento ASC";
    $resultBuscarContas = $mysqli->query($buscarContas);
    $resultBuscarContas2 = $mysqli->query($buscarContas);

}else if($ocorrencia == 1){

    $buscarContas = "SELECT p.nome_produto, l.valor_lancamento, l.quantidade_lancamento, l.valor_total_lancamento, l.data_lancamento, l.Id_lancamento, l.Id_produto, l.cod_lancamento FROM lancamentos l
    INNER JOIN produtos p ON l.Id_produto = p.Id_produto WHERE l.data_lancamento BETWEEN '".$data_inicio."' AND '".$data_fim."' GROUP BY l.Id_lancamento ORDER BY l.Id_lancamento ASC";
    $resultBuscarContas = $mysqli->query($buscarContas);
    $resultBuscarContas2 = $mysqli->query($buscarContas);

}else if($ocorrencia == 2){

    $buscarContas = "SELECT p.nome_produto, l.valor_lancamento, l.quantidade_lancamento, l.valor_total_lancamento, l.data_lancamento, l.Id_lancamento, l.Id_produto, l.cod_lancamento FROM lancamentos l
    INNER JOIN produtos p ON l.Id_produto = p.Id_produto WHERE l.Id_produto = ".$Id_produto." AND l.data_lancamento BETWEEN '".$data_inicio."' AND '".$data_fim."' GROUP BY l.Id_lancamento ORDER BY l.Id_lancamento ASC";
    $resultBuscarContas = $mysqli->query($buscarContas);
    $resultBuscarContas2 = $mysqli->query($buscarContas);

}else if($ocorrencia == 4){
    $buscarContas = "SELECT p.nome_produto, l.valor_lancamento, l.quantidade_lancamento, l.valor_total_lancamento, l.data_lancamento, l.Id_lancamento, l.Id_produto, l.cod_lancamento FROM lancamentos l
    INNER JOIN produtos p ON l.Id_produto = p.Id_produto WHERE l.cod_lancamento LIKE '".$cod_lancamento."'";
    $resultBuscarContas = $mysqli->query($buscarContas);
    $resultBuscarContas2 = $mysqli->query($buscarContas);

}else if($ocorrencia == 3){

    $buscarEstoque = "SELECT estoque_produto FROM produtos WHERE Id_produto=".$Id_produto;
    $resultBuscarEstoque = $mysqli->query($buscarEstoque);
    $arrayEstoque = $resultBuscarEstoque->fetch_array();

    $estoque = $arrayEstoque['estoque_produto'] - $quantidade;

    $alterarEstoque = "UPDATE produtos SET 
                estoque_produto =".$estoque." WHERE Id_produto =".$Id_produto;
    $resultAlterarEstoque = $mysqli->query($alterarEstoque);

    $excluirLancamento = "DELETE FROM lancamentos WHERE Id_lancamento =".$Id_lancamento;
    $resultExcluirLancamento = $mysqli->query($excluirLancamento);
}

while($arrayValor = $resultBuscarContas2->fetch_array()){
    $valor += $arrayValor['valor_total_lancamento'];
}

?>


<div class="table-responsive">
    <table class="display" id="tableInfo">
        <thead>
            <tr>
                <th>NF:</th>
                <th>Produto:</th>
                <th>Valor Un.:</th>
                <th>Quantidade:</th>
                <th>Valor Total:</th>
                <th>Data:</th>
            </tr>
        </thead>
        <tbody>
            <?php while($arrayContas = $resultBuscarContas->fetch_array()) { $data = $arrayContas['data_lancamento']; $data_certa = date('d/m/Y', strtotime($data))?>
            <tr ondblclick="filtrarContas(3, <?= $arrayContas['quantidade_lancamento'] ?>, <?= $arrayContas['Id_lancamento'] ?>, <?= $arrayContas['Id_produto'] ?>)">
                <td><?= $arrayContas['cod_lancamento'] ?></td>
                <td><?= utf8_encode($arrayContas['nome_produto']) ?></td>
                <td style="color: blue;">R$ <?= $arrayContas['valor_lancamento'] ?></td>
                <td style="color: green;"><?= $arrayContas['quantidade_lancamento'] ?></td>
                <td style="color: red;">R$ <?= $arrayContas['valor_total_lancamento'] ?></td>
                <td><?= $data_certa ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<br>
<div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <label>Valor Total:</label>        
        <input type="text" name="valor_total" id="valor_total" class="form-control" style="color: red;" value="R$ <?= $valor ?>">        
    </div>
    <div class="col-sm-4"></div>
</div>

