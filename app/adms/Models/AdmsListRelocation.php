<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListRelocation
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListRelocation {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listRelocation($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'relocation/list');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_relocations");
        } else {
            $paginacao->paginacao("SELECT COUNT(rem.id) AS num_result FROM adms_relocations rem LEFT JOIN adms_relocation_items ri ON ri.adms_relocation_id = rem.id WHERE ri.source_store_id =:source_store_id", "source_store_id=" . $_SESSION['usuario_loja']);
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarRemanejo = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
            $listarRemanejo->fullRead("SELECT rem.id, rem.relocation_name, ri.destination_store_id, rem.adms_sit_relocation_id, ri.id lj_id, ri.source_store_id, lj.nome loja_origem, ld.nome loja_destino, s.name_sit, c.cor FROM adms_relocations rem LEFT JOIN adms_relocation_items ri ON ri.adms_relocation_id = rem.id INNER JOIN tb_lojas lj ON lj.id = ri.source_store_id INNER JOIN tb_lojas ld ON ld.id = ri.destination_store_id INNER JOIN adms_sit_relocations s ON s.id = rem.adms_sit_relocation_id INNER JOIN adms_cors c ON c.id = s.adms_cor_id GROUP BY rem.id, rem.relocation_name, rem.adms_sit_relocation_id, lj.nome, ld.nome, s.name_sit, c.cor ORDER BY rem.id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarRemanejo->fullRead("SELECT rem.id, rem.relocation_name, ri.destination_store_id, rem.adms_sit_relocation_id, ri.id lj_id, lj.nome loja_origem, ld.nome loja_destino, s.name_sit, c.cor FROM adms_relocations rem LEFT JOIN adms_relocation_items ri ON ri.adms_relocation_id = rem.id INNER JOIN tb_lojas lj ON lj.id = ri.source_store_id INNER JOIN tb_lojas ld ON ld.id = ri.destination_store_id INNER JOIN adms_sit_relocations s ON s.id = rem.adms_sit_relocation_id INNER JOIN adms_cors c ON c.id = s.adms_cor_id WHERE ri.source_store_id =:source_store_id GROUP BY rem.id, rem.relocation_name, rem.adms_sit_relocation_id, lj.nome, ld.nome, s.name_sit, c.cor ORDER BY rem.id DESC LIMIT :limit OFFSET :offset", "source_store_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        
        $this->Resultado = $listarRemanejo->getResult();
        return $this->Resultado;
    }

    public function listAdd() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id s_id, name_sit FROM adms_sit_relocations ORDER BY s_id ASC");
        $registro['status'] = $listar->getResult();

        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
            $listar->fullRead("SELECT id loja_ori, nome loja_origem FROM tb_lojas ORDER BY id ASC");
        } else {
            $listar->fullRead("SELECT id loja_ori, nome loja_origem FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        }
        $registro['loja_ori'] = $listar->getResult();
        
        $listar->fullRead("SELECT id id_des, nome loja_destino FROM tb_lojas WHERE status_id <>:status_id ORDER BY id ASC", "status_id=2");
        $registro['loja_des'] = $listar->getResult();

        $this->Resultado = ['loja_ori' => $registro['loja_ori'], 'loja_des' => $registro['loja_des'], 'status' => $registro['status']];

        return $this->Resultado;
    }

}
