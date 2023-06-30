<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerTipoPagamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerTipoPagamento {

    private $Dados;
    private $DadosId;

    public function verTipo($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verTipo = new \App\adms\Models\AdmsVerTipoPagamento();
            $this->Dados['dados_tipo'] = $verTipo->verTipo($this->DadosId);

            $botao = ['list_pag' => ['menu_controller' => 'tipo-pagamento', 'menu_metodo' => 'listar'],
                'edit_pag' => ['menu_controller' => 'editar-tipo-pagamento', 'menu_metodo' => 'edit-tipo'],
                'del_pag' => ['menu_controller' => 'apagar-tipo-pagamento', 'menu_metodo' => 'apagar-tipo']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/tipoPag/verTipoPagamento", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Bairro não encontrado!</div>";
            $UrlDestino = URLADM . 'tipoPag/listarTipoPagamento';
            header("Location: $UrlDestino");
        }
    }

}
