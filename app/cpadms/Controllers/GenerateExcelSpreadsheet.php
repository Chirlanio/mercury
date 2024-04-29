<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of GerarPlanilha
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class GenerateExcelSpreadsheet {

    private $Dados;

    public function generateExcel() {
        
        $botao = ['gerar' => ['menu_controller' => 'generate-excel-spreadsheet', 'menu_metodo' => 'generate-excel']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listVacancy = new \App\cpadms\Models\CpAdmsGenerateExcelSpreadsheet();
        $this->Dados['list_vacancy'] = $listVacancy->list();

        $carregarView = new \App\cpadms\core\ConfigView("cpadms/Views/vacancyOpening/generateExcelSpreadsheet", $this->Dados);
        $carregarView->renderizarListar();
    }

}
