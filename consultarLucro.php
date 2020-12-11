<?php

include 'topo.php';

?>
<br>
<br>
<br>
<br>
<br>
<br>
<h1 class="text-center">Consultar Lucro</h1>
<br>
<br>
<div class="container">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-4">
            <label>Data Inicio:</label>        
            <input type="date" name="data_inicio" id="data_inicio" class="form-control">        
        </div>
        <div class="col-sm-4">
            <label>Data Final:</label>        
            <input type="date" name="data_fim" id="data_fim" class="form-control" onchange="buscarLucro()"> 
        </div>
        <div class="col-sm-2"></div>
    </div>
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <div id="returnLucro"></div>
        </div>
    </div>
</div>




<script>

    function buscarLucro(){
        
        data_inicio = $('#data_inicio').val();
        data_fim = $('#data_fim').val();

        $.post(
            "buscarLucroAjax.php",{
                data_inicio: data_inicio,
                data_fim: data_fim
            },function (data){
                if(data != 0){
                    $('#returnLucro').html(data);
                }else{
                    alert('Erro');
                }
            } 
        );
    }


</script>