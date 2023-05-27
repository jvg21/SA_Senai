<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Gravado</title>
</head>
<body>
    <?php
        
        require_once($_SERVER['DOCUMENT_ROOT']."/SA_Senai/base/pipoteca.php");
        //print_r($_POST);
        if (isset($_POST["enviado"]))
        {
            // Pega os dados
            $cod_cli = $_SESSION["cod_cli"];
            $cod_ate = $_POST["funcionario"];
            $cod_cln = $_SESSION["Clinica"];
            $cod_ser = $_POST["servico"];
            $data_age = $_POST["data_age"];
            $hora_age = $_POST["hora_age"];
            $status_age = 1;

            // Verificar horário incompatível
            // SELECT * FROM agendamento...

            // INSERIR NO BANCO
            $conexao=conectadb();
            $sql = "INSERT INTO agenda (ID_Cliente, ID_Funcionario ,Cod_Servico, Cod_Clinica ,AData ,Horario, status_age ) VALUES (?,?,?,?,?,?,?)";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("iiiissi", $cod_cli,$cod_ate,$cod_ser,$cod_cln,$data_age,$hora_age,$status_age);
            if (! $stmt -> execute()) {
                echo'<script>
                        alert("Falha ao agendar");
                       
                        window.location="../cadastrar.php";   
                    </script>';
            } else
            {
                echo'<script>
                        alert("Sucesso ao agendar");
                        window.location="agendar.php";   
                    </script>';
            }
            echo "<a href='agendar.php' class='abutton'> Voltar </a>";
        } else
        {
            echo "acesso inválido";
        }
    ?>  
</body>
</html>
