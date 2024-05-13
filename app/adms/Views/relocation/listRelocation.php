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
                <h2 class="display-4 titulo">Remanejos</h2>
            </div>
            <?php
            if ($this->Dados['botao']['add_relocation']) {
                echo "<a href='" . URLADM . "add-relocation/add-relocation' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-square-plus'></i> Novo</a> ";
            }
            ?>
        </div>
        <form class="form" method="POST" action="<?php echo URLADM . 'search-relocation/list'; ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 col-lg-4 mb-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text font-weight-bold" for="loja_ori">Loja - Origem</label>
                        </div>
                        <?php
                        echo "<select name='loja_origem_id' id='loja_origem_id' class='custom-select'>";
                        echo "<option value = ''>Selecione</option>";
                        foreach ($this->Dados['select']['loja_ori'] as $lo) {
                            extract($lo);
                            if ($_SESSION['pesqLoja'] == $loja_ori) {
                                echo "<option value='$loja_ori' selected>$loja_origem</option>";
                            } else {
                                echo "<option value='$loja_ori'>$loja_origem</option>";
                            }
                        }
                        echo "</select>";
                        ?>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 mb-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text font-weight-bold" for="loja_des">Loja - Destino</label>
                        </div>
                        <?php
                        echo "<select name='loja_destino_id' id='loja_destino_id' class='custom-select'>";
                        echo "<option value = ''>Selecione</option>";
                        foreach ($this->Dados['select']['loja_des'] as $ld) {
                            extract($ld);
                            if ($_SESSION['pesqLoja'] == $id_des) {
                                echo "<option value='$id_des' selected>$loja_destino</option>";
                            } else {
                                echo "<option value='$id_des'>$loja_destino</option>";
                            }
                        }
                        echo "</select>";
                        ?>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 mb-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text font-weight-bold" for="status_aj_id">Situação</label>
                        </div>
                        <?php
                        echo "<select name='adms_sit_rem_id' id='adms_sit_rem_id' class='custom-select'>";
                        echo "<option value = ''>Selecione</option>";
                        foreach ($this->Dados['select']['status'] as $sit) {
                            extract($sit);
                            if ($_SESSION['sit'] == $s_id) {
                                echo "<option value='$s_id' selected>$name_sit</option>";
                            } else {
                                echo "<option value='$s_id'>$name_sit</option>";
                            }
                        }
                        echo "</select>";
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group ml-sm-2 ml-md-2 ml-lg-2 ml-3">
                    <input name="SearchRelocation" type="submit" class="btn btn-outline-primary mx-sm-2" value="Pesquisar">
                </div>
            </div>
        </form>
        <hr>
        <?php
        if (empty($this->Dados['list_rolocation'])) {
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
                        <th class="d-none d-sm-table-cell">Loja - Origem</th>
                        <th class="d-none d-sm-table-cell">Loja - Destino</th>
                        <th class="d-none d-sm-table-cell">Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['list_relocation'] as $rem) {
                        extract($rem);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $id; ?></th>
                            <td class="d-none d-sm-table-cell align-middle"><?php echo $loja_origem; ?></td>
                            <td class="d-none d-sm-table-cell align-middle"><?php echo $loja_destino; ?></td>
                            <td class="d-none d-sm-table-cell align-middle text-center">
                                <span class="badge badge-<?php echo $cor; ?>"><?php echo $name_sit; ?></span>
                            </td>
                            <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['view_relocation']) {
                                        echo "<a href='" . URLADM . "view-relocation/view-relocation/$id' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['edit_relocation']) {
                                        echo "<a href='" . URLADM . "edit-relocation/edit-relocation/$id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['del_relocation']) {
                                        echo "<a href='" . URLADM . "delete-relocation/delete-relocation/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a>";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['view_relocation']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "view-relocation/view-relocation/$id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_relocation']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "edit-relocation/edit-relocation/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_relocation']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "delete-relocation/delete-relocation/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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