<?php

include 'config.php';

$ocorrencia = $_POST['ocorrencia'];
$Id_cliente = $_POST['Id_cliente'];
$nome_cliente = $_POST['nome_clientes'];
$email_cliente = $_POST['email_clientes'];
$telefone_cliente = $_POST['telefone_clientes'];
$celular_cliente = $_POST['celular_clientes'];
$endereco_cliente = $_POST['endereco_clientes'];
$obs_cliente = $_POST['obs_clientes'];

if($ocorrencia == 1){

    $buscarClientes = "SELECT nome_cliente, email_cliente, telefone_cliente, celular_cliente, Id_cliente, obs_cliente, endereco_cliente  FROM clientes WHERE Id_cliente =".$Id_cliente;
    $resultBuscarClientes = $mysqli->query($buscarClientes) or die(mysqli_error());
    $arrayClientes = $resultBuscarClientes->fetch_array();

?>

<div class="container">    
    <input type="hidden" name="Id_clientes" id="Id_clientes" class="form-control" value="<?= $arrayClientes['Id_cliente'] ?>">
    
<div class="row">
        <div class="col-sm-6">
            <label><b>Nome:</b></label>            
            <input type="text" name="nome_cliente" id="nome_clientes" class="form-control" value="<?= utf8_encode($arrayClientes['nome_cliente']) ?>">            
        </div>
        <div class="col-sm-6">
        <label><b>E-mail:</b></label>            
            <input type="text" name="email_cliente" id="email_clientes" class="form-control" value="<?= utf8_encode($arrayClientes['email_cliente']) ?>">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-6">
            <label><b>Telefone:</b></label>            
            <input type="text" name="telefone_cliente" id="telefone_clientes" class="form-control" value="<?= $arrayClientes['telefone_cliente'] ?>">            
        </div>
        <div class="col-sm-6">
            <label><b>Celular:</b></label>            
            <input type="text" name="celular_cliente" id="celular_clientes" class="form-control" value="<?= $arrayClientes['celular_cliente'] ?>">
        </div>
    </div>
    <br>
    <div class="row">
       <div class="col-sm-12">
            <label><b>Endereço:</b></label>            
            <input type="text" name="endereco_cliente" id="endereco_clientes" class="form-control" value="<?= utf8_encode($arrayClientes['endereco_cliente']) ?>">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <label><b>Observação:</b></label>            
            <textarea name="obs_cliente" id="obs_clientes" class="form-control" rows="3"><?= utf8_encode($arrayClientes['obs_cliente']) ?></textarea>            
        </div>
    </div>
</div>

<?php
}else if($ocorrencia == 2){

    $alterarCliente = "UPDATE clientes SET 
                nome_cliente = '".utf8_decode($nome_cliente)."',
                email_cliente = '".utf8_decode($email_cliente)."',
                telefone_cliente = '".$telefone_cliente."',
                celular_cliente = '".$celular_cliente."',
                endereco_cliente = '".utf8_decode($endereco_cliente)."',
                obs_cliente = '".utf8_decode($obs_cliente)."' WHERE Id_cliente =".$Id_cliente;
    $resultAlterarCliente = $mysqli->query($alterarCliente);
}

?>