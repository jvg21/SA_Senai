<html>
<body>
<div class="DivInativar">
<?php
error_reporting(0);
include($_SERVER['DOCUMENT_ROOT']."/base/pipoteca.php");
$codigo=$_POST["Apagar"];
$conexao = conectadb();

$sql = "SELECT * FROM funcionario WHERE ID_Funcionario='$codigo';";
$result = $conexao->query($sql);

if ($result->num_rows > 0)
{
    while ($linha = $result->fetch_assoc())
    {
    echo "<br/>";
	echo "<br/>";
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
    }
}

echo "<form method='GET'>
<input type='hidden' name='Apagar2' value='$codigo'>
<button class='ButtonInativar' type='submit'>Inativar</button>
</form>";

if(isset($_GET["Apagar2"])){
	$codigo=$_GET["Apagar2"];
	$conexao2 = conectadb();

	$sql = "UPDATE funcionario SET Ativado=0 WHERE ID_Funcionario='$codigo';";
	$conexao2->query($sql);
	$conexao2->close();
    echo'<script>
            alert("Dados Apagados!");
			window.location="/CRUD/FUNCIONARIO/buscar.php";
        </script>';
	//header("Location: buscar.php");
}
?>
</div>
</body>
</html>


