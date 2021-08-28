<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerAjuste
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerAjuste {

    private $Resultado;
    private $DadosId;

    /**
     * <b>Ver Página:</b> Receber o id da página para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function verAjuste($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verAjuste = new \App\adms\Models\helper\AdmsRead();
        $verAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, fs.usuario usuario, f.nome func
                FROM tb_ajuste aj
                INNER JOIN tb_lojas lj ON lj.id=aj.loja_id
                INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id
                INNER JOIN tb_tam tam ON tam.id=aj.tam_id
                INNER JOIN tb_funcionarios fs ON fs.id=aj.solicitante
                INNER JOIN tb_funcionarios f ON f.id=aj.func_id
                WHERE aj.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verAjuste->getResultado();
        return $this->Resultado;
    }

}
