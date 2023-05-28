<?php include($_SERVER['DOCUMENT_ROOT']."/SA_Senai/base/pipoteca.php");

    $Clinica = "";  
?>

<form method="GET">
	<div class="DivPesqCidade">
		<a class="LBLBuscClinica">Clinica:</a>
		<input class="TXTBuscClinica" type="text" name="Clinica"/>
	</div>
	<button class="ButtonProcurar" type="submit">Procurar </button>
</form>

</body>  


<?php 

if(isset($_GET["Clinica"])){

    $Clinica= $_GET["Clinica"]; 
}
/////////////////////////////////////////////////////////////////////////
if($Clinica!=""){
    
    $DGVerificador=1;
}
else{
    $DGVerificador=0;
}

$conexao = conectadb();

switch ($DGVerificador){

case 0:
    $sql = "SELECT * FROM clinica;";
    break;

case 1: 
    $sql = "SELECT * FROM clinica WHERE Nome_Filial='$Clinica';"; 
}

$result = $conexao->query($sql);

if ($result->num_rows > 0)
{	 //echo "Clinica: ".GetTheName($Clinica,"Cod_Clinica","Nome_Filial","clinica");
	   //echo "Clinica: ".$Clinica;
	while ($linha = $result->fetch_assoc())
	{
            echo "<hr>";
			echo "Filial: ".$linha["Nome_Filial"];
			echo "<br/>";
			echo "Gerente: ".$linha["Nome_Gerente"];
			echo "<br/>";
            echo "Cep: ".$linha["CEP"];
			echo "<br/>";
            echo "Endereço: ".$linha["Endereco"].", ".$linha["Numero_Endereco"]." ".$linha["Complemento"];
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
			$Cod_Pegar=$linha["Cod_Clinica"];

		echo "<form action='apagar.php' method='POST' >
		<input type='hidden' name='Apagar' value=$Cod_Pegar>
		<button type='submit'>Apagar</button>
		</form>";

		echo "<form action='alterar.php' method='POST'>
		<input type='hidden' name='Alterar' value='$Cod_Pegar'>
		<button type='submit'>Alterar</button>
		</form>";

		 echo "<br/>";
	}
}
else{
	echo "Sem resultados";
}
$conexao->close();

?>
</html>