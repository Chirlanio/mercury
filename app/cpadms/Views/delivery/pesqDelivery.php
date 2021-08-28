<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Pesquisar Entregas</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['gerar']) {
                        echo "<a href='" . URLADM . "gerar-planilha/gerar' class='btn btn-success btn-sm'>Gerar Excel</a> ";
                    }
                    if ($this->Dados['botao']['list_delivery']) {
                        echo "<a href='" . URLADM . "delivery/listar' class='btn btn-outline-info btn-sm'>Listar</a> ";
                    }
                    if ($this->Dados['botao']['cad_delivery']) {
                        echo "<a href='" . URLADM . "cadastrar-delivery/cad-delivery' class='btn btn-outline-success btn-sm'>Cadastrar</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['list_delivery']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "delivery/listar'>Listar</a>";
                        }
                        if ($this->Dados['botao']['cad_delivery']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "cadastrar-delivery/cad-delivery'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <form class="form" method="POST" action="" enctype="multipart/form-data">
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
                            if ($_SESSION['pesqLoja'] == $loja_id) {
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
                            <label class="input-group-text" style="font-weight: bold;" for="rota_id">Rota</label>
                        </div>
                        <?php
                        echo "<select name='rota_id' id='rota_id' class='custom-select'>";
                        echo "<option value = ''>Selecione</option>";
                        foreach ($this->Dados['select']['rota_id'] as $lo) {
                            extract($lo);
                            if ($_SESSION['pesqRota'] == $rota_id) {
                                echo "<option value='$rota_id' selected>$rota</option>";
                            } else {
                                echo "<option value='$rota_id'>$rota</option>";
                            }
                        }
                        echo "</select>";
                        ?>
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
                            if ($_SESSION['pesqSit'] == $sit_id) {
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
        </form><hr>
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
        </div><hr class="d-print-none">
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
                        <th class="text-center">ID</th>
                        <th>Loja</th>
                        <th class="d-none d-sm-table-cell">Cliente</th>
                        <th class="d-none d-sm-table-cell">Bairro</th>
                        <th class="d-none d-sm-table-cell">Rota</th>
                        <th class="d-none d-sm-table-cell">Saída</th>
                        <th class="d-none d-sm-table-cell d-print-none">Cadastro</th>
                        <th class="d-none d-sm-table-cell">Situação</th>
                        <th class="text-center d-print-none">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($this->Dados['listDelivery'])) {
                        foreach ($this->Dados['listDelivery'] as $lo) {
                            extract($lo);
                            ?>
                            <tr>
                                <th class="align-middle text-center"><?php echo $id; ?></th>
                                <td class="align-middle"><?php echo $loja; ?></td>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo $cliente; ?></td>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo $bairro; ?></td>
                                <td class="d-none d-sm-table-cell align-middle">
                                    <span class="badge badge-<?php echo $cor; ?>"><?php echo $rota; ?></span>
                                </td>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo $saida; ?></td>
                                <td class="d-none d-sm-table-cell align-middle d-print-none"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></td>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo $sit; ?></td>
                                <td class="text-center">
                                    <span class="d-none d-md-block">
                                        <?php
                                        if ($this->Dados['botao']['vis_delivery']) {
                                            echo "<a href='" . URLADM . "ver-delivery/ver-delivery/$id' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                        }
                                        if ($this->Dados['botao']['edit_delivery']) {
                                            echo "<a href='" . URLADM . "editar-delivery/edit-delivery/$id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                        }
                                        if ($this->Dados['botao']['del_delivery']) {
                                            echo "<a href='" . URLADM . "apagar-delivery/apagar-delivery/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title=''><i class='fas fa-eraser'></i></a> ";
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
                                                echo "<a class='dropdown-item' href='" . URLADM . "ver-delivery/ver-delivery/$id'>Visualizar</a>";
                                            }
                                            if ($this->Dados['botao']['edit_delivery']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "editar-delivery/edit-delivery/$id'>Editar</a>";
                                            }
                                            if ($this->Dados['botao']['del_deliverya']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-delivery/apagar-delivery/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
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
