<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerRota
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerRota {

    private $Resultado;
    private $DadosId;

    public function verRota($DadosId) {
        
        $this->DadosId = (int) $DadosId;
        
        $verRota = new \App\adms\Models\helper\AdmsRead();
        $verRota->fullRead("SELECT r.id r_id, r.nome rota, r.adms_cor_id, r.created, r.modified, c.nome n_cor, c.cor
                FROM tb_rotas r
                INNER JOIN adms_cors c ON c.id=r.adms_cor_id
                WHERE r.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verRota->getResultado();
        return $this->Resultado;
    }

}
