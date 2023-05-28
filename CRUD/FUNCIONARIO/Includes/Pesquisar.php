<?php include($_SERVER['DOCUMENT_ROOT']."/SA_Senai/base/pipoteca.php");
error_reporting(0);
    $Clinica = "";  
	$Nome = "";
?>
<form method="GET">
	<?php 
	echo "<div class='combo'>";
	combo("Cod_Clinica","Nome_Filial","clinica","Clinica","True","True");
	echo "</div>";
	?>
	<input class="TXTBuscNome" type="text" placeholder="Nome" name="Nome"/>
	<button class="ButtonProcurar" type="submit">Procurar </button>
</form>
</body>  
<?php 
if(isset($_GET["Clinica"]) && isset($_GET["Nome"])){
    $Clinica = $_GET["Clinica"];
	$Nome = $_GET["Nome"];
}
/////////////////////////////////////////////////////////////////////////
if($Nome!=""){
    
    $DGVerificador=1;
}
else{
    $DGVerificador=0;
}

switch ($DGVerificador){
case 0:
    $sql = "SELECT * FROM Funcionario WHERE Cod_Clinica='$Clinica' AND Ativado = 1 ;";//SE O CAMPO NOME ESTIVER VAZIO
    break;

case 1: 
    $sql = "SELECT * FROM Funcionario WHERE Cod_Clinica='$Clinica' AND Nome='$Nome' AND Ativado = 1;"; //SE ESTIVER PREENCHIDO
}

$conexao = conectadb();
$result = $conexao->query($sql);
if ($result->num_rows > 0)
{	echo "Clinica: ".GetTheName($Clinica,"Cod_Clinica","Nome_Filial","clinica");
	while ($linha = $result->fetch_assoc())
	{
            echo "<hr>";
			echo "Nome: ".$linha["Nome"];
			echo "<br/>";
			$Data = $linha["Data_Nascimento"];
    		$Data = date('d/m/Y');
			echo "Nascimento: ".$Data;
			echo "<br/>";
			echo "Email: ".$linha["Email"];
			echo "<br/>";
            echo "Endereço: ".$linha["Endereco"].", ".$linha["Numero_Endereco"]." ".$linha["Complemento"];
			echo "<br/>";
            $BCE = BCEid($linha["Cod_Bairro"],$linha["Cod_Cidade"],$linha["Cod_Estado"]);//TRAZ O NOME DO BCE APARTIR DOS IDS
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
			echo "<br/>";
			$Clinica = GetTheName($linha["Cod_Clinica"],"Cod_Clinica","Nome_Filial","clinica");
    		$Funcao = GetTheName($linha["Cod_Funcao"],"Cod_Funcao","Nome_Funcao","funcao");
			echo "Filial: ".$Clinica;
			echo "<br/>";
			echo "Função: ".$Funcao;
			echo "<br/>";

			if($linha["Turno1"]==1){
			echo "Turno Manhã: Sim";
			echo "<br/>";
			}else{
			echo "Turno Manhã: Não";
			echo "<br/>";}

			if($linha["Turno2"]==1){
				echo "Turno Tarde: Sim";
				echo "<br/>";
			}else{
			echo "Turno Tarde: Não";
			echo "<br/>";
			}



			$Cod_Pegar=$linha["ID_Funcionario"];

		echo "<form action='apagar.php' method='POST' >
		<input type='hidden' name='Apagar' value=$Cod_Pegar>
		<button type='submit'>Inativar</button>
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