<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarAjuste
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarAjuste {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarAjuste($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'ajuste/listar-ajuste');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_ajuste");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_ajuste WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarAjuste = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, st.adms_cor_id, c.cor cor_cr FROM tb_ajuste aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN adms_cors c on c.id=st.adms_cor_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, st.adms_cor_id, c.cor cor_cr FROM tb_ajuste aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN adms_usuarios user ON user.loja_id=aj.loja_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE aj.loja_id =:loja_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarAjuste->getResult();
        return $this->Resultado;
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        }
        $registro['loja_id'] = $listar->getResult();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status_aj ORDER BY id ASC");
        $registro['sit'] = $listar->getResult();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit']];

        return $this->Resultado;
    }

}
