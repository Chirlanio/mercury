<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['form']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Ordem de Serviço</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_ordem_servico']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ordem-servico/listar'; ?>" class="btn btn-outline-info btn-sm"><i class='fa-solid fa-list'></i></a>
                </div>
                <?php
            }
            ?>
        </div>
        <hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <div class="mr-auto p-2">
            <h3 class="display-4 titulo">Preenchimento - Lojas</h3>
        </div>
        <form method="POST" action="" enctype="multipart/form-data" class="was-validated">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Loja</label>
                    <select name="loja_id" id="loja_id" class="custom-select is-invalid" required autofocus>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['stores'] as $lj) {
                            extract($lj);
                            if (isset($valorForm['loja_id']) and $valorForm['loja_id'] == $l_id) {
                                echo "<option value='$l_id' selected>$loja</option>";
                            } else {
                                echo "<option value='$l_id'>$loja</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Referência</label>
                    <input name="referencia" type="text" class="form-control is-invalid" required value="<?php
                    if (isset($valorForm['referencia'])) {
                        echo strtoupper($valorForm['referencia']);
                    }
                    ?>">
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Tamanho</label>
                    <select name="tam_id" id="tam_id" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['tams'] as $ta) {
                            extract($ta);
                            if (isset($valorForm['tam_id']) and $valorForm['tam_id'] == $tam_id) {
                                echo "<option value='$tam_id' selected>$tam</option>";
                            } else {
                                echo "<option value='$tam_id'>$tam</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Marca</label>
                    <select name="marca_id" id="marca_id" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['marc'] as $m) {
                            extract($m);
                            if (isset($valorForm['marca_id']) and $valorForm['marca_id'] == $m_id) {
                                echo "<option value='$m_id' selected>$marca</option>";
                            } else {
                                echo "<option value='$m_id'>$marca</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="form-row">

                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Tipo</label>
                    <select name="type_order_id" id="type_order_id" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['types'] as $tip) {
                            extract($tip);
                            if (isset($valorForm['type_order_id']) and $valorForm['type_order_id'] == $tip_id) {
                                echo "<option value='$tip_id' selected>$tipo</option>";
                            } else {
                                echo "<option value='$tip_id'>$tipo</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-8">
                    <label><span class="text-danger">*</span> Clientes</label>
                    <input name="client_name" type="text" id="client_name" class="form-control is-invalid" required value="<?php
                    if (isset($valorForm['client_name'])) {
                        echo $valorForm['client_name'];
                    }
                    ?>">
                </div>

                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Quantidade</label>
                    <input name="qtde" type="number" class="form-control is-invalid text-center" value="<?php
                    if (isset($valorForm['qtde'])) {
                        echo $valorForm['qtde'];
                    }
                    ?>" required>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">* </span>Defeito</label>
                    <select name="def_id" id="def_id" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['def'] as $d) {
                            extract($d);
                            if (isset($valorForm['def_id']) and $valorForm['def_id'] == $d_id) {
                                echo "<option value='$d_id' selected>$defeito</option>";
                            } else {
                                echo "<option value='$d_id'>$defeito</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">* </span>Detalhes</label>
                    <select name="det_id" id="det_id" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['det'] as $dt) {
                            extract($dt);
                            if (isset($valorForm['det_id']) and $valorForm['det_id'] == $dt_id) {
                                echo "<option value='$dt_id' selected>$detalhe</option>";
                            } else {
                                echo "<option value='$dt_id'>$detalhe</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">* </span>Posição</label>
                    <select name="loc_id" id="loc_id" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['loc'] as $lc) {
                            extract($lc);
                            if (isset($valorForm['loc_id']) and $valorForm['loc_id'] == $l_id) {
                                echo "<option value='$l_id' selected>$local</option>";
                            } else {
                                echo "<option value='$l_id'>$local</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">

                <ul class="list-unstyled d-flex justify-content-between">
                    <li class="media col-6 col-md-6 col-lg-6">
                        <?php
                        $image_antiga = URLADM . 'assets/imagens/naodisp.jpg';
                        ?>
                        <img class="mr-3 mb-1 img-thumbnail" src="<?php echo $image_antiga; ?>" alt="Imagem do Produto" id="preview-product-one" style="width: 120px; height: 120px;">
                        <div class="media-body">
                            <h5 class="mt-0 mb-1"> Foto Produto</h5>
                            <input class="mr-3" name="image_one" type="file" onchange="previewImageOne();">
                        </div>
                    </li>

                    <li class="media col-6 col-md-6 col-lg-6">
                        <?php
                        $image_antiga = URLADM . 'assets/imagens/naodisp.jpg';
                        ?>
                        <img class="mr-3 mb-1 img-thumbnail" src="<?php echo $image_antiga; ?>" alt="Imagem do Produto" id="preview-product-two" style="width: 120px; height: 120px;">
                        <div class="media-body">
                            <h5 class="mt-0 mb-1"> Foto Solado</h5>
                            <input class="mr-3" name="image_two" type="file" onchange="previewImageTwo();">
                        </div>
                    </li>

                </ul>

                <ul class="list-unstyled d-flex justify-content-between">

                    <li class="media col-6 col-md-6 col-lg-6">
                        <?php
                        $image_antiga = URLADM . 'assets/imagens/naodisp.jpg';
                        ?>
                        <img class="mr-3 mb-1 img-thumbnail" src="<?php echo $image_antiga; ?>" alt="Imagem do Produto" id="preview-product-three" style="width: 120px; height: 120px;">
                        <div class="media-body">
                            <h5 class="mt-0 mb-1"> Foto Defeito</h5>
                            <input class="mr-3" name="image_three" type="file" onchange="previewImageThree();">
                        </div>
                    </li>

                    <li class="media col-6 col-md-6 col-lg-6">
                        <?php
                        $image_antiga = URLADM . 'assets/imagens/naodisp.jpg';
                        ?>
                        <img class="mr-3 mb-1 img-thumbnail" src="<?php echo $image_antiga; ?>" alt="Imagem do cupom" id="preview-product-cupom" style="width: 120px; height: 120px;">
                        <div class="media-body">
                            <h5 class="mt-0 mb-1"> Cupom Fiscal</h5>
                            <input class="mr-3" name="cupom_fiscal" type="file" onchange="previewCupom();">
                        </div>
                    </li>

                </ul>

            </div>

            <div class="form-row">

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Ordem Serviço</label>
                    <input name="order_service" type="number" class="form-control is-invalid" placeholder="Ordem de serviço do CIGAM" value="<?php
                    if (isset($valorForm['order_service'])) {
                        echo $valorForm['order_service'];
                    }
                    ?>" required>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Data de Cadastro</label>
                    <input name="date_order_service" type="date" id="date_order_service" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['date_order_service'])) {
                        echo $valorForm['date_order_service'];
                    }
                    ?>" required>
                </div>

                <div class="form-group col-md-3">
                    <label>O.S ZZnet</label>
                    <input name="order_service_zznet" id="order_service_zznet" type="text" class="form-control is-invalid" placeholder="0000-0000" value="<?php
                    if (isset($valorForm['order_service_zznet'])) {
                        echo $valorForm['order_service_zznet'];
                    }
                    ?>">
                </div>

                <div class="form-group col-md-3">
                    <label>Data de Cadastro ZZnet</label>
                    <input name="date_order_service_zznet" type="date" id="date_order_service_zznet" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['date_order_service_zznet'])) {
                        echo $valorForm['date_order_service_zznet'];
                    }
                    ?>">
                </div>

            </div>

            <div class="form-row">

                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> NF Transferência</label>
                    <input name="num_nota_transf" type="number" id="num_nota_transf" class="form-control is-invalid" required value="<?php
                    if (isset($valorForm['num_nota_transf'])) {
                        echo $valorForm['num_nota_transf'];
                    }
                    ?>">
                </div>

                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Data de Emissão</label>
                    <input name="data_emissao_nota_transf" type="date" id="data_emissao_nota_transf" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['data_emissao_nota_transf'])) {
                        echo $valorForm['data_emissao_nota_transf'];
                    }
                    ?>" required>
                </div>

                <?php
                if (!empty($valorForm['data_confir_nota_transf']) or $_SESSION['adms_niveis_acesso_id'] == 14 or $_SESSION['adms_niveis_acesso_id'] == 1) {
                    ?>
                    <div class="form-group col-md-2">
                        <label>Data de Confirmação</label>
                        <input name="data_confir_nota_transf" type="date" id="data_confir_nota_transf" class="form-control is-invalid" value="<?php
                        if (isset($valorForm['data_confir_nota_transf'])) {
                            echo $valorForm['data_confir_nota_transf'];
                        }
                        ?>">
                    </div>
                    <?php
                }
                ?>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Troca Realizada?</label>
                    <select name="customer_credit_withdrawn" id="customer_credit_withdrawn" class="form-control" required>
                        <?php
                        if (isset($valorForm['customer_credit_withdrawn']) and $valorForm['customer_credit_withdrawn'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Não</option>";
                            echo "<option value='2'>Sim</option>";
                        } elseif (isset($valorForm['customer_credit_withdrawn']) and $valorForm['customer_credit_withdrawn'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Não</option>";
                            echo "<option value='2' selected>Sim</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Não</option>";
                            echo "<option value='2'>Sim</option>";
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="form-row">

                <div class="form-group col-md-12">
                    <label>Observações</label>
                    <textarea name="obs_loja" id="obs_loja" class="form-control editorCK is-invalid" rows="4" required>
                        <?php
                        if (isset($valorForm['obs_loja'])) {
                            echo $valorForm['obs_loja'];
                        }
                        ?>
                    </textarea>
                </div>

            </div>
            <?php
            if ($_SESSION['adms_niveis_acesso_id'] <> 5) {
                ?>
                <hr>

                <div class="mr-auto p-2">
                    <h3 class="display-4 titulo">Preenchimento - Qualidade</h3>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label>Loja - Conserto</label>
                        <select name="loja_id_conserto" id="loja_id_conserto" class="custom-select is-invalid">
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->Dados['select']['loja'] as $lj) {
                                extract($lj);
                                if (isset($valorForm['loja_id_conserto']) and $valorForm['loja_id_conserto'] == $l_id) {
                                    echo "<option value='$l_id' selected>$loja</option>";
                                } else {
                                    echo "<option value='$l_id'>$loja</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label><span class="text-danger">*</span> Nota - Conserto</label>
                        <input name="nf_conserto_devolucao" type="number" class="form-control is-invalid" value="<?php
                        if (isset($valorForm['nf_conserto_devolucao'])) {
                            echo $valorForm['nf_conserto_devolucao'];
                        }
                        ?>">
                    </div>

                    <div class="form-group col-md-3">
                        <label>Data de Confirmação</label>
                        <input name="data_emissao_conserto" type="date" id="data_emissao_conserto" class="form-control is-invalid" value="<?php
                        if (isset($valorForm['data_emissao_conserto'])) {
                            echo $valorForm['data_emissao_conserto'];
                        }
                        ?>">
                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label>Nota - Retorno</label>
                        <input name="nf_retorno_conserto" type="number" class="form-control is-invalid" value="<?php
                        if (isset($valorForm['nf_retorno_conserto'])) {
                            echo $valorForm['nf_retorno_conserto'];
                        }
                        ?>">
                    </div>

                    <div class="form-group col-md-3">
                        <label>Data Emissão da Nota</label>
                        <input name="data_emissao_retorno_conserto" id="data_emissao_retorno_conserto" type="date" class="form-control is-valid" value="<?php
                        if (isset($valorForm['data_emissao_retorno_conserto'])) {
                            echo $valorForm['data_emissao_retorno_conserto'];
                        }
                        ?>">
                    </div>

                    <div class="form-group col-md-3">
                        <label>Data de Confirmação</label>
                        <input name="data_confir_retorno_conserto" type="date" id="data_confir_retorno_conserto" class="form-control is-invalid" value="<?php
                        if (isset($valorForm['data_confir_retorno_conserto'])) {
                            echo $valorForm['data_confir_retorno_conserto'];
                        }
                        ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Nota - Transferência</label>
                        <input name="nf_transf_saldo_produto" type="number" class="form-control is-invalid" value="<?php
                        if (isset($valorForm['nf_transf_saldo_produto'])) {
                            echo $valorForm['nf_transf_saldo_produto'];
                        }
                        ?>">
                    </div>

                    <div class="form-group col-md-3">
                        <label>Data Emissão da Transferência</label>
                        <input name="data_nota_transf_saldo_produto" id="data_nota_transf_saldo_produto" type="date" class="form-control is-valid" value="<?php
                        if (isset($valorForm['data_nota_transf_saldo_produto'])) {
                            echo $valorForm['data_nota_transf_saldo_produto'];
                        }
                        ?>">
                    </div>

                    <div class="form-group col-md-3">
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Observações - Qualidade</label>
                        <textarea name="obs_qualidade" id="obs_qualidade" class="form-control editorObs" rows="4" required>
                            <?php
                            if (isset($valorForm['obs_qualidade'])) {
                                echo $valorForm['obs_qualidade'];
                            }
                            ?>
                        </textarea>
                    </div>
                </div>
            <?php }
            ?>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadOrdem" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>

