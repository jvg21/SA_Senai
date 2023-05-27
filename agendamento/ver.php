<html lang="pt-br">
<head>
<meta charset="UTF-8">

    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo_agendamento.css">
<body>
<div class="Banner">
    <img src="Image/roxinho.jpg" alt="banner" />
    </div>
    <div class="Nav">
        <li><a href="../../menu.php">Menu</a></li>   
    </div>
<?php
require_once($_SERVER['DOCUMENT_ROOT']."/base/pipoteca.php");//BIBLIOTECA
$data = date ('Y-m-d');//PEGA A DATA DE HOJE
//echo $data;
$Clinica = null;
function age($data,$Clinica){
	
	echo'<div class="Menu">
	<table border="1" width="80%" bordercolor="#000000" >
		<tr>
			<th > Funcionario </th>
			<th > Cliente </th>
			<th > Serviço </th>
			<th > Clinica </th>
			<th > Data </th>
			<th > Hora </th>	
		</tr>
</div>
<div class="Agenda">';
	$conexao = conectadb();
	$sql = "SELECT age.Cod_Agenda,age.AData,age.Horario,
	func.Nome as Funcionario,
	cli.Nome as Cliente,
	ser.Nome_Servico as Serviço,
	c.Nome_Filial as Clinica 
	from agenda AS age,funcionario AS func,cliente AS cli,servico AS ser,clinica AS c 
	WHERE (age.ID_Funcionario=func.ID_Funcionario) AND (age.ID_Cliente=cli.ID_Cliente) 
	AND (age.Cod_Servico=ser.Cod_Servico) AND (age.Cod_Clinica=c.Cod_Clinica) AND age.AData='$data' 
	AND age.Cod_Clinica $Clinica;";
	$result = $conexao->query($sql);
	if ($result->num_rows > 0)
	{
		while ($linha = $result->fetch_assoc())
		{
			echo "<tr>";
			echo "<td >".$linha['Funcionario']."</td>";
			echo "<td >".$linha['Cliente']."</td>";
			echo "<td >".$linha['Serviço']."</td>";
			echo "<td >".$linha['Clinica']."</td>";
			$Dataag = date_create($linha['AData']);
			$Dataag = date_format($Dataag,'d/m/Y');//FORMATA A DATA NO PADRÃO BRASIL
			echo "<td >".$Dataag."</td>";
			echo "<td >".$linha['Horario']."</td>";
			echo "</tr>";
		}
	}
	echo'
	</table>
	</div>';
}
function cabecalho(){  //MOSTRA O CABECALHO
echo'
<form method="POST">
<label class="LBLVerClinica" > Clinica </label>
        <select class="SelectSelecioneClinica" name="clinica">
            <option value="">Selecione uma Clinica...</option>';
            select("sa","clinica","Cod_Clinica","Nome_Filial","");
		echo'
        </select>
		<input class="InputVerData" type="date" required name="Data">
		<button class="ButtonPesquisar" name="Enviar">Pesquisar</button>
</form>';
}
/////////////////////////////////////////////////////////////////////////////////////
	cabecalho();
	echo "<div class='DivVerData' >";
	//echo $data;
	echo "</div>";
	age($data,$Clinica);
	
	if (isset($_POST["Enviar"]))
	{
		$data = $_POST["Data"];
		
		if($_POST["clinica"]=="")
		{	
			$Clinica = null;
		}else
		{
			$Clinica = "=".$_POST["clinica"];
		}

		echo'<script>limpar()</script>';

		echo "<div class='Banner'>";
       	echo "<img src='Image/roxinho.jpg' alt='banner' />";
    	echo "</div>";
    	echo "<div class='Nav'>";
       	echo  "<li><a href='../../menu.php'>Menu</a></li> ";
    	echo "</div>";

		cabecalho();
		$Dataag = date_create($data);
		echo "Data:".date_format($Dataag,"d-m-Y");
		age($data,$Clinica);
	}
	
	?>
	</body>
</head>