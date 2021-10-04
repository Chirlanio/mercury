<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($valorForm);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Solicitação</h2>
            </div>

            <div class="p-2 d-print-none">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['list_estorno']) {
                        echo "<a href='" . URLADM . "estorno/listar' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i> Listar</a> ";
                    }
                    if ($this->Dados['botao']['vis_estorno']) {
                        echo "<a href='" . URLADM . "ver-estorno/ver-estorno/" . $valorForm['id'] . "' class='btn btn-outline-primary btn-sm'><i class='fas fa-eye'></i> Visualizar</a> ";
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
                        if ($this->Dados['botao']['vis_estorno']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "ver-estorno/ver-estorno/" . $valorForm['id'] . "'>Cadastrar</a>";
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
        <form method="POST" action="" enctype="multipart/form-data" class="was-validated"> 
            <input name="id" type="hidden" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">

            <h2 class="display-4 titulo">Conteúdo</h2>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Loja</label>
                    <select name="loja_id" id="loja_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['loja_id'] as $lj) {
                            extract($lj);
                            if ($valorForm['loja_id'] == $loja_id) {
                                echo "<option value='$loja_id' selected>$loja</option>";
                            } else {
                                echo "<option value='$loja_id'>$loja</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Consultora</label>
                    <select name="adms_func_id" id="adms_func_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['adms_func_id'] as $fc) {
                            extract($fc);
                            if ($valorForm['adms_func_id'] == $adms_func_id) {
                                echo "<option value='$adms_func_id' selected>$func</option>";
                            } else {
                                echo "<option value='$adms_func_id'>$func</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Cliente</label>
                    <input name="nome_cliente" type="text" class="form-control is-invalid" placeholder="Nome completo do Cliente" value="<?php
                    if (isset($valorForm['nome_cliente'])) {
                        echo $valorForm['nome_cliente'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> CPF</label>
                    <input name="cpf_cliente" type="text" <?php echo (!isset($valorForm['cpf_cliente']) ? 'id="cpf"' : 'id="cpf_cliente"' ); ?> class="form-control is-invalid" placeholder="CPF do Cliente" value="<?php
                    if ($valorForm['cpf_cliente']) {
                        echo $valorForm['cpf_cliente'];
                    }
                    ?>" autocomplete="off" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Valor Registrado</label>
                    <input name="valor_lancado" type="text" class="form-control is-invalid" required value="<?php
                    if (isset($valorForm['valor_lancado'])) {
                        echo $valorForm['valor_lancado'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Valor Correto</label>
                    <input name="valor_correto" type="text" class="form-control is-invalid" required value="<?php
                    if (isset($valorForm['valor_correto'])) {
                        echo $valorForm['valor_correto'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Cupom - Nota Fiscal</label>
                    <input name="doc_nf" type="number" class="form-control is-invalid" required value="<?php
                    if (isset($valorForm['doc_nf'])) {
                        echo $valorForm['doc_nf'];
                    }
                    ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Forma de Pagamento</label>
                    <select name="tb_forma_pag_id" id="tb_forma_pag_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['tb_forma_pag_id'] as $sit) {
                            extract($sit);
                            if ($valorForm['tb_forma_pag_id'] == $tb_forma_pag_id) {
                                echo "<option value='$tb_forma_pag_id' selected>$forma_pag</option>";
                            } else {
                                echo "<option value='$tb_forma_pag_id'>$forma_pag</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Bandeira</label>
                    <select name="adms_bandeira_id" id="adms_bandeira_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['adms_bandeira_id'] as $tpart) {
                            extract($tpart);
                            if (isset($valorForm['adms_bandeira_id']) == $adms_bandeira_id) {
                                echo "<option value='$adms_bandeira_id' selected>$bandeira</option>";
                            } else {
                                echo "<option value='$adms_bandeira_id'>$bandeira</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label> Parcelas</label>
                    <input name="qtd_parcelas" type="number" class="form-control" value="<?php
                    if (isset($valorForm['qtd_parcelas'])) {
                        echo $valorForm['qtd_parcelas'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>NSU</label>
                    <input name="nsu" type="number" class="form-control" value="<?php
                    if (isset($valorForm['nsu'])) {
                        echo $valorForm['nsu'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>Autorização Cartão</label>
                    <input name="auto_cartao" type="number" class="form-control" value="<?php
                    if (isset($valorForm['auto_cartao'])) {
                        echo $valorForm['auto_cartao'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Tipo de Estorno</label>
                    <select name="adms_tps_est_id" id="adms_tps_est_id" class="form-control is-invalid" required>
                        <?php
                        if ($valorForm['adms_tps_est_id'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Total</option>";
                            echo "<option value='2'>Parcial</option>";
                        } elseif ($valorForm['adms_tps_est_id'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Total</option>";
                            echo "<option value='2' selected>Parcial</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Total</option>";
                            echo "<option value='2'>Parcial</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input name="file_antigo" type="hidden" value="<?php
                    if (isset($valorForm['file_antigo'])) {
                        echo $valorForm['file_antigo'];
                    } elseif (isset($valorForm['file'])) {
                        echo $valorForm['file'];
                    }
                    ?>">
                    <div class="mb-3">
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">Documentos</h6>
                                    <small class="text-muted">
                                        <span class="m-auto lead">
                                            <?php
                                            if (isset($valorForm['arquivo'])) {
                                                echo $valorForm['arquivo'] . " - ";
                                            }
                                            ?>
                                        </span>
                                        <a href="<?php echo URLADM . 'assets/files/estorno/' . $valorForm['id'] . '/' . $valorForm['arquivo']; ?>" class="lead m-auto" download>Baixar</a>
                                    </small>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <label><span class="text-danger">*</span> Novo Documento</label>
                    <input name="file_novo" type="file">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Responsável</label>
                    <select name="adms_resp_aut_id" id="adms_resp_aut_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['adms_resp_aut_id'] as $resp) {
                            extract($resp);
                            if ($valorForm['adms_resp_aut_id'] == $adms_resp_aut_id) {
                                echo "<option value='$adms_resp_aut_id' selected>$resp_aut</option>";
                            } else {
                                echo "<option value='$adms_resp_aut_id'>$resp_aut</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="adms_sits_est_id" id="adms_sits_est_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['adms_sits_est_id'] as $sit) {
                            extract($sit);
                            if ($valorForm['adms_sits_est_id'] == $adms_sits_est_id) {
                                echo "<option value='$adms_sits_est_id' selected>$sit_est</option>";
                            } else {
                                echo "<option value='$adms_sits_est_id'>$sit_est</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Observações</label>
                    <textarea name="obs" id="editor" class="form-control" rows="3">
                        <?php
                        if (isset($valorForm['obs'])) {
                            echo $valorForm['obs'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditEstorno" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
