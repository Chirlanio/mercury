<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
//var_dump($_SESSION['loja_id']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Ordens de Serviços</h2>
            </div>

            <div class="p-2">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['gerar']) {
                        if (isset($_SESSION['terms']) and !empty($_SESSION['terms'])) {
                            echo $_SESSION['terms'];
                            //var_dump($_SESSION['terms']);
                        } else {
                            echo "<a href='" . URLADM . "gerar-planilha-order-service/gerar' class='btn btn-success btn-sm'><i class='fa-solid fa-table'></i> Exportar</a> ";
                        }
                    }
                    if ($this->Dados['botao']['list_order_service']) {
                        echo "<a href='" . URLADM . "ordem-servico/listar' class='btn btn-outline-info btn-sm'> <i class='fa-solid fa-list mr-1'></i>Listar</a> ";
                    }
                    if ($this->Dados['botao']['cad_order_service']) {
                        echo "<a href='" . URLADM . "cadastrar-ordem-servico/cad-ordem-servico' class='btn btn-outline-success btn-sm'><i class='fa-regular fa-square-plus mr-1'></i>Cadastrar</a> ";
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
                        foreach ($this->Dados['select']['loja_id'] as $lo) {
                            extract($lo);
                            if ($_SESSION['loja_id'] == $loja_id) {
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
                        foreach ($this->Dados['select']['sit'] as $ld) {
                            extract($ld);
                            if ($_SESSION['sit_id'] == $sit_id) {
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
                            if ($_SESSION['marca_id'] == $m_id) {
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

        <?php
        if (empty($this->Dados['listOrderService'])) {
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
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
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
                    if (!empty($this->Dados['listOrderService'])) {
                        foreach ($this->Dados['listOrderService'] as $orderService) {
                            extract($orderService);
                            ?>
                            <tr>
                                <th class="text-center align-middle"><?php echo $os_id; ?></th>
                                <td class="text-center align-middle pt-1 pr-0 pb-1 pl-0"><?php echo "<img class='img-thumbnail' src='http://www.meiasola.com/powerbi/" . $referencia . ".jpg' width='50' height='50' alt='" . $referencia . "' title='" . $referencia . "'>" ?></td>
                                <td class="text-center align-middle"><?php echo $loja; ?></td>
                                <td class="text-center align-middle"><?php echo $order_service; ?></td>
                                <td class="text-center d-none d-sm-table-cell align-middle"><?php echo $referencia; ?></td>
                                <td class="text-center d-none d-sm-table-cell align-middle"><?php echo $tam; ?></td>
                                <td class="text-center d-none d-sm-table-cell align-middle text-center">
                                    <span class="badge badge-<?php echo $cor; ?>"><?php echo $status; ?></span>
                                </td>
                                <td class="text-center align-middle">
                                    <span class="d-none d-md-block">
                                        <?php
                                        if ($this->Dados['botao']['vis_order_service']) {
                                            echo "<a href='" . URLADM . "ver-ordem-servico/ver-ordem-servico/$os_id' class='btn btn-outline-primary btn-sm mr-1' title='Visualizar'><i class='fas fa-eye'></i></a>";
                                        }
                                        if ($this->Dados['botao']['edit_order_service']) {
                                            echo "<a href='" . URLADM . "editar-ordem-servico/edit-ordem-servico/$os_id' class='btn btn-outline-warning btn-sm mr-1' title='Editar'><i class='fas fa-pen-nib'></i></a>";
                                        }
                                        if ($this->Dados['botao']['del_order_service']) {
                                            echo "<a href='" . URLADM . "apagar-ordem-servico/apagar-ordem-servico/$os_id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                        }
                                        ?>
                                    </span>
                                    <div class="dropdown d-block d-md-none">
                                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Ações
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                            <?php
                                            if ($this->Dados['botao']['vis_order_service']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "ver-ordem-servico/ver-ordem-servico/$os_id'>Visualizar</a>";
                                            }
                                            if ($this->Dados['botao']['edit_order_service']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "editar-ordem-servico/edit-ordem-servico/$os_id'>Editar</a>";
                                            }
                                            if ($this->Dados['botao']['del_order_service']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-ordem-servico/apagar-ordem-servico/$os_id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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