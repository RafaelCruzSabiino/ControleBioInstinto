<?php

include 'topo.php';

$buscarVendedor = "SELECT Id_vendedor, nome_vendedor FROM vendedor WHERE status_vendedor = 'ativado'";
$resultBuscarVendedor = $mysqli->query($buscarVendedor);

?>
<br>
<br>
<br>
<br>
<br>
<br>
<h1 class="text-center">Cadastrar Vendedor</h1>
<br>
<br>
<div class="container">
    <div class="row">
       <div class="col-sm-4"></div>
       <div class="col-sm-4">
            <label>Nome:</label>            
            <input type="text" name="nome_vendedor" id="nome_vendedor" class="form-control">            
       </div>
       <div class="col-sm-4"></div>
    </div>
    <br>
    <div class="row">
       <div class="col-sm-4"></div>
       <div class="col-sm-4">            
            <center><button type="button" class="btn btn-primary" onclick="cadVendedor(0, 0)">Cadastrar</button></center>                    
       </div>
       <div class="col-sm-4"></div>
    </div>   
    <br>
    <br> 
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Cod:</th>
                    <th>Nome:</th>
                </tr>
            </thead>
            <tbody>
                <?php while($arrayVendedor = $resultBuscarVendedor->fetch_array()) { ?>
                <tr>
                    <td><?= $arrayVendedor['Id_vendedor'] ?></td>
                    <td><?= utf8_encode($arrayVendedor['nome_vendedor']) ?></td>
                    <td><a data-toggle="modal" href='#modalVendedor'><button type="button" class="btn btn-primary" onclick="cadVendedor(1, <?= $arrayVendedor['Id_vendedor'] ?>)">Alterar</button></a></td>
                    <td><button type="button" class="btn btn-large btn-block btn-danger" onclick="cadVendedor(3, <?=  $arrayVendedor['Id_vendedor'] ?>)">Excluir</button></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
       </div>
       <div class="col-sm-3"></div>
    </div>

</div>

    <div class="modal fade" id="modalVendedor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alterar Vendedor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                
            </div>
            <div class="modal-body">
                <div id="return"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
                <button type="button" class="btn btn-primary" onclick="cadVendedor(2, 0)">Alterar</button>
            </div>
        </div>
    </div>
</div>






<script>

    function cadVendedor(ocorrencia, Id_vendedor){
        ocorrencia = ocorrencia;
        nome_vendedor = $('#nome_vendedor').val();
        Id_vendedor = Id_vendedor;

        if(nome_vendedor == "" && ocorrencia == 0){
            alert('Insira o nome do Vendedor!');
            return;
        }

        if(ocorrencia == 2){
            confirm = confirm('Deseja realmente Aletar o Vendedor?');
            if(confirm == false){
                location.reload();
                return;
            }
            Id_vendedor = $('#Id_vendedor').val();
            nome_vendedor = $('#nome_vendedores').val();
        }else if(ocorrencia == 3){

             confirm = confirm('Deseja Realmente excluir esse Vendedor?');
             if(confirm == false){
                 location.reload();
                 return;
             }
        }

    

        $.post(
            "inserirVendadorAjax.php",{
                nome_vendedor: nome_vendedor,
                ocorrencia: ocorrencia,
                Id_vendedor: Id_vendedor

            },function (data){
                if(data != 0 && ocorrencia == 0){
                    alert('Cliente Cadastrado com sucesso!');
                    location.reload();
                }else if(ocorrencia == 1){   
                    $('#return').html(data);                 
                }else if(ocorrencia == 2){
                    alert('Vendedor Alterado com Sucesso!');
                    location.reload();
                }else if(ocorrencia == 3){
                    alert('Vendedor Excluido com Sucesso!');
                    location.reload();
                }else{
                    alert('Erro');
                }
            }
        );
    }



</script>