<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerFunc
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerFunc {

    private $Resultado;
    private $DadosId;

    /**
     * <b>Ver Página:</b> Receber o id do funcionário para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function verFunc($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verFunc = new \App\adms\Models\helper\AdmsRead();
        $verFunc->fullRead("SELECT f.*,
                lj.nome loja, s.nome sit, c.nome cargo
                FROM tb_funcionarios f
                INNER JOIN tb_lojas lj ON lj.id=f.loja_id
                INNER JOIN tb_status s ON s.id=f.status_id
                INNER JOIN tb_cargos c ON c.id=f.cargo_id
                WHERE f.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verFunc->getResultado();
        return $this->Resultado;
    }

}
