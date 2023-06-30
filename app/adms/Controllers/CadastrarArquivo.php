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
class CadastrarArquivo {

    private $Dados;

    //Função para cadastrar o usuário na base de dados
    public function cadArquivo() {

        //Recebe as informações do usuário para cadastro
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        //Verifica de o formulário foi submetido.
        if (!empty($this->Dados['CadArq'])) {
            unset($this->Dados['CadArq'], $this->Dados['slug']);

            //Verifica de tem novo arquivo
            $this->Dados['slug'] = ($_FILES['slug'] ? $_FILES['slug'] : null);

            //Instancia a classe para cadastrar na base de dados
            $cadArq = new \App\adms\Models\AdmsCadastrarArquivo();
            $cadArq->cadArquivo($this->Dados);

            //Verifica se o retorno do cadastro é true
            if ($cadArq->getResultado()) {
                $UrlDestino = URLADM . 'arquivo/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadArquivoViewPriv();
            }
        } else {
            $this->cadArquivoViewPriv();
        }
    }

    private function cadArquivoViewPriv() {

        $listarSelect = new \App\adms\Models\AdmsCadastrarArquivo();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_arq' => ['menu_controller' => 'arquivo', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new \Core\ConfigView("adms/Views/upload/cadArquivo", $this->Dados);
        $carregarView->renderizar();
    }

}
