<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarTroca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarTroca {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verTroca($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verTroca = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] > 2) {
            $verTroca->fullRead("SELECT c.*, l.id loja_id, f.nome func, s.id sit_id
                FROM tb_cad_produtos c
                INNER JOIN tb_funcionarios f ON f.id=c.func_id
                INNER JOIN tb_lojas l ON l.id=c.loja_id
                INNER JOIN tb_status_troca s ON s.id=c.status_id
                WHERE c.id =:id AND c.status_id !=:status_id LIMIT :limit", "id=" . $this->DadosId . "&status_id=1&limit=1");
        } else {
            $verTroca->fullRead("SELECT c.*, l.id loja_id, f.nome func, s.id sit_id
                FROM tb_cad_produtos c
                INNER JOIN tb_funcionarios f ON f.id=c.func_id
                INNER JOIN tb_lojas l ON l.id=c.loja_id
                INNER JOIN tb_status_troca s ON s.id=c.status_id
                WHERE c.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        }
        $this->Resultado = $verTroca->getResultado();
        return $this->Resultado;
    }

    public function altTroca(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditTroca();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditTroca() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltTroca = new \App\adms\Models\helper\AdmsUpdate();
        $upAltTroca->exeUpdate("tb_cad_produtos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltTroca->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação atualizada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A solicitação não foi atualizada!</div>";
            $this->Resultado = false;
        }
    }

    /**
     * <b>Listar registros para chave estrangeira:</b> Buscar informações na tabela "adms_cors" para utilizar como chave estrangeira
     */
    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['adms_niveis_acesso_id'] > 2) {
            $listar->fullRead("SELECT id id_loja, nome loja
                    FROM tb_lojas
                    WHERE id =:id
                    ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id id_loja, nome loja FROM tb_lojas ORDER BY id ASC");
        }
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status_troca ORDER BY id ASC");
        $registro['sit_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id func_id, nome consul FROM tb_funcionarios ORDER BY nome ASC");
        $registro['func_id'] = $listar->getResultado();
        
        $listar->fullRead("SELECT id motivo_id, nome motivo FROM adms_motivos ORDER BY nome ASC");
        $registro['motivo_id'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit_id' => $registro['sit_id'], 'func_id' => $registro['func_id'], 'motivo_id' => $registro['motivo_id']];

        return $this->Resultado;
    }

}
