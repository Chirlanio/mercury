<?php

namespace App\cpadms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsPesqOrderService
 *
 * @copyright (c) year, Chiralnio Silva - Grupo Meia Sola
 */
class CpAdmsPesqOrderService {

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoAj() {
        return $this->ResultadoPg;
    }

    public function listar($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;
        var_dump($this->Dados);

        $this->Dados['cliente'] = trim($this->Dados['cliente']);

        $_SESSION['loja_id'] = $this->Dados['loja_id'];
        $_SESSION['min_id'] = $this->Dados['min_id'];
        $_SESSION['max_id'] = $this->Dados['max_id'];
        $_SESSION['sit_id'] = $this->Dados['sit_id'];
        $_SESSION['marca_id'] = $this->Dados['marca_id'];
        $_SESSION['cliente'] = $this->Dados['cliente'];

        if (!empty($_SESSION['terms'])) {
            unset($_SESSION['terms']);
        }

        if ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['min_id'])) AND (!empty($this->Dados['max_id'])) AND (!empty($this->Dados['marca_id'])) AND (!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqComp();
            $_SESSION['terms'] = "<a href='" . URLADM . "gerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&min_id=" . $_SESSION['min_id'] . "&max_id=" . $_SESSION['max_id'] . "&situacao=" . $_SESSION['sit_id'] . "&marca=" . $_SESSION['marca_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Exportar</a> ";
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['min_id'])) AND (!empty($this->Dados['max_id'])) AND (!empty($this->Dados['marca_id'])) AND (!empty($this->Dados['sit_id'])) AND (empty($this->Dados['cliente']))) {
            $this->pesqLojaMinIdMaxIdSitBrand();
            $_SESSION['terms'] = "<a href='" . URLADM . "gerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&min_id=" . $_SESSION['min_id'] . "&max_id=" . $_SESSION['max_id'] . "&situacao=" . $_SESSION['sit_id'] . "&marca=" . $_SESSION['marca_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Exportar</a> ";
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['min_id'])) AND (!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqLojaMinIdSitCli();
            $_SESSION['terms'] = "<a href='" . URLADM . "gerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&min_id=" . $_SESSION['min_id'] . "&situacao=" . $_SESSION['sit_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Exportar</a> ";
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['max_id'])) AND (!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqLojaMaxIdSitCli();
            $_SESSION['terms'] = "<a href='" . URLADM . "gerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&max_id=" . $_SESSION['max_id'] . "&situacao=" . $_SESSION['sit_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Exportar</a> ";
        } elseif ((!empty($this->Dados['min_id'])) AND (!empty($this->Dados['max_id'])) AND (!empty($this->Dados['sit_id']))) {
            $this->pesqMinMaxIdSit();
            $_SESSION['terms'] = "<a href='" . URLADM . "gerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&min_id=" . $_SESSION['min_id'] . "&max_id=" . $_SESSION['max_id'] . "&situacao=" . $_SESSION['sit_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Exportar</a> ";
        } elseif ((!empty($this->Dados['min_id'])) AND (!empty($this->Dados['max_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqMinMaxIdCli();
            $_SESSION['terms'] = "<a href='" . URLADM . "gerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&min_id=" . $_SESSION['min_id'] . "&max_id=" . $_SESSION['max_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Exportar</a> ";
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['min_id'])) AND (!empty($this->Dados['sit_id']))) {
            $this->pesqLojaMinIdSit();
            $_SESSION['terms'] = "<a href='" . URLADM . "gerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&min_id=" . $_SESSION['min_id'] . "&situacao=" . $_SESSION['sit_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Exportar</a> ";
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['max_id'])) AND (!empty($this->Dados['sit_id']))) {
            $this->pesqLojaMaxIdSit();
            $_SESSION['search'] = 7;
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['min_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqLojaMinIdCliente();
            $_SESSION['search'] = 8;
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['max_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqLojaMaxIdCliente();
            $_SESSION['search'] = 9;
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqLojaSitCliente();
            $_SESSION['search'] = 10;
        } elseif ((!empty($this->Dados['min_id'])) AND (!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqMinIdSitCliente();
            $_SESSION['search'] = 11;
        } elseif ((!empty($this->Dados['max_id'])) AND (!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqMaxIdSitCliente();
            $_SESSION['search'] = 12;
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['min_id'])) AND (!empty($this->Dados['max_id']))) {
            $this->pesqLojaMinMaxId();
            $_SESSION['search'] = 13;
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqLojaCliente();
            $_SESSION['search'] = 14;
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['min_id']))) {
            $this->pesqLojaMinId();
            $_SESSION['search'] = 15;
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['max_id']))) {
            $this->pesqLojaMaxId();
            $_SESSION['search'] = 16;
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['sit_id']))) {
            $this->pesqLojaStatus();
            $_SESSION['search'] = 17;
        } elseif ((!empty($this->Dados['min_id'])) AND (!empty($this->Dados['sit_id']))) {
            $this->pesqMinIdStatus();
            $_SESSION['search'] = 18;
        } elseif ((!empty($this->Dados['max_id'])) AND (!empty($this->Dados['sit_id']))) {
            $this->pesqMaxIdStatus();
            $_SESSION['search'] = 19;
        } elseif ((!empty($this->Dados['min_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqMinIdCliente();
            $_SESSION['search'] = 20;
        } elseif ((!empty($this->Dados['max_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqMaxIdCliente();
            $_SESSION['search'] = 21;
        } elseif ((!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqSitCliente();
            $_SESSION['search'] = 22;
        } elseif ((!empty($this->Dados['min_id'])) AND (!empty($this->Dados['max_id']))) {
            $this->pesqMinMaxId();
            $_SESSION['search'] = 23;
        } elseif (!empty($this->Dados['loja_id'])) {
            $this->pesqLoja();
            $_SESSION['search'] = 24;
        } elseif (!empty($this->Dados['min_id'])) {
            $this->pesqMinId();
            $_SESSION['search'] = 25;
        } elseif (!empty($this->Dados['max_id'])) {
            $this->pesqMaxId();
            $_SESSION['search'] = 26;
        } elseif (!empty($this->Dados['sit_id'])) {
            $this->pesqStatus();
            $_SESSION['search'] = 27;
        } elseif (!empty($this->Dados['cliente'])) {
            $this->pesqCliente();
            $_SESSION['search'] = 28;
        } else {
            $this->gerarPlanilha();
        }
        return $this->Resultado;
    }

    private function pesqComp() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id'] . '&max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['sit_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id AND status_id =:status_id AND client_name LIKE '%' :client_name '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id AND status_id =:status_id AND client_name LIKE '%' :client_name '%'", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.order_service BETWEEN :min_id AND :max_id
                    AND d.status_id =:status_id
                    AND d.marca_id =:marca_id
                    AND d.client_name LIKE '%' :client_name '%'
                    ORDER BY d.id DESC
                    LIMIT :limit
                    OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&marca_id={$this->Dados['marca_id']}&client_name={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.order_service BETWEEN :min_id AND :max_id
                    AND d.status_id =:status_id
                    AND d.marca_id =:marca_id
                    AND d.client_name LIKE '%' :client_name '%'
                    ORDER BY d.id DESC
                    LIMIT :limit
                    OFFSET :offset", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&marca_id={$this->Dados['marca_id']}&client_name={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqLojaMinIdMaxIdSitBrand() {
        $paginate = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id'] . '&max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['sit_id'] . '&marca_id=' . $this->Dados['marca_id']);
        $paginate->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginate->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id AND status_id =:status_id AND marca_id =:marca_id", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&marca_id={$this->Dados['marca_id']}");
        } else {
            $paginate->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id AND status_id =:status_id AND marca_id =:marca_id", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&marca_id={$this->Dados['marca_id']}");
        }
        $this->ResultadoPg = $paginate->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.order_service BETWEEN :min_id AND :max_id
                    AND d.status_id =:status_id
                    AND d.marca_id =:marca_id
                    ORDER BY d.id DESC
                    LIMIT :limit
                    OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&marca_id={$this->Dados['marca_id']}&limit={$this->LimiteResultado}&offset={$paginate->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.order_service BETWEEN :min_id AND :max_id
                    AND d.status_id =:status_id
                    AND d.marca_id =:marca_id
                    ORDER BY d.id DESC
                    LIMIT :limit
                    OFFSET :offset", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&marca_id={$this->Dados['marca_id']}&limit={$this->LimiteResultado}&offset={$paginate->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqMinMaxIdSit() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?min_id=' . $this->Dados['min_id'] . '&max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id AND status_id =:status_id", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE id BETWEEN :min_id AND :max_id AND status_id =:status_id", "min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.id BETWEEN :min_id AND :max_id
                    AND d.status_id =:status_id
                    ORDER BY d.id DESC
                    LIMIT :limit", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.id BETWEEN :min_id AND :max_id
                    AND d.status_id =:status_id
                    ORDER BY d.id DESC
                    LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqMinMaxIdCli() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?min_id=' . $this->Dados['min_id'] . '&max_id=' . $this->Dados['max_id'] . '&client_name=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id AND client_name LIKE '%' :client_name '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&client_name={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE id BETWEEN :min_id AND :max_id AND client_name LIKE '%' :client_name '%'", "min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&client_name={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.id BETWEEN :min_id AND :max_id
                    AND d.client_name LIKE '%' :client_name '%'
                    ORDER BY d.id DESC
                    LIMIT :limit
                    OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.id BETWEEN :min_id AND :max_id
                    AND d.client_name LIKE '%' :client_name '%'
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&client_name={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqLojaMinIdSit() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id >=:min_id AND status_id =:status_id", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id >=:min_id AND status_id =:status_id", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.id >=:min_id
                    AND d.status_id =:status_id
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.id >=:min_id
                    AND d.status_id =:status_id
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqLojaMaxIdSit() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?loja=' . $this->Dados['loja_id'] . '&max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id <=:max_id AND status_id =:status_id", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id <=:max_id AND status_id =:status_id", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.id <=:max_id
                    AND d.status_id =:status_id
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.id <=:max_id
                    AND d.status_id =:status_id
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqLojaMinIdSitCli() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id'] . '&situacao=' . $this->Dados['sit_id'] . 'cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id >=:min_id AND status_id =:status_id AND client_name LIKE '%' :client_name '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id >=:min_id AND status_id =:status_id AND client_name LIKE '%' :client_name '%'", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id AND
                    d.id >=:min_id
                    AND d.status_id =:status_id
                    AND d.client_name LIKE '%' :client_name '%'
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.id >=:min_id
                    AND d.status_id =:status_id
                    AND d.client_name LIKE '%' :client_name '%'
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqLojaMaxIdSitCli() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?loja=' . $this->Dados['loja_id'] . '&max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['sit_id'] . 'cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id <=:max_id AND status_id =:status_id AND client_name LIKE '%' :client_name '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id <=:max_id AND status_id =:status_id AND client_name LIKE '%' :client_name '%'", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.id <=:max_id
                    AND d.status_id =:status_id
                    AND d.client_name LIKE '%' :client_name '%'
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.id <=:max_id
                    AND d.status_id =:status_id
                    AND d.client_name LIKE '%' :client_name '%'
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqLojaMinIdCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id >=:min_id AND client_name LIKE '%' :client_name '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&client_name={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id >=:min_id AND client_name LIKE '%' :client_name '%'", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&client_name={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.id >=:min_id
                    AND d.cliente LIKE '%' :cliente '%'
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.id >=:min_id
                    AND d.client_name LIKE '%' :client_name '%'
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&client_name={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqLojaMaxIdCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?loja=' . $this->Dados['loja_id'] . '&max_id=' . $this->Dados['max_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id <=:max_id AND client_name LIKE '%' :client_name '%'", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&client_name={$this->Dados['cliente']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.id <=:max_id
                    AND d.client_name LIKE '%' :client_name '%'
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&client_name={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqLojaSitCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?loja=' . $this->Dados['loja_id'] . '&situacao=' . $this->Dados['sit_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND status_id =:status_id AND client_name LIKE '%' :client_name '%'", "loja_id={$this->Dados['loja_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.status_id =:status_id
                    AND d.client_name LIKE '%' :client_name '%'
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqMinIdSitCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?min_id=' . $this->Dados['min_id'] . '&situacao=' . $this->Dados['sit_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id >=:min_id AND status_id =:status_id AND client_name LIKE '%' :client_name '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE id >=:min_id AND status_id =:status_id AND client_name LIKE '%' :client_name '%'", "min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.id >=:min_id
                    AND d.status_id =:status_id
                    AND d.client_name LIKE '%' :client_name '%'
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.id >=:min_id
                    AND d.status_id =:status_id
                    AND d.client_name LIKE '%' :client_name '%'
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqMaxIdSitCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['sit_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id <=:max_id AND status_id =:status_id AND client_name LIKE '%' :client_name '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE id <=:max_id AND status_id =:status_id AND client_name LIKE '%' :client_name '%'", "max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.id <=:max_id
                    AND d.status_id =:status_id
                    AND d.client_name LIKE '%' :client_name '%'
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.id <=:max_id
                    AND d.status_id =:status_id
                    AND d.client_name LIKE '%' :client_name '%'
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&client_name={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqLojaCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?loja=' . $this->Dados['loja_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND client_name LIKE '%' :client_name '%'", "loja_id={$this->Dados['loja_id']}&client_name={$this->Dados['cliente']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.client_name LIKE '%' :client_name '%'
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&client_name={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqLojaMinMaxId() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id'] . '&max_id=' . $this->Dados['max_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.id BETWEEN :min_id AND :max_id
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqMinMaxId() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?min_id=' . $this->Dados['min_id'] . '&max_id=' . $this->Dados['max_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE id BETWEEN :min_id AND :max_id", "min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.id BETWEEN :min_id AND :max_id
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.id BETWEEN :min_id AND :max_id
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqLojaMinId() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id >=:min_id", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.id >=:min_id
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqLojaMaxId() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?loja=' . $this->Dados['loja_id'] . '&max_id=' . $this->Dados['max_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id <=:max_id", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.id <=:max_id
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqLojaStatus() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?loja=' . $this->Dados['loja_id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND status_id =:status_id", "loja_id={$this->Dados['loja_id']}&status_id={$this->Dados['sit_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        $listOrderService->fullRead("SELECT d.id os_id, d.loja_id, d.referencia,
                    d.order_service, lj.nome loja, c.cor, s.nome status, t.nome tam
                    FROM adms_qualidade_ordem_servico d
                    INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                    INNER JOIN adms_sits_ordem_servico s ON s.id=d.status_id
                    INNER JOIN adms_cors c ON c.id=s.cor_id
                    INNER JOIN tb_tam t ON t.id = d.tam_id
                    WHERE d.loja_id =:loja_id
                    AND d.status_id =:status_id
                    ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqMinIdCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?min_id=' . $this->Dados['min_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id >=:min_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE id >=:min_id AND cliente LIKE '%' :cliente '%'", "min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id >=:min_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqMaxIdCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?max_id=' . $this->Dados['max_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id <=:max_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE id <=:max_id AND cliente LIKE '%' :cliente '%'", "max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE loja_id =:loja_id AND d.id <=:max_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id <=:max_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqSitCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?situacao=' . $this->Dados['sit_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE status_id =:status_id AND cliente LIKE '%' :cliente '%'", "status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE loja_id =:loja_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqMinIdStatus() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?min_id=' . $this->Dados['min_id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id >=:min_id AND status_id =:status_id", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE id >=:min_id AND status_id =:status_id", "min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id >=:min_id AND d.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqMaxIdStatus() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id AND id <=:max_id AND status_id =:status_id", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE id <=:max_id AND status_id =:status_id", "max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id AND d.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id <=:max_id AND d.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqLoja() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?loja=' . $this->Dados['loja_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id WHERE d.loja_id =:loja_id", "loja_id={$this->Dados['loja_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqMinId() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?min_id=' . $this->Dados['min_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM adms_qualidade_ordem_servico d WHERE d.loja_id =:loja_id AND d.id >=:min_id", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM adms_qualidade_ordem_servico d WHERE d.id >=:min_id", "min_id={$this->Dados['min_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id >=:min_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqMaxId() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?max_id=' . $this->Dados['max_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM adms_qualidade_ordem_servico d WHERE d.loja_id =:loja_id AND d.id <=:max_id", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM adms_qualidade_ordem_servico d WHERE d.id <=:max_id", "max_id={$this->Dados['max_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id <=:max_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqStatus() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM adms_qualidade_ordem_servico d WHERE d.loja_id =:loja_id AND d.status_id =:status_id", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['sit_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM adms_qualidade_ordem_servico d WHERE d.status_id =:status_id", "status_id={$this->Dados['sit_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.status_id =:status_id ORDER BY id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.status_id =:status_id ORDER BY id ASC LIMIT :limit OFFSET :offset", "status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM adms_qualidade_ordem_servico d WHERE d.loja_id =:loja_id AND d.cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM adms_qualidade_ordem_servico d WHERE d.cliente LIKE '%' :cliente '%'", "cliente={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function gerarPlanilha() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] <= STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM adms_qualidade_ordem_servico d WHERE d.loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM adms_qualidade_ordem_servico d", "cliente={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] <= STOREPERMITION) {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrderService->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrderService->getResultado();
    }

    private function pesqSearch() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?pesquisar=' . $this->Dados['search']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(os.id) AS num_result FROM adms_qualidade_ordem_servico os WHERE os.loja_id =:loja_id AND os.client_name LIKE '%' :client_name '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&client_name={$this->Dados['search']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(os.id) AS num_result FROM adms_qualidade_ordem_servico os WHERE os.client_name LIKE '%' :client_name '%' OR os.id =:id", "client_name={$this->Dados['search']}&id={$this->Dados['search']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listarOrderService->fullRead("SELECT os.*, lj.nome loja, se.nome status, tp.nome tipo, t.nome tam, m.nome marca, ljc.nome loja_conserto, c.cor
                FROM adms_qualidade_ordem_servico os INNER JOIN tb_lojas lj ON lj.id=os.loja_id LEFT JOIN tb_lojas ljc ON ljc.id=os.loja_id_conserto INNER JOIN adms_sits_ordem_servico se ON se.id=os.status_id INNER JOIN adms_cors c ON c.id=se.cor_id INNER JOIN adms_tips_ordem_servico tp ON tp.id=os.type_order_id INNER JOIN tb_tam t ON t.id=os.tam_id INNER JOIN adms_marcas m ON m.id=os.marca_id WHERE os.loja_id =:loja_id AND (os.client_name LIKE '%' :client_name '%' OR os.id =:id OR lj.nome LIKE '%' :loja '%' OR os.order_service =:ordem OR os.referencia LIKE '%' :referencia '%') ORDER BY os.id DESC LIMIT :limit OFFSET :offset", "loja_id={$_SESSION['usuario_loja']}&client_name={$this->Dados['search']}&id={$this->Dados['search']}&loja={$this->Dados['search']}&ordem={$this->Dados['search']}&referencia={$this->Dados['search']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarOrderService->fullRead("SELECT os.*, lj.nome loja, se.nome status, tp.nome tipo, t.nome tam, m.nome marca, ljc.nome loja_conserto, c.cor
                FROM adms_qualidade_ordem_servico os INNER JOIN tb_lojas lj ON lj.id=os.loja_id LEFT JOIN tb_lojas ljc ON ljc.id=os.loja_id_conserto INNER JOIN adms_sits_ordem_servico se ON se.id=os.status_id INNER JOIN adms_cors c ON c.id=se.cor_id INNER JOIN adms_tips_ordem_servico tp ON tp.id=os.type_order_id INNER JOIN tb_tam t ON t.id=os.tam_id INNER JOIN adms_marcas m ON m.id=os.marca_id WHERE os.client_name LIKE '%' :client_name '%' OR os.id =:id OR lj.nome LIKE '%' :loja '%' OR os.order_service =:ordem OR os.referencia LIKE '%' :referencia '%' ORDER BY os.id DESC LIMIT :limit OFFSET :offset", "client_name={$this->Dados['search']}&id={$this->Dados['search']}&loja={$this->Dados['search']}&ordem={$this->Dados['search']}&referencia={$this->Dados['search']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarOrderService->getResultado();
    }

    public function listCad() {

        $listar = new \App\adms\Models\helper\AdmsRead();
        if (($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION)) {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        }
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id m_id, nome brand FROM adms_marcas ORDER BY nome ASC");
        $registro['marcas'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM adms_sits_ordem_servico ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        //Pedidos Delivery
        if (($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION)) {
            $listar->fullRead("SELECT COUNT(id) AS total_order FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS total_order FROM adms_qualidade_ordem_servico");
        }
        $registro['sitTotal'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION)) {
            $listar->fullRead("SELECT COUNT(id) AS sitPend FROM adms_qualidade_ordem_servico WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=1&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS sitPend FROM adms_qualidade_ordem_servico WHERE status_id =:status_id", "status_id=1");
        }
        $registro['sitPend'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION)) {
            $listar->fullRead("SELECT COUNT(id) AS sitAgCons FROM adms_qualidade_ordem_servico WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=2&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS sitAgCons FROM adms_qualidade_ordem_servico WHERE status_id =:status_id", "status_id=2");
        }
        $registro['sitAgCons'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION)) {
            $listar->fullRead("SELECT COUNT(id) AS sitEmConst FROM adms_qualidade_ordem_servico WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=3&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS sitEmConst FROM adms_qualidade_ordem_servico WHERE status_id =:status_id", "status_id=3");
        }
        $registro['sitEmConst'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION)) {
            $listar->fullRead("SELECT COUNT(id) AS sitConcl FROM adms_qualidade_ordem_servico WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=4&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS sitConcl FROM adms_qualidade_ordem_servico WHERE status_id =:status_id", "status_id=4");
        }
        $registro['sitConcl'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION)) {
            $listar->fullRead("SELECT COUNT(id) AS sitAgRet FROM adms_qualidade_ordem_servico WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=5&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS sitAgRet FROM adms_qualidade_ordem_servico WHERE status_id =:status_id", "status_id=5");
        }
        $registro['sitAgRet'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION)) {
            $listar->fullRead("SELECT COUNT(id) AS sitEmProcess FROM adms_qualidade_ordem_servico WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=6&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS sitEmProcess FROM adms_qualidade_ordem_servico WHERE status_id =:status_id", "status_id=6");
        }
        $registro['sitEmProcess'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION)) {
            $listar->fullRead("SELECT COUNT(id) AS sitFinal FROM adms_qualidade_ordem_servico WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=7&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS sitFinal FROM adms_qualidade_ordem_servico WHERE status_id =:status_id", "status_id=7");
        }
        $registro['sitFinal'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION)) {
            $listar->fullRead("SELECT COUNT(id) AS sitCancel FROM adms_qualidade_ordem_servico WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=8&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS sitCancel FROM adms_qualidade_ordem_servico WHERE status_id =:status_id", "status_id=8");
        }
        $registro['sitCancel'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit'], 'marcas' => $registro['marcas'],
            'sitTotal' => $registro['sitTotal'], 'sitPend' => $registro['sitPend'], 'sitAgCons' => $registro['sitAgCons'],
            'sitEmConst' => $registro['sitEmConst'], 'sitConcl' => $registro['sitConcl'], 'sitAgRet' => $registro['sitAgRet'],
            'sitEmProcess' => $registro['sitEmProcess'], 'sitFinal' => $registro['sitFinal'], 'sitCancel' => $registro['sitCancel']
        ];
        return $this->Resultado;
    }
}
