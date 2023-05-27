<?php
include($_SERVER['DOCUMENT_ROOT']."/base/pipoteca.php");
$Email = $_SESSION["email"];
require_once("auxiliar.php");
error_reporting(0);

?>

<!DOCTYPE html>
<head>
<meta charset="UTF-8">
    <script src="/JS/jquery-3.6.0.min.js"></script>
    <script src="/JS/CEP.js"></script> <!-- Buscador de CEP-->
    <script type="text/javascript" src="/JS/Mascaras.js"></script><!-- Mascaras nos inputs-->
    <link href="/css/css_cadastrar.css" type="text/css" rel="stylesheet">
    <link href="Cadastrar.css" type="text/css" rel="stylesheet">
    <title>Alterar Conta</title>  
</head>
<body>
<script>
    function voltar()
    {
        window.location="/menu.php";
    }
</script>

<form method="GET">
    <label class="LBLAltCPF" >Digite seu CPF</label>
    <input class="TXTAltCPF" type="text" name="Cpf" required maxlength=14 onkeydown="javascript: fMasc( this, mCPF );"/>
    <button class="ButtonAltVoltar" type="button" onclick="voltar()">Voltar</button>
    <button class="ButtonAltEnviar" type="submit">Enviar</button>
</form>

<?php 
if(isset($_GET["Cpf"]))
{

    echo'<script>limpar()</script>';

    $Cpf = $_GET["Cpf"];
    $conexao = conectadb();
    //VERIFICA NO BANCO A EXISTENCIA DO REGISTRO DO CPF
    $sql="SELECT * FROM cliente,usuario WHERE cliente.Email='$Email' AND cliente.CPF='$Cpf'  
    AND cliente.Email=usuario.Email AND usuario.Nivel=0;"; 
    $result = $conexao->query($sql);

    //SE HOUVER REGISTROS
    if ($result->num_rows > 0)
    {
        while ($linha = $result->fetch_assoc())
        {
            //VERIFICADORES
            $CPF = $linha["CPF"];
            if ($Cpf!=$CPF){//verificar o cpf
               echo'<script>
                alert("Cpf inválido");
                limpar();
                window.location="/base/logout.php"; </script>';
            }
            $Nome = $linha["Nome"];
            $Email = $linha["Email"];
            $UserId = $linha["Id"];
            $Id = $linha["ID_Cliente"];

            //ALTERAVEIS
            $Telefone1 = $linha["Telefone"];
            $Telefone2 = $linha["Telefone2"];
            $Senha = $linha["Senha"];
            $Cep = $linha["CEP"];
            $Rua = $linha["Endereco"];
            $Bairro = $linha["Cod_Bairro"];
            $Cidade = $linha["Cod_Cidade"];
            $Estado = $linha["Cod_Estado"];
            $Num = $linha["Numero_Endereco"];
            $Complemento = $linha["Complemento"]; // COLOCAR TELEFONE
        
            $BCE = BCEid($Bairro,$Cidade,$Estado);
            $Bairro = $BCE[6];
            $Cidade = $BCE[4];
            $Estado = $BCE[2];
            ?>    
            <label class="TituloAlt2" > Alterar Dados </Label> 
            <div class="DivForm2Alterar" >
            <form class="Form" method="POST">
                
            <input  class="TXTAlt2Nome" type="text" name="Nome" value="<?=$Nome?>" readonly/>
            <input class="TXTAlt2CPF" type="text" value="<?=$CPF?>" readonly/>
            <input class="TXTAlt2CEP" type="text" name="Cep" id="Cep" placeholder="CEP" value="<?=$Cep?>" maxlength="10" required onkeydown="javascript: fMasc( this, mCEP );"/>
            
            <button class="ButtonAlt2ProcCep" onclick="Abrir('https://buscacepinter.correios.com.br/app/localidade_logradouro/index.php')" type="button">Não sei meu cep</button>

            <input class="TXTAlt2Rua" type="text" name="Rua" id="Rua" placeholder="Rua" value="<?=$Rua?>" readonly required/> 
            <input class="TXTAlt2Bairro" type="text" name="Bairro" id="Bairro" placeholder="Bairro" value="<?=$Bairro?>" readonly required/>
            <input class="TXTAlt2Cidade" type="text" name="Cidade" id="Cidade" placeholder="Cidade" value="<?=$Cidade?>" readonly required/>
            <input class="TXTAlt2Uf" type="text" name="Uf"  id="Uf" size="2" placeholder="UF" value="<?=$Estado?>" readonly required/>
            <input class="TXTAlt2numero" type="number" name="Numero" placeholder="Numero" value="<?=$Num?>" required />
            <input class="TXTAlt2Tel1" type="text" name="Tel1" placeholder="Telefone" maxlength=14 value="<?=$Telefone1?>" onkeydown="javascript: fMasc( this, mTel );" required/>
            <input class="TXTAlt2Tel2" type="text" name="Tel2" placeholder="Telefone2" maxlength=14 value="<?=$Telefone2?>" onkeydown="javascript: fMasc( this, mTel );"/>
            <input class="TXTAlt2Complemento" type="text" name="Complemento" placeholder="Complemento" value="<?=$Complemento?>"  />
            
            <input type="hidden" name="Cpf" placeholder="CPF" value="<?=$CPF?>" required/>
            <button class="ButtonAlt2Voltar" type="button" onclick="voltar()">Voltar</button>
            <button class="ButtonAlt2Enviar" type="submit" name="Enviar">Enviar</button>
            </form>
        </div>
         <?php  
        }//fecha o while

        if (isset($_POST["Enviar"]))
        {
            upd($Id,$Nome);
            echo'
            <script>
                alert("Dados alterardos com sucesso!");
                window.location="/Menu.php";  
            </script>';

        }
    }//fecha o if num_rows
    else if ($result->num_rows == 0)//se não houverem registros do cpf  sistema faz logout
    {
        echo'
            <script>
                alert("Cpf inválido");
                limpar();
                window.location="/../menu.php";   
            </script>';
    }  
    
        
}//FECHA O ISSET CPF
?> 
</body>
</html>