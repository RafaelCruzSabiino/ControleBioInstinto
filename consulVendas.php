<?php

include 'topo.php';

?>
<br>
<br>
<br>
<br>
<br>
<br>
<h1 class="text-center">Consultar Vendas</h1>   
<br>
<br>
<div class="container" id="pageVenda">
        <div class="row">
          <div class="col-sm-2"> 
              <label><b>Cod. Cliente:</b></label>             
              <input type="number" name="Id_cliente" id="Id_cliente" class="form-control" value="" min="0" onchange="buscarVenda(0, 0, 0, 0)">             
          </div>
          <div class="col-sm-1">
              <br>
              <a class="portfolio-link" data-toggle="modal" href="#verificarCod" style="color: black;">Consultar</a> 
          </div>
          <div class="col-sm-1"></div>
          <div class="col-sm-4">
              <label>Data Inicio:</label>              
              <input type="date" name="data_inicio" id="data_inicio" class="form-control">              
          </div>
          <div class="col-sm-4">
              <label>Data Final:</label>              
              <input type="date" name="data_fim" id="data_fim" class="form-control" onchange="buscarVenda(1, 0, 0, 0)">
          </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-sm-12">
                <div id="returnVendas"></div>
            </div>
        </div>
        <br>
        <br>
</div>
<div class="container" id="continuacao" style="display: none">
     <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <center>
            <button type="button" class="btn btn-primary" onclick="alterarVenda(1,0,0)">Voltar</button>
            </center>
        </div>
        <div class="col-sm-4"></div>
     </div>
     <br>
     <div id="returnVenda"></div>
</div>


<div id="return"></div>


<div class="modal fade" id="verificarCod">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Cliente:</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>          
        </div>
        <div class="modal-body">
              <div class="container">
                <div class="row">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-8">
                      <label>Nome do Cliente:</label>                       
                      <input type="text" name="clientes" id="clientes_id" class="form-control" onchange="consultarCod(0)">                    
                  </div>
                  <div class="col-sm-2"></div>
                </div>
                <br>
                    <div id="returnCod"></div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
        </div>
      </div>
    </div>
  </div>


  <script>
    //   function colocarText(Id_cliente){
    //       Id_clientes = Id_cliente;

    //       document.getElementById('Id_cliente').value= Id_clientes;

    //   }

      function consultarCod(ocorrencia){

        ocorrencia = ocorrencia;

        clientes = $('#clientes_id').val();

        $.post(
            "consulClienteAjax.php",{
            ocorrencia: ocorrencia,
            clientes: clientes.toString()
        },function (data){
            if(data != 0){
               $('#returnCod').html(data);          

            }else{
               alert('Erro');
            }
        }
    );
  }

      function buscarVenda(ocorrencia, Id_venda,  quantidade_venda, Id_produto){

          ocorrencia = ocorrencia;
          Id_venda = Id_venda;
          quantidade_venda = quantidade_venda;
          Id_produto = Id_produto;
          Id_cliente = $('#Id_cliente').val();
          data_inicio = $('#data_inicio').val();
          data_fim = $('#data_fim').val();


          if(Id_cliente != "" && data_fim != "" && (ocorrencia == 1 || ocorrencia == 0)){
              ocorrencia = 2 
          }

          if(ocorrencia == 3){
              confirm = confirm('Deseja Realmente Excluir a Venda?');
              if(confirm == false){
                  location.reload();
                  return;
              }

          }

          

          $.post(
              "filtrarVendas.php",{
                  ocorrencia: ocorrencia,
                  Id_venda: Id_venda,
                  quantidade_venda: quantidade_venda,
                  Id_produto: Id_produto,
                  Id_cliente: Id_cliente,
                  data_inicio: data_inicio,
                  data_fim: data_fim

              },function (data){
                  if(data != 0 && (ocorrencia == 0 || ocorrencia == 1  || ocorrencia == 2)){
                      $('#returnVendas').html(data);
                      $('#tableVendas').DataTable( {        
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    extend: 'pdfHtml5',
                                    download: 'open'
                                    
                                }
                            ]
                            
                        });
                  }else if(ocorrencia == 3){
                      alert('Venda excluida com Sucesso!');
                      location.reload();
                  }else{
                      alert('Erro');
                  }
              }
          );
      }


      function alterarVenda(ocorrencia, Id_venda){
          ocorrencia = ocorrencia;
          Id_venda = Id_venda;
          Id_cliente = 0;
          Id_produto = 0;
          tipo_venda = 0;
          quantidade_venda = 0;
          valor_venda = 0;
          total_novo = 0;

          if(ocorrencia == 1){
            $('#pageVenda').css({display: "block"});
            $('#continuacao').css({display: "none"});
            return;
          }

          if(ocorrencia == 2){
              Id_cliente = $('#Id_clientes').val();
              Id_produto = $('#Id_produto').val();
              tipo_venda = $('#tipo_venda').val();
              quantidade_venda = parseInt($('#quantidade_venda').val());
              valor_venda = parseFloat($('#valor_venda').val());          

          }

          if(ocorrencia == 10){
              quantidade_venda = parseInt($('#quantidade_venda').val());
              tipo_venda = $('#tipo_venda').val();
              Id_produto = $('#Id_produto').val();
          }

          $.post(
              "alterarVendaAjax.php",{
                  ocorrencia: ocorrencia,
                  Id_venda: Id_venda,
                  Id_cliente: Id_cliente,
                  Id_produto: Id_produto,
                  tipo_venda: tipo_venda.toString(),
                  quantidade_venda: quantidade_venda,
                  valor_venda: valor_venda

              },function(data){
                  if(data != 0 && ocorrencia == 0){
                      $('#pageVenda').css({display: "none"});
                      $('#continuacao').css({display: "block"});
                      $('#returnVenda').html(data);
                  }else if(data != 0 && ocorrencia == 10){
                      $('#return').html(data);
                      total_novo = document.getElementById('total_novo').value;
                      document.getElementById('valor_venda').value = total_novo;
                  }else if(ocorrencia == 2){
                      alert('Venda Alterada com Sucesso!');
                      location.reload();
                  }else{
                      alert('Erro');
                  }
              }
          );
      }



      



  </script>