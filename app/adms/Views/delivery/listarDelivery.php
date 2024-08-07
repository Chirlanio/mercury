<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
//var_dump($this->Dados);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 mb-4 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Listar Entregas</h2>
            </div>
            <div class="p-2 d-print-none">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['gerar']) {

                        switch (isset($_SESSION['search']) AND (!empty($_SESSION['search']))) {
                            case 1:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?loja=" . $_SESSION['loja_id'] . "&min_id=" . $_SESSION['min_id'] . "&max_id=" . $_SESSION['max_id'] . "&situacao=" . $_SESSION['sit_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 2:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?loja=" . $_SESSION['loja_id'] . "&min_id=" . $_SESSION['min_id'] . "&situacao=" . $_SESSION['sit_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 3:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?loja=" . $_SESSION['loja_id'] . "&max_id=" . $_SESSION['max_id'] . "&situacao=" . $_SESSION['sit_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 4:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?min_id=" . $_SESSION['min_id'] . "&max_id=" . $_SESSION['max_id'] . "&situacao=" . $_SESSION['sit_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 5:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?min_id=" . $_SESSION['min_id'] . "&max_id=" . $_SESSION['max_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 6:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?loja=" . $_SESSION['loja_id'] . "&min_id=" . $_SESSION['min_id'] . "&situacao=" . $_SESSION['sit_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 7:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?loja=" . $_SESSION['loja_id'] . "&max_id=" . $_SESSION['max_id'] . "&situacao=" . $_SESSION['sit_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 8:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?loja=" . $_SESSION['loja_id'] . "&min_id=" . $_SESSION['min_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 9:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?loja=" . $_SESSION['loja_id'] . "&max_id=" . $_SESSION['max_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 10:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?loja=" . $_SESSION['loja_id'] . "&situacao=" . $_SESSION['sit_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 11:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?min_id=" . $_SESSION['min_id'] . "&situacao=" . $_SESSION['sit_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 12:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?max_id=" . $_SESSION['max_id'] . "&situacao=" . $_SESSION['sit_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 13:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?loja=" . $_SESSION['loja_id'] . "&min_id=" . $_SESSION['min_id'] . "&max_id=" . $_SESSION['max_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 14:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?loja=" . $_SESSION['loja_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 15:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?loja=" . $_SESSION['loja_id'] . "&min_id=" . $_SESSION['min_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 16:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?loja=" . $_SESSION['loja_id'] . "&max_id=" . $_SESSION['max_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 17:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?loja=" . $_SESSION['loja_id'] . "&situacao=" . $_SESSION['sit_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 18:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?min_id=" . $_SESSION['min_id'] . "&situacao=" . $_SESSION['sit_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 19:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?max_id=" . $_SESSION['max_id'] . "&situacao=" . $_SESSION['sit_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 20:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?min_id=" . $_SESSION['min_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 21:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?max_id=" . $_SESSION['max_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 22:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?situacao=" . $_SESSION['sit_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 23:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?min_id=" . $_SESSION['min_id'] . "&max_id=" . $_SESSION['max_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 24:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?loja=" . $_SESSION['loja_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 25:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?min_id=" . $_SESSION['min_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 26:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?max_id=" . $_SESSION['max_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 27:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?situacao=" . $_SESSION['sit_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 28:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar?cliente={$thti->Dados['search']['cliente']}' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            default:
                                echo "<a href='" . URLADM . "gerar-planilha/gerar' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                        }
                    }
                    if ($this->Dados['botao']['cad_delivery']) {
                        echo "<a href='" . URLADM . "cadastrar-delivery/cad-delivery' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-square-plus'></i> Novo</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['gerar']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "gerar-planilha/gerar'>Gerar Excel</a>";
                        }
                        if ($this->Dados['botao']['cad_delivery']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "cadastrar-delivery/cad-delivery'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <form class="form d-print-none" method="POST" action="<?php echo URLADM . 'pesq-delivery/listar'; ?>" enctype="multipart/form-data"> 
            <div class="row">
                <div class="col-sm-12 col-lg-3 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="loja_id">Loja</label>
                        </div>
                        <?php
                        echo "<select name='loja_id' id='loja_id' class='custom-select'>";
                        echo "<option value = ''>Selecione</option>";
                        foreach ($this->Dados['select']['loja_id'] as $lo) {
                            extract($lo);
                            if (isset($_SESSION['pesqLoja']) and $_SESSION['pesqLoja'] == $loja_id) {
                                echo "<option value='$loja_id' selected>$loja</option>";
                            } else {
                                echo "<option value='$loja_id'>$loja</option>";
                            }
                        }
                        echo "</select>";
                        ?>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold;" for="id">ID</label>
                        </div>
                        <input name="min_id" type="number" id="min_id" class="form-control" placeholder="Digite o menor ID" value="<?php
                        if (isset($_SESSION['min_id'])) {
                            echo $_SESSION['min_id'];
                        }
                        ?>">
                        <input name="max_id" type="number" id="max_id" class="form-control" placeholder="Digite o maior ID" value="<?php
                        if (isset($_SESSION['max_id'])) {
                            echo $_SESSION['max_id'];
                        }
                        ?>">
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold;" for="sit_id">Situação</label>
                        </div>
                        <?php
                        echo "<select name='sit_id' id='sit_id' class='custom-select'>";
                        echo "<option value = ''>Selecione</option>";
                        foreach ($this->Dados['select']['sit_id'] as $ld) {
                            extract($ld);
                            if (isset($_SESSION['pesqSit']) and $_SESSION['pesqSit'] == $sit_id) {
                                echo "<option value='$sit_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$sit_id'>$sit</option>";
                            }
                        }
                        echo "</select>";
                        ?>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold;" for="cliente">Cliente</label>
                        </div>
                        <input name="cliente" type="text" id="cliente" class="form-control" placeholder="Digite o nome do Cliente" value="<?php
                        if (isset($_SESSION['cliente'])) {
                            echo $_SESSION['cliente'];
                        }
                        ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group ml-sm-3 ml-md-3 ml-lg-3 ml-3">
                    <input name="PesqDelivery" type="submit" class="btn btn-outline-primary" value="Pesquisar">
                </div>
            </div>
        </form>
        <hr>
        <div class="table-responsive my-n1 d-print-none">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr class="bg-dark">
                        <th class="text-white">Total de Pedidos</th>
                        <th class="text-white">Solicitado</th>
                        <th class="text-white">Coletado Loja</th>
                        <th class="text-white">Aguardando Rota</th>
                        <th class="text-white">Em Rota</th>
                        <th class="text-white">Entregue</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    echo "<tr>";
                    foreach ($this->Dados['select']['deli'] as $lo) {
                        extract($lo);
                        echo "<td class='text-right'>" . $deli . "</td>";
                    }
                    foreach ($this->Dados['select']['deliSol'] as $lo) {
                        extract($lo);
                        echo "<td class='text-right'>" . $deliSol . "</td>";
                    }
                    foreach ($this->Dados['select']['deliCol'] as $lo) {
                        extract($lo);
                        echo "<td class='text-right'>" . $deliCol . "</td>";
                    }
                    foreach ($this->Dados['select']['deliAg'] as $lo) {
                        extract($lo);
                        echo "<td class='text-right'>" . $deliAg . "</td>";
                    }
                    foreach ($this->Dados['select']['deliRota'] as $lo) {
                        extract($lo);
                        echo "<td class='text-right'>" . $deliRota . "</td>";
                    }
                    foreach ($this->Dados['select']['deliEnt'] as $lo) {
                        extract($lo);
                        echo "<td class='text-right'>" . $deliEnt . "</td>";
                    }
                    echo "</tr>";
                    ?>
                </tbody>
            </table>
        </div>
        <hr class="d-print-none">
        <?php
        if (empty($this->Dados['listDelivery'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhuma entrega encontrada!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
        }
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">#ID</th>
                        <th>Loja</th>
                        <th class="d-none d-sm-table-cell">Cliente</th>
                        <th class="d-none d-sm-table-cell">Bairro</th>
                        <th class="d-none d-sm-table-cell">Saída</th>
                        <th class="d-none d-sm-table-cell d-print-none">Cadastro</th>
                        <th class="d-none d-sm-table-cell d-print-none">Atualizado</th>
                        <th class="d-none d-sm-table-cell">Situação</th>
                        <th class="text-center d-print-none">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listDelivery'] as $lo) {
                        extract($lo);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $id_loja; ?></th>
                            <td class="align-middle"><?php echo $nome_loja; ?></td>
                            <td class="d-none d-sm-table-cell align-middle"><?php echo $cliente; ?></td>
                            <td class="d-none d-sm-table-cell align-middle"><?php echo $bairro; ?></td>
                            <td class="d-none d-sm-table-cell align-middle"><?php echo $saida; ?></td>
                            <td class="d-none d-sm-table-cell d-print-none align-middle"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></td>
                            <td class="d-none d-sm-table-cell d-print-none align-middle"><?php echo (!empty($modified)) ? date('d/m/Y H:i:s', strtotime($modified)) : ""; ?></td>
                            <td class="d-none d-sm-table-cell align-middle"><span class="badge badge-<?php echo $cr_cor; ?>"><?php echo $sit; ?></span></td>
                            <td class="text-center d-print-none align-middle">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['vis_delivery']) {
                                        echo "<a href='" . URLADM . "ver-delivery/ver-delivery/$id_loja' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['edit_delivery']) {
                                        echo "<a href='" . URLADM . "editar-delivery/edit-delivery/$id_loja' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['del_delivery']) {
                                        echo "<a href='" . URLADM . "apagar-delivery/apagar-delivery/$id_loja' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['vis_delivery']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "ver-delivery/ver-delivery/$id_loja'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_delivery']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "editar-delivery/edit-delivery/$id_loja'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_delivery']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-delivery/apagar-delivery/$id_loja' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php
            echo $this->Dados['paginacao'];
            ?>
        </div>
    </div>
</div>
