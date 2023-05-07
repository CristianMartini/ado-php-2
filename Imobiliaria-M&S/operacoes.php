<?php 
include_once "conecta-sqlite.php";


 function inserir_imovel( $imovel){
    global $pdo;
    $sql = " INSERT INTO imovel ( area_construida_m2, area_total_m2, quartos , banheiros, numero_piso , logradouro , preco_venda , mensalidade_aluguel , situacao , tipo )". 
    " VALUES (:area_construida_m2, :area_total_m2, :quartos , :banheiros, :numero_piso , :logradouro , :preco_venda , :mensalidade_aluguel , :situacao , :tipo )";

    $pdo->prepare($sql)->execute($imovel);
    return $pdo->lastInsertId();
 }

 function alterar_imovel($imovel) {
    global $pdo;
    $sql = "UPDATE imovel SET " .
        "area_construida_m2 = :area_construida_m2,".
        "area_total_m2 = :area_total_m2," .
        "quartos = :quartos," .
        "banheiros = :banheiros,".
        "numero_piso = :numero_piso," .
        "logradouro = :logradouro," .
        "preco_venda = :preco_venda," .
        "mensalidade_aluguel = :mensalidade_aluguel,".
        "situacao = :situacao," .
        "tipo = :tipo" .
        "WHERE chave = :chave";
    $pdo->prepare($sql)->execute($imovel);
}
function excluir_flor($chave) {
    global $pdo;
    $sql = "DELETE FROM imoveis WHERE chave = :chave";
    $pdo->prepare($sql)->execute(["chave" => $chave]);
}

function listar_imoveis() {
    global $pdo;
    $sql = "SELECT * FROM imoveis";
    $resultados = [];
    $consulta = $pdo->query($sql);
    while ($linha = $consulta->fetch()) {
        $resultados[] = $linha;
    }
    return $resultados;
}

function buscar_imoveis($chave) {
    global $pdo;
    $sql = "SELECT * FROM imoveis WHERE chave = :chave";
    $resultados = [];
    $consulta = $pdo->prepare($sql);
    $consulta->execute(["chave" => $chave]);
    return $consulta->fetch();
}
function listar_situacao() {
    global $pdo;
    $sql = "SELECT * FROM situacao";
    $resultados = [];
    $consulta = $pdo->query($sql);
    while ($linha = $consulta->fetch()) {
        $resultados[] = $linha["situacao"];
    }
    return $resultados;
}

function listar_tipo() {
    global $pdo;
    $sql = "SELECT * FROM tipo";
    $resultados = [];
    $consulta = $pdo->query($sql);
    while ($linha = $consulta->fetch()) {
        $resultados[] = $linha["tipo"];
    }
    return $resultados;
}
?>