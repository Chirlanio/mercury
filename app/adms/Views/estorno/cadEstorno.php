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
                    <select name="loja_id" id="loja_id" class="form-control is-invalid" required autofocus>
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
                            if (isset($valorForm['adms_func_id']) == $id_func) {
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
                    <input name="cpf_cliente" type="text" id="cpf" class="form-control is-invalid" placeholder="CPF do Cliente" value="<?php
                    if (isset($valorForm['cpf_cliente'])) {
                        echo $valorForm['cpf_cliente'];
                    }
                    ?>" autocomplete="off" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Valor Registrado</label>
                    <input name="valor_lancado" type="text" id="valor_lancado" class="form-control is-invalid" required value="<?php
                    if (isset($valorForm['valor_lancado'])) {
                        echo $valorForm['valor_lancado'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Valor Correto</label>
                    <input name="valor_correto" type="text" id="valor_correto" onkeyup="valorEstorno()" class="form-control is-invalid" required value="<?php
                    if (isset($valorForm['valor_correto'])) {
                        echo $valorForm['valor_correto'];
                    }
                    ?>">
                </div>
                
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Valor Estorno</label>
                    <input name="valor_estorno" type="text" id="valor_estorno" class="form-control is-invalid" required value="<?php
                    if (isset($valorForm['valor_estorno'])) {
                        echo $valorForm['valor_estorno'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-3">
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
                            if (isset($valorForm['tb_forma_pag_id']) == $id_form) {
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
                    <select name="adms_bandeira_id" id="adms_bandeira_id" class="form-control is-valid">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['id_band'] as $tpart) {
                            extract($tpart);
                            if (isset($valorForm['adms_bandeira_id']) == $id_band) {
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
                        if (isset($valorForm['adms_tps_est_id']) == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Total</option>";
                            echo "<option value='2'>Parcial</option>";
                        } elseif (isset($valorForm['adms_tps_est_id']) == 2) {
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
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Motivo do Estorno</label>
                    <select name="adms_mot_est_id" id="adms_mot_est_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['id_mot'] as $mot) {
                            extract($mot);
                            if (isset($valorForm['adms_mot_est_id']) == $id_mot) {
                                echo "<option value='$id_mot' selected>$motivo</option>";
                            } else {
                                echo "<option value='$id_mot'>$motivo</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Arquivo</label>
                    <input class="form-control-file is-invalid" name="arquivo" type="file" required />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Observações</label>
                    <textarea name="obs" id="editor" class="form-control editorCK" rows="3">
                        <?php
                        if(isset($valorForm['obs'])){
                            echo $valorForm['obs'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadEstorno" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>

