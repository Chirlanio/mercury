<?php

namespace App\cpadms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsPesqCostCenter
 *
 * @copyright (c) year, Chiralnio Silva - Grupo Meia Sola
 */
class CpAdmsPesqCostCenter {

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResult() {
        return $this->ResultadoPg;
    }

    public function list($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['search'] = trim($this->Dados['search']);

        $_SESSION['search'] = $this->Dados['search'];

        if (!empty($this->Dados['search'])) {
            $this->pesqSearch();
        }
        return $this->Resultado;
    }

    private function pesqSearch() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-cost-center/list', '?pesquisar=' . $this->Dados['search']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(e.id) AS num_result FROM adms_cost_centers e WHERE e.loja_id =:loja_id AND e.name LIKE '%' :name '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&name={$this->Dados['search']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(e.id) AS num_result FROM adms_cost_centers e WHERE e.name LIKE '%' :name '%'", "name={$this->Dados['search']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listCostCenter = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listCostCenter->fullRead("SELECT cc.*, f.name gerencia, a.name name_area, s.nome status FROM adms_cost_centers cc INNER JOIN adms_managers f ON f.id=cc.manager_id INNER JOIN adms_sits s ON s.id=cc.status_id LEFT JOIN adms_areas a ON a.id=cc.adms_area_id WHERE cc.name LIKE '%' :name '%' AND cc.status_id =:status_id ORDER BY name ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&name={$this->Dados['search']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listCostCenter->fullRead("SELECT cc.*, f.name gerencia, a.name name_area, s.nome status FROM adms_cost_centers cc INNER JOIN adms_managers f ON f.id=cc.manager_id INNER JOIN adms_sits s ON s.id=cc.status_id LEFT JOIN adms_areas a ON a.id=cc.adms_area_id WHERE cc.name LIKE '%' :name '%' ORDER BY name ASC LIMIT :limit OFFSET :offset", "name={$this->Dados['search']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listCostCenter->getResultado();
    }

}
