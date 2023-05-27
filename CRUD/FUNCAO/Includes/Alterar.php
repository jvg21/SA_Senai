<?php
error_reporting(0);	
	$Codigo="";
	$Funcao="";
	$Salario="";
	include($_SERVER['DOCUMENT_ROOT']."/base/pipoteca.php");	

$codigo=$_POST["Alterar"];

$conexao = conectadb();
$sql = "SELECT * FROM funcao WHERE Cod_Funcao='$codigo';";
$result = $conexao->query($sql);

if ($result->num_rows > 0)
{
    while ($linha = $result->fetch_assoc())
    {
    $Funcao=$linha["Nome_Funcao"];
    $Salario=$linha["Salario"];
    
    }
}
    $conexao->close();
?>
<div class="DivDadosAlterar">
<form method='POST'>
<input type='hidden' name='Alterar2' value='<?=$codigo?>'>
<input class="AltFuncao" type='text' name='Funcao' value='<?=$Funcao?>' placeholder='Função' required>
<input class="AltNumero" type='number' name='Salario' value='<?=$Salario?>' placeholder='Salario' required>
<button class="ButtonAlterar" type='submit'>Alterar</button>
</form>
</div>
<?php 
if(isset($_POST["Alterar2"])){
	$Codigo=$_POST["Alterar2"];
	$Funcao=$_POST["Funcao"];
	$Salario=$_POST["Salario"];

	$conexao2 = conectadb();

	$sql = "UPDATE funcao SET Nome_Funcao='$Funcao',Salario='$Salario' WHERE Cod_Funcao='$Codigo';";
	$conexao2->query($sql);
	$conexao2->close();
	echo'<script>
            alert("Dados Alterados!");
			window.location="/CRUD/FUNCAO/buscar.php";
        </script>';
	//header("Location: buscar.php");
	}?>

</body>
</html>



