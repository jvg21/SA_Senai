<?php
    $servico="";
    include($_SERVER['DOCUMENT_ROOT']."/SA_Senai/base/pipoteca.php");
?>

<body>
<form method="POST">

	<div class="DivBuscServico" >
	<a class="LBLBuscServico" >Serviço:</a>
	<input class="TXTBuscServico" type="text" name="servico" />
	</div>

	<button class="ButtonProcurar" type="submit">Procurar </button>
</form>

<?php 
if(isset($_POST["servico"])){
    $servico=$_POST["servico"];
}


/////////////////////////////////////////////////////////////////////////
if ($servico!=""){
   
    $DGVerificador=1;  
}else{
    $DGVerificador=0;
}

$conexao = conectadb();

switch ($DGVerificador){

case 0:
    $sql = "SELECT * FROM servico ;";
    break;

case 1:
    $sql = "SELECT * FROM servico WHERE Nome_Servico='$servico';"; 
    break;

}

$result = $conexao->query($sql);
if ($result->num_rows > 0)
	{
	
while ($linha = $result->fetch_assoc())
{
    echo "<div class='DivPHPServ'>";
    echo "<hr>";
    //echo "Codigo Servico: ".$linha["Cod_Servico"];
    //echo "<br/>";
    echo "Servico: ".$linha["Nome_Servico"];
    echo "<br/>";
    echo "Duracao: ".$linha["Duracao"]." Min";
    echo "<br/>";
    echo "Valor: ".$linha["Valor"];
    echo "<br/>";
    $Cod_Pegar=$linha["Cod_Servico"];

echo "<form action='apagar.php' method='POST' >
<input type='hidden' name='Apagar' value=$Cod_Pegar>
<button type='submit'>Apagar</button>
</form>";


echo "<form action='alterar.php' method='POST'>
<input type='hidden' name='Alterar' value='$Cod_Pegar'>
<button type='submit'>Alterar</button>
</form>";

echo "</div>"; 
}
}
else{
echo "Sem resultados";
}

$conexao->close();
?>
</body>
</html>
