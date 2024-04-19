<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListVacancyOpening
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListVacancyOpening {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function list($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'vacancy-opening/list');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] >= STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_vacancy_opening WHERE adms_loja_id =:adms_loja_id", "adms_loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_vacancy_opening");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listVacancy = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] >= STOREPERMITION) {
            $listVacancy->fullRead("SELECT v.*,
                    l.nome store, f.nome funcionario, cg.nome cargo, rt.type_name, se.name_sit status, c.cor cor_cr
                    FROM adms_vacancy_opening v
                    LEFT JOIN tb_lojas l ON l.id = v.adms_loja_id
                    LEFT JOIN tb_funcionarios f ON f.id = v.adms_employee_id
                    LEFT JOIN tb_cargos cg ON cg.id = v.adms_cargo_id
                    LEFT JOIN adms_request_types rt ON rt.id = v.adms_request_type_id
                    LEFT JOIN adms_sits_vacancy se ON se.id = v.adms_sit_vacancy_id
                    LEFT JOIN adms_cors c ON c.id = se.adms_cor_id
                    WHERE v.adms_loja_id =:adms_loja_id
                    ORDER BY v.id DESC LIMIT :limit OFFSET :offset", "adms_loja_id={$_SESSION['usuario_loja']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listVacancy->fullRead("SELECT v.*,
                    l.nome store, f.nome funcionario, cg.nome cargo, rt.type_name, se.name_sit status, c.cor cor_cr
                    FROM adms_vacancy_opening v
                    LEFT JOIN tb_lojas l ON l.id = v.adms_loja_id
                    LEFT JOIN tb_funcionarios f ON f.id = v.adms_employee_id
                    LEFT JOIN tb_cargos cg ON cg.id = v.adms_cargo_id
                    LEFT JOIN adms_request_types rt ON rt.id = v.adms_request_type_id
                    LEFT JOIN adms_sits_vacancy se ON se.id = v.adms_sit_vacancy_id
                    LEFT JOIN adms_cors c ON c.id = se.adms_cor_id
                    ORDER BY v.id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listVacancy->getResult();
        return $this->Resultado;
    }

    public function listAdd() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE rede_id <=:rede_id AND status_id =:status_id ORDER BY id ASC", "rede_id=6&status_id=1");
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE id =:id AND status_id =:status_id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        }
        $registro['loja_id'] = $listar->getResult();

        $listar->fullRead("SELECT id sit_id, nome sit FROM adms_sits_estornos ORDER BY id ASC");
        $registro['sit'] = $listar->getResult();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit']];

        return $this->Resultado;
    }
}
