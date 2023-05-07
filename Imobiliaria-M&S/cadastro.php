<?php
try {
    include "abrir_transacao.php";
include_once "operacoes.php";

$tipos = listar_imovel();

function validar($imovel) {
    global $tipos;
    return strlen($imovel["area_construida_m2"]) >= 0 && strlen($imovel["area_construida_m2"]) <= 500000
        && strlen($imovel["quartos"]) >= 0
        && strlen($imovel["quartos"]) <= 50
        && strlen($imovel["localizacao"]) >= 4
        && strlen($imovel["localizacao"]) <= 200
        && $imovel["folhas"] >= 0
        && $imovel["folhas"] <= 5000000
        && in_array($imovel["tipo"], $tipos, true);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $alterar = isset($_GET["chave"]);
    if ($alterar) {
        $chave = $_GET["chave"];
        $imovel = buscar_imovel($chave);
        if ($imovel == null) die("Não existe!");
    } else {
        $chave = "";
        $imovel = [
            "chave" => "",
            "cor" => "",
            "especie" => "",
            "localizacao" => "",
            "folhas" => "",
            "tipo" => ""
        ];
    }
    $validacaoOk = true;

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $alterar = isset($_POST["chave"]);

    if ($alterar) {
        $imovel = [
            "chave" => $_POST["chave"],
            "cor" => $_POST["cor"],
            "especie" => $_POST["especie"],
            "localizacao" => $_POST["localizacao"],
            "folhas" => $_POST["folhas"],
            "tipo" => $_POST["tipo"]
        ];
        $validacaoOk = validar($imovel);
        if ($validacaoOk) alterar_imovel($imovel);
    } else {
        $imovel= [
            "cor" => $_POST["cor"],
            "especie" => $_POST["especie"],
            "localizacao" => $_POST["localizacao"],
            "folhas" => $_POST["folhas"],
            "tipo" => $_POST["tipo"]
        ];
        $validacaoOk = validar($imovel);
        if ($validacaoOk) $id = inserir_imovel($imovel);
    }

    if ($validacaoOk) {
        header("Location: listagem.php");
        $transacaoOk = true;
    }
} else {
    die("Método não aceito");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Cadastro de folhas</title>
    <script>
    function confirmar() {
        if (!confirm("Tem certeza que deseja salvar os dados?")) return;
        document.getElementById("formulario").submit();
    }

    function excluir() {
        if (!confirm("Tem certeza que deseja excluir a flor?")) return;
        document.getElementById("excluir-flor").submit();
    }
    </script>
</head>

<body>
    <form method="POST" action="cadastro.php" id="formulario">
        <?php if (!$validacaoOk) {?>
        <div>
            <p>Preencha os campos corretamente!</p>
        </div>
        <?php } ?>
        <?php if ($alterar) { ?>
        <div>
            <label for="chave">Chave:</label>
            <input type="text" id="chave" name="chave" value="<?= $imkovel["chave"] ?>" readonly>
        </div>
        <?php } ?>
        <div>
            <label for="cor">Cor:</label>
            <input type="text" id="cor" name="cor" value="<?= $imovel["cor"] ?>">
        </div>
        <div>
            <label for="especie">Espécie:</label>
            <input type="text" id="especie" name="especie" value="<?= $imovel["especie"] ?>">
        </div>
        <div>
            <label for="local">Local:</label>
            <input type="text" id="localizacao" name="localizacao" value="<?= $imovel["localizacao"] ?>">
        </div>
        <div>
            <label for="folhas">Folhas:</label>
            <input type="text" id="folhas" name="folhas" value="<?= $imovel["folhas"] ?>">
        </div>
        <div>
            <label for="tipo">Tipo de flor:</label>
            <select id="tipo" name="tipo">
                <option>Escolha...</option>
                <?php foreach ($tipos as $tipo) { ?>
                <option value="<?= $tipo ?>" <?php if ($imovel["tipo"] === $tipo) { ?> selected <?php } ?>>
                    <?= $tipo ?>
                </option>
                <?php } ?>
            </select>
        </div>
        <div>
            <button type="button" onclick="confirmar()">Salvar</button>
        </div>
    </form>
    <?php if ($alterar) { ?>
    <form action="excluir.php" method="POST" style="display: none" id="excluir-imovel">
        <input type="hidden" name="chave" value="<?= $imovel["chave"] ?>">
    </form>
    <button type="button" onclick="excluir()">Excluir</button>
    <?php } ?>
</body>

</html>

<?php
$transacaoOk = true;

} finally {
    include "fechar_transacao.php";
}
?>