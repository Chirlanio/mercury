<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarRota
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarRota {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verRota($DadosId) {
        
        $this->DadosId = (int) $DadosId;
        
        $verRota = new \App\adms\Models\helper\AdmsRead();
        $verRota->fullRead("SELECT r.id r_id, r.nome rota, r.adms_cor_id cor_id, c.nome n_cor, c.cor
                FROM tb_rotas r
                INNER JOIN adms_cors c ON c.id=r.adms_cor_id
                WHERE r.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verRota->getResultado();
        return $this->Resultado;
    }

    public function altRota(array $Dados) {
        
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditRota();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditRota() {
        
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        
        $upAltRota = new \App\adms\Models\helper\AdmsUpdate();
        $upAltRota->exeUpdate("tb_rotas", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltRota->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Rota atualizada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A rota não foi atualizada!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id cor_id, nome n_cor FROM adms_cors ORDER BY nome ASC");
        $registro['cor'] = $listar->getResultado();

        $this->Resultado = ['cor' => $registro['cor']];

        return $this->Resultado;
    }

}
