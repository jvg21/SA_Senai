<?php

function servicos($Clinica,$Data){
$conexao = conectadb();  
$sql = "SELECT Cod_Servico,Nome_Servico FROM servico";
$servico = $conexao->query($sql);

    echo "Clinica: ".$Clinica;
    echo "<br/>";
    $Data2 = date_create($Data);
    $Data2 = date_format($Data2,'d/m/Y');
    echo "Apartir de: ".$Data2;
    echo '<hr/>';
if ($servico->num_rows > 0){

    while ($linha = $servico->fetch_assoc())
    {   
        echo "<br/>";
        $Nome = $linha["Nome_Servico"];
        echo $Nome.": ";
        $Cod = $linha["Cod_Servico"];

        $sql = "SELECT COUNT(Cod_Servico) as Servico FROM agenda WHERE Cod_Servico = '$Cod'
        AND Cod_Clinica = '$Clinica' AND AData >= '$Data' AND status_age = 3";

        $relatorio = $conexao->query($sql);
        if ($relatorio->num_rows > 0)
        {
            while ($row = $relatorio->fetch_assoc())
            {
                echo $row["Servico"]." Realizados";
            }
        }else
        {
            echo "0 Realizados";
        }
        echo "<br/>";
    }
}
}

function Funcionario($Clinica,$Data){

    echo'<form method="POST">
    <input type="text" name="func" placeholder="Digite o Nome Completo do Funcionario">
    <button name="funcionario">Enviar</button>
    </form>';

    echo "Clinica: ".$Clinica;
    echo "<br/>";
    $Data2 = date_create($Data);
    $Data2 = date_format($Data2,'d/m/Y');
    echo "Apartir de: ".$Data2;
    
if(isset($_POST["func"]))
{   
    $conexao = conectadb();
    $Funcionario = $_POST["func"];
    
    if($Funcionario == "")
    {
        $sql = "SELECT * FROM funcionario,usuario WHERE usuario.Email = Funcionario.Email 
        AND usuario.Nivel = 5";
    }else
    {
        $sql = "SELECT * FROM funcionario,usuario WHERE funcionario.Nome = '$Funcionario' 
        AND usuario.Email = Funcionario.Email AND usuario.Nivel = 5";
    }
     
    $Func = $conexao->query($sql);
    if ($Func->num_rows > 0){


        while ($linha = $Func->fetch_assoc())
        {   
            echo "<br/><hr/>";
            $Nome = $linha["Nome"];
            echo $Nome.": ";
            $Cod = $linha["ID_Funcionario"];
    
            $sql = "SELECT COUNT(Cod_Servico) as Servico FROM agenda WHERE ID_Funcionario = '$Cod'
            AND Cod_Clinica = '$Clinica' AND AData >= '$Data' AND status_age = 3";
    
            $relatorio = $conexao->query($sql);
            if ($relatorio->num_rows > 0)
            {
                while ($row = $relatorio->fetch_assoc())
                {
                    echo $row["Servico"]." Servicos Realizados";
                }
            }else
            {
                echo "0 Servicos Realizados";
            }
            echo "<br/>";
        }
    }else
    {
        echo "Sem resultados";
    }
}

}
?>