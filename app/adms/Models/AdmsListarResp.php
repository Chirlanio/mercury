<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarResp
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarResp {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarResp($PageId = null) {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'autorizacao-resp/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(resp.id) AS num_result FROM adms_resp_autorizacao resp");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarResp = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == 1 || $_SESSION['adms_niveis_acesso_id'] == 9) {
            $listarResp->fullRead("SELECT resp.id, user.nome
                FROM adms_resp_autorizacao resp
                INNER JOIN adms_usuarios user ON user.id=resp.adms_func_id
                ORDER BY user.nome ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarResp->fullRead("SELECT resp.id, user.nome
                FROM adms_resp_autorizacao resp
                INNER JOIN adms_usuarios user ON user.id=resp.adms_func_id
                WHERE user.id =:adms_func_id
                ORDER BY user.nome ASC LIMIT :limit OFFSET :offset", "adms_func_id={$_SESSION['usuario_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarResp->getResultado();
        return $this->Resultado;
    }

}
