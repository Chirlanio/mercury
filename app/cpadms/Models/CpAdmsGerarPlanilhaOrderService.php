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
class CpAdmsGerarPlanilhaOrderService {

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

        $this->gerarPlanilha();
        return $this->Resultado;
    }

    private function gerarPlanilha() {
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-order-service/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM adms_qualidade_ordem_servico d WHERE d.loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM adms_qualidade_ordem_servico d");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 5) {
            $listarDelivery->fullRead("SELECT d.id, l.nome loja, d.referencia, t.nome tam, m.nome marca, tip.nome type_order, d.client_name, d.qtde, def.descricao defeito, det.descricao detalhe, loc.descricao local, d.order_service, d.date_order_service, d.order_service_zznet, d.date_order_service_zznet, d.num_nota_transf, d.data_emissao_nota_transf, d.data_confir_nota_transf, d.data_dif_emissao_confir, lj.nome lj_conserto, d.nf_conserto_devolucao, d.data_emissao_conserto, d.nf_retorno_conserto, d.data_emissao_retorno_conserto, d.data_confir_retorno_conserto, d.nf_transf_saldo_produto, d.data_nota_transf_saldo_produto, d.obs_loja, d.indenizado, d.data_indenizado, d.nf_devolucao_fornecedor,d.data_emissao_nf_devolucao, d.obs_qualidade, s.nome status, d.created, d.modified FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas l ON l.id = d.loja_id INNER JOIN tb_tam t ON t.id = d.tam_id INNER JOIN adms_marcas m ON m.id = d.marca_id INNER JOIN adms_tips_ordem_servico tip ON tip.id = d.type_order_id INNER JOIN adms_defeitos_ordem_servico def ON def.id = d.def_id INNER JOIN adms_detalhes_ordem_servico det ON det.id = d.det_id INNER JOIN adms_def_local_ordem_servico loc ON loc.id = d.loc_id LEFT JOIN tb_lojas lj ON lj.id = d.loja_id_conserto INNER JOIN adms_sits_ordem_servico s ON s.id = d.status_id WHERE d.loja_id =:loja_id ORDER BY id ASC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDelivery->fullRead("SELECT d.id, l.nome loja, d.referencia, t.nome tam, m.nome marca, tip.nome type_order, d.client_name, d.qtde, def.descricao defeito, det.descricao detalhe, loc.descricao local, d.order_service, d.date_order_service, d.order_service_zznet, d.date_order_service_zznet, d.num_nota_transf, d.data_emissao_nota_transf, d.data_confir_nota_transf, d.data_dif_emissao_confir, lj.nome lj_conserto, d.nf_conserto_devolucao, d.data_emissao_conserto, d.nf_retorno_conserto, d.data_emissao_retorno_conserto, d.data_confir_retorno_conserto, d.nf_transf_saldo_produto, d.data_nota_transf_saldo_produto, d.obs_loja, d.indenizado, d.data_indenizado, d.nf_devolucao_fornecedor, d.data_emissao_nf_devolucao, d.obs_qualidade, s.nome status, d.created, d.modified FROM adms_qualidade_ordem_servico d INNER JOIN tb_lojas l ON l.id = d.loja_id INNER JOIN tb_tam t ON t.id = d.tam_id INNER JOIN adms_marcas m ON m.id = d.marca_id INNER JOIN adms_tips_ordem_servico tip ON tip.id = d.type_order_id INNER JOIN adms_defeitos_ordem_servico def ON def.id = d.def_id INNER JOIN adms_detalhes_ordem_servico det ON det.id = d.det_id INNER JOIN adms_def_local_ordem_servico loc ON loc.id = d.loc_id LEFT JOIN tb_lojas lj ON lj.id = d.loja_id_conserto INNER JOIN adms_sits_ordem_servico s ON s.id = d.status_id ORDER BY id ASC LIMIT :limit OFFSET :offset", "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDelivery->getResult();
    }

}
