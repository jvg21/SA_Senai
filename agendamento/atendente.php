<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/SA_Senai/base/pipoteca.php");
    function rlz($Cod)
    {   
        $conexao2=conectadb();
        $sql="UPDATE agenda SET status_age = 3 WHERE Cod_Agenda=$Cod;";
		$result = $conexao2->query($sql);
        $conexao2->close();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cliente.css">
    <title>Atendente</title>
</head>
<body>
<div class="Banner">
        <img src="Image/roxinho.jpg" alt="banner" />
    </div>
    <div class="Nav">
        <li><a href="../../SA_Senai/menu.php">Menu</a></li> 
    </div>
    
<div class="DadosAgendadoDia">
    <table class="atendente" border="1" width="80%" bordercolor="#000000">

        
        <tr> <th colspan=4> Agenda do Dia </th> </tr>
        <tr> <th> Horário </th> <th> Cliente </th> <th> Serviço </th> <th> Status </th> </tr>
        
        <?php
            $Email = $_SESSION["email"];
            $data_hoje = date ('Y-m-d');
            $datafr = date_create($data_hoje);
            //echo "<p> Data de Hoje: ".date_format($datafr,"d-m-Y")." </p>";//formata a data para padrão brasil

            $conexao=conectadb();

            $sql = "SELECT ID_Funcionario FROM funcionario WHERE Email='$Email';";
            $resultado = $conexao->query($sql);
                while ($linha = $resultado->fetch_assoc())
                {
                    $atendente = $linha["ID_Funcionario"];
                }
            
            $sql = "SELECT a.*, s.Cod_Servico, s.Nome_Servico AS serv , c.ID_Cliente, c.Nome AS nomecli, ate.* FROM agenda AS a, 
            servico AS s, cliente AS c, funcionario AS ate 
            WHERE a.ID_Funcionario = ? AND a.AData = ? AND a.Cod_Servico=s.Cod_Servico 
            AND a.ID_Funcionario = ate.ID_Funcionario AND a.ID_Cliente=c.ID_Cliente ORDER BY a.AData";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("is", $atendente, $data_hoje);
            if (! $stmt -> execute()) {
                echo $stmt -> error;
            }
            $result = $stmt->get_result();
            //var_dump($result);
            while ($linha = $result->fetch_assoc())
            {  
                $Cod = $linha["Cod_Agenda"];
                $servico = GetTheName($linha['Cod_Servico'],"Cod_Servico","Nome_Servico","servico"); 
              echo "<tr>
                        <td> {$linha['Horario']} </td>
                        <td> {$linha['nomecli']} </td>
                        <td> {$servico} </td>";
                    if ($linha['status_age']== 3){
                        echo "<td> Realizado </td> </tr>"; 
                    }else{
                        ?>
                        <td> 
                        <form method='POST'>
                        <input type='hidden' name="Cod" value='<?=$Cod?>'>
                        <button name='ok'>Realizado</button></td>
                        </form>
                        </tr>
                        
                    <?php
                    }                 
            }
            if(isset($_POST["ok"]))
            {
                $Cod = $_POST["Cod"];
                rlz($Cod);
            }
        ?>
    </table>
    </div>
</body>
</html>