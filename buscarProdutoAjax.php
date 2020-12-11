<?php

include 'config.php';

$ocorrencia = $_POST['ocorrencia'];
$Id_produto = $_POST['Id_produto'];
$nome_produto = $_POST['nome_produto'];
$descricao_produto = $_POST['descricao_produto'];
$preco_produto = $_POST['preco_produto'];
$preco_varejo_produto = $_POST['preco_varejo_produto'];
$entrada_produto = $_POST['entrada_produto'];


if($ocorrencia == 1){
    $status = "";
    $buscarProduto = "SELECT status_produto FROM produtos WHERE Id_produto =".$Id_produto;
    $resultBuscarProduto = $mysqli->query($buscarProduto);
    $getStatus = $resultBuscarProduto->fetch_array();

    if($getStatus['status_produto'] == 'ativado'){
        $status = 'desativado';

    }else{
        $status = 'ativado';
    }

    $alterarStatusProduto = "UPDATE produtos SET
            status_produto = '".$status."' WHERE Id_produto =".$Id_produto;
    $resultAlterarStatusProduto = $mysqli->query($alterarStatusProduto);


}else if($ocorrencia == 2){
     
    $buscarProduto = "SELECT nome_produto, preco_produto, preco_varejo_produto, entrada_produto, status_produto, descricao_produto, quantidade_produto, Id_produto FROM produtos WHERE Id_produto =".$Id_produto;
    $resultBuscarProduto = $mysqli->query($buscarProduto);
    $arrayProduto = $resultBuscarProduto->fetch_array();

?>

<div class="container">
    
    <input type="hidden" name="Id_produtos" id="Id_produtos" class="form-control" value="<?= $arrayProduto['Id_produto'] ?>">
    
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <label><b>Nome:</b></label>            
            <input type="text" name="nome_produto" id="nome_produto" class="form-control" value="<?= utf8_encode($arrayProduto['nome_produto']) ?>">            
        </div>
        <div class="col-sm-2"></div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <label><b>Descrição:</b></label>            
            <textarea name="descricao_produto" id="descricao_produto" class="form-control" rows="3"><?= utf8_encode($arrayProduto['descricao_produto']) ?></textarea>            
        </div>
        <div class="col-sm-2"></div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-2">
            <label><b>Preço:</b></label>            
            <input type="text" name="preco_produto" id="preco_produto" class="form-control" value="<?= $arrayProduto['preco_produto'] ?>" onKeyPress="return(moeda(this,'.','.',event))">            
        </div>
        <div class="col-sm-1"></div>
        <div class="col-sm-2">
            <label><b>Varejo:</b></label>            
            <input type="text" name="preco_varejo_produto" id="preco_varejo_produto" class="form-control" value="<?= $arrayProduto['preco_varejo_produto'] ?>" onKeyPress="return(moeda(this,'.','.',event))">            
        </div>
        <div class="col-sm-1"></div>
        <div class="col-sm-2">
            <label><b>Custo:</b></label>            
            <input type="text" name="entrada_produto" style="color: red;" id="entrada_produto" class="form-control" value="<?= $arrayProduto['entrada_produto'] ?>" onKeyPress="return(moeda(this,'.','.',event))">            
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>

<?php
}else if($ocorrencia == 3){

    $alterarProduto = "UPDATE produtos SET 
            nome_produto ='".utf8_decode($nome_produto)."',
            descricao_produto = '".utf8_decode($descricao_produto)."',
            preco_produto = ".$preco_produto.",
            preco_varejo_produto = ".$preco_varejo_produto.",
            entrada_produto = ".$entrada_produto." WHERE Id_produto =".$Id_produto;
    $resultAlterarProduto = $mysqli->query($alterarProduto);
}

?>


<script>

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


</script>