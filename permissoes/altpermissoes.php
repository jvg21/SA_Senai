<html>
<body>
<div class="DadosAltPerm" >
<script>  
    function voltar(){
        window.location="/permissoes/buscar.php";
    }

</script>
<?php

	include($_SERVER['DOCUMENT_ROOT']."/base/pipoteca.php");	

$codigo = $_POST["Permissao"];
$Email = $_POST["Email"];
//$ID = $_POST["Cod"];

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


$conexao = conectadb();
$sql = "SELECT * FROM funcionario WHERE Email='$Email';";
$result = $conexao->query($sql);
 
if ($result->num_rows > 0)
{
    while ($linha = $result->fetch_assoc())
    { 
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
        $X= Nivel($NEmail);

       ?>
       <form method="POST">
       <input type='hidden' name='Permissao' value='<?=$codigo?>'>
       <input type='hidden' name='Email' value='<?=$Email?>'>
       <?PHP
        combo("Cod_Perfil","Descricao","perfil WHERE Cod_Perfil!=0 ","Perfil","True","True");?>
        <button class="ButtonAltVoltar" type="button" onclick="voltar()">Voltar</button>
        <button class="ButtonConceder" >Conceder</button>
       </form><?php


    }
    $conexao->close();
}
if(isset($_POST["Perfil"]) && isset($_POST["Permissao"]) && isset($_POST["Email"])){

    $Permissao = $_POST["Perfil"];
    $Email = $_POST["Email"];
	$conexao2 = conectadb();

	$sql = "UPDATE usuario SET Nivel = $Permissao WHERE Email= '$Email'";
	$conexao2->query($sql);
	$conexao2->close();
	header("Location: /permissoes/buscar.php");}?>
</div>
</body>
</html>



