<!DOCTYPE html>

<head>
    <meta charset="UTF-8">

    <title>Pesquisar Serviço</title>
</head>
    
<body>
    <form action=<?php click()?> method="POST">
        
        
        <div class="DivPesqCod">
        <label>Código:</label>
        <input class="TXTCod" type="text" name="codigo" />
        <!---<button type="submit">Procurar com Código</button>-->
        </div>

        <div class="DivPesqFunc">
        <label>Função:</label>
        <input class="TXTFuncao" type="text" name="funcao" />
        <!---<button type="submit">Procurar por Função</button>-->
        </div>

        <div class="DivPesqSalario">
        <label>Salário:</label>
        <input class="TXTSalario" type="number" name="salario" />
        </div>
        <button class="BtnProcurar" type="submit">Procurar</button>
        
    </form>

</body>
<?php 

/*	
function click(){

    $funcao=$_POST["funcao"];
    $salario=$_POST["salario"];
    $codigo=$_POST["codigo"];
    //var_dump($funcao,$salario,$codigo);

 
}

/////////////////////////////////////////////////////////////////////////
if ($codigo!=""){
    $DGVerificador=1;

}else if($funcao!=""){
    $DGVerificador=2;

}else if($salario!=""){
    $DGVerificador=3;

}else{
    $DGVerificador=0;
    
}

$conexao = new mysqli("127.0.0.1", "root", "", "sa");
if ($conexao->connect_errno){
echo "Ocorreu um erro na conexão com o banco de dados.";
exit;
}
$conexao->set_charset("utf8"); // Acertar acentuação

switch ($DGVerificador){

case 0:
    $sql = "SELECT * FROM funcao ;";
    break;

case 1:
    $sql = "SELECT * FROM funcao WHERE Cod_Funcao='$codigo';";
    break;

case 2:
    $sql = "SELECT * FROM funcao WHERE Nome_Funcao='$funcao';"; 
    break;

case 3: 
    $sql = "SELECT * FROM funcao WHERE Salario='$salario';";
    break;

}
//echo $sql."<br/>";
$result = $conexao->query($sql);
if ($result->num_rows > 0)
{
while ($linha = $result->fetch_assoc())
{ ?>
<hr>
<div class="">
<?php echo "Codigo Função:".$linha["Cod_Funcao"];?>
<?php echo "<br/>";?>
<?php echo "Função:".$linha["Nome_Funcao"];?>
<?php echo "<br/>";?>
<?php echo "Salário:".$linha["Salario"];?>
<?php echo "<br/>";?>
<?php $Cod_Pegar=$linha["Cod_Funcao"];?>
</div>

<?php
echo "<form action='Funcao_Apagar.php' method='POST' >
<input type='hidden' name='Apagar' value=$Cod_Pegar>
<button type='submit'>Apagar</button>
</form>";


echo "<form action='Funcao_Alterar.php' method='POST'>
<input type='hidden' name='Alterar' value='$Cod_Pegar'>
<button type='submit'>Alterar</button>
</form>";

 echo "<br/>";
}}
else{
echo "Sem resultados";
}

$conexao->close();

echo "<br/>";
echo "<a href='Funcao_Pesquisar1.php'>Voltar</a>";
*/

</html>
