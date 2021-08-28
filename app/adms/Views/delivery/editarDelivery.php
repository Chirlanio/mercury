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
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Delivery</h2>
            </div>
            <?php
            if ($this->Dados['botao']['vis_delivery']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ver-delivery/ver-delivery/' . $valorForm['id']; ?>" class="btn btn-outline-info btn-sm">Visualizar</a>
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
        <form method="POST" action="" enctype="multipart/form-data"> 
            <input name="id" type="hidden" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Loja</label>
                    <select name="loja_id" id="loja_id" class="form-control" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['loja'] as $lj) {
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
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Gerente</label>
                    <select name="func_id" id="func_id" class="form-control" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['func'] as $fu) {
                            extract($fu);
                            if ($valorForm['func_id'] == $func_id) {
                                echo "<option value='$func_id' selected>$func</option>";
                            } else {
                                echo "<option value='$func_id'>$func</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Cliente</label>
                    <input name="cliente" type="text" class="form-control" placeholder="Nome do Cliente" value="<?php
                    if (isset($valorForm['cliente'])) {
                        echo $valorForm['cliente'];
                    }
                    ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Endereço</label>
                    <input name="endereco" type="text" class="form-control" placeholder="Rua A, 01" value="<?php
                    if (isset($valorForm['endereco'])) {
                        echo $valorForm['endereco'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Bairro</label>
                    <select name="bairro_id" id="bairro_id" class="form-control" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['bairro'] as $ba) {
                            extract($ba);
                            if ($valorForm['bairro_id'] == $bairro_id) {
                                echo "<option value='$bairro_id' selected>$bairro</option>";
                            } else {
                                echo "<option value='$bairro_id'>$bairro</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Rota</label>
                    <select name="rota_id" id="rota_id" class="form-control" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['rota'] as $ba) {
                            extract($ba);
                            if ($valorForm['rota_id'] == $rota_id) {
                                echo "<option value='$rota_id' selected>$rota</option>";
                            } else {
                                echo "<option value='$rota_id'>$rota</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Contato</label>
                    <input name="contato" type="text" class="form-control" placeholder="85 99999-8888" value="<?php
                    if (isset($valorForm['contato'])) {
                        echo $valorForm['contato'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Valor da Venda</label>
                    <input name="valor_venda" type="text" class="form-control" placeholder="99,90" value="<?php
                    if (isset($valorForm['valor_venda'])) {
                        echo $valorForm['valor_venda'];
                    }
                    ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Troca</label>
                    <select name="troca" id="troca" class="form-control" required>
                        <?php
                        if ($valorForm['troca'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } elseif ($valorForm['troca'] == 2) {
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
                    <label><span class="text-danger">*</span> Forma de Pagamento</label>
                    <select name="forma_pag_id" id="forma_pag_id" class="form-control" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['pag'] as $pag) {
                            extract($pag);
                            if ($valorForm['f_id'] == $forma_pag_id) {
                                echo "<option value='$f_id' selected>$forma</option>";
                            } else {
                                echo "<option value='$f_id'>$forma</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Parcelas</label>
                    <select name="parcelas" id="troca" class="form-control" required>
                        <?php
                        if ($valorForm['parcelas'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>1X</option>";
                            echo "<option value='2'>2X</option>";
                            echo "<option value='3'>3X</option>";
                            echo "<option value='4'>4X</option>";
                            echo "<option value='5'>5X</option>";
                            echo "<option value='6'>6X</option>";
                        } elseif ($valorForm['troca'] == 2) {
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
                    <input name="nf" type="number" class="form-control" value="<?php
                    if (isset($valorForm['nf'])) {
                        echo $valorForm['nf'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Maquineta</label>
                    <select name="maq" id="maq" class="form-control" required>
                        <?php
                        if ($valorForm['maq'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } elseif ($valorForm['maq'] == 2) {
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
                    <label>Pedido - Prateleira</label>
                    <select name="ped_id" id="ped_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['prat'] as $pag) {
                            extract($pag);
                            if ($valorForm['ped_id'] == $ped_id) {
                                echo "<option value='$ped_id' selected>" . $ped_id . " - " . $loja_ped . "</option>";
                            } else {
                                echo "<option value='$ped_id'>" . $ped_id . " - " . $loja_ped . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!-- Aqui começa a grade da referência com saldo insuficiente-->
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Observação</label>
                    <input name="obs" class="form-control" value="<?php
                    if (isset($valorForm['obs'])) {
                        echo $valorForm['obs'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-2">
                    <label>Recebido Por</label>
                    <input name="recebido" class="form-control" value="<?php
                    if (isset($valorForm['recebido'])) {
                        echo $valorForm['recebido'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Ponto de Saída</label>
                    <select name="ponto_saida" id="ponto_saida" class="form-control" required>
                        <?php
                        if ($valorForm['ponto_saida'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Loja</option>";
                            echo "<option value='2'>CD</option>";
                        } elseif ($valorForm['ponto_saida'] == 2) {
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
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Presente</label>
                    <select name="presente" id="presente" class="form-control" required>
                        <?php
                        if ($valorForm['presente'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } elseif ($valorForm['presente'] == 2) {
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
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="status_id" id="statud_id" class="form-control" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sit'] as $pag) {
                            extract($pag);
                            if ($valorForm['s_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$s_id'>$sit</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <input name="modified" type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>">
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditDelivery" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
