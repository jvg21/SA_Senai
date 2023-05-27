<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/base/pipoteca.php");//BIBLIOTECA
    $Nivel = $_SESSION["nivel"];
    $Email = $_SESSION["email"];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo_agendamento.css">
    <title>Agendamento</title>
    <script type="text/javascript" src="/JS/Mascaras.js"></script><!-- Mascaras nos inputs-->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
		<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

		<script type="text/javascript">
			$(document).ready(function(){
				$('#servico').on('change',function(){
					var servico = $(this).val();
					if(servico){
						$.ajax({
							type:'POST',
							url:'ajaxatendente.php',
							data:'servico='+servico,
							success:function(html){
								$('#funcionario').html(html);
							}
						});					
					}else{
						$('#funcionario').html('<option value="">Selecione o Serviço Antes</option>');
					}
				});
			});

    function voltar()
    {
    window.location="/menu.php";
    }
		</script>
</head>
<body>
    <div class="Banner">
        <img src="Image/roxinho.jpg" alt="banner" />
    </div>
    <h1 class="TITULOAgendamento" > Agendamento </h1>
    <div class="Nav">
       <li><a href="../../menu.php">Menu</a></li> 
    </div>
    <form action="#" method="POST">

        <label class="LBLCPF" > CPF </label>
        <input class="TXTCPF" type="text" name="cpf" placeholder="CPF"  maxlength=14 required onkeydown="javascript: fMasc( this, mCPF );"/>

        <label class="LBLClinica" > Clinica </label>
        <select class="TXTClinica" name="clinica" required>
            <option class="OpClinica" value="">Selecione uma Clinica...</option>
            <?php select('sa','clinica','Cod_Clinica','Nome_Filial','') ?>
        </select>
        
        <input class="ButtonProcurar" type="submit" name="anome" value="Procurar" />
       
    </form>
    </br>
    <?php
        if (isset($_POST['anome']))
        {  
            $conexao=conectadb();

            $CPF=$_POST["cpf"]; 
            $_SESSION["Clinica"] = $_POST["clinica"];
            $Clinica = $_SESSION["Clinica"];
            $sql = "SELECT * FROM cliente WHERE CPF ='$CPF';";
            
            if ($Nivel==0) //SE O USUÁRIO FOR UM CLIENTE
            {  
                $sql = "SELECT * FROM cliente WHERE CPF ='$CPF' AND Email='$Email'";
            }
        
            $result = $conexao->query($sql);
                if ($result->num_rows > 0)
                {   
                    //PARA PEGAR O NOME DA CLINICA
                    $sel = "SELECT * FROM clinica WHERE Cod_Clinica= '$Clinica';";
                    $resultado = $conexao->query($sel);
                    if ($resultado->num_rows > 0)
                    {
                        $LN = $resultado->fetch_assoc();
                        echo "<div class='Nome_Filial' >";
                        echo "Clinica: ".$LN['Nome_Filial'];
                        echo '<br/>';
                        echo "</div>";
                    }///////////////////////////////////////////////
                
                    $linha = $result->fetch_assoc();
                    $Cpf = $linha["CPF"];
                        echo "<div class='Nome_Cliente' >";
                        echo "Cliente: ".$linha['Nome'];
                        echo "</div>";
                        $_SESSION["cod_cli"] = $linha["ID_Cliente"];
                        include ('formulario.php');
                } else 
                if ($result->num_rows == 0)//se não houverem registros do cpf  sistema faz logout
                {
                    echo'<script>
                        alert("Cpf inválido");
                        window.location="../menu.php";   
                    </script>';
                }  
        }
    ?>
    
</body>
</html>