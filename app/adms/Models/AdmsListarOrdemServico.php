<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarOrdemServico
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarOrdemServico {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'ordem-servico/listar-ordem-servico');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_qualidade_ordem_servico WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarOrdemService = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarOrdemService->fullRead("SELECT os.*, lj.nome nome_loja, st.nome status, tam.nome tam, c.cor FROM adms_qualidade_ordem_servico os INNER JOIN tb_lojas lj ON lj.id=os.loja_id INNER JOIN adms_sits_ordem_servico st ON st.id=os.status_id INNER JOIN adms_cors c ON c.id=st.cor_id INNER JOIN tb_tam tam ON tam.id=os.tam_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarOrdemService->fullRead("SELECT os.*, lj.nome nome_loja, st.nome status, tam.nome tam, c.cor FROM adms_qualidade_ordem_servico os INNER JOIN tb_lojas lj ON lj.id=os.loja_id INNER JOIN adms_sits_ordem_servico st ON st.id=os.status_id INNER JOIN adms_cors c ON c.id=st.cor_id INNER JOIN tb_tam tam ON tam.id=os.tam_id INNER JOIN adms_usuarios user ON user.loja_id=os.loja_id WHERE os.loja_id =:loja_id ORDER BY os.id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarOrdemService->getResultado();
        return $this->Resultado;
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['ordem_nivac'] <= 5) {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        }
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status_aj ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit']];

        return $this->Resultado;
    }

}
