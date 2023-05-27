<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/base/pipoteca.php");//biblioteca
    error_reporting(0);
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css.css" />
    <script src="/JS/jquery-3.6.0.min.js"></script>
    <script src="/JS/CEP.js"></script> <!-- Buscador de CEP-->
    <script type="text/javascript" src="/JS/Mascaras.js"></script><!-- Mascaras nos inputs-->
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
        window.location="/index.php";
    }

</script>
    
    <form class="Form2" method="POST">
    <label class="TITULO" >CADASTRAR FUNCIONARIO</label>
    
    <div class="divTudo">

    <div class="divSenha_Nome">   
    <input  class="TXTNome" type="text" name="Nome" placeholder="Nome Completo" minlength="2" required/>
    <input class="TXTSenha" type="password" name="Senha" maxlenght=15 placeholder="Senha" required>
    </div>

    <div class="divData_CPF_RG">
    <input class="TXTCPF" type="text" name="Cpf" placeholder="CPF" required minlength="14" maxlength=14 onkeydown="javascript: fMasc( this, mCPF );"/>
    <input class="TXTRG" type="text" name="Rg" placeholder="RG" required maxlength=15/>
    <input class="TXTData" type="date" name="NData" placeholder="Data de Nascimento" required/>
    </div>

    <div class="divEmail">
    <input class="TXTEmail" type="email" name="Email" Id="Email" placeholder="Email" required/>
    <input class="TXTConfEmail" type="email" name="Cemail" Id="Cemail" placeholder="Confirmar Email" onblur="confirmEmail()" required/>
    </div>

    <div class="divCEP">
    <input class="TXTCEP" name="Cep" type="text" id="Cep" placeholder="CEP" value="" maxlength="10" required onkeydown="javascript: fMasc( this, mCEP );"/>
    </div>

    <div class="divBuscCEP">
    <button class="TXTBuscCEP" onclick="Abrir('https://buscacepinter.correios.com.br/app/localidade_logradouro/index.php')" type="button">Buscar CEP</button>
    </div>

    <div class="divEndereco">
    <input class="TXTRua" name="Rua" type="text" id="Rua" placeholder="Rua" readonly required/> 
    <input class="TXTBairro" name="Bairro" type="text" id="Bairro" placeholder="Bairro" readonly required/>
    <input class="TXTCidade" name="Cidade" type="text" id="Cidade" placeholder="Cidade" readonly required/>
    <input class="TXTUF" name="Uf" type="text" id="Uf" size="2" placeholder="UF" readonly required/>
    <input class="TXTNumero" type="number" name="Numero" placeholder="Numero" required />
    <input class="TXTComplemento" type="text" name="Complemento" placeholder="Complemento" />
    </div>

    <div class="divTelefone">
    <input class="TXTTelefone" type="text" name="Tel" placeholder="Telefone" maxlength=14 onkeydown="javascript: fMasc( this, mTel );" required/>
    <input class="TXTTelefone" type="text" name="Tel2" placeholder="Telefone 2" maxlength=14 onkeydown="javascript: fMasc( this, mTel );"/>
    <input type="hidden" value="-1" name="Codigo"/>

    <?php
    combo("Cod_Clinica","Nome_Filial","clinica","Clinica","false","True");
    combo("Cod_Funcao","Nome_Funcao","funcao","Funcao","false","True");
    ?>
    </div>
    <label class="TXTCheckbox" >Manhã</label>
    <input class="Checkbox" type="checkbox" name="Manha" value="1">
    <label class="TXTCheckbox" >Tarde</label>
    <input class="Checkbox" type="checkbox" name="Tarde" value="1">
    <button class="ButtonVoltar" type="button" onclick="voltar()">Voltar</button>
    <button class="ButtonEnviar" type="submit" name="Enviar" onclick="confirmEmail()">Enviar</button>
    </div>
    </form>
<?php 

if(isset($_POST["Enviar"])){

    if (isset($_POST["Manha"])){
        $Turno1 = 1;
    }else{
        $Turno1 = 0;
    }

    if (isset($_POST["Tarde"])){
        $Turno2 = 1;
    }else{
        $Turno2 = 0;
    }
    $Nome = $_POST["Nome"];
    $Senha = MD5($_POST["Senha"]);
    $Cpf = $_POST["Cpf"];
    $Rg = $_POST["Rg"];
    $Data = $_POST["NData"];
    $Email = $_POST["Email"];
    $Cmail = $_POST["Cemail"];
    $Cep = $_POST["Cep"];
    $Rua = $_POST["Rua"];
    $Num =  $_POST["Numero"];
    $Bairro = $_POST["Bairro"];
    $Cidade = $_POST["Cidade"];
    $Estado = $_POST["Uf"];
    $Complemento = $_POST["Complemento"];
    $Telefone1 = $_POST["Tel"];
    $Telefone2 = $_POST["Tel2"];
    $Clinica = $_POST["Clinica"];
    $Funcao = $_POST["Funcao"];
    $Ativado = 1;
    $Nivel = 6;

    if($Email!=$Cmail){///SE OS EMAILS NÃO CORRESPONDEREM E O USUÁRIO IGNORAR O AVISO VOLTA PRA TELA INICIAL DE CADASTRO
        header("Location: /CRUD/FUNCIONARIO/cadastrar.php");
    }
    $BCE = BCEname($Bairro,$Cidade,$Estado);//TRANFORMA OS NOMES EM ID
    $Estado = $BCE[0];
    $Cidade = $BCE[3];
    $Bairro = $BCE[5];
    $conexao = conectadb();
  
    $Clinica = GetTheName($Clinica,"Cod_Clinica","Cod_Clinica","clinica");
    $Funcao = GetTheName($Funcao,"Cod_Funcao","Cod_Funcao","funcao");
    //CADASTRA O FUNC

    $stmt = $conexao->prepare("INSERT INTO funcionario(Nome,CPF,RG,Data_Nascimento,Telefone,Telefone2,Email,
    CEP,Endereco,Numero_Endereco,Complemento,Cod_Clinica,Cod_Funcao,Cod_Estado,Cod_Cidade,Cod_Bairro,Turno1,Turno2,Ativado) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param('sssssssssisiiiiiiii',$Nome,$Cpf,$Rg,$Data,$Telefone1,$Telefone2,$Email,$Cep,$Rua,$Num,
    $Complemento,$Clinica,$Funcao,$Estado,$Cidade,$Bairro,$Turno1,$Turno2,$Ativado);//......se um deles for INT....tem que mudar o S para I   
      //$stmt->bind_param('ssss', $nome, $email, $cidade, $uf);
    if(!$stmt->execute())
    {
        $erro = $stmt->error;
     }
    //CADASTRA A CONTA DO USUÁRIO 
    $stmt1 = $conexao->prepare("INSERT INTO usuario (Nome,Email,Senha,Nivel) VALUES (?,?,?,?)");
    $stmt1->bind_param('sssi',$Nome,$Email,$Senha,$Nivel);
    if(!$stmt1->execute())
    {
        $erro = $stmt1->error;
    }
    else
    { //CAMINHO FELIZ
    echo "Dados cadastrados com sucesso!";
           
    }
}

?>
</body>
</html>