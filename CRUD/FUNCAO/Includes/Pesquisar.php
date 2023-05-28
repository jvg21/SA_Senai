<?php 
error_reporting(0);
require_once($_SERVER['DOCUMENT_ROOT']."/SA_Senai/base/pipoteca.php");
	$funcao="";
    $salario="";
    $codigo="";?>
	
<body>	
<form method="GET">

        <div class="DivPesqFunc">
        <label class="LBLFuncao" >Função:</label>
        <input class="TXTFuncao" type="text" name="funcao" />
        <br />
        <br />
        </div>
        <button class="ButtonProcurar" type="submit">Procurar </button>

</form>	
<?php
if(isset($_GET["funcao"]) ){

    $funcao=$_GET["funcao"];
}

if($funcao!=""){
   
    $DGVerificador=1;
}else{
    $DGVerificador=0;
}

$conexao = conectadb();
switch ($DGVerificador){

case 0:
    $sql = "SELECT * FROM funcao ;";
    break;

case 1:
    $sql = "SELECT * FROM funcao WHERE Nome_Funcao='$funcao';"; 
    break;


}
$result = $conexao->query($sql);
if ($result->num_rows > 0)
{   //echo "Função: ".$funcao;
while ($linha = $result->fetch_assoc())
{ 
    
    echo "<div class='DivPHP'>";
    echo "<hr>";
	//echo "Codigo Função:".$linha["Cod_Funcao"];
	//echo "<br/>";
	echo "Função:".$linha["Nome_Funcao"];
	echo "<br/>";
	echo "Salário:".$linha["Salario"];
	echo "<br/>";
	$Cod_Pegar=$linha["Cod_Funcao"];


echo "<form action='apagar.php' method='POST' >
<input type='hidden' name='Apagar' value=$Cod_Pegar>
<button type='submit'>Apagar</button>
</form>";


echo "<form action='alterar.php' method='POST'>
<input type='hidden' name='Alterar' value='$Cod_Pegar'>
<button type='submit'>Alterar</button>
</form>";

 echo "</div>";
}}
else{
echo "Sem resultados";
}
$conexao->close();

?>
</body>
</html>
