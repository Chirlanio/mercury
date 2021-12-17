<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarRemanejo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarRemanejo {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarRemanejo($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'remanejo/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_remanejos");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_remanejos WHERE loja_origem_id =:loja_origem_id", "loja_origem_id=" . $_SESSION['usuario_loja']);
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarRemanejo = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarRemanejo->fullRead("SELECT rem.*, lj.nome loja_origem, ld.nome loja_destino, m.nome marca, t.nome tipo, p.nome prioridade, s.nome situacao, c.cor FROM adms_remanejos rem INNER JOIN adms_marcas m ON m.id=rem.adms_marca_id INNER JOIN tb_lojas lj ON lj.id=rem.loja_origem_id INNER JOIN tb_lojas ld ON ld.id=rem.loja_destino_id INNER JOIN adms_tps_remanejos t ON t.id=rem.adms_tipo_rem_id INNER JOIN adms_prioridades p ON p.id=rem.adms_prdd_id INNER JOIN adms_sits_remanejos s ON s.id=rem.adms_sit_rem_id INNER JOIN adms_cors c ON c.id=s.adms_cor_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarRemanejo->fullRead("SELECT rem.*, lj.nome loja_origem, ld.nome loja_destino, m.nome marca, t.nome tipo, p.nome prioridade, s.nome situacao, c.cor FROM adms_remanejos rem INNER JOIN adms_marcas m ON m.id=rem.adms_marca_id INNER JOIN tb_lojas lj ON lj.id=rem.loja_origem_id INNER JOIN tb_lojas ld ON ld.id=rem.loja_destino_id INNER JOIN adms_tps_remanejos t ON t.id=rem.adms_tipo_rem_id INNER JOIN adms_prioridades p ON p.id=rem.adms_prdd_id INNER JOIN adms_sits_remanejos s ON s.id=rem.adms_sit_rem_id INNER JOIN adms_cors c ON c.id=s.adms_cor_id WHERE rem.loja_origem_id =:loja_origem_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        
        $this->Resultado = $listarRemanejo->getResultado();
        return $this->Resultado;
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['ordem_nivac'] <= 5) {
            $listar->fullRead("SELECT id loja_ori, nome loja_origem FROM tb_lojas ORDER BY id ASC");
        } else {
            $listar->fullRead("SELECT id loja_ori, nome loja_origem FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        }
        $registro['loja_ori'] = $listar->getResultado();
        
        $listar->fullRead("SELECT id id_des, nome loja_destino FROM tb_lojas WHERE status_id <>:status_id ORDER BY id ASC", "status_id=2");
        $registro['loja_des'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM adms_sits_remanejos ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['loja_ori' => $registro['loja_ori'], 'loja_des' => $registro['loja_des'], 'sit' => $registro['sit']];

        return $this->Resultado;
    }

}
