<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Gerar Planilha</title>
    </head>
    <body>
        <?php
        $arquivo = 'entregas.xls';

// Criamos uma tabela HTML com o formato da planilha
        $html = '';
        $html .= '<table border="1" class="table table-striped table-hover table-bordered">';
        $html .= '<tr>';
        $html .= '<th colspan="16">Entregas de produtos</th>';
        $html .= '</tr>';

        $html .= "<tr>";
        $html .= "<th>ID</th>";
        $html .= "<th>Loja</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Cliente</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Contato</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Endereço</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Bairro</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Rota</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Valor</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Pagamento</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Parcelas</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Maquineta</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Observações</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Troca</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Saída</th>";
        $html .= "<th class='d-none d-sm-table-cell d-print-none'>Cadastro</th>";
        $html .= "<th class='d-none d-sm-table-cell'>Situação</th>";
        $html .= "</tr>";
        $html .= "</thead>";
        $html .= "<tbody>";
        foreach ($this->Dados['listPlanilha'] as $c) {
            extract($c);
            $html .= "<tr>";
            $html .= "<th>" . $id_loja . "</th>";
            $html .= "<td>" . $nome_loja . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $cliente . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $contato . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $endereco . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $bairro . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>";
            $html .= "<span>" . $rota . "</span>";
            $html .= "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>R$ " . $valor_venda . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $forma . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $parcelas . "X</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . ($maq == 1 ? "Sim" : "Não") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $obs . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . ($troca == 1 ? "Sim" : "Não") . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $saida . "</td>";
            $html .= "<td class='d-none d-sm-table-cell d-print-none'>" . date('d/m/Y H:i:s', strtotime($created)) . "</td>";
            $html .= "<td class='d-none d-sm-table-cell'>" . $sit . "</td>";
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

