<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarUsuarioTreinamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarUsuarioTreinamento {

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $Foto;
    private $ImgAntiga;

    function getResultado() {
        return $this->Resultado;
    }

    public function verUsuario($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verPerfil = new \App\adms\Models\helper\AdmsRead();
        $verPerfil->fullRead("SELECT user.* FROM adms_users_treinamentos user
                INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
                WHERE user.id =:id AND nivac.ordem >:ordem LIMIT :limit", "id=" . $this->DadosId . "&ordem=" . $_SESSION['ordem_nivac'] . "&limit=1");
        $this->Resultado = $verPerfil->getResult();
        return $this->Resultado;
    }

    public function altUsuario(array $Dados) {
        $this->Dados = $Dados;
        $this->Dados['cpf'] = str_replace('.', '', str_replace('-', '', $this->Dados['cpf']));
        //var_dump($this->Dados);
        
        $this->Foto = $this->Dados['imagem_nova'];
        $this->ImgAntiga = $this->Dados['imagem_antiga'];
        unset($this->Dados['imagem_nova'], $this->Dados['imagem_antiga']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->valCampos();
        } else {
            $this->Resultado = false;
        }
    }

    private function valCampos() {
        $valEmail = new \App\adms\Models\helper\AdmsEmail();
        $valEmail->valEmail($this->Dados['email']);

        $valEmailUnico = new \App\adms\Models\helper\AdmsEmailUnicoTreinamento();
        $EditarUnico = true;
        $valEmailUnico->valEmailUnico($this->Dados['email'], $EditarUnico, $this->Dados['id']);

        if ($valEmail->getResultado() AND $valEmailUnico->getResultado()) {
            $this->valFoto();
        } else {
            $this->Resultado = false;
        }
    }

    private function valFoto() {
        if (empty($this->Foto['name'])) {
            $this->updateEditUsuario();
        } else {
            $slugImg = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['image'] = $slugImg->nomeSlug($this->Foto['name']);

            $uploadImg = new \App\adms\Models\helper\AdmsUploadImg();
            $uploadImg->uploadImagem($this->Foto, 'assets/imagens/usuario/treinamento/' . $this->Dados['id'] . '/', $this->Dados['image'], 150, 150);

            if ($uploadImg->getResultado()) {
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('assets/imagens/usuario/treinamento/' . $this->Dados['id'] . '/' . $this->ImgAntiga);
                $this->updateEditUsuario();
            } else {
                $this->Resultado = false;
            }
        }
    }

    private function updateEditUsuario() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltSenha = new \App\adms\Models\helper\AdmsUpdate();
        $upAltSenha->exeUpdate("adms_users_treinamentos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltSenha->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Usuário</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O usuario não foi atualizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_sit, nome nome_sit FROM adms_sits_usuarios ORDER BY nome ASC");
        $registro['sit'] = $listar->getResult();
        
        $listar->fullRead("SELECT id n_id, nome nome_nivac FROM adms_niveis_acessos WHERE id =:id ORDER BY nome ASC", "id=11");
        $registro['nivac'] = $listar->getResult();

        $this->Resultado = ['nivac' => $registro['nivac'], 'sit' => $registro['sit']];

        return $this->Resultado;
    }

}
