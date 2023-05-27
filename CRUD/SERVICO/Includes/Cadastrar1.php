    <div class="divCadastrar">
        <form  method="POST">

            <a class="LBLServico">Nome do Serviço</a>
            <input class="TXTServico" type="text" name="Nome_Servico" required />
            
            <a class="LBLDuracao">Duração</a>
            <input class="TXTDuracao" type="number" name="Duracao" placeholder="(min)" required />
            
            <a class="LBLValor">Valor</a>
            <input class="TXTValor" type="number" name="Valor" required />
            
            <input type="hidden" value="-1" name="Codigo" />
           <button class="ButtonCad" type="submit">Cadastrar</button>
        </form>
    </div>