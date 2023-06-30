<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarUsuario
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarArq {

    private $Dados;

    //Função para cadastrar o usuário na base de dados
    public function cadArq() {

        //Recebe as informações do usuário para cadastro
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        //Verifica de o formulário foi submetido.
        if (!empty($this->Dados['CadArq'])) {
            unset($this->Dados['CadArq'], $this->Dados['slug']);

            //Verifica de tem novo arquivo
            $this->Dados['slug'] = ($_FILES['slug'] ? $_FILES['slug'] : null);
            //var_dump($this->Dados);

            //Instancia a classe para cadastrar na base de dados
            $cadArq = new \App\adms\Models\AdmsCadastrarArq();
            $cadArq->cadArq($this->Dados);

            //Verifica se o retorno do cadastro é true
            if ($cadArq->getResultado()) {
                $UrlDestino = URLADM . 'listar-arquivo/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadArqViewPriv();
            }
        } else {
            $this->cadArqViewPriv();
        }
    }

    private function cadArqViewPriv() {

        $listarSelect = new \App\adms\Models\AdmsCadastrarArq();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_arq' => ['menu_controller' => 'listar-arquivo', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new \Core\ConfigView("adms/Views/upload/cadArquivo", $this->Dados);
        $carregarView->renderizar();
    }

}
