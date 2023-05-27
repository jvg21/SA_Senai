<br/><br/>
<script>
function showCustomer(str) {
    console.log(str);
  var xhttp;  
  if (str == "") {
    document.getElementById("horarios").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("horarios").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "horarios.php?q="+str, true);
  xhttp.send();
}
</script>

<form action="grava.php" method="POST">

			<label class="LBLServico" > Serviço </label>
			<select class="SelectServico" name="servico" id="servico" required>
			<?php
				$db = new mysqli("localhost","root","","sa");
				$sql = "SELECT * FROM servico";
				$query = $db->query ($sql);
				while ($linha = $query->fetch_assoc())
				{
					echo '<option value="'.$linha['Cod_Servico'].'"> '.$linha['Nome_Servico'].' </option>\n';
				}
			?>
			</select>
			<label class="LBLAtendente" > Atendente </label>
			<select class="SelectAtendente" name="funcionario" id="funcionario"  onchange="showCustomer(this.value)">
				<option value="">Selecionar Serviço antes </option>
			</select>

    <!--<select name="servico" required>
      <option value="">Selecione um Serviço...</option>
        <?php //select('sa','servico','Cod_Servico','Nome_Servico','') ?>
    </select>
    <br/>
    <br/>

    <label> Atendente  </label> <br/>
    <select name='atendente' required onchange="showCustomer(this.value)">
        <option value="">Selecione um Atendente...</option>
        <?php //select('sa','funcionario','ID_Funcionario','Nome','WHERE Cod_Clinica="$Clinica"') ?>
    </select>
    <br/>-->

    <div id="horarios"></div>
    <label class="LBLData" > Data </label> <br/>
    <input class="InputData" type="date" name="data_age" value="<?= date ('Y-m-d') ?>" required />
    <br/>
    <br/>
    <label class="LBLHora" > Hora <label> <br/>
    <select class="SelectHora" name="hora_age" required>
      <option value="">Selecione um horário...</option>
      
      <?php
      
          $hora = '08:30';
          for ($i=1;$i<=23;$i++)
          {
              $hora = date('H:i',strToTime('+30 minutes',strtotime($hora)));
              echo "<option value='{$hora}'>{$hora}</option>";
          }
      
      ?>
    </select>
    <br/><br/>
    <input class="ButtonEnviar" type="submit" name="enviado" value="Enviar" />
</form>