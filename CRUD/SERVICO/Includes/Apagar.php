<html>
<body>
<div class="DivDadosApagar">
<?php

require_once($_SERVER['DOCUMENT_ROOT']."/SA_Senai/base/pipoteca.php");//biblioteca

$codigo=$_POST["Apagar"];

$conexao = conectadb();
$sql = "SELECT * FROM servico WHERE Cod_Servico='$codigo';";
$result = $conexao->query($sql);  

if ($result->num_rows > 0)
{
    while ($linha = $result->fetch_assoc())
    {
    echo "<br/>";
	echo "<br/>";
   	//echo "Código:".$linha["Cod_Servico"];
    //echo "<br/>";
    echo "Servico:".$linha["Nome_Servico"];
    echo "<br/>";
    echo "Duracao:".$linha["Duracao"];
    echo "<br/>";
    echo "Valor:".$linha["Valor"];
    echo "<br/>";
    }
}

echo "<form method='POST'>
<input type='hidden' name='Apagar2' value='$codigo'>
<button class='ButtonApagar' type='submit'>Apagar</button>
</form>";



if(isset($_POST["Apagar2"])){
	
	$codigo=$_POST["Apagar2"];
	$conexao2 = conectadb();

	$sql = "DELETE FROM servico WHERE Cod_Servico='$codigo';";
	$conexao2->query($sql);
	$conexao2->close();
    echo'<script>
            alert("Dados Apagados!");
			window.location="/CRUD/SERVICO/buscar.php";
        </script>';
	//header("Location: buscar.php");
}
?>
</div>
</body>
</html>


