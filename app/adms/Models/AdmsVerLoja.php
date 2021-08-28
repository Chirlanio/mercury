<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerLoja
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerLoja {

    private $Resultado;
    private $DadosId;

    /**
     * <b>Ver Página:</b> Receber o id da página para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function verLoja($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verLoja = new \App\adms\Models\helper\AdmsRead();
        $verLoja->fullRead("SELECT lj.*,
                r.nome rede,
                sit.nome sit_lj
                FROM tb_lojas lj
                INNER JOIN tb_redes r ON r.id=lj.rede_id
                INNER JOIN tb_status_loja sit ON sit.id=lj.status_id
                WHERE lj.id_loja =:id_loja LIMIT :limit", "id_loja=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verLoja->getResultado();
        return $this->Resultado;
    }

}
