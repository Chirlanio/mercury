<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 mb-4 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Listar Ordens de Serviços</h2>
            </div>
            <div class="p-2 d-print-none">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['gerar']) {

                        switch (isset($_SESSION['search']) AND (!empty($_SESSION['search']))) {
                            case 1:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&min_id=" . $_SESSION['min_id'] . "&max_id=" . $_SESSION['max_id'] . "&situacao=" . $_SESSION['sit_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 2:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&min_id=" . $_SESSION['min_id'] . "&situacao=" . $_SESSION['sit_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 3:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&max_id=" . $_SESSION['max_id'] . "&situacao=" . $_SESSION['sit_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 4:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?min_id=" . $_SESSION['min_id'] . "&max_id=" . $_SESSION['max_id'] . "&situacao=" . $_SESSION['sit_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 5:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?min_id=" . $_SESSION['min_id'] . "&max_id=" . $_SESSION['max_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 6:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&min_id=" . $_SESSION['min_id'] . "&situacao=" . $_SESSION['sit_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 7:
                                echo "<a href='" . URLADM . "ggerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&max_id=" . $_SESSION['max_id'] . "&situacao=" . $_SESSION['sit_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 8:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&min_id=" . $_SESSION['min_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 9:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&max_id=" . $_SESSION['max_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 10:
                                echo "<a href='" . URLADM . "ggerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&situacao=" . $_SESSION['sit_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 11:
                                echo "<a href='" . URLADM . "gegerar-planilha-order-service/gerar?min_id=" . $_SESSION['min_id'] . "&situacao=" . $_SESSION['sit_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 12:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?max_id=" . $_SESSION['max_id'] . "&situacao=" . $_SESSION['sit_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 13:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&min_id=" . $_SESSION['min_id'] . "&max_id=" . $_SESSION['max_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 14:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 15:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&min_id=" . $_SESSION['min_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 16:
                                echo "<a href='" . URLADM . "gegerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&max_id=" . $_SESSION['max_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 17:
                                echo "<a href='" . URLADM . "ggerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "&situacao=" . $_SESSION['sit_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 18:
                                echo "<a href='" . URLADM . "ggerar-planilha-order-service/gerar?min_id=" . $_SESSION['min_id'] . "&situacao=" . $_SESSION['sit_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 19:
                                echo "<a href='" . URLADM . "ggerar-planilha-order-service/gerar?max_id=" . $_SESSION['max_id'] . "&situacao=" . $_SESSION['sit_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 20:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?min_id=" . $_SESSION['min_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 21:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?max_id=" . $_SESSION['max_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 22:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?situacao=" . $_SESSION['sit_id'] . "&cliente=" . $_SESSION['cliente'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 23:
                                echo "<a href='" . URLADM . "ggerar-planilha-order-service/gerar?min_id=" . $_SESSION['min_id'] . "&max_id=" . $_SESSION['max_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 24:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?loja=" . $_SESSION['loja_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 25:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?min_id=" . $_SESSION['min_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 26:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?max_id=" . $_SESSION['max_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 27:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?situacao=" . $_SESSION['sit_id'] . "' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            case 28:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar?cliente={$thti->Dados['search']['cliente']}' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                            default:
                                echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Gerar Excel</a> ";
                                break;
                        }
                    }
                    if ($this->Dados['botao']['cad_ordem_servico']) {
                        echo "<a href='" . URLADM . "cadastrar-ordem-servico/cad-ordem-servico' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-square-plus'></i> Novo</a> ";
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
                            echo "<a class='dropdown-item' href='" . URLADM . "gerar-planilha-order-service/gerar'>Exportar</a>";
                        }
                        if ($this->Dados['botao']['list_order_service']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "ordem-servico/listar'>Listar</a>";
                        }
                        if ($this->Dados['botao']['cad_order_service']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "cadastrar-ordem-servico/cad-ordem-servico'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>

        <form class="form d-print-none" method="POST" action="<?php echo URLADM . 'pesq-order-service/listar'; ?>" enctype="multipart/form-data"> 
            <div class="row">
                <div class="col-sm-12 col-lg-3 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="loja_id">Loja</label>
                        </div>
                        <?php
                        echo "<select name='loja_id' id='loja_id' class='custom-select'>";
                        echo "<option value = ''>Selecione...</option>";
                        foreach ($this->Dados['select']['lojas'] as $lo) {
                            extract($lo);
                            if (isset($_SESSION['loja_id']) and $_SESSION['loja_id'] == $loja_id) {
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
                        <input name="min_id" type="number" id="min_id" class="form-control" placeholder="Menor ID" value="<?php
                        if (isset($_SESSION['min_id'])) {
                            echo $_SESSION['min_id'];
                        }
                        ?>">
                        <input name="max_id" type="number" id="max_id" class="form-control" placeholder="Maior ID" value="<?php
                        if (isset($_SESSION['max_id'])) {
                            echo $_SESSION['max_id'];
                        }
                        ?>">
                    </div>
                </div>
                <div class="col-sm-12 col-lg-2 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold;" for="sit_id">Situação</label>
                        </div>
                        <?php
                        echo "<select name='sit_id' id='sit_id' class='custom-select'>";
                        echo "<option value = ''>Selecione</option>";
                        foreach ($this->Dados['select']['sits'] as $ld) {
                            extract($ld);
                            if (isset($_SESSION['sit_id']) and $_SESSION['sit_id'] == $sit_id) {
                                echo "<option value='$sit_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$sit_id'>$sit</option>";
                            }
                        }
                        echo "</select>";
                        ?>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-2 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold;" for="sit_id">Marca</label>
                        </div>
                        <?php
                        echo "<select name='marca_id' id='marca_id' class='custom-select'>";
                        echo "<option value = ''>Selecione</option>";
                        foreach ($this->Dados['select']['marcas'] as $marca) {
                            extract($marca);
                            if (isset($_SESSION['marca_id']) and $_SESSION['marca_id'] == $m_id) {
                                echo "<option value='$m_id' selected>$brand</option>";
                            } else {
                                echo "<option value='$m_id'>$brand</option>";
                            }
                        }
                        echo "</select>";
                        ?>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-2 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold;" for="cliente">Cliente</label>
                        </div>
                        <input name="cliente" type="text" id="cliente" class="form-control" placeholder="Nome do Cliente" value="<?php
                        if (isset($_SESSION['cliente'])) {
                            echo $_SESSION['cliente'];
                        }
                        ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group ml-sm-3 ml-md-3 ml-lg-3 ml-3">
                    <input name="PesqOrderService" type="submit" class="btn btn-outline-primary" value="Pesquisar">
                </div>
            </div>
        </form>

        <hr>
        
        <div class="table-responsive my-n1 d-print-none">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr class="bg-dark">
                        <th class="text-white text-center align-middle">Pendentes</th>
                        <th class="text-white text-center align-middle">Aguardando Conserto</th>
                        <th class="text-white text-center align-middle">Em Conserto</th>
                        <th class="text-white text-center align-middle">Conserto Concluído</th>
                        <th class="text-white text-center align-middle">Aguardando Retirada</th>
                        <th class="text-white text-center align-middle">Em Processo de Indenização</th>
                        <th class="text-white text-center align-middle">Finalizado</th>
                        <th class="text-white text-center align-middle">Cancelado</th>
                        <th class="text-white text-center align-middle">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    echo "<tr>";
                    foreach ($this->Dados['select']['sitPend'] as $pendente) {
                        extract($pendente);
                        echo "<td class='text-right'>" . $sitPend . "</td>";
                    }
                    foreach ($this->Dados['select']['sitAgCons'] as $agConst) {
                        extract($agConst);
                        echo "<td class='text-right'>" . $sitAgCons . "</td>";
                    }
                    foreach ($this->Dados['select']['sitEmConst'] as $emConst) {
                        extract($emConst);
                        echo "<td class='text-right'>" . $sitEmConst . "</td>";
                    }
                    foreach ($this->Dados['select']['sitConcl'] as $consConcl) {
                        extract($consConcl);
                        echo "<td class='text-right'>" . $sitConcl . "</td>";
                    }
                    foreach ($this->Dados['select']['sitAgRet'] as $agReti) {
                        extract($agReti);
                        echo "<td class='text-right'>" . $sitAgRet . "</td>";
                    }
                    foreach ($this->Dados['select']['sitEmProcess'] as $emProcess) {
                        extract($emProcess);
                        echo "<td class='text-right'>" . $sitEmProcess . "</td>";
                    }
                    foreach ($this->Dados['select']['sitFinal'] as $final) {
                        extract($final);
                        echo "<td class='text-right'>" . $sitFinal . "</td>";
                    }
                    foreach ($this->Dados['select']['sitCancel'] as $cancel) {
                        extract($cancel);
                        echo "<td class='text-right'>" . $sitCancel . "</td>";
                    }
                    foreach ($this->Dados['select']['sitTotal'] as $total) {
                        extract($total);
                        echo "<td class='text-right'>" . $total_order . "</td>";
                    }
                    echo "</tr>";
                    ?>
                </tbody>
            </table>
        </div>

        <hr class="d-print-none">

        <?php
        if (empty($this->Dados['list_ordem_servico'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhuma solicitação encontrada!
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
                        <th class="text-center">Foto</th>
                        <th class="text-center">Loja</th>
                        <th class="text-center d-none d-sm-table-cell">O.S</th>
                        <th class="text-center d-none d-sm-table-cell">Referência</th>
                        <th class="text-center d-none d-sm-table-cell">Tamanho</th>
                        <th class="text-center d-none d-sm-table-cell">Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['list_ordem_servico'] as $Ordem) {
                        extract($Ordem);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $id; ?></th>
                            <td class="text-center align-middle pt-1 pr-0 pb-1 pl-0"><?php echo "<img class='img-thumbnail' src='http://www.meiasola.com/powerbi/" . $referencia . ".jpg' width='50' height='50' alt='" . $referencia . "' title='" . $referencia . "'>" ?></td>
                            <td class="text-center align-middle"><?php echo $nome_loja; ?></td>
                            <td class="text-center align-middle"><?php echo $order_service; ?></td>
                            <td class="text-center d-none d-sm-table-cell align-middle"><?php echo $referencia; ?></td>
                            <td class="text-center d-none d-sm-table-cell align-middle"><?php echo $tam; ?></td>
                            <td class="text-center d-none d-sm-table-cell align-middle text-center">
                                <span class="badge badge-<?php echo $cor; ?>"><?php echo $status; ?></span>
                            </td>
                            <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['vis_ordem_servico']) {
                                        echo "<a href='" . URLADM . "ver-ordem-servico/ver-ordem-servico/$id' class='btn btn-outline-primary btn-sm mr-1' title='Visualizar'><i class='fas fa-eye'></i></a>";
                                    }
                                    if ($this->Dados['botao']['edit_ordem_servico']) {
                                        echo "<a href='" . URLADM . "editar-ordem-servico/edit-ordem-servico/$id' class='btn btn-outline-warning btn-sm mr-1' title='Editar'><i class='fas fa-pen-nib'></i></a>";
                                    }
                                    if ($this->Dados['botao']['del_ordem_servico']) {
                                        echo "<a href='" . URLADM . "apagar-ordem-servico/apagar-ordem-servico/$id' class='btn btn-outline-danger btn-sm mr-1' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a>";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['vis_ordem_servico']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "ver-ordem-servico/ver-ordem-servico/$id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_ordem_servico']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "editar-ordem-servico/edit-ordem-servico/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_ordem_servico']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-ordem-servico/apagar-ordem-servico/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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