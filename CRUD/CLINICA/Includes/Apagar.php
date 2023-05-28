<body>
<html>
<div class="DivDados" >
<?php
error_reporting(0);
include($_SERVER['DOCUMENT_ROOT']."/SA_Senai/base/pipoteca.php");
$codigo=$_POST["Apagar"];
$conexao = conectadb();

$sql = "SELECT * FROM clinica WHERE Cod_Clinica='$codigo';";
$result = $conexao->query($sql);

if ($result->num_rows > 0)
{
    while ($linha = $result->fetch_assoc())
    {
    echo "<br/>";
	echo "<br/>";
    echo "Filial:".$linha["Nome_Filial"];
    echo "<br/>";
    echo "Gerente:".$linha["Nome_Gerente"];
    echo "<br/>";
    echo "Endereço:".$linha["Endereco"].", ".$linha["Numero_Endereco"];
    echo "<br/>";
    echo "Complemento: ".$linha["Complemento"];
    echo "<br/>";

    $BCE = BCEid($linha["Cod_Bairro"],$linha["Cod_Cidade"],$linha["Cod_Estado"]);

    $Estado = $BCE[2];
    $Cidade = $BCE[4];
    $Bairro = $BCE[6];

    echo "Bairro: ".$Bairro;
    echo "<br/>";
    echo "Cidade: ".$Cidade;
    echo "<br/>";
    echo "Estado: ".$Estado;
    echo "<br/>";
    echo "Telefone: ".$linha["Telefone"];
    echo "<br/>";
    echo "Telefone2: ".$linha["Telefone2"];
    }
}

echo "<form method='GET'>
<input type='hidden' name='Apagar2' value='$codigo'>
<button class='ButtonApagar' type='submit'>Apagar</button>
</form>";

if(isset($_GET["Apagar2"])){
	$codigo=$_GET["Apagar2"];
	$conexao2 = conectadb();

	$sql = "DELETE FROM clinica WHERE Cod_Clinica='$codigo';";
	$conexao2->query($sql);
	$conexao2->close();
    echo'<script>
            alert("Dados Apagados!");
			window.location="/SA_Senai/CRUD/CLINICA/buscar.php";
        </script>';
	//header("Location: buscar.php");
}


?>
</div>
</body>
</html>


