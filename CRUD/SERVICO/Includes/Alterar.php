<html>
<body>
<div class="DivDadosAlterar">
<?php	
require_once($_SERVER['DOCUMENT_ROOT']."/base/pipoteca.php");

$Servico="";
$Duracao="";
$Valor="";
$codigo=$_POST["Alterar"];
$conexao = conectadb();

$sql = "SELECT * FROM servico WHERE Cod_Servico='$codigo';";

$result = $conexao->query($sql);

if ($result->num_rows > 0)
{
    while ($linha = $result->fetch_assoc())
    {
    $Servico=$linha["Nome_Servico"];
    $Duracao=$linha["Duracao"];
    $Valor=$linha["Valor"];
    
    }
}
    $conexao->close();
?>

<form  method='POST'>
<input type='hidden' name='Alterar2' value='<?=$codigo?>'>

<input class="TXTAltServico" type='text' name='Servico' value='<?=$Servico?>' placeholder='Servico' required>
<input class="TXTAltDuracao" type='number' name='Duracao' value='<?=$Duracao?>' placeholder='Duracao' required>
<input class="TXTAltValor" type='number' name='Valor' value='<?=$Valor?>' placeholder='Valor' required>
<button class="ButtonAlterar" type='submit'>Alterar</button>
</form>

<?php

if(isset($_POST["Alterar2"])){
	
	$Codigo=$_POST["Alterar2"];
	$servico=$_POST["Servico"];
	$duracao=$_POST["Duracao"];
	$valor=$_POST["Valor"];

	$conexao2 = conectadb();
	$sql = "UPDATE servico SET Nome_Servico='$servico',Duracao='$duracao',Valor='$valor' WHERE Cod_Servico='$Codigo';";
	$conexao2->query($sql);
	$conexao2->close();
	echo'<script>
            alert("Dados Alterados!");
			window.location="/CRUD/SERVICO/buscar.php";
        </script>';}
?>
</div>
</body>
</html>




