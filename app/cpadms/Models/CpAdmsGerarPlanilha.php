<?php

namespace App\cpadms\Models;

if (!defined('URL')) {
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
    private $PageId;
    private $LimiteResultado = 1048576;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerar-planilha/gerar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_delivery");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarCargo = new \App\adms\Models\helper\AdmsRead();
        $listarCargo->fullRead("SELECT d.id id_loja, d.loja_id, d.func_id, d.cliente, d.endereco, d.bairro_id, d.rota_id, d.contato, d.valor_venda, d.forma_pag_id,
                d.parcelas, d.maq, d.ped_id, d.obs, d.troca, d.ponto_saida, d.status_id, d.created,
                l.nome nome_loja, ls.nome saida, f.nome func, t.nome sit, b.nome bairro, r.nome rota, c.cor, fp.nome forma
                FROM tb_delivery d
                INNER JOIN tb_lojas l ON l.id=d.loja_id
                INNER JOIN tb_funcionarios f ON f.id=d.func_id
                INNER JOIN tb_status_delivery t ON t.id=d.status_id
                INNER JOIN tb_ponto_saida ls ON ls.id=d.ponto_saida
                INNER JOIN tb_bairros b ON b.id=d.bairro_id
                INNER JOIN tb_rotas r ON r.id=b.rota_id
                INNER JOIN adms_cors c ON c.id=r.adms_cor_id
                INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id
                ORDER BY d.id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarCargo->getResultado();
        return $this->Resultado;
    }

}
