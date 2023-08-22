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
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoAj() {
        return $this->ResultadoPg;
    }

    public function listar($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['search'] = trim($this->Dados['search']);

        $_SESSION['pesqOrderService'] = $this->Dados['search'];

        if (!empty($this->Dados['search'])) {
            $this->pesqSearch();
        }
        return $this->Resultado;
    }

    private function pesqSearch() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar', '?pesquisar=' . $this->Dados['search']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(os.id) AS num_result FROM adms_qualidade_ordem_servico os WHERE os.loja_id =:loja_id AND os.client_name LIKE '%' :client_name '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&client_name={$this->Dados['search']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(os.id) AS num_result FROM adms_qualidade_ordem_servico os WHERE os.client_name LIKE '%' :client_name '%' OR os.id =:id", "client_name={$this->Dados['search']}&id={$this->Dados['search']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarOrderService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarOrderService->fullRead("SELECT os.*, lj.nome loja, se.nome status, tp.nome tipo, t.nome tam, m.nome marca, ljc.nome loja_conserto, c.cor
                FROM adms_qualidade_ordem_servico os
                INNER JOIN tb_lojas lj ON lj.id=os.loja_id
                LEFT JOIN tb_lojas ljc ON ljc.id=os.loja_id_conserto
                INNER JOIN adms_sits_ordem_servico se ON se.id=os.status_id
                INNER JOIN adms_cors c ON c.id=se.cor_id
                INNER JOIN adms_tips_ordem_servico tp ON tp.id=os.type_order_id
                INNER JOIN tb_tam t ON t.id=os.tam_id
                INNER JOIN adms_marcas m ON m.id=os.marca_id
                WHERE os.loja_id =:loja_id AND (os.client_name LIKE '%' :client_name '%' OR os.id =:id OR lj.nome LIKE '%' :loja '%' OR os.order_service =:ordem OR os.referencia LIKE '%' :referencia '%') ORDER BY os.id DESC LIMIT :limit OFFSET :offset", "loja_id={$_SESSION['usuario_loja']}&client_name={$this->Dados['search']}&id={$this->Dados['search']}&loja={$this->Dados['search']}&ordem={$this->Dados['search']}&referencia={$this->Dados['search']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarOrderService->fullRead("SELECT os.*, lj.nome loja, se.nome status, tp.nome tipo, t.nome tam, m.nome marca, ljc.nome loja_conserto, c.cor
                FROM adms_qualidade_ordem_servico os
                INNER JOIN tb_lojas lj ON lj.id=os.loja_id
                LEFT JOIN tb_lojas ljc ON ljc.id=os.loja_id_conserto
                INNER JOIN adms_sits_ordem_servico se ON se.id=os.status_id
                INNER JOIN adms_cors c ON c.id=se.cor_id
                INNER JOIN adms_tips_ordem_servico tp ON tp.id=os.type_order_id
                INNER JOIN tb_tam t ON t.id=os.tam_id
                INNER JOIN adms_marcas m ON m.id=os.marca_id
                WHERE os.client_name LIKE '%' :client_name '%' OR os.id =:id OR lj.nome LIKE '%' :loja '%' OR os.order_service =:ordem OR os.referencia LIKE '%' :referencia '%' ORDER BY os.id DESC LIMIT :limit OFFSET :offset", "client_name={$this->Dados['search']}&id={$this->Dados['search']}&loja={$this->Dados['search']}&ordem={$this->Dados['search']}&referencia={$this->Dados['search']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarOrderService->getResultado();
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
