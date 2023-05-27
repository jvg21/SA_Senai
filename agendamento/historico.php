<?php
require_once($_SERVER['DOCUMENT_ROOT']."/base/pipoteca.php");
$Nivel = $_SESSION["nivel"];
$Email = $_SESSION["email"];
$data_hoje = date ('Y-m-d');
?>
<html>
<head>
<script>
function age()
{
    window.location="/agendamento/clienteag.php";
}
function voltar()
{
    window.location="/menu.php";
}
</script>
</head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cliente.css">
<body>
<div class="Banner">
        <img src="Image/roxinho.jpg" alt="banner" />
    </div>
    <div class="Nav">
        <li><a href="../../menu.php">Menu</a></li>  
		<li><a href="clienteag.php">Agendamentos</a></li>    
    </div>
	<div class="Menu">
	<!--<button class="ButtonAgendamentos" type="button" onclick='age()'>Agendamentos</button>-->
	<!--<button type="button" onclick='voltar()'>Menu</button>-->
	
		<table class="TableHistorico" border="1" width="80%" bordercolor="#000000">
			<tr>
                <th> Cliente </th>
                <th> Serviço </th>
                <th> Data </th>
				<th> Hora </th>
                <th> Atendente </th>
				<th> Clinica </th>
                <th> Status </th>
                		
			</tr>
	
	</div>
	<div class="Agenda">
		<?php
			$conexao = conectadb();
           
			// LIMIT deslocamento, quantidade 
			//1 chama os campos //2 apelidos //3 e 4 "join" 

			$sql = "SELECT age.Cod_Agenda,age.AData,age.Horario,
			func.Nome as Funcionario,
			cli.Nome as Cliente,
			ser.Nome_Servico as Serviço,
			c.Nome_Filial as Clinica,
            age.status_age as Confirm
			from agenda AS age,funcionario AS func,cliente AS cli,servico AS ser,clinica AS c 
			WHERE (age.ID_Funcionario=func.ID_Funcionario) AND (age.ID_Cliente=cli.ID_Cliente) 
			AND (age.Cod_Servico=ser.Cod_Servico) AND (age.Cod_Clinica=c.Cod_Clinica) AND cli.Email='$Email'
			AND age.AData<'$data_hoje'";

			$result = $conexao->query($sql);
			if ($result->num_rows > 0)
			{
				while ($linha = $result->fetch_assoc())
				{
                    $Cod_Pegar=$linha["Cod_Agenda"];
					echo "<tr>";
                    echo "<td>".$linha['Cliente']."</td>";
					echo "<td>".$linha['Serviço']."</td>";
					$Dataag = date_create($linha['AData']);
					$Dataag = date_format($Dataag,'d/m/Y');//FORMATA A DATA PARA PADRÃO BRASIL
					echo "<td>".$Dataag."</td>";
					echo "<td>".$linha['Horario']."</td>";
					echo "<td>".$linha['Funcionario']."</td>";
					echo "<td>".$linha['Clinica']."</td>";
					echo"<td>Realizado</td>";
				}
			}
           
		?>
		</table>
	</div>
</body>


</html>