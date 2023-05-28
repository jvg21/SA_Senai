<html>
<body>
<div class="DivDadosAlterar">
<?php

include($_SERVER['DOCUMENT_ROOT']."/SA_Senai/base/pipoteca.php");	
error_reporting(0);
$codigo=$_POST["Alterar"];

$conexao = conectadb();
$sql = "SELECT * FROM clinica WHERE Cod_Clinica='$codigo';";
$result = $conexao->query($sql);

if ($result->num_rows > 0)
{
    while ($linha = $result->fetch_assoc())
    {
		$Gerente = $linha["Nome_Gerente"];
		$Cep = $linha["CEP"];
		$Endereco = $linha["Endereco"];
		$Numero = $linha["Numero_Endereco"];
		$Complemento = $linha["Complemento"];
		$Telefone1 = $linha["Telefone"];
		$Telefone2 = $linha["Telefone2"];
		$BCE = BCEid($linha["Cod_Bairro"],$linha["Cod_Cidade"],$linha["Cod_Estado"]);

		$Estado = $BCE[2];
		$Cidade = $BCE[4];
		$Bairro = $BCE[6];
?>
		<form method='POST'>
		<input type='hidden' name='Alterar2' value='<?=$codigo?>'>
		<input class="TXTAltGerente" type="text" name="Gerente" placeholder="Gerente" value='<?=$Gerente?>' required />
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
		<button class="ButtonAlterar" type='submit'>Alterar</button>
		</form>
<?php
    }
}
    $conexao->close();
?>


<?php 
if(isset($_POST["Alterar2"])){

	$codigo = $_POST["Alterar2"];
	$Gerente = $_POST["Gerente"];
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
	$conexao2 = conectadb();

	$sql = "UPDATE clinica SET Nome_Gerente='$Gerente',Telefone='$Telefone1',Telefone2='$Telefone2',CEP='$Cep',Endereco='$Endereco',
	Numero_Endereco='$Numero',Complemento='$Complemento',Cod_bairro='$Bairro',Cod_Cidade='$Cidade',Cod_Estado='$Estado' WHERE Cod_Clinica='$codigo';";
	$conexao2->query($sql);
	$conexao2->close();
	echo'<script>
            alert("Dados Alterados!");
			window.location="/SA_Senai/CRUD/CLINICA/buscar.php";
        </script>';
	//header("Location: buscar.php");
	}
?>
</div>
</body>
</html>



