<?php
try {
    include "abrir_transacao.php";
include_once "operacoes.php";

$tipos = listar_tipo();
$situacoes = listar_situacao();

function validar($imovel) {
    global $tipos;
    global $situacoes;
    return strlen($imovel["area_construida_m2"]) >= 0 && strlen($imovel["area_construida_m2"]) <= 5000000
        && strlen($imovel["quartos"]) >= 0
        && strlen($imovel["quartos"]) <= 50
        && strlen($imovel["banheiros"]) >= 0
        && strlen($imovel["banheiros"]) <= 50
        && strlen($imovel["numero_piso"]) >=-5
        && strlen($imovel["numero_piso"]) <= 50
        && strlen($imovel["banheiros"]) >= 0
        && strlen($imovel["banheiros"]) <= 50
        && strlen($imovel["logradouro"]) >= 0
        && strlen($imovel["logradouro"]) <= 5000000
        && strlen($imovel["preco_venda"]) >= 0
        && strlen($imovel["preco_venda"]) <= 500000000
        && strlen($imovel["mensalidade_aluguel"]) >= 0
        && strlen($imovel["mensalidade_aluguel"]) <= 5000000
        && strlen($imovel["situacao"]) >= 0
        && strlen($imovel["situacao"]) <= 50
        && in_array($imovel["situacao"], $situacoes, true)
        && strlen($imovel["tipo_imovel"]) >= 0
        && strlen($imovel["tipo_imovel"]) <= 50
        && in_array($imovel["tipo_imovel"], $tipos, true);
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
            "area_construida_m2" => "",
            "area_total_m2" => "",
            "quartos" => "",
            "banheiros" => "",
            "numero_piso" => "",
            "logradouro" => "",
            "preco_venda" => "",
            "mensalidade_aluguel" => "",
            "situacao" => "",
            "tipo_imovel" => "",
          
        ];
    }
    $validacaoOk = true;

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $alterar = isset($_POST["chave"]);

    if ($alterar) {
        $imovel = [
            "chave" =>  $_POST["chave"],
            "area_construida_m2" =>  $_POST["area_construida_m2"],
            "area_total_m2" =>  $_POST["area_total_m2"],
            "quartos" =>  $_POST["quartos"],
            "banheiros" =>  $_POST["banheiros"],
            "numero_piso" =>  $_POST["numero_piso"],
            "logradouro" =>  $_POST["logradouro"],
            "preco_venda" =>  $_POST["preco_venda"],
            "mensalidade_aluguel" =>  $_POST["mensalidade_aluguel"],
            "situacao" =>  $_POST["situacao"],
            "tipo_imovel" =>  $_POST["tipo_imovel"],
           
        ];
        $validacaoOk = validar($imovel);
        if ($validacaoOk) alterar_imovel($imovel);
    } else {
        $imovel= [
            "area_construida_m2" =>  $_POST["area_construida_m2"],
            "area_total_m2" =>  $_POST["area_total_m2"],
            "quartos" =>  $_POST["quartos"],
            "banheiros" =>  $_POST["banheiros"],
            "numero_piso" =>  $_POST["numero_piso"],
            "logradouro" =>  $_POST["logradouro"],
            "preco_venda" =>  $_POST["preco_venda"],
            "mensalidade_aluguel" =>  $_POST["mensalidade_aluguel"],
            "situacao" =>  $_POST["situacao"],
            "tipo_imovel" =>  $_POST["tipo_imovel"],
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
<html lang="pt-br">
<head>
    <title>Imobiliaria Martini & Showza</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/Style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


        <script>
    function confirmar() {
        if (!confirm("Tem certeza que deseja salvar os dados?")) return;
        document.getElementById("formulario").submit();
    }

    function excluir() {
        if (!confirm("Tem certeza que deseja excluir o imovel?")) return;
        document.getElementById("excluir-imovel").submit();
    }
    </script>
</head>



<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-sm fixed-top bg-primary-color" id="navbar">
        <div class="container-sm ">
            <a class="navbar-brand" href="index">
                <img class="logo" src="../imagem/Martini & Showza.png" alt="Logo" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-items"
                aria-controls="navbar-items" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbar-items">
                <ul class="navbar-nav me-auto  mb-lg-2 mb-md-0">
                    <li class="nav-item">
                        <h1>Imobiliaria Martini & Showza</h1>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container_adm">
    <div class="container-md  forms">
      <form method="POST" action="cadastro.php" id="formulario">
        <?php if (!$validacaoOk) {?>
        <div>
            <p>Preencha os campos corretamente!</p>
        </div>
        <?php } ?>
        <?php if ($alterar) { ?>
        <div>
            <label for="chave">Chave:</label>
            <input type="text" id="chave" name="chave" value="<?= $imovel["chave"] ?>" readonly>
        </div>
        <?php } ?>
        <div>
            <label for="area_construida_m2">Area construida  :</label>
            <input type="number" id="area_construida_m2" name="area_construida_m2" value="<?= $imovel["area_construida_m2"] ?>">
        </div>
        <div>
            <label for="area_total_m2"> Area total do imovel:</label>
            <input type="number" id="area_total_m2" name="area_total_m2" value="<?= $imovel["area_total_m2"] ?>">
        </div>
        <div>
            <label for="quartos">Quantidade de quartos:</label>
            <input type="number" id="quartos" name="quartos" value="<?= $imovel["quartos"] ?>">
        </div>
        <div>
            <label for="banheiros">Banheiros:</label>
            <input type="number" id="banheiros" name="banheiros" value="<?= $imovel["banheiros"] ?>">
        </div>
        <div>
            <label for="numero_piso">Numero do piso:</label>
            <input type="number" id="numero_piso" name="numero_piso" value="<?= $imovel["numero_piso"] ?>">
        </div>
        <div>
            <label for="logradouro">Insira  seu Endereço completo:</label>
            <input type="text" id="logradouro" name="logradouro" value="<?= $imovel["logradouro"] ?>">
        </div> 
        <div>
            <label for="preco_venda">Preço de venda do imovel:</label>
            <input type="number" id="preco_venda" name="preco_venda" value="<?= $imovel["preco_venda"] ?>">
        </div>
        <div>
            <label for="mensalidade_aluguel">Mensalidade do imovel:</label>
            <input type="number" id="mensalidade_aluguel" name="mensalidade_aluguel" value="<?= $imovel["mensalidade_aluguel"] ?>">
        </div>
       
        <div>
            <label for="situacao">Situação do imóvel:</label>
            <select id="situacao" name="situacao">
                <option>Escolha...</option>
                <?php foreach ($situacoes as $situacao) { ?>
                <option value="<?= $situacao ?>" <?php if ($imovel["situacao"] === $situacao) { ?> selected <?php } ?>>
                    <?= $situacao ?>
                </option>
                <?php } ?>
            </select>
        </div>
        <label for="tipo_imovel">Tipo do Imóvel:</label>
                <select id="tipo_imovel" name="tipo_imovel">
                    <option>Escolha...</option>
                    <?php foreach ($tipos as $tipo_imovel) { ?>
                        <option value="<?= $tipo_imovel ?>"
                            <?php if ($imovel["tipo"] === $tipo_imovel) { ?>
                            selected
                            <?php } ?>>
                            <?= $tipo_imovel ?>
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
    </div>
    </div>
    
</body>

</html>

<?php
$transacaoOk = true;

} finally {
    include "fechar_transacao.php";
}
?>