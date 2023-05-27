<?php
function GravarUsu(){ 
    echo'<script>limpar()</script>';//LIMPA A TELA
    
    $Nome=$_POST["nome"];
    $Senha=$_POST["senha"];
    $Cpf = $_POST["Cpf"];
    $Rg = $_POST["Rg"];
    $Data = $_POST["NData"];
    $Email = $_POST["Email"];
    $Cmail = $_POST["Cemail"];
    $Cep = $_POST["Cep"];
    $Rua = $_POST["Rua"];
    $Num = $_POST["Numero"];
    $Bairro = $_POST["Bairro"];
    $Cidade = $_POST["Cidade"];
    $Estado = $_POST["Uf"];
    $Complemento = $_POST["Complemento"];
    $Telefone1 = $_POST["Tel1"];
    $Telefone2 = $_POST["Tel2"];

    if($Email!=$Cmail){///SE OS EMAILS NÃO CORRESPONDEREM E O USUÁRIO IGNORAR O AVISO VOLTA PRA TELA INICIAL DE CADASTRO
        header("Location: /SA_Senai/CRUD/Cliente/cadastrar.php");
    }
    $BCE = BCEname($Bairro,$Cidade,$Estado);//TRANFORMA OS NOMES EM ID

    $Estado = $BCE[0];
    $Cidade = $BCE[3];
    $Bairro = $BCE[5];
   
    $conexao = conectadb();

    //CADASTRA O CLIENTE
    $stmt = $conexao->prepare("INSERT INTO cliente (Nome,CPF,RG,Data_Nascimento,Telefone,Telefone2,Email,CEP,Endereco,Numero_Endereco,Complemento,Cod_Bairro,Cod_Cidade,Cod_Estado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param('sssssssssisiii',$Nome,$Cpf,$Rg,$Data,$Telefone1,$Telefone2,$Email,$Cep,$Rua,$Num,$Complemento,$Bairro,$Cidade,$Estado);//......se um deles for INT....tem que mudar o S para I   
    //$stmt->bind_param('ssss', $nome, $email, $cidade, $uf);
      if(!$stmt->execute())
    {
        $erro = $stmt->error;
    }

    //CADASTRA A CONTA DO USUÁRIO 
    $stmt = $conexao->prepare("INSERT INTO usuario (Nome,Email,Senha) VALUES (?,?,?)");
    $stmt->bind_param('sss',$Nome,$Email,$Senha);
    if(!$stmt->execute())
    {
        $erro = $stmt->error;
    }
    else
    { //CAMINHO FELIZ
    echo'
        <script>
            alert("Dados cadastrados com sucesso!");
            window.location="/SA_Senai/index.php";
        </script>';
    }
}
//////////////////////////////////////////////////////////////////////////
function upd($Id,$Nome){
    $Cep = $_POST["Cep"];
    $Rua = $_POST["Rua"];
    $Num = $_POST["Numero"];
    $Bairro = $_POST["Bairro"];
    $Cidade = $_POST["Cidade"];
    $Estado = $_POST["Uf"];
    $Telefone = $_POST["Tel1"];
    $Telefone2 = $_POST["Tel2"];
    $Complemento = $_POST["Complemento"]; //TELEFONE

    $BCE = BCEname($Bairro,$Cidade,$Estado);
    //var_dump($BCE);

    $Estado = $BCE[0];
    $Cidade = $BCE[3];
    $Bairro = $BCE[5];
    //var_dump($Cep,$Rua,$Num,$Complemento,$Bairro,$Cidade,$Estado);
    $conexao2 = conectadb();

    $sql = "UPDATE cliente SET Telefone='$Telefone',Telefone2='$Telefone2',CEP='$Cep',Endereco='$Rua',Numero_endereco='$Num',
    Cod_Bairro='$Bairro',Cod_Cidade='$Cidade',Cod_Estado='$Estado',Complemento='$Complemento'
    WHERE Id_Cliente=$Id AND Nome='$Nome';"; 

    $conexao2->query($sql);
    $conexao2->close();
    }
?>