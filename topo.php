<?php

include 'config.php';

?>
<title>Sistema de Gerenciamento</title>   

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">S
<body id="page-top" style="background-color: #dcdcdc;">
    
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav" style="background-color: black;">
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
            <a class="nav-link js-scroll-trigger" href="receberContas.php">Contas a Receber</a>
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
        </ul>
        <ul></ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: white; text-transform: uppercase;">Financeiro</a>
                <ul class="dropdown-menu" style="background-color: black;">
                    <li><a href="consulVendas.php">Consultar Vendas</a></li>
                    <li><a href="consultarContas.php">Consultar Contas</a></li>
                    <li><a href="lancamentoContas.php">Lançar Contas</a></li>
                    <li><a href="consultarLucro.php">Lucro</a></li>
                </ul>
            </li>
        </ul>
        <li></li>
        </ul>
      </div>
    </div>
  </nav>


  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Contact form JavaScript -->
  <script src="js/jqBootstrapValidation.js"></script>
  <script src="js/contact_me.js"></script>

  <!-- Custom scripts for this template -->
  <script src="js/agency.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>