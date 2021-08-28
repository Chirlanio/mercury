<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Balanços</h2>
            </div>
            <?php
            if ($this->Dados['botao']['cad_balanco']) {
                ?>
                <a href="<?php echo URLADM . 'cadastrar-balanco/cad-balanco'; ?>">
                    <div class="p-2">
                        <button class="btn btn-outline-success btn-sm"><span><i class="fas fa-plus d-block d-md-none fa-2x"></i>
                                <span class='d-none d-md-block'>Cadastrar</span>
                            </span>
                        </button>
                    </div>
                </a>
                <?php
            }
            ?>
        </div>
        <form class="form-inline" method="POST" action="<?php echo URLADM . 'pesq-balanco/listar'; ?>" enctype="multipart/form-data">
            <div class="col-sm-12 col-lg-3 mb-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="loja_id" style="font-weight: bold">Loja</label>
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
                        <label class="input-group-text" for="referencia" style="font-weight: bold">Referência</label>
                    </div>
                    <input name="referencia" type="text" id="referencia" class="form-control" placeholder="Digite a referência" value="<?php
                    if (isset($_SESSION['referencia'])) {
                        echo $_SESSION['referencia'];
                    }
                    ?>">
                </div>
            </div>
            <div class="col-sm-12 col-lg-3 mb-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="status_aj_id" style="font-weight: bold">Situação</label>
                    </div>
                    <?php
                    echo "<select name='status_aj_id' id='status_aj_id' class='custom-select'>";
                    echo "<option value = ''>Selecione</option>";
                    foreach ($this->Dados['select']['sit'] as $ld) {
                        extract($ld);
                        if ($_SESSION['sit'] == $sit_id) {
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
                <input name="PesqBalanco" type="submit" class="btn btn-outline-primary mx-sm-2" value="Pesquisar">
            </div>
        </form><hr>
        <?php
        if (empty($this->Dados['listBalanco'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhuma balanço encontrada!
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
                        <th class="d-none d-sm-table-cell">Responsável</th>
                        <th class="d-none d-sm-table-cell">Auditor</th>
                        <th class="d-none d-sm-table-cell text-center">Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listBalanco'] as $Ajuste) {
                        extract($Ajuste);
                        ?>
                        <tr title="<?php echo strip_tags($obs) ?>">
                            <th class="text-center align-middle"><?php echo $id; ?></th>
                            <td class="align-middle"><?php echo $nome_loja; ?></td>
                            <td class="d-none d-sm-table-cell align-middle"><?php echo $responsavel; ?></td>
                            <td class="d-none d-sm-table-cell align-middle"><?php echo $aud_resp; ?></td>
                            <td class="d-none d-sm-table-cell align-middle text-center"><?php echo $status; ?></td>
                            <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['vis_balanco']) {
                                        echo "<a href='" . URLADM . "ver-balanco/ver-balanco/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                    }
                                    if ($this->Dados['botao']['edit_balanco']) {
                                        echo "<a href='" . URLADM . "editar-balanco/edit-balanco/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                                    }
                                    if ($this->Dados['botao']['del_balanco']) {
                                        echo "<a href='" . URLADM . "apagar-balanco/apagar-balanco/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['vis_balanco']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "ver-balanco/ver-balanco/$id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_balanco']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "editar-balanco/edit-balanco/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_balanco']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-balanco/apagar-balanco/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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