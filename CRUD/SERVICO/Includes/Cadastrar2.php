<?php

if(isset($_POST["Nome_Servico"]) && isset($_POST["Duracao"]) && isset($_POST["Valor"]))
{  
    ////////verificando campos e a conexão com o bd
  
    if(empty($_POST["Nome_Servico"])){
        $erro = "O campo serviço é obrigatório";

    }
    else if (empty($_POST["Duracao"])){
        $erro = "O campo Duração é obrigatório";
    }
    else if (empty($_POST["Valor"])){
        $erro = "O campo Valor é obrigatório";
    }
    else {
        $conexao = new mysqli("127.0.0.1", "root", "", "sa");

        if ($conexao->connect_errno)//verifica se existem erros na conexao
        {
        echo "Ocorreu um erro na conexão com o banco de dados.";
        exit;
        }

        /////////////////////////////
        $Servico = $_POST["Nome_Servico"];
        $Duracao = $_POST["Duracao"];
        $Valor = $_POST["Valor"];

        $stmt = $conexao->prepare("INSERT INTO servico (Nome_Servico,Duracao,Valor) VALUES (?,?,?)");

        $stmt->bind_param('sid', $Servico,$Duracao,$Valor);//......se um deles for INT....tem que mudar o S para I   
        //$stmt->bind_param('ssss', $nome, $email, $cidade, $uf);
        
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
