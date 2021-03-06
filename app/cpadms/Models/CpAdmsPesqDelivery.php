<?php

namespace App\cpadms\Models;

if (!defined('URL')) {
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

        $_SESSION['pesqLoja'] = $this->Dados['loja_id'];
        $_SESSION['pesqId'] = $this->Dados['id'];
        $_SESSION['pesqSit'] = $this->Dados['sit_id'];
        $_SESSION['pesqCli'] = $this->Dados['cliente'];

        if ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['id'])) AND (!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqComp();
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['id'])) AND (!empty($this->Dados['sit_id']))) {
            $this->pesqLojaIdSit();
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqLojaIdCliente();
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqLojaSitCliente();
        } elseif ((!empty($this->Dados['id'])) AND (!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqIdSitCliente();
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqLojaCliente();
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['id']))) {
            $this->pesqLojaId();
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['sit_id']))) {
            $this->pesqLojaStatus();
        } elseif ((!empty($this->Dados['id'])) AND (!empty($this->Dados['sit_id']))) {
            $this->pesqIdStatus();
        } elseif ((!empty($this->Dados['id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqIdCliente();
        } elseif ((!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqSitCliente();
        } elseif (!empty($this->Dados['loja_id'])) {
            $this->pesqLoja();
        } elseif (!empty($this->Dados['id'])) {
            $this->pesqId();
        } elseif (!empty($this->Dados['sit_id'])) {
            $this->pesqStatus();
        } elseif (!empty($this->Dados['cliente'])) {
            $this->pesqCliente();
        }
        return $this->Resultado;
    }

    private function pesqComp() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?loja=' . $this->Dados['loja_id'] . '&id=' . $this->Dados['id'] . '&situacao=' . $this->Dados['sit_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id =:id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&id={$this->Dados['id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id =:id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id={$this->Dados['loja_id']}&id={$this->Dados['id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id =:id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&id={$this->Dados['id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id =:id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&id={$this->Dados['id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaIdSit() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?loja=' . $this->Dados['loja_id'] . '&id=' . $this->Dados['id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id =:id AND status_id =:status_id", "loja_id=" . $_SESSION['usuarioa_loja'] . "&id={$this->Dados['id']}&status_id={$this->Dados['sit_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id =:id AND status_id =:status_id", "loja_id={$this->Dados['loja_id']}&id={$this->Dados['id']}&status_id={$this->Dados['sit_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id =:id AND d.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&id={$this->Dados['id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaIdCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?loja=' . $this->Dados['loja_id'] . '&id=' . $this->Dados['id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id =:id AND cliente LIKE '%' :cliente '%'", "loja_id={$this->Dados['loja_id']}&id={$this->Dados['id']}&cliente={$this->Dados['cliente']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id =:id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&id={$this->Dados['id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
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

    private function pesqIdSitCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?id=' . $this->Dados['id'] . '&situacao=' . $this->Dados['sit_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id =:id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "id={$this->Dados['id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id =:id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "id={$this->Dados['id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
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

    private function pesqLojaId() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?loja=' . $this->Dados['loja_id'] . '&id=' . $this->Dados['id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id =:id", "loja_id={$this->Dados['loja_id']}&id={$this->Dados['id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id LIKE '%' :id '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&id={$this->Dados['id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
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

    private function pesqIdCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?id=' . $this->Dados['id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id =:id AND cliente LIKE '%' :cliente '%'", "id={$this->Dados['id']}&cliente={$this->Dados['cliente']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id =:id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "id={$this->Dados['id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqSitCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?situacao=' . $this->Dados['sit_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE status_id =:status_id AND cliente LIKE '%' :cliente '%'", "status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqIdStatus() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?id=' . $this->Dados['id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id =:id AND status_id =:status_id", "id={$this->Dados['id']}&status_id={$this->Dados['sit_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id =:id AND d.status_id =:status_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "id={$this->Dados['id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
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

    private function pesqId() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?id=' . $this->Dados['id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d WHERE d.id =:id", "id={$this->Dados['id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id =:id ORDER BY id DESC LIMIT :limit OFFSET :offset", "id={$this->Dados['id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqStatus() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d WHERE d.status_id =:status_id", "status_id={$this->Dados['sit_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d WHERE d.loja_id =:loja_id AND d.status_id =:status_id", "loja_id" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['sit_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.status_id =:status_id ORDER BY id ASC LIMIT :limit OFFSET :offset", "status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.status_id =:status_id ORDER BY id ASC LIMIT :limit OFFSET :offset", "loja_id" . $_SESSION['usuario_loja'] . "status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqCliente() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d WHERE d.cliente LIKE '%' :cliente '%'", "cliente={$this->Dados['cliente']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.cliente LIKE '%' :cliente '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
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
