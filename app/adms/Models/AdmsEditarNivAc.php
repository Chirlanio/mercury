<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarNivAc
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarNivAc {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verNivAc($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verPerfil = new \App\adms\Models\helper\AdmsRead();
        $verPerfil->fullRead("SELECT n.*, c.id cor_id, c.nome nome_cor, c.cor cor_boot
                FROM adms_niveis_acessos n
                INNER JOIN adms_cors c ON c.id=n.adms_cor_id
                WHERE n.id =:id AND ordem >=:ordem LIMIT :limit", "id=" . $this->DadosId . "&ordem=" . $_SESSION['ordem_nivac'] . "&limit=1");
        $this->Resultado = $verPerfil->getResultado();
        return $this->Resultado;
    }

    public function altNivAc(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditNivAc();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditNivAc() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltNivAc = new \App\adms\Models\helper\AdmsUpdate();
        $upAltNivAc->exeUpdate("adms_niveis_acessos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltNivAc->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Nível de acesso atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O nível de acesso não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id id_cor, nome nome_cor, cor FROM adms_cors ORDER BY nome ASC");
        $registro['cor_id'] = $listar->getResultado();

        $this->Resultado = ['cor_id' => $registro['cor_id']];

        return $this->Resultado;
    }

}
