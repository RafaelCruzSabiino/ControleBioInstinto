<?php

include 'config.php';

$nome_vendedor = $_POST['nome_vendedor'];
$ocorrencia = $_POST['ocorrencia'];
$Id_vendedor = $_POST['Id_vendedor'];

if($ocorrencia == 0){
        $inserirVendedor = "INSERT INTO vendedor SET 
                    nome_vendedor = '".utf8_decode($nome_vendedor)."',
                    status_vendedor = '".'ativado'."' ";
        $resultInserirVendedor = $mysqli->query($inserirVendedor);

        if($resultInserirVendedor){
            echo 1;
        }else{
            echo $inserirVendedor;
        }

}else if($ocorrencia == 1){

    $buscarVendedor = "SELECT Id_vendedor, nome_vendedor FROM vendedor WHERE Id_vendedor = ".$Id_vendedor;
    $resultBuscarVendedor = $mysqli->query($buscarVendedor);
    $arrayVendedor = $resultBuscarVendedor->fetch_array();
?>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-2">
            <label>Cod.:</label>            
            <input type="text" name="Id_vendedor" id="Id_vendedor" class="form-control" value="<?= $arrayVendedor['Id_vendedor'] ?>" readonly>            
        </div>
        <div class="col-sm-4">
            <label>Nome:</label>            
            <input type="text" name="nome_vendedor" id="nome_vendedores" class="form-control" value="<?= utf8_encode($arrayVendedor['nome_vendedor']) ?>">            
        </div>
        <div class="col-sm-2"></div>
        <div class="col-sm-2"></div>
    </div>


<?php
}else if($ocorrencia == 2){
    $alterarVendedor = "UPDATE vendedor SET 
            nome_vendedor='".utf8_decode($nome_vendedor)."' WHERE Id_vendedor =".$Id_vendedor;
    $resultAlterarVendedor = $mysqli->query($alterarVendedor);
        

}else{

    $alterarStatus = "UPDATE vendedor SET 
            status_vendedor = '".'desativado'."' WHERE Id_vendedor =".$Id_vendedor; 
    $resultAlterarStatus = $mysqli->query($alterarStatus);
}

?>