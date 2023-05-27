<form method="POST">
	<div>
		<input class="TXTClinica" type="text" name="Clinica" placeholder="Clinica" required />
		<input class="TXTGerente" type="text" name="Gerente" placeholder="Gerente" required />
		<input class="TXTCEP" name="Cep" type="text" id="Cep" placeholder="CEP" value="" maxlength="10" onkeydown="javascript: fMasc( this, mCEP );" required/>
        <button class="ButtonCEP" onclick="Abrir('https://buscacepinter.correios.com.br/app/localidade_logradouro/index.php')" type="button">Descobrir CEP</button>
		<input class="TXTRua" name="Rua" type="text" id="Rua" placeholder="Rua" readonly required/>
        <input class="TXTBairro" name="Bairro" type="text" id="Bairro" placeholder="Bairro" readonly required/>
        <input class="TXTCidade" name="Cidade" type="text" id="Cidade" placeholder="Cidade" readonly required/>
        <input class="TXTUf" name="Uf" type="text" id="Uf" size="2" placeholder="UF" readonly required/>
		<input class="TXTNumero" type="number" name="Numero" placeholder="Numero" required />
		<input class="TXTComplemento" type="text" name="Complemento" placeholder="Complemento" />
		<input class="TXTTel1" type="text" name="Tel1" placeholder="Telefone" maxlength=14 onkeydown="javascript: fMasc( this, mTel );" required/>
    	<input class="TXTTel2" type="text" name="Tel2" placeholder="Telefone2" maxlength=14 onkeydown="javascript: fMasc( this, mTel );"/>
    
		<!--<input type="hidden" value="-1" name="Codigo"/>-->
		<button class="ButtonCadastrar" id="Botao" type="submit">Cadastrar</button>
	</div>
</form>
