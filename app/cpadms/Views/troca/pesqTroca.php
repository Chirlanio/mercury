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
                <h2 class="display-4 titulo">Pesquisar Cadastro para Trocas</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['list_troca']) {
                        echo "<a href='" . URLADM . "listar-troca/listar-troca' class='btn btn-outline-info btn-sm'>Listar</a> ";
                    }
                    if ($this->Dados['botao']['cad_troca']) {
                        echo "<a href='" . URLADM . "cadastrar-troca/cad-troca' class='btn btn-outline-success btn-sm'>Cadastrar</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['list_troca']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "listar-troca/listar-troca'>Listar</a>";
                        }
                        if ($this->Dados['botao']['cad_troca']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "cadastrar-troca/cad-trocaf'>Cadastrar</a>";
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
                            <label class="input-group-text" style="font-weight: bold" for="loja_id">Loja</label>
                        </div>
                        <?php
                        echo "<select name='loja_id' id='loja_id' class='custom-select'>";
                        echo "<option value = ''>Selecione</option>";
                        foreach ($this->Dados['select']['loja_id'] as $lo) {
                            extract($lo);
                            if (isset($valorForm['loja_id']) == $loja_id) {
                                echo "<option value='$loja_id' selected>$loja</option>";
                            } else {
                                echo "<option value='$loja_id'>$loja</option>";
                            }
                        }
                        echo "</select>";
                        ?>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="sit_id">Situação</label>
                        </div>
                        <?php
                        echo "<select name='status_id' id='sit_id' class='custom-select'>";
                        echo "<option value = ''>Selecione</option>";
                        foreach ($this->Dados['select']['status_id'] as $ld) {
                            extract($ld);
                            if ($_SESSION['status_id'] == $sit_id) {
                                echo "<option value='$sit_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$sit_id'>$sit</option>";
                            }
                        }
                        echo "</select>";
                        ?>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="referencia">Referência</label>
                        </div>
                        <input name="referencia" type="text" id="referencia" class="form-control" aria-describedby="referencia" placeholder="Digite a referência" value="<?php
                        if (isset($_SESSION['referencia'])) {
                            echo $_SESSION['referencia'];
                        }
                        ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group ml-sm-2 ml-md-2 ml-lg-2 ml-3">
                    <input name="PesqTroca" type="submit" class="btn btn-outline-primary mx-sm-2" value="Pesquisar">
                </div>
            </div>
        </form><hr>
        <?php
        if (empty($this->Dados['listTroca'])) {
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
                        <th>Nome</th>
                        <th class="d-none d-sm-table-cell">Loja</th>
                        <th class="d-none d-sm-table-cell">Referência</th>
                        <th class="d-none d-lg-table-cell">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($this->Dados['listTroca'])) {
                        foreach ($this->Dados['listTroca'] as $usuario) {
                            extract($usuario);
                            ?>
                            <tr>
                                <th class="text-center align-middle"><?php echo $id; ?></th>
                                <td class="align-middle"><?php echo $func; ?></td>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo $nome_loja; ?></td>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo $referencia; ?></td>
                                <td class="d-none d-sm-table-cell align-middle text-center"><span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $status; ?></span></td>
                                <td class="text-center">
                                    <span class="d-none d-md-block">
                                        <?php
                                        if ($this->Dados['botao']['vis_troca']) {
                                            echo "<a href='" . URLADM . "ver-troca/ver-troca/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                        }
                                        if ($this->Dados['botao']['edit_troca']) {
                                            echo "<a href='" . URLADM . "editar-troca/edit-troca/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                                        }
                                        if ($this->Dados['botao']['del_troca']) {
                                            echo "<a href='" . URLADM . "apagar-troca/apagar-troca/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                                        }
                                        ?>
                                    </span>
                                    <div class="dropdown d-block d-md-none">
                                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Ações
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                            <?php
                                            if ($this->Dados['botao']['vis_usuario']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "ver-usuario/ver-usuario/$id'>Visualizar</a>";
                                            }
                                            if ($this->Dados['botao']['edit_usuario']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "editar-usuario/edit-usuario/$id'>Editar</a>";
                                            }
                                            if ($this->Dados['botao']['del_usuario']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-usuario/apagar-usuario/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
