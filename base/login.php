<?php //by:jãozin21
require_once("pipoteca.php");

if((isset($_POST['email']))&&(isset($_POST['senha'])))
{
    //post->var

    $user=$_POST['email'];
    $pass=$_POST['senha'];
    //conexão
    $sql= "SELECT Nome,Email,Senha,Nivel FROM usuario WHERE Email='$user' AND senha = md5('$pass')";
    try
	{	
		$conexao = conectadb();
		$result = $conexao->query($sql); // USA A VAR CONEXÃO(CONECTADB) PARA REALIZAR O SELECT
		if ($result)
		{	
			if ($result->num_rows > 0) //SE O RESULTADO ALGUM REGISTRO
			{
				while($linha = $result->fetch_assoc()) 
				{
					// Cria as sessões (super variáveis)
					$_SESSION["conectado"] = "sistema";//confirma o login
					$_SESSION["email"] = $_POST["email"];
					$_SESSION["nome_usuario"] = $linha["Nome"];
					$_SESSION["nivel"] = $linha["Nivel"];
					$nivel = $linha["Nivel"];//nivel do acesso

					header("Location: ../index.php");//dps do login confirmado ele retorna a pagina do index
					exit();
				}
			}
			else 
			{
				header("Location: /index.php?msg=2");
				exit();
			}
		} else
		{
			echo "Falha query: ".$conexao->error;
			die();
		}
	} catch (Expection $e)
	{
		echo "Falha<br/>";
		echo $e->getMessage();
		die();
	}
	
}?>
