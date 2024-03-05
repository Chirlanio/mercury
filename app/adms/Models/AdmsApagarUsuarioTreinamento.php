<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarUsuarioTreinamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarUsuarioTreinamento {

    private $DadosId;
    private $Resultado;
    private $DadosUsuario;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarUsuario($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verUsuario();
        if ($this->DadosUsuario) {
            $apagarUsuario = new \App\adms\Models\helper\AdmsDelete();
            $apagarUsuario->exeDelete("adms_users_treinamentos", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarUsuario->getResult()) {
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('assets/imagens/usuario/treinamento/' . $this->DadosId . '/' . $this->DadosUsuario[0]['image'], 'assets/imagens/usuario/treinamento/' . $this->DadosId);
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Usuário</strong> apagado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Usuário não foi apagado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Usuário não foi apagado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function verUsuario() {
        $verUsuario = new \App\adms\Models\helper\AdmsRead();
        $verUsuario->fullRead("SELECT user.image FROM adms_users_treinamentos user
                INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
                WHERE user.id =:id AND nivac.ordem >:ordem LIMIT :limit", "id=" . $this->DadosId . "&ordem=" . $_SESSION['ordem_nivac'] . "&limit=1");
        $this->DadosUsuario = $verUsuario->getResult();
    }

}
