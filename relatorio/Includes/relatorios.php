<html>
<body>
<div class="DivDadosRelatorios">
<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/SA_Senai/base/pipoteca.php");
include("bibliorelatorios.php");
?>

<!DOCTYPE html>
<head>
    <title>Relatórios</title>
</head>
<body>
    <form method="GET">
        
        <label>A partir de: </label>
        <input class="TXTData" type="date" name="Data" required>
        <label>Clinica: </label>
        <button class="ButtonServContr" type="submit" value="1" name="x">Relatório de Serviços Contratados</button>
        <button class="ButtonRendFunc" type="submit" value="2" name="x">Relatório de Rendimento do Funcionário</button>
        <?php 
        echo "<div class='Relatorioscombo' >";
        combo("Cod_Clinica","Nome_Filial","clinica","Clinica","false","True");
        echo "</div>";
        ?>
    </form> 
<?php
if(isset($_GET["x"])){
    $X = $_GET["x"];
    $Clinica = $_GET["Clinica"];
    $Data = $_GET["Data"];

    $Select="";
    switch ($_GET["x"]){
        case 1: servicos($Clinica,$Data);
        break;
        case 2: Funcionario($Clinica,$Data);
        break;

    }
}
?>
</div>
</body>
</html>



