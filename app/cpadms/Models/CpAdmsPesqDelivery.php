<?php

namespace App\cpadms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsPesqDelivery
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CpAdmsPesqDelivery {

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = 50;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function pesqDelivery($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['cliente'] = trim($this->Dados['cliente']);

        $_SESSION['loja_id'] = $this->Dados['loja_id'];
        $_SESSION['min_id'] = $this->Dados['min_id'];
        $_SESSION['max_id'] = $this->Dados['max_id'];
        $_SESSION['sit_id'] = $this->Dados['sit_id'];
        $_SESSION['cliente'] = $this->Dados['cliente'];

        if ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['min_id'])) AND (!empty($this->Dados['max_id'])) AND (!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqComp();
            $_SESSION['search'] = 1;
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['min_id'])) AND (!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqLojaMinIdSitCli();
            $_SESSION['search'] = 2;
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['max_id'])) AND (!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqLojaMaxIdSitCli();
            $_SESSION['search'] = 3;
        } elseif ((!empty($this->Dados['min_id'])) AND (!empty($this->Dados['max_id'])) AND (!empty($this->Dados['sit_id']))) {
            $this->pesqMinMaxIdSit();
            $_SESSION['search'] = 4;
        } elseif ((!empty($this->Dados['min_id'])) AND (!empty($this->Dados['max_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqMinMaxIdCli();
            $_SESSION['search'] = 5;
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['min_id'])) AND (!empty($this->Dados['sit_id']))) {
            $this->pesqLojaMinIdSit();
            $_SESSION['search'] = 6;
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
        } else{
            $this->gerarPlanilha();
        }
        return $this->Resultado;
    }

    private function pesqComp() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id'] . '&max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['sit_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id BETWEEN :min_id AND :max_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id BETWEEN :min_id AND :max_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqMinMaxIdSit() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?min_id=' . $this->Dados['min_id'] . '&max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id AND status_id =:status_id", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id BETWEEN :min_id AND :max_id AND status_id =:status_id", "min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id BETWEEN :min_id AND :max_id AND d.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id BETWEEN :min_id AND :max_id AND d.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqMinMaxIdCli() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?min_id=' . $this->Dados['min_id'] . '&max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id BETWEEN :min_id AND :max_id AND cliente LIKE '%' :cliente '%'", "min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id BETWEEN :min_id AND :max_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id BETWEEN :min_id AND :max_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaMinIdSit() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id AND status_id =:status_id", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id AND status_id =:status_id", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaMaxIdSit() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?loja=' . $this->Dados['loja_id'] . '&max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id AND status_id =:status_id", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id AND status_id =:status_id", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id AND d.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaMinIdSitCli() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id'] . '&situacao=' . $this->Dados['sit_id'] . 'cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaMaxIdSitCli() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?loja=' . $this->Dados['loja_id'] . '&max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['sit_id'] . 'cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaMinIdCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id AND cliente LIKE '%' :cliente '%'", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaMaxIdCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?loja=' . $this->Dados['loja_id'] . '&max_id=' . $this->Dados['max_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id AND cliente LIKE '%' :cliente '%'", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaSitCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?loja=' . $this->Dados['loja_id'] . '&situacao=' . $this->Dados['sit_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id={$this->Dados['loja_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqMinIdSitCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?min_id=' . $this->Dados['min_id'] . '&situacao=' . $this->Dados['sit_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id >=:min_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id >=:min_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqMaxIdSitCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['sit_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id <=:max_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id <=:max_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?loja=' . $this->Dados['loja_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND cliente LIKE '%' :cliente '%'", "loja_id={$this->Dados['loja_id']}&cliente={$this->Dados['cliente']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaMinMaxId() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id'] . '&max_id=' . $this->Dados['max_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id BETWEEN :min_id AND :max_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqMinMaxId() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?min_id=' . $this->Dados['min_id'] . '&max_id=' . $this->Dados['max_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id BETWEEN :min_id AND :max_id", "min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id BETWEEN :min_id AND :max_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id BETWEEN :min_id AND :max_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaMinId() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaMaxId() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?loja=' . $this->Dados['loja_id'] . '&max_id=' . $this->Dados['max_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaStatus() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?loja=' . $this->Dados['loja_id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND status_id =:status_id", "loja_id={$this->Dados['loja_id']}&status_id={$this->Dados['sit_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqMinIdCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?min_id=' . $this->Dados['min_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id >=:min_id AND cliente LIKE '%' :cliente '%'", "min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id >=:min_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqMaxIdCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?max_id=' . $this->Dados['max_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id <=:max_id AND cliente LIKE '%' :cliente '%'", "max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE loja_id =:loja_id AND d.id <=:max_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id <=:max_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqSitCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?situacao=' . $this->Dados['sit_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE status_id =:status_id AND cliente LIKE '%' :cliente '%'", "status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE loja_id =:loja_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqMinIdStatus() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?min_id=' . $this->Dados['min_id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id AND status_id =:status_id", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id >=:min_id AND status_id =:status_id", "min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id >=:min_id AND d.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqMaxIdStatus() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id AND status_id =:status_id", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id <=:max_id AND status_id =:status_id", "max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id AND d.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id <=:max_id AND d.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLoja() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?loja=' . $this->Dados['loja_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id WHERE d.loja_id =:loja_id", "loja_id={$this->Dados['loja_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqMinId() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?min_id=' . $this->Dados['min_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d WHERE d.loja_id =:loja_id AND d.id >=:min_id", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d WHERE d.id >=:min_id", "min_id={$this->Dados['min_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id >=:min_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqMaxId() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?max_id=' . $this->Dados['max_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d WHERE d.loja_id =:loja_id AND d.id <=:max_id", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d WHERE d.id <=:max_id", "max_id={$this->Dados['max_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id <=:max_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqStatus() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d WHERE d.loja_id =:loja_id AND d.status_id =:status_id", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['sit_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d WHERE d.status_id =:status_id", "status_id={$this->Dados['sit_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.status_id =:status_id ORDER BY id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.status_id =:status_id ORDER BY id ASC LIMIT :limit OFFSET :offset", "status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d WHERE d.loja_id =:loja_id AND d.cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d WHERE d.cliente LIKE '%' :cliente '%'", "cliente={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function gerarPlanilha() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d WHERE d.loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d", "cliente={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] <= 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        }
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status_delivery ORDER BY id ASC");
        $registro['sit_id'] = $listar->getResultado();

        //Pedidos Delivery
        if (($_SESSION['adms_niveis_acesso_id'] == 5)) {
            $listar->fullRead("SELECT COUNT(id) AS deli FROM tb_delivery WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS deli FROM tb_delivery");
        }
        $registro['deli'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5)) {
            $listar->fullRead("SELECT COUNT(id) AS deliSol FROM tb_delivery WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=1&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS deliSol FROM tb_delivery WHERE status_id =:status_id", "status_id=1");
        }
        $registro['deliSol'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5)) {
            $listar->fullRead("SELECT COUNT(id) AS deliCol FROM tb_delivery WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=2&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS deliCol FROM tb_delivery WHERE status_id =:status_id", "status_id=2");
        }
        $registro['deliCol'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5)) {
            $listar->fullRead("SELECT COUNT(id) AS deliAg FROM tb_delivery WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=3&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS deliAg FROM tb_delivery WHERE status_id =:status_id", "status_id=3");
        }
        $registro['deliAg'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5)) {
            $listar->fullRead("SELECT COUNT(id) AS deliRota FROM tb_delivery WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=4&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS deliRota FROM tb_delivery WHERE status_id =:status_id", "status_id=4");
        }
        $registro['deliRota'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5)) {
            $listar->fullRead("SELECT COUNT(id) AS deliEnt FROM tb_delivery WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=5&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS deliEnt FROM tb_delivery WHERE status_id =:status_id", "status_id=5");
        }
        $registro['deliEnt'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit_id' => $registro['sit_id'],
            'deli' => $registro['deli'], 'deliSol' => $registro['deliSol'], 'deliCol' => $registro['deliCol'], 'deliAg' => $registro['deliAg'], 'deliRota' => $registro['deliRota'], 'deliEnt' => $registro['deliEnt']
        ];
        return $this->Resultado;
    }

}
