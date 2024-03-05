<?php

namespace App\cpadms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsPesqRemanejo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CpAdmsPesqRemanejo {

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function pesqRemanejo($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;
        //var_dump($this->Dados);

        $_SESSION['pesqOrigem'] = $this->Dados['loja_origem_id'];
        $_SESSION['pesqDestino'] = $this->Dados['loja_destino_id'];
        $_SESSION['pesqStatus'] = $this->Dados['adms_sit_rem_id'];

        if ((!empty($this->Dados['loja_origem_id'])) AND (!empty($this->Dados['loja_destino_id'])) AND (!empty($this->Dados['adms_sit_rem_id']))) {
            $this->pesqComp();
        } elseif ((!empty($this->Dados['loja_origem_id'])) AND (!empty($this->Dados['adms_sit_rem_id']))) {
            $this->pesqLojaOriSit();
        } elseif ((!empty($this->Dados['loja_destino_id'])) AND (!empty($this->Dados['adms_sit_rem_id']))) {
            $this->pesqLojaDesSit();
        } elseif ((!empty($this->Dados['loja_origem_id'])) AND (!empty($this->Dados['loja_destino_id']))) {
            $this->pesqLojaOriDes();
        } elseif (!empty($this->Dados['loja_origem_id'])) {
            $this->pesqLojaOrigem();
        } elseif (!empty($this->Dados['loja_destino_id'])) {
            $this->pesqLojaDestino();
        } elseif (!empty($this->Dados['adms_sit_rem_id'])) {
            $this->pesqStatus();
        }
        return $this->Resultado;
    }

