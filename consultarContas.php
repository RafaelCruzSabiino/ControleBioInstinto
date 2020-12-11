<?php

include 'topo.php';

?>
<br>
<br>
<br>
<br>
<br>
<br>
<h1 class="text-center">Consultar Contas</h1>
<br>
<br>
<div class="container">
    <div class="row">
          <div class="col-sm-2"> 
              <label><b><a class="portfolio-link" data-toggle="modal" href="#verificarCod2" style="color: black;"> Cod. Produto:</a></b></label>             
              <input type="number" name="Id_produto" id="Id_produto" class="form-control" value="" min="0" onchange="filtrarContas(0, 0, 0, 0)">             
          </div>
          <div class="col-sm-2">
              <label>NF:</label>              
              <input type="number" name="cod_lancamento" id="cod_lancamento" class="form-control" value="" min="0" onchange="filtrarContas(4, 0, 0, 0)">              
          </div>
          <div class="col-sm-4">
               <label>Data Inicio:</label>               
               <input type="date" name="data_inicio" id="data_inicio" class="form-control">               
          </div>
          <div class="col-sm-4">
               <label>Data Final:</label>               
               <input type="date" name="data_fim" id="data_fim" class="form-control" onchange="filtrarContas(1, 0, 0, 0)">  
          </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <div id="returnContas"></div>
        </div>
    </div>
</div>


<div class="modal fade" id="verificarCod2">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Produtos:</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>          
        </div>
        <div class="modal-body">
              <div class="container">
                <div class="row">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-8">
                      <label>Nome do Produto:</label>                       
                      <input type="text" name="clientes" id="produto_id" class="form-control" onchange="consultarCod(1)">                    
                  </div>
                  <div class="col-sm-2"></div>
                </div>
                <br>
                    <div id="returnCod">
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
        </div>
      </div>
    </div>
  </div>

  <script>

      function consultarCod(ocorrencia){

            ocorrencia = ocorrencia;
            clientes = $('#produto_id').val();

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


        function filtrarContas(ocorrencia, quantidade, Id_lancamento, Id_produto){
            ocorrencia = ocorrencia;
            quantidade = quantidade;
            Id_lancamento = Id_lancamento;
            data_inicio = $('#data_inicio').val();
            data_fim = $('#data_fim').val();
            cod_lancamento = $('#cod_lancamento').val();

            if(ocorrencia == 3){
                Id_produto = Id_produto;
                confirm = confirm('Deseja Realmente Excluir a Conta?');
                if(confirm == false){
                    location.reload();
                    return;
                }
            }else{
                Id_produto = $('#Id_produto').val();
            }

            if(Id_produto != "" && data_fim != "" && (ocorrencia == 1 || ocorrencia == 0)){
                ocorrencia = 2;
            }


            $.post(
                "filtrarContasAjax.php",{
                    ocorrencia: ocorrencia,
                    quantidade: quantidade,
                    Id_lancamento: Id_lancamento,
                    data_inicio: data_inicio,
                    data_fim: data_fim,
                    Id_produto: Id_produto,
                    cod_lancamento: cod_lancamento
                },function (data){
                    if(data != 0 && (ocorrencia == 0 || ocorrencia == 1 || ocorrencia == 2 || ocorrencia == 4)){
                        $('#returnContas').html(data);    
                        $('#tableInfo').DataTable({        
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    extend: 'pdfHtml5',
                                    download: 'open'
                                    
                                }
                            ]
                            
                        });                    
                    }else if(ocorrencia == 3){
                        alert('Venda Excluida com Sucesso!');
                        location.reload();
                    }else{
                        alert('Erro');
                    }
                }
            );
        }
        

  </script>