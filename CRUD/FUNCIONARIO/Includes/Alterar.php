<?php
error_reporting(0);
	include($_SERVER['DOCUMENT_ROOT']."/base/pipoteca.php");	

$codigo=$_POST["Alterar"];

$conexao = conectadb();
$sql = "SELECT * FROM funcionario WHERE ID_Funcionario='$codigo';";
$result = $conexao->query($sql);

if ($result->num_rows > 0)
{
    while ($linha = $result->fetch_assoc())
    {
		$Nome = $linha["Nome"];
		$Cep = $linha["CEP"];
		$Endereco = $linha["Endereco"];
		$Numero = $linha["Numero_Endereco"];
		$Complemento = $linha["Complemento"];
		$Telefone1 = $linha["Telefone"];
		$Telefone2 = $linha["Telefone2"];
		$Turno1 = $linha["Turno1"];
		$Turno2 = $linha["Turno2"];

		$Clinica = GetTheName($linha["Cod_Clinica"],"Cod_Clinica","Cod_Clinica","clinica");
    	$Funcao = GetTheName($linha["Cod_Funcao"],"Cod_Funcao","Cod_Funcao","funcao");
		$BCE = BCEid($linha["Cod_Bairro"],$linha["Cod_Cidade"],$linha["Cod_Estado"]);

		$Estado = $BCE[2];
		$Cidade = $BCE[4];
		$Bairro = $BCE[6];
?>
		<form method='POST'>
		<label class="LBLTitulo"> Alterar Dados Funcionario </label>
		<?php echo "<br/>" ?>
		<input type='hidden' name='Alterar2' value='<?=$codigo?>'>
		<input class="TXTAltNome" type="text" value='<?=$Nome?>' readonly required/>
		<input class="TXTAltCEP" name="Cep" type="text" id="Cep" placeholder="CEP" value='<?=$Cep?>' maxlength="10" onkeydown="javascript: fMasc( this, mCEP );" required/>
		<button class="ButtonAltCEP" onclick="Abrir('https://buscacepinter.correios.com.br/app/localidade_logradouro/index.php')" type="button">Descobrir CEP</button>
		<input class="TXTAltRua" name="Rua" type="text" id="Rua" placeholder="Rua" value='<?=$Endereco?>' readonly required/>
		<input class="TXTAltBairro" name="Bairro" type="text" id="Bairro" placeholder="Bairro" value='<?=$Bairro?>' readonly required/>
		<input class="TXTAltCidade" name="Cidade" type="text" id="Cidade" placeholder="Cidade" value='<?=$Cidade?>' readonly required/>
		<input class="TXTAltUf" name="Uf" type="text" id="Uf" size="2" placeholder="UF" value='<?=$Estado?>' readonly required/>
		<input class="TXTAltNumero" type="number" name="Numero" placeholder="Numero" value='<?=$Numero?>' required />
		<input class="TXTAltComplemento" type="text" name="Complemento" placeholder="Complemento" value='<?=$Complemento?>' />
		<input class="TXTAltTel1" type="text" name="Tel1" placeholder="Telefone" value='<?=$Telefone1?>' maxlength=14 onkeydown="javascript: fMasc( this, mTel );" required/>
		<input class="TXTAltTel2" type="text" name="Tel2" placeholder="Telefone2" value='<?=$Telefone2?>' maxlength=14 onkeydown="javascript: fMasc( this, mTel );"/>
		<br/>
		<?php
			echo "<div class='AltClinica' >";
			echo "Clinica: ". GetTheName($Clinica,"Cod_Clinica","Nome_Filial","clinica")." ";
			combo("Cod_Clinica","Nome_Filial","clinica","Clinica","false","True");
			echo "</div>";

			

			echo "<div class='AltFuncao' >";
			echo "Função: ".GetTheName($Funcao,"Cod_Funcao","Nome_Funcao","funcao")." ";
    		combo("Cod_Funcao","Nome_Funcao","funcao","Funcao","false","True");
			echo "</div>";

			echo "<div class='AltTurno' >";
			if($Turno1==1){
				echo "Turno Manhã: Sim";
				echo "<br/>";
				}else{
				echo "Turno Manhã: Não";
				echo "<br/>";}
	
				if($Turno2==1){
					echo "Turno Tarde: Sim";
					echo "<br/>";
				}else{
				echo "Turno Tarde: Não";
				echo "<br/>";}
			echo "</div>";
  		?>
		<br/>
		<label class="LBLAltCheckbox" >Manhã</label>
    	<input class="AltCheckbox" type="checkbox" name="Manha" value="1">
    	<label class="LBLAltCheckbox" >Tarde</label>
   	 	<input class="AltCheckbox" type="checkbox" name="Tarde" value="1">
		<button class="AltButton" type='submit' name="Alterar" >Alterar</button>
		</form>
<?php
    }
}
    $conexao->close();
?>
<?php 
if(isset($_POST["Alterar2"])){
	
    if (isset($_POST["Manha"])){
        $Turno1 = 1;
    }else{
        $Turno1 = 0;
    }

    if (isset($_POST["Tarde"])){
        $Turno2 = 1;
    }else{
        $Turno2 = 0;
    }

	$codigo = $_POST["Alterar2"];
	$Cep = $_POST["Cep"];
	$Endereco = $_POST["Rua"];
	$Numero = $_POST["Numero"];
	$Complemento = $_POST["Complemento"];
	$Telefone1 = $_POST["Tel1"];
	$Telefone2 = $_POST["Tel2"];
	$BCE=BCEname($_POST["Bairro"],$_POST["Cidade"],$_POST["Uf"]);
	$Estado = $BCE[0];//ESPAÇO REFERENTE AO COD_ESTADO
	$Cidade = $BCE[3];//ESPAÇO REFERENTE AO COD_CIDADE
	$Bairro = $BCE[5];//ESPAÇO REFERENTE AO COD_BAIRRO
	$Clinica = $_POST["Clinica"];
    $Funcao = $_POST["Funcao"];
    $Clinica = GetTheName($Clinica,"Cod_Clinica","Cod_Clinica","clinica");
    $Funcao = GetTheName($Funcao,"Cod_Funcao","Cod_Funcao","funcao");
	//var_dump($_POST);
	//var_dump($Funcao,$Clinica,$Bairro,$Cidade,$Estado,$codigo);
	$conexao2 = conectadb();
	$sql = "UPDATE funcionario SET Telefone='$Telefone1',Telefone2='$Telefone2',CEP='$Cep',Endereco='$Endereco',
	Numero_Endereco='$Numero',Complemento='$Complemento',Cod_bairro='$Bairro',Cod_Cidade='$Cidade',Cod_Estado='$Estado',
	Cod_Clinica='$Clinica',Cod_Funcao='$Funcao',Turno1='$Turno1',Turno2='$Turno2' WHERE ID_Funcionario='$codigo';";
	$conexao2->query($sql);
	$conexao2->close();
	echo'<script>
            alert("Dados Alterados!");
			window.location="/CRUD/FUNCIONARIO/buscar.php";
        </script>';
	//header("Location: buscar.php");
	}?>

</body>
</html>



