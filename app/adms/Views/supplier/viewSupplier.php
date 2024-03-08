<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['data_supplier'][0])) {
    extract($this->Dados['data_supplier'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Fornecedor</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_supplier']) {
                            echo "<a href='" . URLADM . "supplier/list' class='btn btn-outline-info btn-sm'><i class='fa-solid fa-list'></i></a> ";
                        }
                        if ($this->Dados['botao']['edit_supplier']) {
                            echo "<a href='" . URLADM . "edit-supplier/edit-supplier/$id_supp' class='btn btn-outline-warning btn-sm'><i class='fa-solid fa-pen-to-square'></i></a> ";
                        }
                        if ($this->Dados['botao']['del_supplier']) {
                            echo "<a href='" . URLADM . "delete-supplier/delete-supplier/$id_supp' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_supplier']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "supplier/list'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_supplier']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-supplier/edit-supplier/$id_supp'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_supplier']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delete-supplier/delete-supplier/$id_supp' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div><hr>
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <dl class="row">

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?php echo $id_supp; ?></dd>

                <dt class="col-sm-3">Razão Social</dt>
                <dd class="col-sm-9"><?php echo $corporate_social; ?></dd>

                <dt class="col-sm-3">Nome Fantasia</dt>
                <dd class="col-sm-9"><?php echo $fantasy_name; ?></dd>

                <dt class="col-sm-3">CPF/CNPF</dt>
                <dd class="col-sm-9" id="cnpj"><?php echo $cnpj_cpf; ?></dd>

                <dt class="col-sm-3">Contato</dt>
                <dd class="col-sm-9" id="phone_with_ddd"><?php echo $contact; ?></dd>

                <dt class="col-sm-3">E-mail</dt>
                <dd class="col-sm-9"><?php echo $email; ?></dd>

                <dt class="col-sm-3">Cadastrado</dt>
                <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></dd>

                <dt class="col-sm-3">Atualizado</dt>
                <dd class="col-sm-9"><?php
                    if (!empty($modified)) {
                        echo date('d/m/Y H:i:s', strtotime($modified));
                    }
                    ?>
                </dd>
            </dl>
        </div>
    </div>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Fornecedor não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    $UrlDestino = URLADM . 'supplier/list';
    header("Location: $UrlDestino");
}
