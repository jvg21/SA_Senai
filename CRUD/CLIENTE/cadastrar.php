<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/SA_Senai/base/pipoteca.php");//biblioteca
    require_once("auxiliar.php");
    error_reporting(0);

    $UNome="";
    $UEmail="";
    $USenha="";
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <script src="/SA_Senai/JS/jquery-3.6.0.min.js"></script>
    <script src="/SA_Senai/JS/CEP.js"></script> <!-- Buscador de CEP-->
    <script type="text/javascript" src="/SA_Senai/JS/Mascaras.js"></script><!-- Mascaras nos inputs-->

    <link href="/SA_Senai/css/css_cadastrar.css" type="text/css" rel="stylesheet">
    <link href="./Cadastrar.css" type="text/css" rel="stylesheet">
    <title>Cadastrar Conta</title>
</head>
<body>

<script type="text/javascript">

    function confirmEmail() {
        var email = document.getElementById("Email").value
        var confemail = document.getElementById("Cemail").value

        if(email != confemail) {
            alert('Email não correspondendo!');
        }
    }
    function voltar(){
        window.location="/SA_Senai/index.php";
    }

</script>

    <div class="caixa">
        <div class="login">
            <p>CADASTRAR</p>
        </div> 

        <form class="Usuario" method="POST">
        <div class="nome">
            <input type="text" name="Nome" placeholder="&#128100 NOME COMPLETO:" required/><br/>
        </div>
        <div class="email">
            <input type="email" name="Email" placeholder="&#128231 E-MAIL:" required>
        </div>
        <div class="senha">
            <input type="password" name="Senha" maxlenght=15 placeholder="&#128273 SENHA:" required>
        </div>
        <br/>
        <div class="botao">
            <button class="ButtonVoltar" type="button" onclick="voltar()">VOLTAR</button>
            <input type="submit" name="Proximo" value="PRÓXIMO" />
        </div>
        </form>

    </div>
    
<?php 
if(isset($_POST["Proximo"]))
{ 
    $UNome=$_POST["Nome"];
    $UEmail=$_POST["Email"];
    $USenha=MD5($_POST["Senha"]);

    echo'<script> limpar(); </script>';//limpar a tela
    
?>
    <Label class="TituloForm2" > Cadastre Seus dados </Label>

    <div class="DivCadastro">

    <form class="Form2" method="POST">
    <input class="TXTNome" type="text" value="<?=$UNome?>" minlength="2" name="nome"/>
    <input class="TXTCPF" type="text" name="Cpf" placeholder="CPF" required minlength="14" maxlength="14" onkeydown="javascript: fMasc( this, mCPF );"/>
    <input class="TXTRG" type="text" name="Rg" placeholder="RG" maxlength=20 required />
    <input class="InputData" type="date" name="NData" placeholder="Data de Nascimento" required/>

    <input class="TXTEmail" type="email" name="Email" Id="Email" placeholder="Email" value='<?=$UEmail?>' required/>
    <input class="TXTConfEmail" type="email" name="Cemail" Id="Cemail" placeholder="Confirmar Email" onblur="confirmEmail()" required/>

    <input class="TXTCEP" name="Cep" type="text" id="Cep" placeholder="CEP" value="" maxlength="10" required onkeydown="javascript: fMasc( this, mCEP );"/>
    
    <button class="ButtonProcCep" onclick="Abrir('https://buscacepinter.correios.com.br/app/localidade_logradouro/index.php')" type="button">Não sei meu cep</button>
    <input class="TXTRua" name="Rua" type="text" id="Rua" placeholder="Rua" readonly required/> 
    <input class="TXTBairro" name="Bairro" type="text" id="Bairro" placeholder="Bairro" readonly required/>
    <input class="TXTCidade" name="Cidade" type="text" id="Cidade" placeholder="Cidade" readonly required/>
    <input class="TXTUf" name="Uf" type="text" id="Uf" size="2" placeholder="UF" readonly required/>
    <input class="TXTNumero" type="number" name="Numero" placeholder="Numero" required />
    <input class="TXTComplemento" type="text" name="Complemento" placeholder="Complemento" />

    <input class="TXTTel1" type="text" name="Tel1" placeholder="Telefone" maxlength=14 onkeydown="javascript: fMasc( this, mTel );" required/>
    <input class="TXTTel2" type="text" name="Tel2" placeholder="Telefone2" maxlength=14 onkeydown="javascript: fMasc( this, mTel );"/>

    <input type="hidden" value="-1" name="Codigo"/>
    <input type="hidden" value="<?=$USenha?>" name="senha"/>

    <button class="ButtonForm2Voltar" type="button" onclick="voltar()">Voltar</button>
    <button class="ButtonEnviar" type="submit" name="Enviar" value="Enviado" onclick="confirmEmail()">Enviar</button>
    </form>

    </div>   
<?php 
}//FECHA O IF


if(isset($_POST["Enviar"]))
{   
    GravarUsu();
}
?>
</body>
</html>