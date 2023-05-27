<?php
require_once($_SERVER['DOCUMENT_ROOT']."/base/pipoteca.php");//BIBLITECA
$Cod_Pegar = $_POST["Alterar"];
$conexao = conectadb();

    if(isset($_POST["Cancelar"]))
        {
			$sql="DELETE FROM agenda WHERE Cod_Agenda=$Cod_Pegar";//CANCELA O AGENDAMENTO
			$result = $conexao->query($sql);
            echo'<script>
                alert("Cancelado");
                window.location="clienteag.php";   
            </script>';
        }
        if(isset($_POST["Confirmar"]))
        {   
			$sql="UPDATE agenda SET status_age = 2 WHERE Cod_Agenda=$Cod_Pegar"; //CONFIRMA O AGENDAMENTO
			$result = $conexao->query($sql);
            echo'<script>
                alert("Sucesso ao Confirmar");
                window.location="clienteag.php";   
            </script>';
        }
?>