<!DOCTYPE html>

<html>
<head>
   <link href="css/css_menu.css" type="text/css" rel="stylesheet">
</head>
<body>

<?php
require_once($_SERVER['DOCUMENT_ROOT']."/SA_Senai/base/pipoteca.php");
if (isset($_SESSION["nivel"])) {
  $nivel = $_SESSION["nivel"];
  $Email = $_SESSION["email"];
  $Usuario = $_SESSION['nome_usuario'];
  //echo 'Bom dia, '.$Usuario.' nivel:'.$nivel;
}else{
  header("Location: /SA_Senai/index.php");
}
?>
<ul>
  <li><a class="home" href="#home">Home</a></li>

  <?php  //MENU POR NIVEL
        if($nivel==0)
        {
          $li1='<li class="dropdown">
          <a href="javascript:void(0)" class="dropbtn">Agendar</a>
          <div class="dropdown-content">
            <a href="/SA_Senai/agendamento/agendar.php">Marcar Atendimentos</a>
            <a href="/SA_Senai/agendamento/clienteag.php">Meus Agendamentos</a>
          </div>
          </li>';
        }
        else
        {
          $li1='<li class="dropdown">
          <a href="javascript:void(0)" class="dropbtn">Agendar</a>
          <div class="dropdown-content">
            <a href="/SA_Senai/agendamento/agendar.php">Marcar Atendimentos</a>
          </div>
          </li>';
        }
        $li2='<li><a href="/SA_Senai/CRUD/CLIENTE/alterar.php">Meus Dados</a></li>';

        $li3='<li class="dropdown">
        <a href="javascript:void(0)" class="dropbtn">RH</a>
        <div class="dropdown-content">

            <a href="/SA_Senai/CRUD/FUNCIONARIO/cadastrar.php">Funcionário</a>
            <a href="/SA_Senai/CRUD/FUNCAO/Cadastrar.php">Função</a> 

        </div>
        </li>';
        $li4='<li class="dropdown">
          <a href="javascript:void(0)" class="dropbtn">Manutenção</a>
          <div class="dropdown-content">
          
            <a href="/SA_Senai/CRUD/Clinica/Cadastrar.php">Clínica</a>
            <a href="/SA_Senai/CRUD/SERVICO/Cadastrar.php">Serviço</a>
            <a href="/SA_Senai/permissoes/buscar.php">Permissões</a>
            <a href="/SA_Senai/relatorio/opcoes.php">Relatório</a>
            
          </div>
        </li>';
        $li5='<li><a href="/SA_Senai/agendamento/atendente.php">Meus Atendimentos</a></li>';
        $li6='<li><a href="/SA_Senai/agendamento/ver.php">Atendimentos</a></li>';

        switch($nivel){
          case 0: echo $li1,$li2;//cliente
            break;
          case 1: echo $li1,$li3,$li4,$li6;//adm
            break;
          case 2: echo $li1,$li3,$li4,$li6;//gerente
            break;
          case 3: echo $li1,$li6;//atendente
            break;
          case 4: echo $li3;//rh
            break;
          case 5: echo $li1,$li5;//atendendente
            break;
        }
        ?>

        <li class="logout"><a href="/SA_Senai/base/logout.php">Logout</a></li>
</ul>

</body>
</html>
