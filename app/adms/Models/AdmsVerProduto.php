<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerProduto
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerProduto {

    private $Resultado;
    private $DadosId;
    private $LimiteResultado = 1;

    /**
     * <b>Ver Página:</b> Receber o id da página para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function verProduto($DadosId) {

        $this->DadosId = $DadosId;

        $verProduto = new \App\adms\Models\helper\AdmsReadCigam();
        $verProduto->fullRead("SELECT referencia, codbarra, refauxiliar, descricao, colecao, subcolecao, linha, tamanho, artigo, complartigo, cor, marca, material, datacadastro, min_vlrvenda, min_vlrcusto
           FROM msl_dprodutos_
           WHERE referencia =:referencia", "referencia=" . $this->DadosId);
        $this->Resultado = $verProduto->getResultado();
        return $this->Resultado;
    }

}
