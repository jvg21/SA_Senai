<?php
echo "<div class='DivHorarios' >";
    require_once($_SERVER['DOCUMENT_ROOT']."/SA_Senai/base/pipoteca.php");

    $atendente = $_GET['q']; // Pega o valor do atendente

    // Auxíliar
    $datahoje = date("d.m.Y");
 
    //echo "<p> Data de Hoje: ".$datahoje."</p>";   
    // Dia da Semana
    $diasem = date("N");

    // Array para a Tabela
    $tabela = Array(
        array ("Horários","segunda","terça","quarta","quinta","sexta","sábado")
    );

    // completar a tabela horários e posições começando em 06:30 + 30 = 07:00
    $hora = '08:30';
    for ($i=1;$i<=23;$i++)
    {
        $hora = date('H:i',strToTime('+30 minutes',strtotime($hora)));
        $tabela[$i] = Array ($hora,"","","","","","");
    }

    // Mês
    $ames = array ("","Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
    $mes = date("n"); // o número do mês
    //echo "<p> Mês: $mes </p>";
    // Cabeçalho da tabela
    echo "<table class='tabela_horarios'>";
    echo "<tr> <th colspan=8 class='tab_mes'>".$ames[$mes]."</th></tr>";
    //echo "<tr> <th colspan='8'> Agenda </th> </tr>";
    echo "<tr>";
    // Titulos colunas

    $dia_mes = date ('d'); // dia do mês
    $dia_mes = $dia_mes - $diasem; // acertar a semana
    echo "<th>".$tabela[0][0]."</th>"; // Palavra horário
    for ($i=1;$i<7;$i++) // Adiciona dia ao dia da semana
    {
        echo "<th>";
        echo $tabela[0][$i]." \n \n \n";
        echo  ($dia_mes+$i)."</th>";
    }
    echo "</tr>";
    // Mostra turno
    $conexao=conectadb();
    $sql = "SELECT * FROM funcionario WHERE ID_Funcionario = ? ";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $atendente);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($linha = $result->fetch_assoc())
    {
        for ($i=1;$i<7;$i++)
        {
            
                if ($linha['Turno1']==1) // Se for primeiro turno vai das 07:00 até 14:00
                {
                   for ($j=1;$j<12;$j++)
                    $tabela[$j][$i] ="X"; // Marca com X como disponível
                }
                if ($linha['Turno2']==1) // Se for segundo turno vai das 14:30 até 21:00
                {
                    for ($j=14;$j<24;$j++)
                    $tabela[$j][$i] ="X"; // Marco com X como disponível
                 }            
            
        }
    }

    // Verifica agenda
    // Data inicio => $dia_mes
    $ano = date ('Y');
    $Mdias = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); // 31
    //echo "Existem ".$Mdias." dias no mês $mes de ".$ano."";
    $ver = ($Mdias - $dia_mes);

    //var_dump($dia_mes+7,$ver,$Mdias);
    $data_inicio = $ano.'-'.$mes.'-'.($dia_mes+1);
    if($dia_mes+7>$Mdias)
    {
        //ECHO 'FERROU';
        $data_fim = $ano.'-'.($mes).'-'.($dia_mes+$ver) ;
    }else
    {
        $data_fim = $ano.'-'.$mes.'-'.($dia_mes+7);
        $ver = 6;
    }
    //echo "<p> Data Inicio: $data_inicio </p>";
    //echo "<p> Data Fim: $data_fim </p>";
    //echo "<p> Código atendente: $atendente </p>";
    $conexao=conectadb();
    $sql = "SELECT a.*, s.* FROM agenda AS a, servico AS s WHERE a.ID_Funcionario = ? AND a.AData >= ? AND a.AData <= ? AND a.Cod_Servico=s.Cod_Servico";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("iss", $atendente, $data_inicio, $data_fim);
    if (! $stmt -> execute()) {
        echo $stmt -> error;
    }
    $result = $stmt->get_result();
    while ($linha = $result->fetch_assoc())
    {
        $horario = $linha['Horario'];
        $tempo = $linha['Duracao'];
        $dia = date('N',strtotime($linha['AData']));
       // echo "<p> $dia </p>";
        for ($i=1;$i<=23;$i++)
        {
            if (substr($horario,0,5) == $tabela[$i][0])
            {
                // Encontrou o horário na tabela
                $linhas = $tempo / 30; // Tempos em múltiplos de 30 minutos
                for ($k=0;$k<$linhas;$k++) // Quantas linhas vamos ter que alocar
                {
                    $tabela[$i+$k][$dia] = "";
                }
            }
        }

        // Grifar linha e coluna na tabela
        //echo "<p> $horario -  $tempo </p>";
    }
    // Mostra a tabela completa
    for ($j=1;$j<=23;$j++)
    {
        echo "<tr>";
        for ($i=0;$i<$ver+1;$i++)
        {
            if ($tabela[$j][$i]=="X"){
                echo "<td class='trabalha'>&check;</td>";  
            } else if ($tabela[$j][$i]=="") 
            {
                echo "<td class='nao_trabalha'>&#9747;</td>";
            } else
            {
                echo "<td>".$tabela[$j][$i]."</td>";
            }
        }
        echo "</tr>"; 
    }

    echo "<table/>";
    $stmt->close();
    echo "</div>";
?>