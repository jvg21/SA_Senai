<?php
	session_start();
	$Clinica = $_SESSION["Clinica"];
	
	$db = new mysqli("localhost","root","","sa");
	$sql = "SELECT * FROM funcionario,usuario WHERE funcionario.Email=usuario.Email AND usuario.nivel=5 AND
	Cod_Clinica='$Clinica' AND Ativado=1 "; // poderia ter um WHERE para especificar se o atendente faz aquele servico
	$query = $db->query($sql);
	echo '<option value="">Selecione o Atendente</option>';
	while ($linha = $query->fetch_assoc())
	{
		echo '<option value="'.$linha['ID_Funcionario'].'"> '.$linha['Nome'].' </option>\n';
	}
?>