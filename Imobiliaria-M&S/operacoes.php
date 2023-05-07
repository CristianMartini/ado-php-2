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

?>