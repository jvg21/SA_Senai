<?php
error_reporting(0);
include($_SERVER['DOCUMENT_ROOT']."/SA_Senai/base/pipoteca.php");

if(isset($_POST["Gerente"]) && isset($_POST["Clinica"]) && isset($_POST["Cep"]) 
&& isset($_POST["Numero"]) && isset($_POST["Rua"]))
{   ////////verificando campos e a conexão com o bd
    if(empty($_POST["Gerente"])){
        $erro = "O campo gerente é obrigatório";
    }
    else if (empty($_POST["Clinica"])){
        $erro = "O campo clinica é obrigatório";
    }
    else if (empty($_POST["Cep"])){
        $erro = "O campo CEP é obrigatório";
    }
    else if (empty($_POST["Numero"])){
        $erro = "O campo Numero é obrigatório";
    }
    else if (empty($_POST["Rua"])){
        $erro = "O campo Rua é obrigatório";
    }
    else {
        $conexao = conectadb();
        /////////////////////////////DECLARANDO AS VARIAVEIS COM OS POST DO CADASTRAR 1
        $Clinica = $_POST["Clinica"];
        $Gerente = $_POST["Gerente"];
        $Cep = $_POST["Cep"];
        $Endereco = $_POST["Rua"];
        $Numero = $_POST["Numero"];
        $Complemento = $_POST["Complemento"];
        $Estado = $_POST["Uf"];
        $Cidade = $_POST["Cidade"];
        $Bairro = $_POST["Bairro"];
        $Telefone1 = $_POST["Tel1"];
        $Telefone2 = $_POST["Tel2"];

        $BCE=BCEname($Bairro,$Cidade,$Estado);////CONVERTE O NOME DO BAIRRO,CIDADE,ESTADO EM SEUS CÓDIGOS

        $Estado = $BCE[0];//ESPAÇO REFERENTE AO COD_ESTADO
        $Cidade = $BCE[3];//ESPAÇO REFERENTE AO COD_CIDADE
        $Bairro = $BCE[5];//ESPAÇO REFERENTE AO COD_BAIRRO

        $stmt = $conexao->prepare("INSERT INTO clinica (Nome_Filial,Nome_Gerente,Telefone,Telefone2,CEP,Endereco,Numero_Endereco,Complemento,Cod_bairro,Cod_Cidade,Cod_Estado) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('ssssssisiii',$Clinica,$Gerente,$Telefone1,$Telefone2,$Cep,$Endereco,$Numero,$Complemento,$Bairro,$Cidade,$Estado);/*,$Bairro,$Cidade,$Estado*/
        //......se um deles for INT....tem que mudar o S para I   
        if(!$stmt->execute())
        {
			$erro = $stmt->error;
        }
        else
        {
			$sucesso = "Dados cadastrados com sucesso!";
        }
       
    }
}

if(isset($erro)){
	echo '<div style="color:#F00">'.$erro.'</div><br/><br/>';
}

if(isset($sucesso)){
	echo '<div style="color:#00f">'.$sucesso.'</div><br/><br/>';
}

?>
</body>
</html>
