<?php 
 require_once($_SERVER['DOCUMENT_ROOT']."/SA_Senai/base/pipoteca.php");?>
<html>
<head>
	<link rel="stylesheet" href="css/index_login.css" />
</head>
<body>
<?php 
	//se o login foi feito vai direto para o menu
	if ((isset($_SESSION["conectado"])) && $_SESSION["conectado"]=="sistema"){

		header("Location: /SA_Senai/menu.php");//menu
	}
	//se nao foi feito o login ele abre o formulário
	?>
	
	<div class="login-page">
	  <div class="form">
		<form class="login-form" method="POST" action='/SA_Senai/base/login.php'>
		  <input type="email" placeholder="Email" name="email"/>
		  <input type="password" placeholder="Senha" name="senha"/>
		  <button class="btn">
		<svg width="180px" height="60px" viewBox="0 0 180 60" class="border">
          <polyline points="179,1 179,59 1,59 1,1 179,1" class="bg-line" />
          <polyline points="179,1 179,59 1,59 1,1 179,1" class="hl-line" />
        </svg>
		  <span>ENTRAR</span>
		</button>
		  <p class="message">Não registrado? <a href="/SA_Senai/CRUD/CLIENTE/cadastrar.php">Criar uma conta</a></p>
		</form>
		<div class="case">
		<?php
		$x = count($_GET);
		$message="";
		if ($x != 0)
		{
			$x = $_GET["msg"];
			SWITCH ("$x")
			{
				case 1 :
					$message = "Falha de conexão com banco de dados";
					break;
				case 2 :
					$message = "Usuário ou senha inválidos";
					break;
				default:
					$message="&nbsp;";
			}
			echo "<p>$message</p>";
		}
	?>
		</div>
	  </div>
	</div>

</body>
</html>