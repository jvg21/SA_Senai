<?php

session_start();
// Conecta no banco
function conectadb() 
{
    $endereco = "localhost";    $usuario  = "root";
    $senha    = "";             $banco    = "sa";
    try
    {
        $con = new mysqli($endereco, $usuario, $senha, $banco);
        return $con;
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
        die();
    }
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

?>