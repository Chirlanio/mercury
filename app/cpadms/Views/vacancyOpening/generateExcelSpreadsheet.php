<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Abertura de Vagas</title>
    </head>
    <body>
        <?php
        $arquivo = 'abertura-de-vagas.xls';

        // Criamos uma tabela HTML com o formato da planilha
        $html = '';
        $html .= '<table border="1" class="table table-striped table-hover table-bordered">';
        $html .= '<tr>';
        $html .= '<th colspan="22">Abertura de Vagas</th>';
        $html .= '</tr>';

        $html .= "<tr>";
        $html .= "<th class='d-none d-sm-table-cell'>ID</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Tipo de Solicitação</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Colaborador</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Data Cadastro</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Área/Loja</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Cargo</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Horário</th>";
        $html .= "<th class='d-none d-sm-table-cell'>SLA</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Data Prevista</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Recrutador(a)</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Entrevista c/ RH</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Entrevista c/ Lider</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Avaliadores</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Aprovado(a)</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Observações</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Data Fechamento</th>";
        $html .= "<th class='d-none d-sm-table-cell'>SLA Efetivo</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Cadastrado Por</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Atualizado Por</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Situaçao</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Cadastro</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Atualizado</th>";
        $html .= "</tr>";
        $html .= "</thead>";
        $html .= "<tbody>";
        foreach ($this->Dados['list_vacancy'] as $vacancy) {
            extract($vacancy);
            $html .= "<tr>";
            $html .= "<th class='d-none d-sm-table-cell'>" . $vop_id . "</th>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $type_name . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($emploee) ? $emploee : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . date("d/m/Y", strtotime($created)) . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $store . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $cargo . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $schedules . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $predicted_sla . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . date("d/m/Y", strtotime($delivery_forecast)) . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($recruiter_name) ? $recruiter_name : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($interview_hr) ? date("d/m/Y", strtotime($interview_hr)) : "" ) . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($evaluators_hr) ? date("d/m/Y", strtotime($evaluators_hr)) : "" ) . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($evaluators_hr) ? $evaluators_hr : "") . " - " . (!empty($evaluators_leader) ? $evaluators_leader : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($approved) ? $approved : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($comments) ? $comments : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($closing_date) ? date("d/m/Y", strtotime($closing_date)) : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($effective_sla) ? $effective_sla : "") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $creator . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $updater . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $name_sit . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . date('d/m/Y H:i:s', strtotime($created)) . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . (!empty($modified) ? date('d/m/Y H:i:s', strtotime($modified)) : "") . "</td>";
            $html .= "</tr>";
        }

        $html .= "</tbody>";
        $html .= "</table>";
        // Configurações header para forçar o download
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/x-msexcel");
        header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
        header("Content-Description: PHP Generated Data");
        // Envia o conteúdo do arquivo
        echo $html;
        exit;
        ?>
    </body>
</html>

