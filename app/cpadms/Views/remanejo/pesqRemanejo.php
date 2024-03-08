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
                <h2 class="display-4 titulo">Pesquisar Remanejos</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['list_remanejo']) {
                        echo "<a href='" . URLADM . "remanejo/listar' class='btn btn-outline-info btn-sm'><i class='fa-solid fa-list'></i></a> ";
                    }
                    if ($this->Dados['botao']['cad_remanejo']) {
                        echo "<a href='" . URLADM . "cadastrar-remanejo/cad-remanejo' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-square-plus'></i> Novo</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['list_remanejo']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "remanejo/listar'>Listar</a>";
                        }
                        if ($this->Dados['botao']['cad_remanejo']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "cadastrar-remanejo/cad-remanejo'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <form class="form" method="POST" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 col-lg-4 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text font-weight-bold" for="loja_origem_id">Loja - Origem</label>
                        </div>
                        <?php
                        echo "<select name='loja_origem_id' id='loja_origem_id' class='custom-select' autofocus>";
                        echo "<option value = ''>Selecione</option>";
                        foreach ($this->Dados['select']['origem'] as $lo) {
                            extract($lo);
                            if (isset($valorForm['loja_origem_id']) == $id_ori) {
                                echo "<option value='$id_ori' selected>$loja_orig</option>";
                            } else {
                                echo "<option value='$id_ori'>$loja_orig</option>";
                            }
                        }
                        echo "</select>";
                        ?>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text font-weight-bold" for="loja_destino_id">Loja - Destino</label>
                        </div>
                        <?php
                        echo "<select name='loja_destino_id' id='loja_destino_id' class='custom-select'>";
                        echo "<option value = ''>Selecione</option>";
                        foreach ($this->Dados['select']['loja_destino_id'] as $ld) {
                            extract($ld);
                            if (isset($valorForm['loja_destino_id']) == $loja_id) {
                                echo "<option value='$loja_id' selected>$loja_dest</option>";
                            } else {
                                echo "<option value='$loja_id'>$loja_dest</option>";
                            }
                        }
                        echo "</select>";
                        ?>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text font-weight-bold" for="status_id">Situação</label>
                        </div>
                        <?php
                        echo "<select name='adms_sit_rem_id' id='adms_sit_rem_id' class='custom-select'>";
                        echo "<option value = ''>Selecione</option>";
                        foreach ($this->Dados['select']['sit'] as $ld) {
                            extract($ld);
                            if (isset($valorForm['adms_sit_rem_id']) == $sit_id) {
                                echo "<option value='$sit_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$sit_id'>$sit</option>";
                            }
                        }
                        echo "</select>";
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group ml-sm-2 ml-md-2 ml-lg-2 ml-3">
                    <input name="PesqRemanejo" type="submit" class="btn btn-outline-primary mx-sm-2" value="Pesquisar">
                </div>
            </div>
        </form><hr>
        <?php
        if (empty($this->Dados['listRemanejo'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum remanejo encontrado!
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
                        <th>Loja de Origem</th>
                        <th class="d-none d-sm-table-cell">Loja de Destino</th>
                        <th class="d-none d-sm-table-cell">Tipo</th>
                        <th class="d-none d-sm-table-cell">Cadastrado</th>
                        <th class="d-none d-sm-table-cell">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($this->Dados['listRemanejo'])) {
                        foreach ($this->Dados['listRemanejo'] as $remanejo) {
                            extract($remanejo);
                            ?>
                            <tr>
                                <th class="text-center align-middle"><?php echo $id; ?></th>
                                <td class="align-middle"><?php echo $loja_ori; ?></td>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo $nome_des; ?></td>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo $tipo; ?></td>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo date('d/m/Y', strtotime($created)); ?></td>
                                <td class="d-none d-sm-table-cell align-middle text-center"><span class="badge badge-<?php echo $cor; ?>"><?php echo $sit; ?></span></td>
                                <td class="text-center">
                                    <span class="d-none d-md-block">
                                        <?php
                                        if (!empty($arquivo)) {
                                            echo "<a href='" . URLADM . "assets/files/remanejo/$id/$arquivo' class='btn btn-outline-success btn-sm' download title='Baixar lista'><i class='fas fa-download'></i></a> ";
                                        } else {
                                            echo "<button class='btn btn-outline-secondary btn-sm' title='Sem lista'><i class='fas fa-download'></i></button> ";
                                        }
                                        if ($this->Dados['botao']['vis_remanejo']) {
                                            echo "<a href='" . URLADM . "ver-remanejo/ver-remanejo/$id' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                        }
                                        if ($this->Dados['botao']['edit_remanejo']) {
                                            echo "<a href='" . URLADM . "editar-remanejo/edit-remanejo/$id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                        }
                                        if ($this->Dados['botao']['del_remanejo']) {
                                            echo "<a href='" . URLADM . "apagar-remanejo/apagar-remanejo/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                        }
                                        ?>
                                    </span>
                                    <div class="dropdown d-block d-md-none">
                                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Ações
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                            <?php
                                            if (!empty($arquivo)) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "assets/files/remanejo/$id/$arquivo' download>Baixar</a>";
                                            }
                                            if ($this->Dados['botao']['vis_remanejo']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "ver-remanejo/ver-remanejo/$id'>Visualizar</a>";
                                            }
                                            if ($this->Dados['botao']['edit_remanejo']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "editar-remanejo/edit-remanejo/$id'>Editar</a>";
                                            }
                                            if ($this->Dados['botao']['del_remanejo']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-remanejo/apagar-remanejo/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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