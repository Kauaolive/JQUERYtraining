<?php
require_once "includes/dbh.inc.php";

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    header("Location: index.php");
    exit("Método inválido.");
}

$pesquisaUsuario = isset($_GET["pesquisaUsuario"]) ? trim($_GET["pesquisaUsuario"]) : '';
$pesquisaCNPJ = isset($_GET["pesquisaCNPJ"]) ? trim($_GET["pesquisaCNPJ"]) : '';
$pesquisaEmail = isset($_GET["pesquisaEmail"]) ? trim($_GET["pesquisaEmail"]) : '';
$pesquisaTelefone = isset($_GET["pesquisaTelefone"]) ? trim($_GET["pesquisaTelefone"]) : '';
$pagination = isset($_GET["pagination"]) && is_numeric($_GET["pagination"]) ? (int) $_GET["pagination"] : 0;
$situacao = isset($_GET["situacao"]) ? trim($_GET["situacao"]) : '';

$pesquisaUsuario = '%' . htmlspecialchars($pesquisaUsuario) . '%';
$pesquisaCNPJ = '%' . htmlspecialchars($pesquisaCNPJ) . '%';
$pesquisaEmail = '%' . htmlspecialchars($pesquisaEmail) . '%';
$pesquisaTelefone = '%' . htmlspecialchars($pesquisaTelefone) . '%';

$limite = 12;
$offset = $pagination * $limite;

try {
    $query = "SELECT * FROM usuarios WHERE
        usuario LIKE :pesquisaUsuario
         AND
        CNPJ_CPF LIKE :pesquisaCNPJ
         AND
        email LIKE :pesquisaEmail
         AND
        telefone LIKE :pesquisaTelefone ";

    if( $situacao != ""){
        $query .= "AND situacao = :situacao ";

    }

    $query .= "ORDER BY usuario ASC LIMIT :offset, :limite;";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":pesquisaUsuario", $pesquisaUsuario, PDO::PARAM_STR);
    $stmt->bindParam(":pesquisaCNPJ", $pesquisaCNPJ, PDO::PARAM_STR);
    $stmt->bindParam(":pesquisaEmail", $pesquisaEmail, PDO::PARAM_STR);
    $stmt->bindParam(":pesquisaTelefone", $pesquisaTelefone, PDO::PARAM_STR);

    if( $situacao != ""){
        $stmt->bindParam(":situacao", $situacao, PDO::PARAM_STR);
    }
    $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
    $stmt->bindParam(":limite", $limite, PDO::PARAM_INT);

    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    exit("<p>Erro na pesquisa: " . htmlspecialchars($e->getMessage()) . "</p>");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Pesquisar informações</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<section>

    <?php 
    if (empty($resultados)) {?>
       <div><p>Nenhum resultado encontrado.</p></div>
       <div id="paginacao">
            <?php if($pagination > 0):?>
            <button class='paginacaoBtn' onclick='carregarPagina(<?php echo $pagination - 1?>)'><<</button>
            <?php endif; ?>
        </div>
            <?php
    } else {?>
        <table>
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>CNPJ/CPF</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php
        foreach ($resultados as $row) :?>
                <tr>
                    <td><?= htmlspecialchars($row["usuario"]) ?></td>
                    <td><?= htmlspecialchars($row["email"]) ?></td>
                    <td><?= htmlspecialchars($row["telefone"]) ?></td>
                    <td><?= htmlspecialchars($row["CNPJ_CPF"]) ?></td>
                    
                    <td>
                        <form action='At&Del/indexAtualizar.php' method='GET' style='display:inline;'>
                            <input type='hidden' name='idUsuario' value='<?= htmlspecialchars($row['id']) ?>'>
                            <button type='submit' class='edit'>Editar</button>
                        </form>
                        <form action='At&Del/indexDelet.php' method='GET' style='display:inline;'>
                            <input type='hidden' name='idUsuario' value='<?= htmlspecialchars($row['id']) ?>'>
                            <button type='submit' class='delete'>Deletar</button>
                        </form>
                    </td>
                </tr>
        <?php 
        endforeach;?>
                
            </tbody>
        </table>
        
        <div id='paginacao'>
            <?php
        if ($pagination > 0) :?>
            <button class='paginacaoBtn' onclick="carregarPagina(<?= $pagination  - 1?>)"><<</button>
            <?php 
        endif; ?>
        
        <button class='paginacaoBtn' onclick="carregarPagina(<?= $pagination + 1?>)">>></button>
    </div>
</section>
<script src="script.js" type="text/javascript"></script>
</body>
    <?php
    }
?>