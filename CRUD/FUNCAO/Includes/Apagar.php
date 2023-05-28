<body>
<html>
<?php
error_reporting(0);
$codigo=$_POST["Apagar"];
include($_SERVER['DOCUMENT_ROOT']."/SA_Senai/base/pipoteca.php");

$conexao = conectadb();

$sql = "SELECT * FROM funcao WHERE Cod_Funcao='$codigo';";
$result = $conexao->query($sql);

if ($result->num_rows > 0)
{
    while ($linha = $result->fetch_assoc())
    {
    echo "<br/>";
	echo "<br/>";
   //	echo "Código:".$linha["Cod_Funcao"];
    //echo "<br/>";
    echo "<div class='DivDados' >";
    echo "Função:".$linha["Nome_Funcao"];
    echo "<br/>";
    echo "Salário:".$linha["Salario"];
    echo "<br/>";
    echo "</div>";
    }
}

echo "<form method='POST'>
<input type='hidden' name='Apagar2' value='$codigo'>
<button class='ButtonApagarInativar' type='submit'>Apagar</button>
</form>";


if(isset($_POST["Apagar2"])){
	$codigo=$_POST["Apagar2"];
	$conexao2 = conectadb();

	$sql = "DELETE FROM funcao WHERE Cod_Funcao='$codigo';";
	$conexao2->query($sql);
	$conexao2->close();
    echo'<script>
            alert("Dados Apagar!");
			window.location="/SA_Senai/CRUD/FUNCAO/buscar.php";
        </script>';
	//header("Location: buscar.php");
}


?>

</body>
</html>


