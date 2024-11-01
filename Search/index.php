<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Pesquisar informações</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <header>
        <form class="pesquisa" action="pesquisa.php" id="formPesquisa" method="get">

            <input type="text" id="pesquisaUsuario" name="pesquisaUsuario" placeholder="Nome do usuário...">

            <input type="text" id="pesquisaEmail" name="pesquisaEmail" placeholder="Email...">

            <input type="text" id="pesquisaTelefone" name="pesquisaTelefone" placeholder="Telefone...">

            <input type="text" id="pesquisaCNPJ" name="pesquisaCNPJ" placeholder="CNPJ/CPF...">


            <select name="situacao" id="situacao">
                <option value="1">Ativo</option>
                <option value="0">Inativo</option>
                <option value="">Ambos</option>
            </select>

            <input type="hidden" id="pagination" name="pagination" value="0">
            <button type="Submit" id="botaoPesquisa"></button>
        </form>
    </header>

    <div id="pesquisaResultados"></div>

    <script src="script.js" type="text/javascript"></script>
</body>
</html>
