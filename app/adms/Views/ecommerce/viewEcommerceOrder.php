<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_ecommerce'][0])) {
    extract($this->Dados['dados_ecommerce'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Pedido de Faturamento - <strong>ID:</strong> <?php echo $id; ?></h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_ecommerce_order']) {
                            echo "<a href='" . URLADM . "ecommerce/list' class='btn btn-outline-info btn-sm m-1' title='Listar'><i class='fas fa-list'></i></a>";
                        }
                        if ($this->Dados['botao']['edit_ecommerce_order']) {
                            echo "<a href='" . URLADM . "edit-ecommerce-order/edit-order/$id' class='btn btn-outline-warning btn-sm m-1' title='Editar'><i class='fa-solid fa-pen-to-square'></i></a>";
                        }
                        if ($this->Dados['botao']['del_ecommerce_order']) {
                            echo "<a href='" . URLADM . "delete-ecommerce-order/delete-moviment/$id' class='btn btn-outline-danger btn-sm m-1' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none d-print-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_ecommerce_order']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "ecommerce/list'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_ecommerce_order']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-ecommerce-order/edit-moviment/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_ecommerce_order']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delete-ecommerce-order/delete-moviment/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
            <div class="content p1">
                <div class="row">

                    <div class="col-md-12">
                        <form>
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="loja_id">Loja</label>
                                    <input type="text" class="form-control bg-white" id="loja_id" readonly value="<?php echo $store; ?>">
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label for="func_id">Colaborador</label>
                                    <input type="text" class="form-control bg-white" id="func_id" value="<?php echo $colaborador; ?>" readonly>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="date_order">Data do Pedido</label>
                                    <input type="text" class="form-control bg-white" id="date_order" value="<?php echo date("d/m/Y", strtotime($date_order)); ?>" readonly>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="number_order">Nº do Pedido</label>
                                    <input type="text" class="form-control bg-white" id="number_order" value="<?php echo $number_order; ?>" readonly>
                                </div>
                            </div>

                            <div class="form-row">

                                <div class="col-md-2">
                                    <label for="number_nf"><span class="text-danger">*</span> Nota de Transferência Nº:</label>
                                    <input name="number_nf" type="text" class="form-control bg-white" id="number_nf" value="<?php echo $number_nf; ?>" readonly />
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="just_invoice"><span class="text-danger">*</span> Só Faturar?</label>
                                    <input name="just_invoice" type="text" class="form-control bg-white" id="just_invoice" value="<?php echo $just_invoice == 1 ? "Não" : "Sim"; ?>" readonly />
                                </div>

                                <div class="form-group col-md-5">
                                    <label for="created_by"><span class="text-danger">*</span> Cadastrado Por:</label>
                                    <input name="created_by" type="text" class="form-control bg-white" id="created_by" value="<?php echo $creator; ?>" readonly />
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="number_invoice_nf">Rastreio:</label>
                                    <input name="number_invoice_nf" type="text" class="form-control bg-white" id="number_invoice_nf" value="<?php echo $number_invoice_nf; ?>" readonly />
                                </div>

                            </div>

                            <div class="mb-3">
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0"><p>Observações:</p></h6>
                                            <small class="text-muted lead"><?php echo $obsarvations; ?></small>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="form-row">
                                <div class="col-md-2 mb-3">
                                    <label for="date_order">Data de Cadastro</label>
                                    <input type="text" class="form-control bg-white" id="date_order" value="<?php echo date("d/m/Y H:i:s", strtotime($created)); ?>" readonly>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="date_order">Data de Atualização</label>
                                    <input type="text" class="form-control bg-white" id="date_order" value="<?php echo (!empty($modified) ? date("d/m/Y H:i:s", strtotime($modified)) : ""); ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="adms_sit_ecommerce_id"><span class="text-danger">*</span> Situação</label>
                                    <input name="adms_sit_ecommerce_id" type="text" class="form-control bg-white" id="adms_sit_ecommerce_id" value="<?php echo $status; ?>" readonly />
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="update_by"><span class="text-danger">*</span> Atualizado Por:</label>
                                    <input name="update_by" type="text" class="form-control bg-white" id="update_by" value="<?php echo $updated; ?>" readonly />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Nenhuma solicitação encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    $UrlDestino = URLADM . 'ecommerce/list';
    header("Location: $UrlDestino");
}    