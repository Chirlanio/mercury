<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Entrega</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_delivery']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'delivery/listar'; ?>" class="btn btn-outline-info btn-sm"><i class='fa-solid fa-list'></i></a>
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
        <form method="POST" action="" class="was-validated" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Loja</label>
                    <select name="loja_id" id="loja_id" class="form-control is-invalid" required autofocus>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['stores'] as $store) {
                            extract($store);
                            if (isset($valorForm['loja_id']) and $valorForm['loja_id'] == $l_id) {
                                echo "<option value='$l_id' selected>$name_store</option>";
                            } else {
                                echo "<option value='$l_id'>$name_store</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Gerente</label>
                    <select name="func_id" id="func_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['employees'] as $employee) {
                            extract($employee);
                            if (isset($valorForm['func_id']) and $valorForm['func_id'] == $f_id) {
                                echo "<option value='$f_id' selected>$func</option>";
                            } else {
                                echo "<option value='$f_id'>$func</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Cliente</label>
                    <input name="cliente" type="text" class="form-control is-invalid" placeholder="Nome do Cliente" value="<?php
                    if (isset($valorForm['cliente'])) {
                        echo $valorForm['cliente'];
                    }
                    ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Endereço</label>
                    <input name="endereco" type="text" class="form-control is-invalid" placeholder="Exemplo: Rua A, 01" value="<?php
                    if (isset($valorForm['endereco'])) {
                        echo $valorForm['endereco'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Bairro</label>
                    <select name="bairro_id" id="bairro_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['neighborhoods'] as $neighborhood) {
                            extract($neighborhood);
                            if (isset($valorForm['bairro_id']) and $valorForm['bairro_id'] == $b_id) {
                                echo "<option value='$b_id' selected>$nome_bairro</option>";
                            } else {
                                echo "<option value='$b_id'>$nome_bairro</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <input name="rota_id" type="hidden" value="5">
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Contato</label>
                    <input name="contato" id="contact" type="tel" class="form-control is-invalid" placeholder="85 99999-8888" value="<?php
                    if (isset($valorForm['contato'])) {
                        echo $valorForm['contato'];
                    }
                    ?>" autocomplete="off" required>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Valor da Venda</label>
                    <input name="valor_venda" type="text" id="valor_lancado" class="form-control is-invalid" placeholder="99,90" value="<?php
                    if (isset($valorForm['valor_venda'])) {
                        echo $valorForm['valor_venda'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Troca</label>
                    <select name="troca" id="troca" class="form-control is-invalid" required>
                        <?php
                        if (isset($valorForm['troca']) and $valorForm['troca'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } elseif (isset($valorForm['troca']) and $valorForm['troca'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2' selected>Não</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Forma de Pagamento</label>
                    <select name="forma_pag_id" id="forma_pag_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['payments'] as $payment) {
                            extract($payment);
                            if (isset($valorForm['forma_pag_id']) and $valorForm['forma_pag_id'] == $p_id) {
                                echo "<option value='$p_id' selected>$type_pay</option>";
                            } else {
                                echo "<option value='$p_id'>$type_pay</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Parcelas</label>
                    <select name="parcelas" id="troca" class="form-control is-invalid" required>
                        <?php
                        if (isset($valorForm['parcelas']) and $valorForm['parcelas'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>1X</option>";
                            echo "<option value='2'>2X</option>";
                            echo "<option value='3'>3X</option>";
                            echo "<option value='4'>4X</option>";
                            echo "<option value='5'>5X</option>";
                            echo "<option value='6'>6X</option>";
                        } elseif (isset($valorForm['parcelas']) and $valorForm['parcelas'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>1X</option>";
                            echo "<option value='2' selected>2X</option>";
                            echo "<option value='3'>3X</option>";
                            echo "<option value='4'>4X</option>";
                            echo "<option value='5'>5X</option>";
                            echo "<option value='6'>6X</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>1X</option>";
                            echo "<option value='2'>2X</option>";
                            echo "<option value='3'>3X</option>";
                            echo "<option value='4'>4X</option>";
                            echo "<option value='5'>5X</option>";
                            echo "<option value='6'>6X</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Nota Fiscal</label>
                    <input name="nf" type="number" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['nf'])) {
                        echo $valorForm['nf'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Maquineta</label>
                    <select name="maq" id="maq" class="form-control is-invalid" required>
                        <?php
                        if (isset($valorForm['maq']) and $valorForm['maq'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } elseif (isset($valorForm['maq']) and $valorForm['maq'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2' selected>Não</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Presente</label>
                    <select name="presente" id="presente" class="form-control is-invalid" required>
                        <?php
                        if (isset($valorForm['presente']) and $valorForm['presente'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } elseif (isset($valorForm['presente']) and $valorForm['presente'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2' selected>Não</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label>Observação</label>
                    <input name="obs" class="form-control" value="<?php
                    if (isset($valorForm['obs'])) {
                        echo $valorForm['obs'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-3">
                    <label>Recebido Por</label>
                    <input name="recebido" class="form-control" value="<?php
                    if (isset($valorForm['recebido'])) {
                        echo $valorForm['recebido'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-2">
                    <label>Total de Produtos</label>
                    <input name="qtde_produto" type="number" class="form-control" value="<?php
                    if (isset($valorForm['qtde_produto'])) {
                        echo $valorForm['qtde_produto'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Ponto de Saída</label>
                    <select name="ponto_saida" id="ponto_saida" class="form-control is-invalid" required>
                        <?php
                        if (isset($valorForm['ponto_saida']) and $valorForm['ponto_saida'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Loja</option>";
                            echo "<option value='2'>CD</option>";
                        } elseif (isset($valorForm['ponto_saida']) and $valorForm['ponto_saida'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Loja</option>";
                            echo "<option value='2' selected>CD</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Loja</option>";
                            echo "<option value='2'>CD</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadDelivery" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>