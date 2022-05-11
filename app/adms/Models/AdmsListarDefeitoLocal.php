<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarDefeitoLocal
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarDefeitoLocal {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarDefeitoLocal($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'defeito-local/listar-defeito-local');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_def_local_ordem_servico");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_def_local_ordem_servico WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDefLocal = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarDefLocal->fullRead("SELECT d.*, st.nome status FROM adms_def_local_ordem_servico d INNER JOIN adms_sits st ON st.id=d.status_id ORDER BY d.id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarDefLocal->fullRead("SELECT d.*, st.nome status FROM adms_def_local_ordem_servico d INNER JOIN adms_sits st ON st.id=d.status_id WHERE aj.loja_id =:loja_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarDefLocal->getResultado();
        return $this->Resultado;
    }

}