    private function pesqComp() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-remanejo/listar', '?origem=' . $this->Dados['loja_origem_id'] . '&destino=' . $this->Dados['loja_destino_id'] . '&situacao=' . $this->Dados['adms_sit_rem_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_remanejos t WHERE t.loja_origem_id =:loja_origem_id AND t.loja_destino_id =:loja_destino_id AND t.adms_sit_rem_id =:adms_sit_rem_id", "loja_origem_id={$this->Dados['loja_origem_id']}&loja_destino_id={$this->Dados['loja_destino_id']}&adms_sit_rem_id={$this->Dados['adms_sit_rem_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarRemanejo = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarRemanejo->fullRead("SELECT rem.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor FROM adms_remanejos rem INNER JOIN tb_lojas l ON l.id=rem.loja_origem_id INNER JOIN tb_lojas lj ON lj.id=rem.loja_destino_id INNER JOIN adms_tps_remanejos tt ON tt.id=rem.adms_tipo_rem_id INNER JOIN adms_sits_remanejos s ON s.id=rem.adms_sit_rem_id INNER JOIN adms_cors c ON c.id=s.adms_cor_id WHERE rem.loja_origem_id =:loja_origem_id AND rem.loja_destino_id =:loja_destino_id AND rem.adms_sit_rem_id =:adms_sit_rem_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id={$this->Dados['loja_origem_id']}&loja_destino_id={$this->Dados['loja_destino_id']}&adms_sit_rem_id={$this->Dados['adms_sit_rem_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarRemanejo->fullRead("SELECT rem.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor FROM adms_remanejos remINNER JOIN tb_lojas l ON l.id=rem.loja_origem_id INNER JOIN tb_lojas lj ON lj.id=rem.loja_destino_id INNER JOIN adms_tps_remanejos tt ON tt.id=rem.adms_tipo_rem_id INNER JOIN adms_sits_remanejos s ON s.id=rem.adms_sit_rem_id INNER JOIN adms_cors c ON c.id=s.adms_cor_id WHERE rem.loja_origem_id =:loja_origem_id AND rem.loja_origem_id =:loja_origem_id AND rem.loja_destino_id =:loja_destino_id AND rem.adms_sit_rem_id =:adms_sit_rem_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id=" . $_SESSION['usuario_loja'] . "&loja_origem_id={$this->Dados['loja_origem_id']}&loja_destino_id={$this->Dados['loja_destino_id']}&adms_sit_rem_id={$this->Dados['adms_sit_rem_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarRemanejo->getResult();
    }

    private function pesqLojaOriSit() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-remanejo/listar', '?origem=' . $this->Dados['loja_origem_id'] . '&situacao=' . $this->Dados['adms_sit_rem_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_remanejos t WHERE t.loja_origem_id =:loja_origem_id AND t.adms_sit_rem_id =:adms_sit_rem_id", "loja_origem_id={$this->Dados['loja_origem_id']}&adms_sit_rem_id={$this->Dados['adms_sit_rem_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarRemanejo = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarRemanejo->fullRead("SELECT rem.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor FROM adms_remanejos rem INNER JOIN tb_lojas l ON l.id=rem.loja_origem_id INNER JOIN tb_lojas lj ON lj.id=rem.loja_destino_id INNER JOIN adms_tps_remanejos tt ON tt.id=rem.adms_tipo_rem_id INNER JOIN adms_sits_remanejos s ON s.id=rem.adms_sit_rem_id INNER JOIN adms_cors c ON c.id=s.adms_cor_id WHERE rem.loja_origem_id =:loja_origem_id AND rem.adms_sit_rem_id =:adms_sit_rem_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id={$this->Dados['loja_origem_id']}&adms_sit_rem_id={$this->Dados['adms_sit_rem_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarRemanejo->fullRead("SELECT rem.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor FROM adms_remanejos rem INNER JOIN tb_lojas l ON l.id=rem.loja_origem_id INNER JOIN tb_lojas lj ON lj.id=rem.loja_destino_id INNER JOIN adms_tps_remanejos tt ON tt.id=rem.adms_tipo_rem_id INNER JOIN adms_sits_remanejos s ON s.id=rem.adms_sit_rem_id INNER JOIN adms_cors c ON c.id=s.adms_cor_id WHERE rem.loja_origem_id =:loja_origem_id AND rem.loja_origem_id =:loja_origem_id AND rem.adms_sit_rem_id =:adms_sit_rem_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id=" . $_SESSION['usuario_loja'] . "&loja_origem_id={$this->Dados['loja_origem_id']}&adms_sit_rem_id={$this->Dados['adms_sit_rem_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarRemanejo->getResult();
    }

    private function pesqLojaDesSit() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-remanejo/listar', '?destino=' . $this->Dados['loja_destino_id'] . '&situacao=' . $this->Dados['adms_sit_rem_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_remanejos t WHERE t.loja_destino_id =:loja_destino_id AND t.adms_sit_rem_id =:adms_sit_rem_id", "loja_destino_id={$this->Dados['loja_destino_id']}&adms_sit_rem_id={$this->Dados['adms_sit_rem_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarRemanejo = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarRemanejo->fullRead("SELECT rem.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor FROM adms_remanejos rem INNER JOIN tb_lojas l ON l.id=rem.loja_origem_id INNER JOIN tb_lojas lj ON lj.id=rem.loja_destino_id INNER JOIN adms_tps_remanejos tt ON tt.id=rem.adms_tipo_rem_id INNER JOIN adms_sits_remanejos s ON s.id=rem.adms_sit_rem_id INNER JOIN adms_cors c ON c.id=s.adms_cor_id WHERE rem.loja_destino_id =:loja_destino_id AND rem.adms_sit_rem_id =:adms_sit_rem_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_destino_id={$this->Dados['loja_destino_id']}&adms_sit_rem_id={$this->Dados['adms_sit_rem_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarRemanejo->fullRead("SELECT rem.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor FROM adms_remanejos rem INNER JOIN tb_lojas l ON l.id=rem.loja_origem_id INNER JOIN tb_lojas lj ON lj.id=rem.loja_destino_id INNER JOIN adms_tps_remanejos tt ON tt.id=rem.adms_tipo_rem_id INNER JOIN adms_sits_remanejos s ON s.id=rem.adms_sit_rem_id INNER JOIN adms_cors c ON c.id=s.adms_cor_id WHERE rem.loja_origem_id =:loja_origem_id AND rem.loja_destino_id =:loja_destino_id AND rem.adms_sit_rem_id =:adms_sit_rem_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id=" . $_SESSION['usuario_loja'] . "&loja_destino_id={$this->Dados['loja_destino_id']}&adms_sit_rem_id={$this->Dados['adms_sit_rem_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarRemanejo->getResult();
    }

    private function pesqLojaOriDes() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-remanejo/listar', '?origem=' . $this->Dados['loja_origem_id'] . '&destino=' . $this->Dados['loja_destino_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_remanejos t WHERE t.loja_origem_id LIKE '%' :loja_origem_id '%' AND t.loja_destino_id LIKE '%' :loja_destino_id '%'", "loja_origem_id={$this->Dados['loja_origem_id']}&loja_destino_id={$this->Dados['loja_destino_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarRemanejo = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarRemanejo->fullRead("SELECT rem.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor FROM adms_remanejos rem INNER JOIN tb_lojas l ON l.id=rem.loja_origem_id INNER JOIN tb_lojas lj ON lj.id=rem.loja_destino_id INNER JOIN adms_tps_remanejos tt ON tt.id=rem.adms_tipo_rem_id INNER JOIN adms_sits_remanejos s ON s.id=rem.adms_sit_rem_id INNER JOIN adms_cors c ON c.id=s.adms_cor_id WHERE rem.loja_origem_id LIKE '%' :loja_origem_id '%' AND rem.loja_destino_id LIKE '%' :loja_destino_id '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id={$this->Dados['loja_origem_id']}&loja_destino_id={$this->Dados['loja_destino_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarRemanejo->fullRead("SELECT rem.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor FROM adms_remanejos rem INNER JOIN tb_lojas l ON l.id=rem.loja_origem_id INNER JOIN tb_lojas lj ON lj.id=rem.loja_destino_id INNER JOIN adms_tps_remanejos tt ON tt.id=rem.adms_tipo_rem_id INNER JOIN adms_sits_remanejos s ON s.id=rem.adms_sit_rem_id INNER JOIN adms_cors c ON c.id=s.adms_cor_id WHERE rem.loja_origem_id =:loja_origem_id AND (rem.loja_origem_id LIKE '%' :loja_origem_id '%' AND rem.loja_destino_id LIKE '%' :loja_destino_id '%') ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id=" . $_SESSION['usuario_loja'] . "&loja_origem_id={$this->Dados['loja_origem_id']}&loja_destino_id={$this->Dados['loja_destino_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarRemanejo->getResult();
    }

    private function pesqLojaOrigem() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-remanejo/listar', '?origem=' . $this->Dados['loja_origem_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_remanejos t WHERE t.loja_origem_id =:loja_origem_id", "loja_origem_id={$this->Dados['loja_origem_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarRemanejo = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarRemanejo->fullRead("SELECT rem.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor FROM adms_remanejos rem INNER JOIN tb_lojas l ON l.id=rem.loja_origem_id INNER JOIN tb_lojas lj ON lj.id=rem.loja_destino_id INNER JOIN adms_tps_remanejos tt ON tt.id=rem.adms_tipo_rem_id INNER JOIN adms_sits_remanejos s ON s.id=rem.adms_sit_rem_id INNER JOIN adms_cors c ON c.id=s.adms_cor_id WHERE rem.loja_origem_id =:loja_origem_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id={$this->Dados['loja_origem_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarRemanejo->fullRead("SELECT rem.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor FROM adms_remanejos rem INNER JOIN tb_lojas l ON l.id=rem.loja_origem_id INNER JOIN tb_lojas lj ON lj.id=rem.loja_destino_id INNER JOIN adms_tps_remanejos tt ON tt.id=rem.adms_tipo_rem_id INNER JOIN adms_sits_remanejos s ON s.id=rem.adms_sit_rem_id INNER JOIN adms_cors c ON c.id=s.adms_cor_id WHERE rem.loja_origem_id =:loja_origem_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id={$this->Dados['loja_origem_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarRemanejo->getResult();
    }

    private function pesqLojaDestino() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-remanejo/listar', '?destino=' . $this->Dados['loja_destino_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_remanejos t WHERE t.loja_destino_id =:loja_destino_id", "loja_destino_id={$this->Dados['loja_destino_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarRemanejo = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarRemanejo->fullRead("SELECT rem.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor FROM adms_remanejos rem INNER JOIN tb_lojas l ON l.id=rem.loja_origem_id INNER JOIN tb_lojas lj ON lj.id=rem.loja_destino_id INNER JOIN adms_tps_remanejos tt ON tt.id=rem.adms_tipo_rem_id INNER JOIN adms_sits_remanejos s ON s.id=rem.adms_sit_rem_id INNER JOIN adms_cors c ON c.id=s.adms_cor_id WHERE rem.loja_destino_id =:loja_destino_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_destino_id={$this->Dados['loja_destino_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarRemanejo->fullRead("SELECT rem.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor FROM adms_remanejos rem INNER JOIN tb_lojas l ON l.id=rem.loja_origem_id INNER JOIN tb_lojas lj ON lj.id=rem.loja_destino_id INNER JOIN adms_tps_remanejos tt ON tt.id=rem.adms_tipo_rem_id INNER JOIN adms_sits_remanejos s ON s.id=rem.adms_sit_rem_id INNER JOIN adms_cors c ON c.id=s.adms_cor_id WHERE rem.loja_destino_id =:loja_destino_id AND rem.loja_destino_id LIKE '%' :loja_destino_id '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_destino_id=" . $_SESSION['usuario_loja'] . "&loja_destino_id={$this->Dados['loja_destino_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarRemanejo->getResult();
    }

    private function pesqStatus() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-remanejo/listar', '?situacao=' . $this->Dados['adms_sit_rem_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_remanejos WHERE adms_sit_rem_id =:adms_sit_rem_id", "adms_sit_rem_id={$this->Dados['adms_sit_rem_id']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarRemanejo = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= 5) {
            $listarRemanejo->fullRead("SELECT rem.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor FROM adms_remanejos rem INNER JOIN tb_lojas l ON l.id=rem.loja_origem_id INNER JOIN tb_lojas lj ON lj.id=rem.loja_destino_id INNER JOIN adms_tps_remanejos tt ON tt.id=rem.adms_tipo_rem_id INNER JOIN adms_sits_remanejos s ON s.id=rem.adms_sit_rem_id INNER JOIN adms_cors c ON c.id=s.adms_cor_id WHERE rem.adms_sit_rem_id =:adms_sit_rem_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "adms_sit_rem_id={$this->Dados['adms_sit_rem_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listarRemanejo->fullRead("SELECT rem.*, l.nome loja_ori, lj.nome nome_des, tt.nome tipo, s.nome sit, s.adms_cor_id, c.cor FROM adms_remanejos rem INNER JOIN tb_lojas l ON l.id=rem.loja_origem_id INNER JOIN tb_lojas lj ON lj.id=rem.loja_destino_id INNER JOIN adms_tps_remanejos tt ON tt.id=rem.adms_tipo_rem_id INNER JOIN adms_sits_remanejos s ON s.id=rem.adms_sit_rem_id INNER JOIN adms_cors c ON c.id=s.adms_cor_id WHERE (rem.loja_origem_id =:loja_origem_id OR rem.loja_destino_id =:loja_destino_id) AND rem.adms_sit_rem_id =:adms_sit_rem_id ORDER BY id DESC LIMIT :limit OFFSET :offset", "loja_origem_id=" . $_SESSION['usuario_loja'] . "&loja_destino_id=" . $_SESSION['usuario_loja'] . "&adms_sit_rem_id={$this->Dados['adms_sit_rem_id']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listarRemanejo->getResult();
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['ordem_nivac'] >= 4) {
            $listar->fullRead("SELECT id id_ori, nome loja_orig FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id id_ori, nome loja_orig FROM tb_lojas ORDER BY id ASC");
        }
        $registro['origem'] = $listar->getResult();

        $listar->fullRead("SELECT id loja_id, nome loja_dest FROM tb_lojas ORDER BY id ASC");
        $registro['loja_destino_id'] = $listar->getResult();

        $listar->fullRead("SELECT id id_tipo, nome tipo FROM adms_tips_remanejos ORDER BY id ASC");
        $registro['tipo_transf_id'] = $listar->getResult();

        $listar->fullRead("SELECT id sit_id, nome sit FROM adms_sits_remanejos ORDER BY id ASC");
        $registro['sit'] = $listar->getResult();

        $this->Resultado = ['origem' => $registro['origem'], 'loja_destino_id' => $registro['loja_destino_id'], 'sit' => $registro['sit']];

        return $this->Resultado;
    }

}
