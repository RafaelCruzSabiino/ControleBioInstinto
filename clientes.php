<?php

include 'topo.php';

$buscarCliente = "SELECT nome_cliente, email_cliente, telefone_cliente, celular_cliente, Id_cliente FROM clientes ORDER BY nome_cliente ASC";
$resultBuscarCliente = $mysqli->query($buscarCliente) or die (mysqli_error());

?>
<br>
<br>
<br>
<br>
<br>
<br>
<h1 class="text-center">Clientes</h1>
<br>
<br>
<div class="container" id="antes">
   <div class="row">
       <div class="col-sm-4"></div>
       <div class="col-sm-4"><center>
       <a data-toggle="modal" href='#CadastrarClientes'><button type="button" class="btn btn-primary" style="width: 100%;">Incluir</button></a>
       </center></div>
       <div class="col-sm-4"></div>
   </div>
   <br>
   <br>
   <div class="row">
       <div class="col-sm-2"></div>
       <div class="col-sm-2"></div>
       <div class="col-sm-6"></div>
       <div class="col-sm-2"></div>
   </div>
   <br>
   <div class="row">
    <div class="table-responsive">
        <table class="display" id="table_id">
            <thead>
                <tr>
                    <th>Cod.:</th>
                    <th>Nome:</th>
                    <th>E-mail:</th>
                    <th>Telefone:</th>
                    <th>Celular:</th>
                </tr>
            </thead>
            <tbody>
                <?php while($arrayCliente = $resultBuscarCliente->fetch_array()) {?>
                <tr>
                    <td><?= $arrayCliente['Id_cliente'] ?></td>
                    <td onclick="consultarCliente(1, <?= $arrayCliente['Id_cliente'] ?>)"><?= utf8_encode($arrayCliente['nome_cliente']) ?></td>
                    <td><?= utf8_encode($arrayCliente['email_cliente']) ?></td>
                    <td><?= $arrayCliente['telefone_cliente'] ?></td>
                    <td><?= $arrayCliente['celular_cliente'] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
     </div>
     <br>
   </div>
</div>

<div class="container" id="depois" style="display: none;">
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4"><center>
        <button type="button" class="btn btn-primary" onclick="consultarCliente(3, 0)">Voltar</button>
        </center></div>
        <div class="col-sm-4"></div>
    </div>
    <br>
    <div id="infoCliente2"></div>
    <br>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4"><center>
        <button type="button" class="btn btn-danger" onclick="consultarCliente(2, 0)">Alterar Cliente</button>
        </center></div>
        <div class="col-sm-4"></div>
    </div>
    <br>
    <br>
</div>

<div class="modal fade" id="CadastrarClientes">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cadastrar Cliente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></div>
            <div class="modal-body">
                <div class="container" id="cadastro">
                    <div class="row">
                        <div class="col-sm-6">
                            <label><b>Nome:</b></label>            
                            <input type="text" name="nome_cliente" id="nome_cliente" class="form-control" placeholder="Nome Cliente">            
                        </div>
                        <div class="col-sm-6">
                        <label><b>E-mail:</b></label>            
                            <input type="text" name="email_cliente" id="email_cliente" class="form-control" placeholder="E-mail Cliente">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-4">
                            <label><b>Telefone:</b></label>            
                            <input type="text" name="telefone_cliente" id="telefone_cliente" class="form-control" placeholder="Telefone Cliente">            
                        </div>
                        <div class="col-sm-4">
                            <label><b>Celular:</b></label>            
                            <input type="text" name="celular_cliente" id="celular_cliente" class="form-control" placeholder="Celular Cliente">
                        </div>
                        <div class="col-sm-4">
                            <label><b>Endereço:</b></label>            
                            <input type="text" name="endereco_cliente" id="endereco_cliente" class="form-control" placeholder="Endereço Cliente">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12">
                            <label><b>Observação:</b></label>            
                            <textarea name="obs_cliente" id="obs_cliente" class="form-control" rows="3">Sem Observação</textarea>            
                        </div>
                    </div>
                    <br>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
                <button type="button" class="btn btn-primary" onclick="cadCliente()">Cadastrar</button>
            </div>
        </div>
    </div>
</div>





<script>

    $(document).ready( function () {
       $('#table_id').DataTable({        
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                download: 'open'
                
            }
        ]
        
    });
    } );

  function consultarCliente(ocorrencia, Id_cliente){
        ocorrencia = ocorrencia;
        nome_clientes = "";
        email_clientes = "";
        telefone_clientes = "";
        celular_clientes = "";
        endereco_clientes = "";
        obs_clientes = "";

        if(ocorrencia == 0){
            Id_cliente = $('#Id_cliente2').val();
        }else if(ocorrencia == 2){
            confirm = confirm('Deseja Realmente Alterar o Cliente?');
            if(confirm == false){
                location.reload();
                return;
            }
            Id_cliente = $('#Id_clientes').val();
            nome_clientes = $('#nome_clientes').val();
            email_clientes = $('#email_clientes').val();
            telefone_clientes = $('#telefone_clientes').val();
            celular_clientes = $('#celular_clientes').val();
            endereco_clientes = $('#endereco_clientes').val();
            obs_clientes = $('#obs_clientes').val();

        }else if(ocorrencia == 3){
            location.reload();
            return;
        }else{
            Id_cliente = Id_cliente;
        }

        $.post(
            "buscarClienteAjax.php",{
                ocorrencia: ocorrencia,
                Id_cliente: Id_cliente,
                nome_clientes: nome_clientes.toString(),
                email_clientes: email_clientes.toString(),
                telefone_clientes: telefone_clientes.toString(),
                celular_clientes: celular_clientes.toString(),
                endereco_clientes: endereco_clientes.toString(),
                obs_clientes: obs_clientes.toString()

            },function (data){
                if(ocorrencia == 1){
                    $('#antes').css({display: "none"});
                    $('#depois').css({display: "block"});
                    $('#infoCliente2').html(data);           
                }else if(ocorrencia == 2){
                    alert('Cliente Alterado Com Sucesso!');
                    location.reload();
                }else{
                    alert('Erro');
                }
            }
        );



    }


function cadCliente(){
    nome_cliente = $('#nome_cliente').val();
    email_cliente = $('#email_cliente').val();
    telefone_cliente = $('#telefone_cliente').val();
    celular_cliente = $('#celular_cliente').val();
    endereco_cliente = $('#endereco_cliente').val();
    obs_cliente = $('#obs_cliente').val();

    if(nome_cliente == ""){
        alert('Informar os Dados do Cliente!!!');
        return;
    }

    $.post(
        "inserirClienteAjax.php",{
           nome_cliente: nome_cliente.toString(),
           email_cliente: email_cliente.toString(),
           telefone_cliente: telefone_cliente.toString(),
           celular_cliente: celular_cliente.toString(),
           endereco_cliente: endereco_cliente.toString(),
           obs_cliente: obs_cliente.toString()            

        },function (data){
            if(data != 0){
                alert('Cliente Cadastrado com Sucesso!');
                location.reload();
            }else{
                alert('Erro');
            }
        }
    );
}



    
</script>