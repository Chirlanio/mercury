<?php

namespace App\cpadms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsSearchOrderPayments
 *
 * @copyright (c) year, Chiralnio Silva - Grupo Meia Sola
 */
class CpAdmsSearchOrderPayments {

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultado() {
        return $this->ResultadoPg;
    }

    public function list($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['search'] = trim($this->Dados['search']);

        $_SESSION['serach'] = $this->Dados['search'];

        if (!empty($this->Dados['search'])) {
            $this->pesqSearch();
        }
        return $this->Resultado;
    }

    private function pesqSearch() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'search-order-payments/list', '?search=' . $this->Dados['search']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(o.id) / COUNT(DISTINCT(o.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments o WHERE o.loja_id =:loja_id AND e.nome_cliente LIKE '%' :nome_cliente '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&nome_cliente={$this->Dados['search']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(o.id) / COUNT(DISTINCT(o.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments o WHERE o.nome_cliente LIKE '%' :nome_cliente '%'", "nome_cliente={$this->Dados['search']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarEstorno = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarEstorno->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, c.cor cor_cr FROM adms_estornos aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN adms_sits_estornos st ON st.id=aj.adms_sits_est_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE aj.loja_id =:loja_id AND aj.nome_cliente LIKE '%' :nome_cliente '%' OR st.nome LIKE '%' :status '%' OR lj.nome LIKE '%' :nome_loja '%' OR aj.id LIKE '%' :est_id '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&nome_cliente={$this->Dados['search']}&status={$this->Dados['search']}&nome_loja={$this->Dados['search']}&est_id={$this->Dados['search']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarEstorno->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, c.cor cor_cr FROM adms_estornos aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN adms_sits_estornos st ON st.id=aj.adms_sits_est_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE aj.nome_cliente LIKE '%' :nome_cliente '%' OR st.nome LIKE '%' :status '%' OR lj.nome LIKE '%' :nome_loja '%' OR aj.id LIKE '%' :est_id '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "nome_cliente={$this->Dados['search']}&status={$this->Dados['search']}&nome_loja={$this->Dados['search']}&est_id={$this->Dados['search']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarEstorno->getResultado();
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        }
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM adms_sits_estornos ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit']];

        return $this->Resultado;
    }

}
