<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
//var_dump($this->Dados['listQuantity']);
if (!empty($this->Dados['dados_relocation'][0])) {
    extract($this->Dados['dados_relocation'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Detalhes da Solicitação</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_relocation']) {
                            echo "<a href='" . URLADM . "relocation/list' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                        }
                        if ($this->Dados['botao']['edit_relocation']) {
                            echo "<a href='" . URLADM . "editar-relocation/edit-relocation/$id' class='btn btn-outline-warning btn-sm'><i class='fas fa-pen-fancy'></i></a> ";
                        }
                        if ($this->Dados['botao']['del_relocation']) {
                            echo "<a href='" . URLADM . "delete-relocation/del-relocation/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <?php
                            if ($this->Dados['botao']['list_relocation']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "relocation/list'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_relocation']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-relocation/edit-relocation/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_relocation']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-relocation/apagar-relocation/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <?php
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
                            <th class="d-none d-sm-table-cell">Destino</th>
                            <th class="d-none d-sm-table-cell">Referência</th>
                            <?php
                            foreach ($this->Dados['dados_relocation'] as $tam) {
                                extract($tam);
                                echo "<th class='d-none d-sm-table-cell text-center' id='$size'>$size</th>";
                            }
                            ?>
                            <th class="d-none d-sm-table-cell">Total</th>
                            <th class="d-none d-sm-table-cell">Status</th>
                            <!--<th class="text-center">Ações</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($this->Dados['listRelocation'] as $rem) {
                            extract($rem);
                            var_dump($rem);
                            ?>
                            <tr>
                                <th class="text-center align-middle"><?php echo $ri_id; ?></th>
                                <th class="text-center align-middle"><?php echo $loja_destino; ?></th>
                                <td class="d-none d-sm-table-cell align-middle"><?php echo $product_reference; ?></td>
                                <?php
                                $tams = count($this->Dados['dados_relocation']);
                                //var_dump($this->Dados['listQuantity']);

                                for ($i = 0; $i < $tams; $i++) {
                                    foreach ($this->Dados['listQuantity'] as $query) {
                                        extract($query);
                                        var_dump($query['q_id']);
                                        if ($query['q_id'] == $ri_id) {
                                            $tamm = $rem['quantity_requested'];
                                        } else {
                                            $tamm = 0;
                                        }
                                    }
                                    ?>
                                    <td class = 'd-none d-sm-table-cell align-middle text-center'>
                                        0+1
                                    </td>
                                    <?php
                                }
                                ?>
                                <td class="d-none d-sm-table-cell align-middle text-center"><?php echo 0; ?></td>
                                <td class="d-none d-sm-table-cell align-middle text-center">
                                    <span class="badge badge-<?php echo $cor; ?>"><?php echo $name_sit; ?></span>
                                </td>
                                <!--<td class="text-center">
                                    <span class="d-none d-md-block">
                                <?php
                                if ($this->Dados['botao']['edit_relocation']) {
                                    echo "<a href='" . URLADM . "edit-relocation/edit-relocation/$lj_id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                }
                                if ($this->Dados['botao']['del_relocation']) {
                                    echo "<a href='" . URLADM . "delete-relocation/delete-relocation/$lj_id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a>";
                                }
                                ?>
                                    </span>
                                    <div class="dropdown d-block d-md-none">
                                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Ações
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                <?php
                                if ($this->Dados['botao']['edit_relocation']) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "edit-relocation/edit-relocation/$lj_id'>Editar</a>";
                                }
                                if ($this->Dados['botao']['del_relocation']) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "delete-relocation/delete-relocation/$lj_id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                }
                                ?>
                                        </div>
                                    </div>
                                </td>-->
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Página não encontrada!</div>";
    $UrlDestino = URLADM . 'relocation/list';
    header("Location: $UrlDestino");
}
