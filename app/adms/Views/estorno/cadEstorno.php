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
                <h2 class="display-4 titulo">Solicitar Estorno</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_estorno']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'estorno/listar'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
                </div>
                <?php
            }
            ?>
        </div><hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" enctype="multipart/form-data" class="was-validated">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Loja</label>
                    <select name="loja_id" id="loja_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['loja_id'] as $lj) {
                            extract($lj);
                            if (isset($valorForm['loja_id']) == $loja_id) {
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
                        foreach ($this->Dados['select']['id_func'] as $fc) {
                            extract($fc);
                            if (isset($valorForm['id_func']) == $id_func) {
                                echo "<option value='$id_func' selected>$func</option>";
                            } else {
                                echo "<option value='$id_func'>$func</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Cliente</label>
                    <input name="nome_cliente" type="text" class="form-control is-invalid" placeholder="Nome completo do Cliente" value="<?php
                    if (isset($valorForm['nome_cliente'])) {
                        echo $valorForm['nome_cliente'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> CPF</label>
                    <input name="cpf_cliente" type="text" class="form-control is-invalid" placeholder="CPF do Cliente" value="<?php
                    if (isset($valorForm['cpf_cliente'])) {
                        echo $valorForm['cpf_cliente'];
                    }
                    ?>" required>
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
                        foreach ($this->Dados['select']['id_form'] as $sit) {
                            extract($sit);
                            if (isset($valorForm['id_form']) == $id_form) {
                                echo "<option value='$id_form' selected>$forma_pag</option>";
                            } else {
                                echo "<option value='$id_form'>$forma_pag</option>";
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
                        foreach ($this->Dados['select']['id_band'] as $tpart) {
                            extract($tpart);
                            if (isset($valorForm['id_band']) == $id_band) {
                                echo "<option value='$id_band' selected>$bandeira</option>";
                            } else {
                                echo "<option value='$id_band'>$bandeira</option>";
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
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Responsável</label>
                    <select name="adms_resp_aut_id" id="adms_resp_aut_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['id_resp'] as $res) {
                            extract($res);
                            if (isset($valorForm['id_resp']) == $id_resp) {
                                echo "<option value='$id_resp' selected>$resp_aut</option>";
                            } else {
                                echo "<option value='$id_resp'>$resp_aut</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="adms_sits_est_id" id="adms_sits_est_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['id_sit'] as $sit) {
                            extract($sit);
                            if (isset($valorForm['id_sit']) == $id_sit) {
                                echo "<option value='$id_sit' selected>$sit_est</option>";
                            } else {
                                echo "<option value='$id_sit'>$sit_est</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Arquivo</label>
                    <input class="form-control-file is-invalid" name="arquivo" type="file" required>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadEstorno" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
