
<!DOCTYPE html>
<html>

<head>
    <title>Cadastrar Função</title>
</head>

<body>
    <form class="Formulario"method="POST">

        <div class="divCadastar">
            <a class="aFuncao">Função:</a>
            <input class="Funcao" type="text" name="funcao" required />
            <a class="aSalario">Salario:</a>
            <input class="Salario" type="number" name="salario" required />
        </div>

        <input type="hidden" value="-1" name="Codigo" />
        <div class="middle">
        <button class="Cad Cad1" type="submit">Cadastrar</button>
        </div>
    </form>

</body>

</html>