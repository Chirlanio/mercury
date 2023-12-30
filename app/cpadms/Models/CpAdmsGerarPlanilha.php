<?php

namespace App\cpadms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsGerarPlanilha
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CpAdmsGerarPlanilha {

    private $Resultado;
    private $Dados;
    private $PageId;
    private $LimiteResultado = 1048576;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listar($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['cliente'] = trim($this->Dados['cliente']);

        $_SESSION['loja_id'] = $this->Dados['loja_id'];
        $_SESSION['min_id'] = $this->Dados['min_id'];
        $_SESSION['max_id'] = $this->Dados['max_id'];
        $_SESSION['sit_id'] = $this->Dados['sit_id'];
        $_SESSION['cliente'] = $this->Dados['cliente'];

        if ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['min_id'])) AND (!empty($this->Dados['max_id'])) AND (!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqComp(); //Revisado
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['min_id'])) AND (!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqLojaMinIdSitCli(); //Revisado
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['max_id'])) AND (!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqLojaMaxIdSitCli(); //Revisado
        } elseif ((!empty($this->Dados['min_id'])) AND (!empty($this->Dados['max_id'])) AND (!empty($this->Dados['sit_id']))) {
            $this->pesqMinMaxIdSit(); //Revisado
        } elseif ((!empty($this->Dados['min_id'])) AND (!empty($this->Dados['max_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqMinMaxIdCli(); //Revisado
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['min_id'])) AND (!empty($this->Dados['sit_id']))) {
            $this->pesqLojaMinIdSit(); //Revisado
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['max_id'])) AND (!empty($this->Dados['sit_id']))) {
            $this->pesqLojaMaxIdSit(); //Revisado
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['min_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqLojaMinIdCliente(); //Revisado
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['max_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqLojaMaxIdCliente(); //Revisado
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqLojaSitCliente(); //Revisado
        } elseif ((!empty($this->Dados['min_id'])) AND (!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqMinIdSitCliente(); //Revisado
        } elseif ((!empty($this->Dados['max_id'])) AND (!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqMaxIdSitCliente(); //Revisado
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['min_id'])) AND (!empty($this->Dados['max_id']))) {
            $this->pesqLojaMinMaxId(); //Revisado
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqLojaCliente();//Revisado
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['min_id']))) {
            $this->pesqLojaMinId();//Revisado
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['max_id']))) {
            $this->pesqLojaMaxId();//Revisado
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['sit_id']))) {
            $this->pesqLojaStatus();//Revisado
        } elseif ((!empty($this->Dados['min_id'])) AND (!empty($this->Dados['sit_id']))) {
            $this->pesqMinIdStatus();//Revisado
        } elseif ((!empty($this->Dados['max_id'])) AND (!empty($this->Dados['sit_id']))) {
            $this->pesqMaxIdStatus();//Revisado
        } elseif ((!empty($this->Dados['min_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqMinIdCliente();//Revisado
        } elseif ((!empty($this->Dados['max_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqMaxIdCliente();//Revisado
        } elseif ((!empty($this->Dados['sit_id'])) AND (!empty($this->Dados['cliente']))) {
            $this->pesqSitCliente();//Revisado
        } else if ((!empty($this->Dados['min_id'])) AND (!empty($this->Dados['max_id']))) {
            $this->pesqMinMaxId();
        } elseif (!empty($this->Dados['loja_id'])) {
            $this->pesqLoja();
        } elseif (!empty($this->Dados['min_id'])) {
            $this->pesqMinId();
        } elseif (!empty($this->Dados['max_id'])) {
            $this->pesqMaxId();
        } elseif (!empty($this->Dados['sit_id'])) {
            $this->pesqStatus();
        } elseif (!empty($this->Dados['cliente'])) {
            $this->pesqCliente();
        } else{
            $this->gerarPlanilha();
        }
        return $this->Resultado;
    }

    private function pesqComp() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id'] . '&max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['sit_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id BETWEEN :min_id AND :max_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id BETWEEN :min_id AND :max_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaMinIdSitCli() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id'] . '&situacao=' . $this->Dados['sit_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaMaxIdSitCli() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?loja=' . $this->Dados['loja_id'] . '&max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['sit_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqMinMaxIdSit() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id'] . '&max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id AND status_id =:status_id", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id BETWEEN :min_id AND :max_id AND status_id =:status_id", "min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id BETWEEN :min_id AND :max_id AND d.status_id =:status_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id BETWEEN :min_id AND :max_id AND d.status_id =:status_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqMinMaxIdCli() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?min_id=' . $this->Dados['min_id'] . '&max_id=' . $this->Dados['max_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id BETWEEN :min_id AND :max_id AND cliente LIKE '%' :cliente '%'", "min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id BETWEEN :min_id AND :max_id AND d.cliente  LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id BETWEEN :min_id AND :max_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaMinMaxId() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id'] . '&max_id=' . $this->Dados['max_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id BETWEEN :min_id AND :max_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id BETWEEN :min_id AND :max_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaMinIdSit() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id AND status_id =:status_id", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id AND status_id =:status_id", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.status_id =:status_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.status_id =:status_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaMaxIdSit() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?loja=' . $this->Dados['loja_id'] . '&max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id AND status_id =:status_id", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id AND status_id =:status_id", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id AND d.status_id =:status_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id AND d.status_id =:status_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaMinIdCliente() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id AND cliente LIKE '%' :cliente '%'", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaMaxIdCliente() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?loja=' . $this->Dados['loja_id'] . '&max_id=' . $this->Dados['max_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id AND cliente LIKE '%' :cliente '%'", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaSitCliente() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?loja=' . $this->Dados['loja_id'] . '&situacao=' . $this->Dados['sit_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id={$this->Dados['loja_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqMinIdSitCliente() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?min_id=' . $this->Dados['min_id'] . '&situacao=' . $this->Dados['sit_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id >=:min_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id >=:min_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqMaxIdSitCliente() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['sit_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id <=:max_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id <=:max_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLojaCliente() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?loja=' . $this->Dados['loja_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&cliente={$this->Dados['cliente']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND cliente LIKE '%' :cliente '%'", "loja_id={$this->Dados['loja_id']}&cliente={$this->Dados['cliente']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }
    
    private function pesqLojaMinId() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?loja=' . $this->Dados['loja_id'] . '&min_id=' . $this->Dados['min_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&min_id={$this->Dados['min_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }
    
    private function pesqLojaMaxId() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?loja=' . $this->Dados['loja_id'] . '&max_id=' . $this->Dados['max_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }
    
    private function pesqLojaStatus() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?loja=' . $this->Dados['loja_id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND status_id =:status_id", "loja_id=" . $_SESSION['usuario_loja'] . "&situacao={$this->Dados['sit_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND status_id =:status_id", "loja_id={$this->Dados['loja_id']}&situacao={$this->Dados['sit_id']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.status_id =:status_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.status_id =:status_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }
    
    private function pesqMinIdStatus() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?min_id=' . $this->Dados['min_id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id AND status_id =:status_id", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id >=:min_id AND status_id =:status_id", "min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.status_id =:status_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id >=:min_id AND d.status_id =:status_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }
    
    private function pesqMaxIdStatus() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?max_id=' . $this->Dados['max_id'] . '&situacao=' . $this->Dados['sit_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id AND status_id =:status_id", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id <=:max_id AND status_id =:status_id", "max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id AND d.status_id =:status_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id <=:max_id AND d.status_id =:status_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "max_id={$this->Dados['max_id']}&status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }
    
    private function pesqMinIdCliente() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?min_id=' . $this->Dados['min_id'] . '&cliente=' . $this->Dados['cliente']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id >=:min_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id >=:min_id AND cliente LIKE '%' :cliente '%'", "min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id >=:min_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }
    
    private function pesqMaxIdCliente() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', "?max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}");
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id <=:max_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id <=:max_id AND cliente LIKE '%' :cliente '%'", "max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id <=:max_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id <=:max_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "max_id={$this->Dados['max_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }
    
    private function pesqSitCliente() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', "?situacao={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND status_id =:status_id AND cliente LIKE '%' :cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE status_id =:status_id AND cliente LIKE '%' :cliente '%'", "status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.status_id =:status_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "status_id={$this->Dados['sit_id']}&cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqMinMaxId() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?min_id=' . $this->Dados['min_id'] . '&max_id=' . $this->Dados['max_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE loja_id =:loja_id AND id BETWEEN :min_id AND :max_id", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery WHERE id BETWEEN :min_id AND :max_id", "min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id BETWEEN :min_id AND :max_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id BETWEEN :min_id AND :max_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqLoja() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar', '?loja=' . $this->Dados['loja_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id WHERE d.loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id WHERE d.loja_id =:loja_id", "loja_id={$this->Dados['loja_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.*, lj.nome loja, b.nome bairro, r.nome rota, c.cor, cr.cor cr_cor, ps.nome saida, s.nome sit, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas lj ON lj.id=d.loja_id INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=d.rota_id INNER JOIN tb_status_delivery s ON s.id=d.status_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN adms_cors cr ON cr.id=s.adms_cor_id INNER JOIN tb_ponto_saida ps ON ps.id=d.ponto_saida INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqMinId() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?min_id=' . $this->Dados['min_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d WHERE d.loja_id =:loja_id d.id >=:min_id", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d WHERE d.id >=:min_id", "min_id={$this->Dados['min_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.id >=:min_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&min_id={$this->Dados['min_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id >=:min_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "min_id={$this->Dados['min_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqMaxId() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar', '?max_id=' . $this->Dados['max_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d WHERE d.loja_id =:loja_id AND d.id <=:max_id", "loja_id=" . $_SESSION['usuario_loja'] . "max_id={$this->Dados['max_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d WHERE d.id <=:max_id", "max_id={$this->Dados['max_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d,loja_id =:loja_id AND d.id <=:max_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.id <=:max_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "max_id={$this->Dados['max_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqStatus() {//Revisado
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
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.status_id =:status_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.status_id =:status_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "status_id={$this->Dados['sit_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function pesqCliente() {//Revisado
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
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id AND d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.cliente LIKE '%' :cliente '%' ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "cliente={$this->Dados['cliente']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

    private function gerarPlanilha() {//Revisado
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-delivery/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d WHERE d.loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM tb_delivery d");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id WHERE d.loja_id =:loja_id ORDER BY id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id, d.parcelas, d.maq, d.obs, d.qtde_produto, d.troca, d.ponto_saida, d.status_id, d.created, d.modified, l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma FROM tb_delivery d INNER JOIN tb_lojas l ON l.id=d.loja_id INNER JOIN tb_funcionarios f ON f.id=d.func_id INNER JOIN tb_status_delivery t ON t.id=d.status_id INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida INNER JOIN tb_bairros b ON b.id=d.bairro_id INNER JOIN tb_rotas r ON r.id=b.rota_id INNER JOIN adms_cors c ON c.id=r.adms_cor_id INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResultado();
    }

}
