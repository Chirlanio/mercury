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
                <h2 class="display-4 titulo">Pesquisar Prateleira Infinita</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['list_ped']) {
                        echo "<a href='" . URLADM . "prateleira-infinita/listar' class='btn btn-outline-info btn-sm'>Listar</a> ";
                    }
                    if ($this->Dados['botao']['cad_ped']) {
                        echo "<a href='" . URLADM . "cadastrar-ped/cad-ped' class='btn btn-outline-success btn-sm'>Cadastrar</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['list_ped']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "prateleira-infinita'>Listar</a>";
                        }
                        if ($this->Dados['botao']['cad_ped']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "cadastrar-ped/cad-ped'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <form class="form" method="POST" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-4 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="loja_id">Loja</label>
                        </div>
                        <?php
                        echo "<select name='loja_id' id='loja_id' class='custom-select'>";
                        echo "<option value = ''>Selecione</option>";
                        foreach ($this->Dados['select']['loja'] as $lo) {
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
                <div class="col-sm-12 col-md-12 col-lg-4 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="referencia">Referência</label>
                        </div>
                        <input name="referencia" type="text" id="referencia" class="form-control" placeholder="Digite a referência" value="<?php
                        if (isset($_SESSION['referencia'])) {
                            echo $_SESSION['referencia'];
                        }
                        ?>">
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-4 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="status_id">Situação</label>
                        </div>
                        <?php
                        echo "<select name='status_id' id='status_id' class='custom-select'>";
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
            </div>
            <div class="row">
                <div class="form-group ml-sm-2 ml-md-2 ml-lg-2 ml-3">
                    <input name="PesqPed" type="submit" class="btn btn-outline-primary mx-sm-2" value="Pesquisar">
                </div>
            </div>
        </form><hr>
        <?php
        if (empty($this->Dados['listPed'])) {
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
                        <th class="text-center">ID</th>
                        <th>Referência</th>
                        <th class="d-none d-sm-table-cell">Tamanho</th>
                        <th class="d-none d-sm-table-cell">Loja</th>
                        <th class="d-none d-sm-table-cell">Solicitante</th>
                        <th class="d-none d-sm-table-cell">Nota - Transferência</th>
                        <th class="d-none d-sm-table-cell">Nota - Venda</th>
                        <th class="d-none d-sm-table-cell">Situação</th>
                        <th class="text-center d-print-none">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($this->Dados['listPed'])) {
                        foreach ($this->Dados['listPed'] as $dash) {
                            extract($dash);
                            ?>
                            <tr>
                                <th class="text-center align-middle"><?php echo $id; ?></th>
                                <td class="align-middle"><?php echo $referencia; ?></td>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo $tam; ?></td>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo $loja; ?></td>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo $func; ?></td>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo $nf_transf; ?></td>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo $nf_venda; ?></td>
                                <td class="d-none d-sm-table-cell align-middle">
                                    <span class="badge badge-<?php echo $cor; ?>"><?php echo $sit; ?></span>
                                </td>
                                <td class="text-center d-print-none">
                                    <span class="d-none d-md-block">
                                        <?php
                                        if ($this->Dados['botao']['vis_ped']) {
                                            echo "<a href='" . URLADM . "ver-ped/ver-ped/$id' class='btn btn-outline-primary btn-sm d-print-none' title='Visualizar'><i class='fas fa-eye'></i></a>";
                                        }
                                        if ($this->Dados['botao']['edit_ped']) {
                                            echo "<a href='" . URLADM . "editar-ped/edit-ped/$id' class='btn btn-outline-warning btn-sm d-print-none' title='Editar'><i class='fas fa-pen-nib'></i></a>";
                                        }
                                        if ($this->Dados['botao']['del_ped']) {
                                            echo "<a href='" . URLADM . "apagar-ped/apagar-ped/$id' class='btn btn-outline-danger btn-sm d-print-none' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                        }
                                        ?>
                                    </span>
                                    <div class="dropdown d-block d-md-none">
                                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Ações
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                            <?php
                                            if ($this->Dados['botao']['vis_ped']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "ver-ped/ver-ped/$id'>Visualizar</a>";
                                            }
                                            if ($this->Dados['botao']['edit_ped']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "editar-ped/edit-ped/$id'>Editar</a>";
                                            }
                                            if ($this->Dados['botao']['del_ped']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-ped/apagar-ped/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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