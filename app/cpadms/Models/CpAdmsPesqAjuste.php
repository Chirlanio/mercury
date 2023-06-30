<?php

namespace App\cpadms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsPesqAjuste
 *
 * @copyright (c) year, Chiralnio Silva - Grupo Meia Sola
 */
class CpAdmsPesqAjuste {

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

        $this->Dados['referencia'] = trim($this->Dados['referencia']);

        $_SESSION['pesqLoja'] = $this->Dados['loja_id'];
        $_SESSION['pesqRef'] = $this->Dados['referencia'];
        $_SESSION['pesqSit'] = $this->Dados['status_aj_id'];

        if ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['referencia'])) AND (!empty($this->Dados['status_aj_id']))) {
            $this->pesqComp();
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['referencia']))) {
            $this->pesqLojaRef();
        } elseif ((!empty($this->Dados['loja_id'])) AND (!empty($this->Dados['status_aj_id']))) {
            $this->pesqLojaStatus();
        } elseif ((!empty($this->Dados['referencia'])) AND (!empty($this->Dados['status_aj_id']))) {
            $this->pesqRefStatus();
        } elseif (!empty($this->Dados['loja_id'])) {
            $this->pesqLoja();
        } elseif (!empty($this->Dados['referencia'])) {
            $this->pesqReferencia();
        } elseif (!empty($this->Dados['status_aj_id'])) {
            $this->pesqStatus();
        }
        return $this->Resultado;
    }

    private function pesqComp() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-ajuste/listar', '?loja=' . $this->Dados['loja_id'] . '&referencia=' . $this->Dados['referencia'] . '&situacao=' . $this->Dados['status_aj_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_ajuste WHERE loja_id =:loja_id AND referencia LIKE '%' :referencia '%' AND status_aj_id =:status_aj_id", "loja_id={$this->Dados['loja_id']}&referencia={$this->Dados['referencia']}&status_aj_id={$this->Dados['status_aj_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_ajuste WHERE loja_id =:loja_id AND referencia LIKE '%' :referencia '%' AND status_aj_id =:status_aj_id", "loja_id=" . $_SESSION['usuario_loja'] . "&referencia={$this->Dados['referencia']}&status_aj_id={$this->Dados['status_aj_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarAjuste = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, st.adms_cor_id, c.cor cor_cr FROM tb_ajuste aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE aj.loja_id =:loja_id AND aj.referencia LIKE '%' :referencia '%' AND status_aj_id =:status_aj_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&referencia={$this->Dados['referencia']}&status_aj_id={$this->Dados['status_aj_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, st.adms_cor_id, c.cor cor_cr FROM tb_ajuste aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN adms_usuarios user ON user.loja_id=aj.loja_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE aj.loja_id =:loja_id AND aj.referencia LIKE '%' :referencia '%' AND aj.status_aj_id =:status_aj_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&referencia={$this->Dados['referencia']}&status_aj_id={$this->Dados['status_aj_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarAjuste->getResultado();
    }

    private function pesqLojaRef() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-ajuste/listar', '?loja=' . $this->Dados['loja_id'] . '&referencia=' . $this->Dados['referencia']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_ajuste WHERE loja_id =:loja_id AND referencia LIKE '%' :referencia '%'", "loja_id={$this->Dados['loja_id']}&referencia={$this->Dados['referencia']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_ajuste WHERE loja_id =:loja_id AND referencia LIKE '%' :referencia '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&referencia={$this->Dados['referencia']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarAjuste = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, st.adms_cor_id, c.cor cor_cr FROM tb_ajuste aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE loja_id =:loja_id AND aj.referencia LIKE '%' :referencia '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&referencia={$this->Dados['referencia']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, st.adms_cor_id, c.cor cor_cr FROM tb_ajuste aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN adms_usuarios user ON user.loja_id=aj.loja_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE aj.loja_id =:loja_id AND aj.referencia LIKE '%' :referencia '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&referencia={$this->Dados['referencia']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarAjuste->getResultado();
    }

    private function pesqLojaStatus() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-ajuste/listar', '?loja=' . $this->Dados['loja_id'] . '&situacao=' . $this->Dados['status_aj_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_ajuste WHERE loja_id =:loja_id AND status_aj_id =:status_aj_id", "loja_id={$this->Dados['loja_id']}&status_aj_id={$this->Dados['status_aj_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_ajuste WHERE loja_id =:loja_id AND status_aj_id =:status_aj_id", "loja_id=" . $_SESSION['usuario_loja'] . "&status_aj_id={$this->Dados['status_aj_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarAjuste = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, st.adms_cor_id, c.cor cor_cr FROM tb_ajuste aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE loja_id =:loja_id AND status_aj_id =:status_aj_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&status_aj_id={$this->Dados['status_aj_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, st.adms_cor_id, c.cor cor_cr FROM tb_ajuste aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN adms_usuarios user ON user.loja_id=aj.loja_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE aj.loja_id =:loja_id AND aj.status_aj_id =:status_aj_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&status_aj_id={$this->Dados['status_aj_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarAjuste->getResultado();
    }

    private function pesqRefStatus() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-ajuste/listar', '?referencia=' . $this->Dados['referencia'] . '&situacao=' . $this->Dados['status_aj_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_ajuste WHERE referencia LIKE '%' :referencia '%' AND status_aj_id =:status_aj_id", "referencia={$this->Dados['referencia']}&status_aj_id={$this->Dados['status_aj_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_ajuste WHERE loja_id =:loja_id AND referencia LIKE '%' :referencia '%' AND status_aj_id =:status_aj_id", "loja_id=" . $_SESSION['usuario_loja'] . "&referencia={$this->Dados['referencia']}&status_aj_id={$this->Dados['status_aj_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarAjuste = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, st.adms_cor_id, c.cor cor_cr FROM tb_ajuste aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE aj.referencia LIKE '%' :referencia '%' AND status_aj_id =:status_aj_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "referencia={$this->Dados['referencia']}&status_aj_id={$this->Dados['status_aj_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, st.adms_cor_id, c.cor cor_cr FROM tb_ajuste aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN adms_usuarios user ON user.loja_id=aj.loja_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE aj.loja_id =:loja_id AND aj.referencia LIKE '%' :referencia '%' AND aj.status_aj_id =:status_aj_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&referencia={$this->Dados['referencia']}&status_aj_id={$this->Dados['status_aj_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarAjuste->getResultado();
    }

    private function pesqLoja() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-ajuste/listar', '?loja=' . $this->Dados['loja_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_ajuste WHERE loja_id =:loja_id", "loja_id={$this->Dados['loja_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_ajuste WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja'] . "&loja_id={$this->Dados['loja_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarAjuste = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, st.adms_cor_id, c.cor cor_cr FROM tb_ajuste aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE aj.loja_id =:loja_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id={$this->Dados['loja_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, st.adms_cor_id, c.cor cor_cr FROM tb_ajuste aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN adms_usuarios user ON user.loja_id=aj.loja_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE aj.loja_id =:loja_id AND aj.referencia LIKE '%' :referencia '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&referencia={$this->Dados['referencia']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarAjuste->getResultado();
    }

    private function pesqReferencia() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-ajuste/listar', '?referencia=' . $this->Dados['referencia']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_ajuste WHERE referencia LIKE '%' :referencia '%'", "referencia={$this->Dados['referencia']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_ajuste WHERE loja_id =:loja_id AND referencia LIKE '%' :referencia '%'", "loja_id=" . $_SESSION['usuario_loja'] . "&referencia={$this->Dados['referencia']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarAjuste = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, st.adms_cor_id, c.cor cor_cr FROM tb_ajuste aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE aj.referencia LIKE '%' :referencia '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "referencia={$this->Dados['referencia']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, st.adms_cor_id, c.cor cor_cr FROM tb_ajuste aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN adms_usuarios user ON user.loja_id=aj.loja_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE aj.loja_id =:loja_id AND aj.referencia LIKE '%' :referencia '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&referencia={$this->Dados['referencia']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarAjuste->getResultado();
    }

    private function pesqStatus() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-ajuste/listar', '?situacao=' . $this->Dados['status_aj_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= 5) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_ajuste WHERE status_aj_id =:status_aj_id", "status_aj_id={$this->Dados['status_aj_id']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_ajuste WHERE loja_id =:loja_id AND status_aj_id =:status_aj_id", "loja_id=" . $_SESSION['usuario_loja'] . "&status_aj_id={$this->Dados['status_aj_id']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listarAjuste = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam, st.adms_cor_id, c.cor cor_cr FROM tb_ajuste aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN adms_cors c on c.id=st.adms_cor_id WHERE aj.status_aj_id =:status_aj_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "status_aj_id={$this->Dados['status_aj_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarAjuste->fullRead("SELECT aj.*, lj.nome nome_loja, st.nome status, tam.nome tam FROM tb_ajuste aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_status_aj st ON st.id=aj.status_aj_id INNER JOIN adms_usuarios user ON user.loja_id=aj.loja_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id WHERE aj.loja_id =:loja_id AND aj.status_aj_id =:status_aj_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_id=" . $_SESSION['usuario_loja'] . "&status_aj_id={$this->Dados['status_aj_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarAjuste->getResultado();
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
