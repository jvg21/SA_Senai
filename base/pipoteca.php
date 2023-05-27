<?php

session_start();

///functions///

//////////////////////////CONECTAR BANCO//////////////////////////////////////////
function conectadb() 
{
	$endereco = "localhost";
	$usuario  = "root";
	$senha    = "";
	$banco    = "sa";
	try
	{
		$con = new mysqli($endereco, $usuario, $senha, $banco);
		$con->set_charset("utf8"); // acentuação
		return $con;
	}
	catch (Exception $e)
	{
		echo "<h1>Falha</h1><br/>";
		echo $e->getMessage();
		die();
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////	
function logout(){

	session_destroy();
	header("Location: ../index.php");
}


///////////////////////////////////////////////////////////////////////////////////////////////////////
function combo($id,$nome,$tabela,$name,$bool,$req)  
/* Captura informações de uma tabela e carrega no combo box. id=campo1 da tabela, nome=campo2 da tabela, tabela=nome da tabela
  bool = recebe True ou False para mostra a linha "- Escolha um - ", name = nome do input no html, req = required true or false */
{   
	$sql  = "SELECT $id,$nome FROM $tabela ORDER BY $nome";
	$conexao = conectadb();    
	$resultado = $conexao->query($sql);
	if($req=="True"){
		$req="required";
		
	}else{
		$req="";
	}
    echo '<select id="'.$id.'" name="'.$name.'" '.$req.'>';
	if ($bool)
	{
		$Branco="";
		print "<option value=\"" .$Branco. "\" >" . "-- Escolha um -- " . "</option>\n"; 
    }
	while ($row = $resultado->fetch_assoc())
    {       
        echo '<option value="' .$row["$id"]. '">' .$row["$nome"]. '</option>\n'; 
    }
	echo '</select>';
}

function select($banco, $tabela, $indice, $Nome, $Where)
{
	$conexao=conectadb($banco);
	$sql = "SELECT * from $tabela $Where;";
	$result = $conexao->query($sql);
	if ($result->num_rows > 0)
	{
		while ($linha = $result->fetch_assoc())
		{
			echo '<option value="'.$linha["$indice"].'">'.$linha["$Nome"].'</option>';
		}
	} else
	{
		echo '<option value="">Sem resultados</option>';
	}
	$conexao->close();				
}

//////PEGA O NOME DO ESTADO, CIDADE, BAIRRO E TRAZ TODOS OS DADOS
function BCEname($Bairro,$Cidade,$Estado){
    $result = "";
    $conexao2 = conectadb();

    $bce = "SELECT * FROM bairro,cidade,estado WHERE 
    estado.Cod_Estado=cidade.Cod_Estado AND cidade.Cod_Cidade=bairro.Cod_Cidade 
    AND bairro.Nome_Bairro='$Bairro' AND cidade.Nome_Cidade='$Cidade' 
    AND estado.Sigla='$Estado'";


    $resultado = $conexao2->query($bce);  

    if ($resultado->num_rows > 0){

        while ($linha = $resultado->fetch_assoc())
        {   
            $result = array (

            $linha["Cod_Estado"],//0
            $linha["Nome_Estado"],//1
            $linha["Sigla"],//2
            $linha["Cod_Cidade"],//3
            $linha["Nome_Cidade"],//4
            $linha["Cod_Bairro"],//5
            $linha["Nome_Bairro"]);//6
        }
    }
    return ($result);
}

////PEGA O ID DO ESTADO, CIDADE, BAIRRO E TRAZ TODOS OS DADOS
function BCEid($Bairro,$Cidade,$Estado){
    $result = "";
    $conexao2 = conectadb();

    $bce = "SELECT * FROM bairro,cidade,estado WHERE 
    estado.Cod_Estado=cidade.Cod_Estado AND cidade.Cod_Cidade=bairro.Cod_Cidade 
    AND bairro.Cod_Bairro='$Bairro' AND cidade.Cod_Cidade='$Cidade' 
    AND estado.Cod_Estado='$Estado'";


    $resultado = $conexao2->query($bce);  

    if ($resultado->num_rows > 0){

        while ($linha = $resultado->fetch_assoc())
        {   
            $result = array (

            $linha["Cod_Estado"],//0
            $linha["Nome_Estado"],//1
            $linha["Sigla"],//2
            $linha["Cod_Cidade"],//3
            $linha["Nome_Cidade"],//4
            $linha["Cod_Bairro"],//5
            $linha["Nome_Bairro"]);//6
        }
    }
    return ($result);
}

function GetTheName($var,$id,$nome,$tabela){
//Pega o valor de uma variavel ($var), compara a variavel com um id($id) e traz o campo 
//correspondete ($nome) na tabela($tabela)

//'Trasforma' um cód no nome correspondente na tabela
	$resposta ="";
	$conexao=conectadb();

	$sql  = "SELECT $nome FROM $tabela WHERE $id = '$var'"; 
 	
	$resultado = $conexao->query($sql);

	while ($row = $resultado->fetch_assoc())
    {    	
	  $resposta = $row["$nome"];
    }
	$conexao->close();
    return($resposta);
	
}

function confirmar_secao(){
	if (!$_SESSION["conectado"]=="sistema")
	{
		header($_SERVER['DOCUMENT_ROOT']."/index.php");
	} 
}
///////////////////////////////////////////JAVASCRIPTO/////////////////////////////////////////

?>
<script>
//FUNCTION PARA ABRIR LINKS NUMA NOVA GUIA
function Abrir(url){
        window.open(url)
    }

function limpar(){
	document.body.innerHTML = ""//LIMPA A TELA
}

</script>
