<?php

include 'topo.php';

$total = 0;
$i = 0;

$buscarContas = "SELECT c.nome_cliente, v.Id_cliente, SUM(v.valor_venda) as valor_venda FROM vendas v
INNER JOIN clientes c ON v.Id_cliente = c.Id_cliente WHERE v.status_venda = 'pagar' GROUP BY v.Id_cliente ORDER BY v.Id_cliente";
$resultBuscarContas = $mysqli->query($buscarContas);    



?>
<br>
<br>
<br>
<br>
<br>
<br>
<h1 class="text-center">Contas a Receber</h1>
<br>
<br>
<div class="container">
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
           <label id="label_pesquisa_nome">Pesquisar:</label>           
           <input type="text" name="pesquisa_nome" id="pesquisa_nome" class="form-control" onkeyup="buscarContas(12,0,0)">           
        </div>
        <div class="col-sm-2"><center>
        <br>
        <a href="todasContasReceber.php"><button type="button" class="btn btn-danger">Gerar Todas</button></a>
        </center></div>
        <div class="col-sm-2"></div>
    </div>
    <br>
    <br>
</div>
<div class="container" id="conta">
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-2">
        <label>Cod.:</label>  
    </div>
    <div class="col-sm-4">
        <label>Nome:</label> 
    </div>
    <div class="col-sm-2">
        <label>Valor:</label>   
    </div>
    <div class="col-sm-2"></div>
    <div class="col-sm-1"></div>
  </div>
<?php while($arrayConta = $resultBuscarContas->fetch_array()) {;?>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-2">          
            <input type="text" name="Id_cliente" id="Id_cliente" class="form-control" value="<?= $arrayConta['Id_cliente'] ?>">            
        </div>
        <div class="col-sm-4">           
            <input type="text" name="nome_cliente" id="nome_cliente" class="form-control" style="color: green;" value="<?= utf8_encode($arrayConta['nome_cliente']) ?>">
        </div>
        <div class="col-sm-2">         
            <input type="text" name="valor_venda" id="valor_venda" class="form-control" style="color: red;" value="R$ <?= utf8_encode($arrayConta['valor_venda']) ?>">          
        </div>
        <div class="col-sm-2">      
            <button type="button" class="btn btn-primary" onclick="buscarContas(0, <?= $arrayConta['Id_cliente'] ?>, 0)">Info</button></center> 
        </div>
    </div>
    <div class="col-sm-1"></div>
    <br>
<?php }?>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-4"><center><button type="button" class="btn btn-danger"  id="btnImprimir" style="display: none;" onclick="buscarContas(11,0,0)">Imprimir</button></center></div>
        <div class="col-sm-4"><center><button type="button" class="btn btn-primary" id="btnVoltar" style="display: none;" onclick="buscarContas(10,0,0)">Voltar</button></center></div>
        <div class="col-sm-2"></div>
    </div>
    <br>
    <div id="slogan" style="display: none;">
    <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-2">
                <label>Cod.:</label>  
            </div>
            <div class="col-sm-4">
                <label>Nome:</label> 
            </div>
            <div class="col-sm-2">
                <label>Valor:</label>   
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-1"></div>
    </div>
    </div>
    <div class="row">       
        <div class="col-sm-12">  
            <div id="returnContas"></div>
        </div>
    </div>
    <br>
</div>



<script>
    
    function buscarContas(ocorrencia, Id_cliente, Id_venda){
        Id_cliente5 = Id_cliente;
        Id_venda = Id_venda;
        ocorrencia = ocorrencia;
        pesquisa_nome = $('#pesquisa_nome').val();

        if(ocorrencia == 1){
            confirm = confirm('Deseja realmente Pagar a Venda?');
            if(confirm == false){
                location.reload();
                return;
            }
        }

        if(ocorrencia == 10){
            location.reload();
            return;
        }else if(ocorrencia == 11){
            $('#btnVoltar').css({display: 'none'});
            $('#btnImprimir').css({display: 'none'});
            window.print();
            $('#btnVoltar').css({display: 'block'});
            $('#btnImprimir').css({display: 'block'});
            return;
        }

        $.post(
            "buscarContaAjax.php",{
                ocorrencia: ocorrencia,
                Id_cliente5: Id_cliente5,
                Id_venda: Id_venda,
                pesquisa_nome: pesquisa_nome
            },function (data){
                if(data != 0 && ocorrencia == 0){
                   $('#returnContas').html(data);
                   $('#conta').css({display: 'none'});
                   $('#pesquisa_nome').css({display: 'none'});
                   $('#label_pesquisa_nome').css({display: 'none'});
                   $('#slogan').css({display: 'none'});
                   $('#btnVoltar').css({display: 'block'});
                   $('#btnImprimir').css({display: 'block'});  
                   $('#tablePagar').DataTable( {        
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'pdfHtml5',
                                download: 'open'
                                
                            }
                        ]
                        
                    });
                }else if(ocorrencia == 1){
                    alert('Venda Paga com Sucesso!');
                    location.reload();
                }else if(ocorrencia == 12){
                    $('#returnContas').html(data); 
                    $('#conta').css({display: 'none'});
                    $('#slogan').css({display: 'block'});
                }
            }
        );


    }



</script>
