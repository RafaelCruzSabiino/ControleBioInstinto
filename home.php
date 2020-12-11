<?php

include 'config.php';

$buscarCliente = "SELECT nome_cliente, Id_cliente FROM clientes GROUP BY nome_cliente ORDER BY nome_cliente ASC";
$resultBuscarCliente = $mysqli->query($buscarCliente);
$resultBuscarCliente2 = $mysqli->query($buscarCliente);

$buscarProduto = "SELECT nome_produto, Id_produto FROM produtos GROUP BY nome_produto ORDER BY nome_produto ASC";
$resultBuscarProduto = $mysqli->query($buscarProduto);








?>

<style>
    
</style>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sistema de Gerenciamento</title>

</head>

<body id="page-top" style="background-color: #dcdcdc;">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="home.php">Sis. Gerenciamento</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav text-uppercase ml-auto">
        <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="vendas.php">Pedido de Vendas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" id="nav-item" href="receberContas.php"><b>Contas a Receber</b></a>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: white; text-transform: uppercase;">Consultas</a>
                <ul class="dropdown-menu" style="background-color: black;">
                   <li><a href="produtos.php">Produtos</a></li>
                   <li><a href="clientes.php">Clientes</a></li>
                   <li><a href="cadastroVendedor.php">Vendedor</a></li>
                </ul>
            </li>
            <ul></ul>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: white; text-transform: uppercase;"><b>Financeiro</b></a>
                <ul class="dropdown-menu" style="background-color: black;">
                    <li><a href="consulVendas.php">Consultar Vendas</a></li>
                    <li><a href="consultarContas.php">Consultar Contas</a></li>
                    <li><a href="lancamentoContas.php">Lançar Contas</a></li>
                    <li><a href="consultarLucro.php">Lucro</a></li>
                </ul>
            </li>
        </ul>
        <li></li>
      </div>
    </div>
  </nav>

  <!-- topo -->
  <header class="masthead" style="background-image: url('img/header-bg.jpg');">
    <div class="container">
      <div class="intro-text">
        <div class="intro-heading text-uppercase">Bem Vindo</div>
        <a class="btn btn-primary btn-xl text-uppercase js-scroll-trigger" href="vendas.php" style="background-color: black; border: 0;">Pedido de Venda</a>
      </div>
    </div>
  </header>


  <!-- Rodape -->
  <footer class="footer">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-12">
          <span class="copyright"><b>Copyright &copy; Rafael Sabino</b></span>
        </div>
      </div>
    </div>
  </footer>

<!-- fim -->
  


  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Contact form JavaScript -->
  <script src="js/jqBootstrapValidation.js"></script>
  <script src="js/contact_me.js"></script>

  <!-- Custom scripts for this template -->
  <script src="js/agency.min.js"></script>

</body>

</html>

