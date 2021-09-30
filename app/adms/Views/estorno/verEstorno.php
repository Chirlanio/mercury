<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_estorno'][0])) {
    extract($this->Dados['dados_estorno'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Detalhes da Solicitação</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_estorno']) {
                            echo "<a href='" . URLADM . "estorno/listar' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->Dados['botao']['edit_estorno']) {
                            echo "<a href='" . URLADM . "editar-estorno/edit-estorno/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->Dados['botao']['del_estorno']) {
                            echo "<a href='" . URLADM . "apagar-estorno/apagar-estorno/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_estorno']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "estorno/listar'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_estorno']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-estorno/edit-estorno/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_estorno']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-estorno/apagar-estorno/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
                <dd class="col-sm-9"><?php echo $id; ?></dd>

                <dt class="col-sm-3">Loja</dt>
                <dd class="col-sm-9"><?php echo $loja_id; ?></dd>

                <dt class="col-sm-3">Consultora</dt>
                <dd class="col-sm-9"><?php echo $adms_func_id; ?></dd>

                <dt class="col-sm-3">Cliente</dt>
                <dd class="col-sm-9"><?php echo $nome_cliente; ?></dd>

                <dt class="col-sm-3">CPF</dt>
                <dd class="col-sm-9"><?php echo $cpf_cliente; ?></dd>

                <dt class="col-sm-3">Cupom - Nota Fiscal</dt>
                <dd class="col-sm-9"><?php echo $doc_nf; ?></dd>

                <dt class="col-sm-3">Valor lançado</dt>
                <dd class="col-sm-9"><?php echo "R$ " . $valor_lancado; ?></dd>

                <dt class="col-sm-3">Metodo no Menu</dt>
                <dd class="col-sm-9"><?php echo "R$ " . $valor_correto; ?></dd>

                <dt class="col-sm-3">Forma de Pagamento</dt>
                <dd class="col-sm-9"><?php echo $tb_forma_pag_id; ?></dd>

                <dt class="col-sm-3">Bandeira</dt>
                <dd class="col-sm-9"><?php echo $adms_bandeira_id; ?></dd>              

                <dt class="col-sm-3">Parcelas</dt>
                <dd class="col-sm-9"><?php echo $qtd_parcelas . "x"; ?></dd>

                <dt class="col-sm-3">NSU</dt>
                <dd class="col-sm-9"><?php echo $nsu; ?></dd>

                <dt class="col-sm-3">Autorização do Cartão</dt>
                <dd class="col-sm-9"><?php echo $auto_cartao; ?></dd>

                <dt class="col-sm-3">Tipo de Estorno</dt>
                <dd class="col-sm-9"><?php echo ($adms_tps_est_id = 1) ? "Total" : "Parcial"; ?></dd>

                <dt class="col-sm-3">Inserido</dt>
                <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></dd>

                <dt class="col-sm-3">Alterado</dt>
                <dd class="col-sm-9"><?php
                    if (!empty($modified)) {
                        echo date('d/m/Y H:i:s', strtotime($modified));
                    }
                    ?>
                </dd>
            </dl>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Dados do Cliente</span>
                        <span class="badge badge-secondary badge-pill"><?php echo $id; ?></span>
                    </h4>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">Nome</h6>
                                <small class="text-muted"><?php echo $nome_cliente; ?></small>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">CPF</h6>
                                <small class="text-muted"><?php echo $cpf_cliente; ?></small>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">Valor Registrado</h6>
                                <small class="text-muted"><?php echo "R$ " . $valor_lancado; ?></small>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <div class="text-success">
                                <h6 class="my-0">Valor Correto</h6>
                                <small><?php echo "R$ " . $valor_correto; ?></small>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (USD)</span>
                            <strong>$20</strong>
                        </li>
                    </ul>
                </div>
                <div class="col-md-8 order-md-1">
                    <h4 class="mb-3">Dados da Venda</h4>
                    <form class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="loja_id">Loja</label>
                                <input type="text" class="form-control" id="loja_id" placeholder="" value="<?php echo $loja_id; ?>" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="adms_func_id">Consultora</label>
                                <input type="text" class="form-control" id="adms_func_id" placeholder="" value="<?php echo $adms_func_id; ?>" disabled>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="username">Username</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@</span>
                                </div>
                                <input type="text" class="form-control" id="username" placeholder="Username" required>
                                <div class="invalid-feedback" style="width: 100%;">
                                    Your username is required.
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email">Email <span class="text-muted">(Optional)</span></label>
                            <input type="email" class="form-control" id="email" placeholder="you@example.com">
                            <div class="invalid-feedback">
                                Please enter a valid email address for shipping updates.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="1234 Main St" required>
                            <div class="invalid-feedback">
                                Please enter your shipping address.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                            <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
                        </div>

                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="country">Country</label>
                                <select class="custom-select d-block w-100" id="country" required>
                                    <option value="">Choose...</option>
                                    <option>United States</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid country.
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state">State</label>
                                <select class="custom-select d-block w-100" id="state" required>
                                    <option value="">Choose...</option>
                                    <option>California</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please provide a valid state.
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="zip">Zip</label>
                                <input type="text" class="form-control" id="zip" placeholder="" required>
                                <div class="invalid-feedback">
                                    Zip code required.
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Página não encontrada!</div>";
    $UrlDestino = URLADM . 'pagina/listar';
    header("Location: $UrlDestino");
}
