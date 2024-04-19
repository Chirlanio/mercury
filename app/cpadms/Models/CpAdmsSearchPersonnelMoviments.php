<?php

namespace App\cpadms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsSearchPersonnelMoviments
 *
 * @copyright (c) year, Chiralnio Silva - Grupo Meia Sola
 */
class CpAdmsSearchPersonnelMoviments {

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $Terms;
    private $ResultadoPg;

    function getResultado() {
        return $this->ResultadoPg;
    }

    public function list($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['search'] = trim($this->Dados['search']);

        $this->Terms = "?search={$this->Dados['search']}";

        $_SESSION['search'] = $this->Dados['search'];

        if (!empty($this->Dados['search'])) {
            $this->search();
        }
        return $this->Resultado;
    }

    private function search() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'search-personel-moviments/list', "?search={$this->Dados['search']}");
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(m.id) AS num_result FROM adms_personnel_moviments m LEFT JOIN tb_lojas l ON l.id = m.adms_loja_id LEFT JOIN adms_areas ar ON ar.id = m.adms_area_id LEFT JOIN tb_funcionarios f ON f.id = m.adms_employee_id WHERE m.id =:id OR l.nome LIKE '%' :nome '%' OR ar.name LIKE '%' :area '%' OR f.nome LIKE '%' :employee '%'","id={$this->Dados['search']}&nome={$this->Dados['search']}&area={$this->Dados['search']}&employee={$this->Dados['search']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(m.id) AS num_result FROM adms_personnel_moviments m LEFT JOIN tb_lojas l ON l.id = m.adms_loja_id LEFT JOIN adms_areas ar ON ar.id = m.adms_area_id LEFT JOIN tb_funcionarios f ON f.id = m.adms_employee_id WHERE loja_id =:adms_loja_id AND (m.id =:id OR l.nome LIKE '%' :nome '%' OR ar.name LIKE '%' :area '%' OR f.nome LIKE '%' :employee '%')","loja_id={$_SESSION['usuario_loja']}&id={$this->Dados['search']}&nome={$this->Dados['search']}&area={$this->Dados['search']}&employee={$this->Dados['search']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrder = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= STOREPERMITION) {
            $listOrder->fullRead("SELECT m.*, l.nome store, sp.name status, c.cor cor_cr, f.nome funcionario FROM adms_personnel_moviments m LEFT JOIN tb_lojas l ON l.id = m.adms_loja_id LEFT JOIN adms_areas ar ON ar.id = m.adms_area_id LEFT JOIN tb_funcionarios f ON f.id = m.adms_employee_id LEFT JOIN adms_sits_personnel_moviments sp ON sp.id = m.adms_sits_personnel_mov_id LEFT JOIN adms_cors c ON c.id = sp.adms_cor_id WHERE m.id =:id OR l.nome LIKE '%' :nome '%' OR ar.name LIKE '%' :area '%' OR f.nome LIKE '%' :employee '%' ORDER BY m.id DESC LIMIT :limit OFFSET :offset", "id={$this->Dados['search']}&nome={$this->Dados['search']}&area={$this->Dados['search']}&employee={$this->Dados['search']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }  else {
            $listOrder->fullRead("SELECT m.*, l.nome store, sp.name status, c.cor cor_cr, f.nome funcionario FROM adms_personnel_moviments m LEFT JOIN tb_lojas l ON l.id = m.adms_loja_id LEFT JOIN adms_areas ar ON ar.id = m.adms_area_id LEFT JOIN tb_funcionarios f ON f.id = m.adms_employee_id LEFT JOIN adms_sits_personnel_moviments sp ON sp.id = m.adms_sits_personnel_mov_id LEFT JOIN adms_cors c ON c.id = sp.adms_cor_id WHERE m.adms_loja_id =:loja_id AND (m.id =:id OR l.nome LIKE '%' :nome '%' OR ar.name LIKE '%' :area '%' OR f.nome LIKE '%' :employee '%') ORDER BY m.id DESC LIMIT :limit OFFSET :offset", "loja_id={$_SESSION['usuario_loja']}&id={$this->Dados['search']}&nome={$this->Dados['search']}&area={$this->Dados['search']}&employee={$this->Dados['search']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrder->getResult();
    }
}
