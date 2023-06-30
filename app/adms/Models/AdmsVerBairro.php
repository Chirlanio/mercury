<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerBairro
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerBairro {

    private $Resultado;
    private $DadosId;

    public function verBairro($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verBairro = new \App\adms\Models\helper\AdmsRead();
        $verBairro->fullRead("SELECT b.id id_bai, b.nome bairro, b.rota_id, b.created, b.modified, r.nome rota
                FROM tb_bairros b
                INNER JOIN tb_rotas r ON r.id=b.rota_id
                WHERE b.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verBairro->getResultado();
        return $this->Resultado;
    }

}
