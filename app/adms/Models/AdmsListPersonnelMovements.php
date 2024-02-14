<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListPersonnelMovements
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListPersonnelMovements {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function list($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'personnel-moviments/list');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] <= STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_personnel_moviments");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_personnel_moviments WHERE adms_loja_id =:adms_loja_id", "adms_loja_id=" . $_SESSION['usuario_loja']);
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listPersonnel = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listPersonnel->fullRead("SELECT pm.id m_id, lj.nome name_store, fc.nome funcionario, pm.last_day_worked, st.name status, pm.early_warning_id, cr.cor FROM adms_personnel_moviments pm LEFT JOIN tb_lojas lj on lj.id = pm.adms_loja_id LEFT JOIN tb_funcionarios fc on fc.id = pm.adms_employee_id LEFT JOIN adms_sits_personnel_moviments st on st.id = pm.adms_sits_personnel_mov_id LEFT JOIN adms_cors cr on cr.id = st.adms_cor_id WHERE pm.adms_loja_id =:loja_id LIMIT :limit OFFSET :offset", "loja_id={$_SESSION['usuario_loja']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listPersonnel->fullRead("SELECT pm.id m_id, lj.nome name_store, fc.nome funcionario, pm.last_day_worked, st.name status, pm.early_warning_id, cr.cor FROM adms_personnel_moviments pm LEFT JOIN tb_lojas lj on lj.id = pm.adms_loja_id LEFT JOIN tb_funcionarios fc on fc.id = pm.adms_employee_id LEFT JOIN adms_sits_personnel_moviments st on st.id = pm.adms_sits_personnel_mov_id LEFT JOIN adms_cors cr on cr.id = st.adms_cor_id ORDER BY pm.id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }

        $this->Resultado = $listPersonnel->getResultado();
        return $this->Resultado;
    }

    public function listAdd() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['ordem_nivac'] <= STOREPERMITION) {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE rede_id <=:rede_id AND status_id =:status_id ORDER BY id ASC", "rede_id=6&status_id=1");
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE id =:id AND status_id =:status_id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        }
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, name sit FROM adms_sits_personnel_moviments ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit']];

        return $this->Resultado;
    }

}
