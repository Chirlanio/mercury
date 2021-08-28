<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsHome
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsHome {

    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function listarAjuste() {

        $contAjuste = new \App\adms\Models\helper\AdmsRead();
        $contAjuste->fullRead("SELECT COUNT(id) AS num_result FROM tb_ajuste WHERE status_aj_id =:status_aj_id", "status_aj_id=1");

        $this->Resultado = $contAjuste->getResultado();
        //var_dump($this->Resultado);
        return $this->Resultado;
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        if (($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
            $listar->fullRead("SELECT COUNT(id) AS transf FROM tb_transferencias WHERE loja_origem_id =:loja_origem_id", "loja_origem_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS transf FROM tb_transferencias");
        }
        $registro['transf'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
            $listar->fullRead("SELECT COUNT(id) AS agCol FROM tb_transferencias WHERE status_id =:status_id AND loja_origem_id =:loja_origem_id", "status_id=1&loja_origem_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS agCol FROM tb_transferencias WHERE status_id =:status_id", "status_id=1");
        }
        $registro['agCol'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
            $listar->fullRead("SELECT COUNT(id) AS emRota FROM tb_transferencias WHERE status_id =:status_id AND loja_origem_id =:loja_origem_id", "status_id=2&loja_origem_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS emRota FROM tb_transferencias WHERE status_id =:status_id", "status_id=2");
        }
        $registro['emRota'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
            $listar->fullRead("SELECT COUNT(id) AS entregue FROM tb_transferencias WHERE status_id =:status_id AND loja_origem_id =:loja_origem_id", "status_id=3&loja_origem_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS entregue FROM tb_transferencias WHERE status_id =:status_id", "status_id=3");
        }
        $registro['entregue'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
            $listar->fullRead("SELECT COUNT(id) AS ajuste FROM tb_ajuste WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS ajuste FROM tb_ajuste");
        }
        $registro['ajuste'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
            $listar->fullRead("SELECT COUNT(id) AS ajustado FROM tb_ajuste WHERE status_aj_id =:status_aj_id AND loja_id =:loja_id", "status_aj_id=1&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS ajustado FROM tb_ajuste WHERE status_aj_id =:status_aj_id", "status_aj_id=1");
        }
        $registro['ajustado'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
            $listar->fullRead("SELECT COUNT(id) AS pend FROM tb_ajuste WHERE status_aj_id =:status_aj_id AND loja_id =:loja_id", "status_aj_id=2&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS pend FROM tb_ajuste WHERE status_aj_id =:status_aj_id", "status_aj_id=2");
        }
        $registro['pend'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
            $listar->fullRead("SELECT COUNT(id) AS semAj FROM tb_ajuste WHERE status_aj_id =:status_aj_id AND loja_id =:loja_id", "status_aj_id=3&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS semAj FROM tb_ajuste WHERE status_aj_id =:status_aj_id", "status_aj_id=3");
        }
        $registro['semAj'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
            $listar->fullRead("SELECT COUNT(id) AS troca FROM tb_cad_produtos WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS troca FROM tb_cad_produtos");
        }
        $registro['troca'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
            $listar->fullRead("SELECT COUNT(id) AS cad FROM tb_cad_produtos WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=1&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS cad FROM tb_cad_produtos WHERE status_id =:status_id", "status_id=1");
        }
        $registro['cad'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
            $listar->fullRead("SELECT COUNT(id) AS jaCad FROM tb_cad_produtos WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=2&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS jaCad FROM tb_cad_produtos WHERE status_id =:status_id", "status_id=2");
        }
        $registro['jaCad'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
            $listar->fullRead("SELECT COUNT(id) AS cadPend FROM tb_cad_produtos WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=3&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS cadPend FROM tb_cad_produtos WHERE status_id =:status_id", "status_id=3");
        }
        $registro['cadPend'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
            $listar->fullRead("SELECT COUNT(id) AS dash FROM tb_dashboards WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS dash FROM tb_dashboards");
        }
        $registro['dash'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
            $listar->fullRead("SELECT COUNT(id) AS dashAt FROM tb_dashboards WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=1&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS dashAt FROM tb_dashboards WHERE status_id =:status_id", "status_id=1");
        }
        $registro['dashAt'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
            $listar->fullRead("SELECT COUNT(id) AS dashIna FROM tb_dashboards WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=2&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS dashIna FROM tb_dashboards WHERE status_id =:status_id", "status_id=2");
        }
        $registro['dashIna'] = $listar->getResultado();

        if (($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
            $listar->fullRead("SELECT COUNT(id) AS dashPen FROM tb_dashboards WHERE status_id =:status_id AND loja_id =:loja_id", "status_id=3&loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT COUNT(id) AS dashPen FROM tb_dashboards WHERE status_id =:status_id", "status_id=3");
        }
        $registro['dashPen'] = $listar->getResultado();

        $this->Resultado = ['transf' => $registro['transf'], 'agCol' => $registro['agCol'], 'emRota' => $registro['emRota'], 'entregue' => $registro['entregue'],
            'ajuste' => $registro['ajuste'], 'ajustado' => $registro['ajustado'], 'pend' => $registro['pend'], 'semAj' => $registro['semAj'],
            'troca' => $registro['troca'], 'cad' => $registro['cad'], 'cadPend' => $registro['cadPend'], 'jaCad' => $registro['jaCad'],
            'dash' => $registro['dash'], 'dashAt' => $registro['dashAt'], 'dashIna' => $registro['dashIna'], 'dashPen' => $registro['dashPen']
        ];

        return $this->Resultado;
    }

}
