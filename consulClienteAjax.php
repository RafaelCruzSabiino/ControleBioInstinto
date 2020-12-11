<?php  

include 'config.php';

$ocorrencia = $_POST['ocorrencia'];
$cliente = $_POST['clientes'];

if($ocorrencia == 0){

$buscarCliente = "SELECT Id_cliente, nome_cliente FROM clientes WHERE nome_cliente LIKE '%".$cliente."%' ";
$resultBuscarCliente = $mysqli->query($buscarCliente);




?>

<?php while($getCod = $resultBuscarCliente->fetch_array()) { ?>
<div class="row">
   <div class="col-sm-2">
       <label>Cod:</label>
      <input type="text" name="clientes" id="clientes" class="form-control" value="<?= $getCod['Id_cliente'] ?>" readonly>
   </div>
   <div class="col-sm-8">
       <label>Nome:</label>
       <input type="text" name="nome" id="nome" class="form-control" value="<?= utf8_encode($getCod['nome_cliente']) ?>" readonly>
   </div>
   <div class="col-sm-1"> 
        <!-- <br>      
        <button type="button" class="btn btn-primary" onclick="colocarText(<?= $getCod['Id_cliente'] ?>)">+</button>      -->
   </div>
   <div class="col-sm-1"></div>
</div>
<br>
<?php } ?>


<?php
}else if($ocorrencia == 1){
    $buscarCliente = "SELECT Id_produto, nome_produto FROM produtos WHERE nome_produto LIKE '%".$cliente."%' ";
    $resultBuscarCliente = $mysqli->query($buscarCliente);



?>

<?php while($getCod = $resultBuscarCliente->fetch_array()) { ?>
<div class="row">
   <div class="col-sm-2">
       <label>Cod:</label>
      <input type="text" name="clientes" id="clientes" class="form-control" value="<?= $getCod['Id_produto'] ?>" readonly>
   </div>
   <div class="col-sm-10">
       <label>Nome:</label>
       <input type="text" name="nome" id="nome" class="form-control" value="<?= utf8_encode($getCod['nome_produto']) ?>" readonly>
   </div>
</div>
<br>
<?php } ?>




<?php
}

?>

