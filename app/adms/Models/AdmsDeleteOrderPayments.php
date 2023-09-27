<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsDeleteOrderPayments
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsDeleteOrderPayments {

    private $DadosId;
    private $Resultado;
    private $DadosArq;

    function getResultado() {
        return $this->Resultado;
    }

    public function orderPayment($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->viewOrder();
        if ($this->DadosArq) {
            $delOrder = new \App\adms\Models\helper\AdmsDelete();
            $delOrder->exeDelete("adms_order_payments", "WHERE id =:id", "id={$this->DadosId}");
            if ($delOrder->getResultado()) {
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('assets/files/orderPayments/' . $this->DadosId . '/' . $this->DadosArq[0]['file_name'], 'assets/files/orderPayments/' . $this->DadosId);
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Ordem de pagamento</strong> cadastro e arquivos apagados com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O Arquivo não foi apagado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Cadastro e o Arquivos não foram apagados!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function viewOrder() {
        $viewOrder = new \App\adms\Models\helper\AdmsRead();
        $viewOrder->fullRead("SELECT * FROM adms_order_payments
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosArq = $viewOrder->getResultado();
    }

}
