<?php

include 'topo.php';

$buscarSubLancamento = "SELECT p.nome_produto, s.valor_lancamento, s.quantidade_lancamento, s.valor_total_lancamento, s.Id_sub_lancamento, s.Id_produto FROM sub_lancamentos s
            INNER JOIN produtos p ON p.Id_produto = s.Id_produto";
$resultBuscarSubLancamento = $mysqli->query($buscarSubLancamento) or die(mysqli_error());

$buscarCodNf = "SELECT cod_sub_lancamento FROM sub_lancamentos";
$resultBuscarCodNf = $mysqli->query($buscarCodNf);
$arrayInfo = $resultBuscarCodNf->fetch_array();

?>
<br>
<br>
<br>
<br>
<br>
<br>
<h1 class="text-center">Lançamento de Contas</h1>
<br>
<br>
<div class="container">
    <div class="row">
          <div class="col-sm-2">
          <label><b>Cod. NF:</b></label>             
              <input type="number" name="cod_lancamento" id="cod_lancamento" class="form-control" value="<?= $arrayInfo['cod_sub_lancamento'] ?>" min="0">
          </div>
          <div class="col-sm-2"> 
              <label><b>Cod. Produto:</b></label>             
              <input type="number" name="Id_produto" id="Id_produto" class="form-control" value="" min="0" onchange="buscarProduto(0)">             
          </div>
          <div class="col-sm-3">
               <label><a data-toggle="modal" href='#verificarCod2' style="color: black;">Nome Produto:</a></label>
               <input type="text" name="nome_produto" id="nome_produto" class="form-control" onchange="buscarProduto(1)">
          </div>
          <div class="col-sm-3">
              <label><b>Valor:</b></label>              
              <input type="text" name="valor_lancamento" id="valor_lancamento" class="form-control" value="0" onKeyPress="return(moeda(this,'.','.',event))">
          </div>
          <div class="col-sm-2">
              <label><b>Quantidade:</b></label>             
              <input type="number" name="quantidade_lancamento" id="quantidade_lancamento" class="form-control" value="0" min="0">
          </div>
    </div>
    <br>
    <div class="row">
          <div class="col-sm-4"></div>
          <div class="col-sm-4"> 
              <center>
              <button type="button" class="btn btn-primary" onclick="lancarProduto(0, 0, 0, 0)">Lançar</button>
              </center>             
          </div>
          <div class="col-sm-4"></div>
    </div>
    <br>
    <br>
    <div class="row" id="tabela" style="display: none;">
        
        <div class="table-responsive">
            <table class="display" id="table_sub_lancamento">
                <thead>
                    <tr>
                        <th>Produto:</th>
                        <th>Valor Unid.:</th>
                        <th>Quantidade:</th>
                        <th>Valor Total:</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($arraySubLancamento = $resultBuscarSubLancamento->fetch_array()) { ?>
                    <tr ondblclick="lancarProduto(1, <?= $arraySubLancamento['Id_sub_lancamento'] ?>, <?=$arraySubLancamento['Id_produto']?>, <?= $arraySubLancamento['quantidade_lancamento'] ?>)">
                        <td><?= utf8_encode($arraySubLancamento['nome_produto'])?></td>
                        <td><?= $arraySubLancamento['valor_lancamento'] ?></td>
                        <td><?= $arraySubLancamento['quantidade_lancamento'] ?></td>
                        <td><?= $arraySubLancamento['valor_total_lancamento'] ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
    <br>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4"><center>
        <button type="button" class="btn btn-primary" id="botaoEfetivar" style="display: none;" onclick="lancarProduto(2, 0, 0, 0)">Efetivar Lancamento</button>
        </center></div>
        <div class="col-sm-4"></div>
    </div>
    <br>
</div>


<div id="ruturnProduto">

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

            $(document).ready( function () {
               $('#table_sub_lancamento').DataTable( {        
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                download: 'open'
                
            }
        ]
        
    });
               if($('#cod_lancamento').val() != ""){
                   document.getElementById('cod_lancamento').setAttribute('readonly',true);
                   $('#botaoEfetivar').css({display: "block"});
                   $('#tabela').css({display: "block"});
               }
            } );

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


      function lancarProduto(ocorrencia, Id_sub_lancamento, Id_produto, quantidade_lancamento){
          ocorrencia = ocorrencia;
          cod_lancamento = $('#cod_lancamento').val();
          Id_produto = Id_produto;
          valor_lancamento = parseFloat($('#valor_lancamento').val());
          quantidade_lancamento = quantidade_lancamento;
          produtos = $('#nome_produtos').val();
          Id_sub_lancamento = Id_sub_lancamento;

          if(ocorrencia == 0){
            Id_produto = $('#Id_produto').val();
            quantidade_lancamento = parseInt($('#quantidade_lancamento').val());
            if(cod_lancamento == ""){
                  alert('Cod. NF não informado!');
                  return;
              }else if(Id_produto == "" || valor_lancamento == 0 || quantidade_lancamento == 0 || $('#nome_produto').val() == ""){
                  alert('Informe todos os dados!');
                  return;
              }
          }else if(ocorrencia == 1){
              confirm = confirm('Deseja Realmente Excluir esse Lançamento?');
              if(confirm == false){
                  location.reload();
                  return;
              }
          }else if(ocorrencia == 2){
              confirm = confirm('Deseja Efetivar o Lançamento?');
              if(confirm == false){
                  location.reload();
                  return;
              }
          }
          

          valor_total_lancamento = valor_lancamento * quantidade_lancamento;

          $.post(
              "inserirLancamentoAjax.php",{
                  ocorrencia: ocorrencia,
                  cod_lancamento: cod_lancamento,
                  Id_produto: Id_produto,
                  valor_lancamento: valor_lancamento,
                  quantidade_lancamento: quantidade_lancamento,
                  valor_total_lancamento: valor_total_lancamento,
                  Id_sub_lancamento: Id_sub_lancamento
              },function (data){
                  if(data != 0 && ocorrencia == 0){
                      alert('Pré-Lançamento Realizado com Sucesso!');
                      location.reload();
                  }else if(ocorrencia == 1){
                      location.reload();
                  }else if(ocorrencia == 2){
                      alert('Lançamento Realizado com Sucesso!');
                      location.reload();
                  }else{
                      alert('Erro');
                  }
              }
          );
      }

      function moeda(a, e, r, t) {
    let n = ""
      , h = j = 0
      , u = tamanho2 = 0
      , l = ajd2 = ""
      , o = window.Event ? t.which : t.keyCode;
    if (13 == o || 8 == o)
        return !0;
    if (n = String.fromCharCode(o),
    -1 == "0123456789".indexOf(n))
        return !1;
    for (u = a.value.length,
    h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
        ;
    for (l = ""; h < u; h++)
        -1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
    if (l += n,
    0 == (u = l.length) && (a.value = ""),
    1 == u && (a.value = "0" + r + "0" + l),
    2 == u && (a.value = "0" + r + l),
    u > 2) {
        for (ajd2 = "",
        j = 0,
        h = u - 3; h >= 0; h--)
            3 == j && (ajd2 += e,
            j = 0),
            ajd2 += l.charAt(h),
            j++;
            for (a.value = "",
        tamanho2 = ajd2.length,
        h = tamanho2 - 1; h >= 0; h--)
            a.value += ajd2.charAt(h);
        a.value += r + l.substr(u - 2, u)
    }
    return !1
}

     function buscarProduto(ocorrencia){
         ocorrencia = ocorrencia;
         Id_produto = $('#Id_produto').val();
         nome_produto = $('#nome_produto').val();

         $.post(
             "buscarProduto.php",{
                 ocorrencia: ocorrencia,
                 Id_produto: Id_produto,
                 nome_produto: nome_produto

             },function (data){
                 if(data != 0 && ocorrencia == 0){
                     $('#ruturnProduto').html(data);
                    nome_produtos = $('#nome_produtos').val();
                    document.getElementById('nome_produto').value = nome_produtos;
                 }else if(ocorrencia == 1){
                    $('#ruturnProduto').html(data);
                    nome_produtos = $('#nome_produtos').val();
                    document.getElementById('nome_produto').value = nome_produtos;
                    id_produtos = $('#Id_produtos').val();
                    document.getElementById('Id_produto').value = id_produtos;
                 }
             }
         );
     }



  </script>