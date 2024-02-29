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
                <h2 class="display-4 titulo">Pesquisar Funcionários</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['list_func']) {
                        echo "<a href='" . URLADM . "funcionarios/listar-func' class='btn btn-outline-info btn-sm'>Listar</a> ";
                    }
                    if ($this->Dados['botao']['cad_func']) {
                        echo "<a href='" . URLADM . "cadastrar-func/cad-func/' class='btn btn-outline-success btn-sm'>Cadastrar</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['list_func']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "funcionarios/listar-func'>Listar</a>";
                        }
                        if ($this->Dados['botao']['cad_func']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "cadastrar-func/cad-func/'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <form class="form" method="POST" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 col-lg-6 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold;" for="cliente">Nome</label>
                        </div>
                        <input name="nome" type="text" id="nome" class="form-control" placeholder="Digite o nome do funcionário" value="<?php
                        if (isset($_SESSION['nome'])) {
                            echo $_SESSION['nome'];
                        }
                        ?>" autofocus>
                    </div>
                </div>

                <div class='col-sm-12 col-lg-3 mb-3'>
                    <div class='input-group'>
                        <div class='input-group-prepend'>
                            <label class='input-group-text' style='font-weight: bold;' for='loja_id'>Loja</label>
                        </div>

                        <select name='loja_id' id='loja_id' class='custom-select'>
                            <option value = ''>Selecione</option>
                            <?php
                            foreach ($this->Dados['select']['stores'] as $ld) {
                                extract($ld);
                                if ($_SESSION['loja_id'] == $l_id) {
                                    echo "<option value='$l_id' selected>$loja</option>";
                                } else {
                                    echo "<option value='$l_id'>$loja</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>


                <div class='col-sm-12 col-lg-3 mb-3'>
                    <div class='input-group'>
                        <div class='input-group-prepend'>
                            <label class='input-group-text' style='font-weight: bold;' for='loja_id'>Situação</label>
                        </div>

                        <select name='status_id' id='status_id' class='custom-select'>
                            <option value = ''>Selecione</option>
                            <?php
                            foreach ($this->Dados['select']['sits'] as $sit) {
                                extract($sit);
                                if ($_SESSION['sits'] == $s_id) {
                                    echo "<option value='$s_id' selected>$status</option>";
                                } else {
                                    echo "<option value='$s_id'>$status</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group ml-sm-2 ml-md-2 ml-lg-2 ml-3">
                    <input name="PesqFunc" type="submit" class="btn btn-outline-primary mx-sm-2" value="Pesquisar">
                </div>
            </div>
        </form><hr>
        <?php
        if (empty($this->Dados['listFunc'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum funcionário encontrado!
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
                        <th>Cupom Site</th>
                        <th class="d-none d-sm-table-cell">Função</th>
                        <th class="d-none d-sm-table-cell">Loja</th>
                        <th class="d-none d-sm-table-cell">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($this->Dados['listFunc'])) {
                        foreach ($this->Dados['listFunc'] as $func) {
                            extract($func);
                            ?>
                            <tr>
                                <th class="text-center align-middle"><?php echo $id; ?></th>
                                <td class="align-middle"><?php echo $nome; ?></td>
                                <td class="align-middle"><span class="badge badge-warning"><?php echo $cupom_site; ?></span></td>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo $cargo; ?></td>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo $loja; ?></td>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo $sit; ?></td>
                                <td class="text-center">
                                    <span class="d-none d-md-block">

                                        <?php
                                        if ($this->Dados['botao']['vis_func']) {
                                            echo "<a href='" . URLADM . "ver-func/ver-func/$id' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                        }
                                        if ($this->Dados['botao']['edit_func']) {
                                            echo "<a href='" . URLADM . "editar-func/edit-func/$id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                        }
                                        if ($this->Dados['botao']['del_func']) {
                                            echo "<a href='" . URLADM . "apagar-func/apagar-func/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                        }
                                        ?>
                                    </span>
                                    <div class="dropdown d-block d-md-none">
                                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Ações
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                            <a class='dropdown-item' href='<?php echo $link; ?>'  target="_blank">Acessar</a>
                                            <?php
                                            if ($this->Dados['botao']['vis_func']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "ver-func/ver-func/$id'>Visualizar</a>";
                                            }
                                            if ($this->Dados['botao']['edit_func']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "editar-func/edit-func/$id'>Editar</a>";
                                            }
                                            if ($this->Dados['botao']['del_func']) {
                                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-func/apagar-func/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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