<script>  
    function voltar(){
        window.location="/SA_Senai/menu.php";
    }

</script>
<?php include($_SERVER['DOCUMENT_ROOT']."/SA_Senai/base/pipoteca.php");

    $Clinica = "";  
	$Nome = "";
?>
<form method="GET">
	<?php 
    echo "<div class = 'combo'>";
    combo("Cod_Clinica","Nome_Filial","clinica","Clinica","True","True");
    echo "</div>";
    ?>
	<input class="TXTNome" type="text" placeholder="Nome" name="Nome"/>
    <button class="ButtonVoltar" type="button" onclick="voltar()">Voltar</button>
	<button class="ButtonProcurar" type="submit">Procurar </button>
</form>
</body>  
<?php 
////////////////////////////////////////////////////////
function Nivel($NEmail){
    $conexao2 = conectadb();
    $sql = "SELECT * FROM usuario WHERE Email = '$NEmail';";
    $Usu = $conexao2->query($sql);
    if ($Usu->num_rows > 0)
    {   
        while ($linha = $Usu->fetch_assoc()){
            $Nivel = $linha["Nivel"];
            $Nivel = GetTheName($Nivel,"Cod_Perfil","Descricao","perfil");
            echo "Permissão: ".$Nivel;
            echo "<br/>";
        }
    }
    return($Nivel);
}
/////////////////////////////////////////////////////////////////////////////////////
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
    $sql = "SELECT * FROM Funcionario WHERE Cod_Clinica='$Clinica';";//SE O CAMPO NOME ESTIVER VAZIO
    break;

case 1: 
    $sql = "SELECT * FROM Funcionario WHERE Cod_Clinica='$Clinica' AND Nome='$Nome';"; //SE ESTIVER PREENCHIDO
}
$conexao = conectadb();
$result = $conexao->query($sql);
if ($result->num_rows > 0)
{   echo "Clinica: ".GetTheName($Clinica,"Cod_Clinica","Nome_Filial","clinica");
	while ($linha = $result->fetch_assoc())
	{          
            echo "<hr>";
			echo "Nome: ".$linha["Nome"];
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

            $NEmail = $linha["Email"]; 
			$Cod_Pegar = Nivel($NEmail);
            $COD = $linha["ID_Funcionario"];
    
		echo "<form action='alterar.php' method='POST'>
		<input type='hidden' name='Permissao' value=$Cod_Pegar >
        <input type='hidden' name='Email' value=$NEmail >
        <input type='hidden' name='Cod' value=$COD >
		<button type='submit'>Alterar Permisão</button>
		</form>";
	
	}
}
else{
	echo "Sem resultados";
}
$conexao->close();

?>
</html>