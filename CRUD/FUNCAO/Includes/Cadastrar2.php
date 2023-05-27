<?php
error_reporting(0);
if(isset($_POST["funcao"]) && isset($_POST["salario"]) )
{  //
    ////////verificando campos e a conexão com o bd
  
    if(empty($_POST["funcao"])){
        $erro = "O campo função é obrigatório";

    }
    else if (empty($_POST["salario"])){
        $erro = "O campo salário é obrigatório";
    }
    else {
        $conexao = new mysqli("127.0.0.1", "root", "", "sa");

        if ($conexao->connect_errno)//verifica se existem erros na conexao
        {
        echo "Ocorreu um erro na conexão com o banco de dados.";
        exit;
        }

        /////////////////////////////
        $funcao = $_POST["funcao"];
        $salario = $_POST["salario"];

        $stmt = $conexao->prepare("INSERT INTO funcao (Nome_Funcao,Salario) VALUES (?,?)");

        $stmt->bind_param('sd', $funcao,$salario);//......se um deles for INT....tem que mudar o S para I   
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
</head>
<body>
    
</body>
</html>
