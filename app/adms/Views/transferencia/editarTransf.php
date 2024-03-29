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
                <h2 class="display-4 titulo">Editar Transferências</h2>
            </div>
            <span class="d-none d-md-block">
                <?php
                if ($this->Dados['botao']['list_transf']) {
                    echo "<a href='" . URLADM . "transferencia/listar-transf' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                }
                if ($this->Dados['botao']['vis_transf']) {
                    echo "<a href='" . URLADM . "ver-transf/ver-transf/{$valorForm['id']}' class='btn btn-outline-primary btn-sm'><i class='fa-solid fa-eye'></i></a> ";
                }
                ?>
            </span>
        </div>
        <hr>
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
                <div class="form-group col-md-5">
                    <label><span class="text-danger">*</span> Loja - Origem</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        echo '<input name="loja_ori" type="text" class="form-control" aria-label="Disabled input" disabled placeholder="Loja de origem" value="';
                        if (isset($valorForm['loja_ori'])) {
                            echo $valorForm['loja_ori'];
                        }
                        echo '">';
                    } else {
                        echo "<select name='loja_origem_id' id='loja_destino_id' class='custom-select'>";
                        echo "<option value = ''>Selecione</option>";
                        foreach ($this->Dados['select']['loja_origem_id'] as $lo) {
                            extract($lo);
                            if ($valorForm['loja_origem_id'] == $loja_id) {
                                echo "<option value='$loja_id' selected>$loja_orig</option>";
                            } else {
                                echo "<option value='$loja_id'>$loja_orig</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>
                <div class="form-group col-md-5">
                    <label><span class = "text-danger">*</span> Loja - Destino</label>
                    <?php
                    if (($_SESSION['adms_niveis_acesso_id'] == 4) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
                        echo '<input name="loja_destino_id" type="text" class="form-control" aria-label="Disabled input" disabled placeholder="Loja de origem" value="';
                        if (isset($valorForm['loja_dest'])) {
                            echo $valorForm['loja_dest'];
                        }
                        echo '">';
                    } else if (($_SESSION['adms_niveis_acesso_id'] == 5 and $valorForm['status_id'] != 1)) {
                        echo '<input name="loja_destino_id" type="text" class="form-control" aria-label="Disabled input" disabled placeholder="Loja de origem" value="';
                        if (isset($valorForm['loja_dest'])) {
                            echo $valorForm['loja_dest'];
                        }
                        echo '">';
                    } else {
                        echo "<select name='loja_destino_id' id='loja_destino_id' class='custom-select'>";
                        echo "<option value = ''>Selecione</option>";
                        foreach ($this->Dados['select']['loja_destino_id'] as $ld) {
                            extract($ld);
                            if ($valorForm['loja_destino_id'] == $loja_id) {
                                echo "<option value='$loja_id' selected>$loja_dest</option>";
                            } else {
                                echo "<option value='$loja_id'>$loja_dest</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span>Nota Fiscal</label>
                    <?php
                    if (($_SESSION['adms_niveis_acesso_id'] == 4) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
                        echo '<input name="nf" type="number" class="form-control" aria-label="Disabled input" disabled placeholder="Nota fiscal" value="';
                        if (isset($valorForm['nf'])) {
                            echo $valorForm['nf'];
                        }
                        echo '">';
                    } else if (($_SESSION['adms_niveis_acesso_id'] == 5 and $valorForm['status_id'] != 1)) {
                        echo '<input name="nf" type="text" class="form-control" aria-label="Disabled input" disabled placeholder="Nota fiscal" value="';
                        if (isset($valorForm['nf'])) {
                            echo $valorForm['nf'];
                        }
                        echo '">';
                    } else {
                        echo '<input name="nf" type="number" class="form-control" placeholder="Nota fiscal" value="';
                        if (isset($valorForm['nf'])) {
                            echo $valorForm['nf'];
                        }
                        echo '">';
                    }
                    ?>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Volumes</label>
                    <?php
                    if (($_SESSION['adms_niveis_acesso_id'] == 4) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
                        echo '<input name="qtd_vol" type="number" class="form-control" aria-label="Disabled input" disabled placeholder="Qtd de Volumes" value="';
                        if (isset($valorForm['qtd_vol'])) {
                            echo $valorForm['qtd_vol'];
                        }
                        echo '">';
                    } else if (($_SESSION['adms_niveis_acesso_id'] == 5 and $valorForm['status_id'] != 1)) {
                        echo '<input name="qtd_vol" type="text" class="form-control" aria-label="Disabled input" disabled placeholder="Qtd de Volumes" value="';
                        if (isset($valorForm['qtd_vol'])) {
                            echo $valorForm['qtd_vol'];
                        }
                        echo '">';
                    } else {
                        echo '<input name="qtd_vol" type="number" class="form-control" placeholder="Qtd de Volumes" value="';
                        if (isset($valorForm['qtd_vol'])) {
                            echo $valorForm['qtd_vol'];
                        }
                        echo '">';
                    }
                    ?>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Qtd Prudutos</label>
                    <?php
                    if (($_SESSION['adms_niveis_acesso_id'] == 4) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
                        echo '<input name="qtd_prod" type="number" class="form-control" aria-label="Disabled input" disabled placeholder="Qtd de produtos" value="';
                        if (isset($valorForm['qtd_prod'])) {
                            echo $valorForm['qtd_prod'];
                        }
                        echo '">';
                    } else if (($_SESSION['adms_niveis_acesso_id'] == 5 and $valorForm['status_id'] != 1)) {
                        echo '<input name="qtd_prod" type="text" class="form-control" aria-label="Disabled input" disabled placeholder="Qtd de Produtos" value="';
                        if (isset($valorForm['qtd_prod'])) {
                            echo $valorForm['qtd_prod'];
                        }
                        echo '">';
                    } else {
                        echo '<input name="qtd_prod" type="number" class="form-control" placeholder="Qtd de Produtos" value="';
                        if (isset($valorForm['qtd_prod'])) {
                            echo $valorForm['qtd_prod'];
                        }
                        echo '">';
                    }
                    ?>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Tipo</label>
                    <?php
                    if (($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
                        echo '<select name="tipo_transf_id" id="tipo_transf_id" class="custom-select" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['tipo_transf_id'] as $t) {
                            extract($t);
                            if ($valorForm['tipo_transf_id'] == $id_tipo) {
                                echo "<option value='$id_tipo' selected>$tipo</option>";
                            } else {
                                echo "<option value='$id_tipo'>$tipo</option>";
                            }
                        }
                    } else {
                        echo '<select name="tipo_transf_id" id="tipo_transf_id" class="custom-select">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['tipo_transf_id'] as $t) {
                            extract($t);
                            if ($valorForm['tipo_transf_id'] == $id_tipo) {
                                echo "<option value='$id_tipo' selected>$tipo</option>";
                            } else {
                                echo "<option value='$id_tipo'>$tipo</option>";
                            }
                        }
                    }
                    ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <?php
                    if (($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 4)) {
                        if ($valorForm['status_id'] != 1 or $valorForm['status_id'] == 3) {
                            echo '<select name="status_id" id="status_id" class="custom-select" aria-label="Disabled input" disabled>';
                            echo '<option value="">Selecione</option>';
                            foreach ($this->Dados['select']['status_id'] as $s) {
                                extract($s);
                                if ($valorForm['status_id'] == $id_sit) {
                                    echo "<option value='$id_sit' selected>$sit</option>";
                                } else {
                                    echo "<option value='$id_sit'>$sit</option>";
                                }
                            }
                        } else if ($_SESSION['adms_niveis_acesso_id'] == 5) {
                            echo '<select name="status_id" id="status_id" class="custom-select" aria-label="Disabled input" disabled>';
                            echo '<option value="">Selecione</option>';
                            foreach ($this->Dados['select']['status_id'] as $s) {
                                extract($s);
                                if ($valorForm['status_id'] == $id_sit) {
                                    echo "<option value='$id_sit' selected>$sit</option>";
                                } else {
                                    echo "<option value='$id_sit'>$sit</option>";
                                }
                            }
                        } else {
                            echo '<select name="status_id" id="status_id" class="custom-select">';
                            echo '<option value="">Selecione</option>';
                            foreach ($this->Dados['select']['status_id'] as $s) {
                                extract($s);
                                if ($valorForm['status_id'] == $id_sit) {
                                    echo "<option value='$id_sit' selected>$sit</option>";
                                } else {
                                    echo "<option value='$id_sit'>$sit</option>";
                                }
                            }
                        }
                    } else {
                        if ($valorForm['status_id'] >= 3) {
                            if (($_SESSION['adms_niveis_acesso_id'] == 4) OR ($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
                                echo '<select name="status_id" id="status_id" class="custom-select" aria-label="Disabled input" disabled>';
                                echo '<option value="">Selecione</option>';
                                foreach ($this->Dados['select']['status_id'] as $s) {
                                    extract($s);
                                    if ($valorForm['status_id'] == $id_sit) {
                                        echo "<option value='$id_sit' selected>$sit</option>";
                                    } else {
                                        echo "<option value='$id_sit'>$sit</option>";
                                    }
                                }
                            } else {
                                echo '<select name="status_id" id="status_id" class="custom-select"';
                                echo '<option value="">Selecione</option>';
                                foreach ($this->Dados['select']['status_id'] as $s) {
                                    extract($s);
                                    if ($valorForm['status_id'] == $id_sit) {
                                        echo "<option value='$id_sit' selected>$sit</option>";
                                    } else {
                                        echo "<option value='$id_sit'>$sit</option>";
                                    }
                                }
                            }
                        } else {
                            echo '<select name="status_id" id="status_id" class="custom-select">';
                            echo '<option value="">Selecione</option>';
                            foreach ($this->Dados['select']['status_id'] as $s) {
                                extract($s);
                                if ($valorForm['status_id'] == $id_sit) {
                                    echo "<option value='$id_sit' selected>$sit</option>";
                                } else {
                                    echo "<option value='$id_sit'>$sit</option>";
                                }
                            }
                        }
                    }
                    ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <?php
                    //input para colocar o nome de quem recebeu a entrega
                    if (($_SESSION['adms_niveis_acesso_id'] == 4) OR ($_SESSION['adms_niveis_acesso_id'] == 5)) {
                        echo " <label><span class='text-danger'>*</span> Recebido Por:</label>";
                        echo '<input name="recebido" type="text" class="form-control" aria-label="Disabled input" disabled placeholder="Digite o nome de quem recebeu" value="';
                        if (isset($valorForm['recebido'])) {
                            echo $valorForm['recebido'];
                        }
                        echo '">';
                    } else {
                        if ($valorForm['status_id'] >= 3) {
                            if (($_SESSION['adms_niveis_acesso_id'] == 4) OR ($_SESSION['adms_niveis_acesso_id'] == 5)) {
                                if ($_SESSION['adms_niveis_acesso_id'] == 1) {
                                    echo " <label><span class='text-danger'>*</span> Recebido Por:</label>";
                                    echo '<input name="recebido" type="text" class="form-control" placeholder="Digite o nome de quem recebeu" value="';
                                    if (isset($valorForm['recebido'])) {
                                        echo $valorForm['recebido'];
                                    }
                                    echo '">';
                                } else {
                                    echo " <label><span class='text-danger'>*</span> Recebido Por:</label>";
                                    echo '<input name="recebido" type="text" class="form-control" aria-label="Disabled input" disabled placeholder="Digite o nome de quem recebeu" value="';
                                    if (isset($valorForm['recebido'])) {
                                        echo $valorForm['recebido'];
                                    }
                                    echo '">';
                                }
                                echo '">';
                            } else {
                                if ($_SESSION['adms_niveis_acesso_id'] == 1) {
                                    echo " <label><span class='text-danger'>*</span> Recebido Por:</label>";
                                    echo '<input name="recebido" type="text" class="form-control" placeholder="Digite o nome de quem recebeu" value="';
                                    if (isset($valorForm['recebido'])) {
                                        echo $valorForm['recebido'];
                                    }
                                    echo '">';
                                } else {
                                    echo " <label><span class='text-danger'>*</span> Recebido Por:</label>";
                                    echo '<input name="recebido" type="text" class="form-control" aria-label="Disabled input" disabled placeholder="Digite o nome de quem recebeu" value="';
                                    if (isset($valorForm['recebido'])) {
                                        echo $valorForm['recebido'];
                                    }
                                    echo '">';
                                }
                            }
                        } else {
                            echo " <label><span class='text-danger'>*</span> Recebido Por:</label>";
                            echo '<input name="recebido" type="text" class="form-control" placeholder="Digite o nome de quem recebeu" value="';
                            if (isset($valorForm['recebido'])) {
                                echo $valorForm['recebido'];
                            }
                            echo '">';
                        }
                    }
                    ?>
                </div>
                <?php
                if (($valorForm['status_id'] == 3 and $_SESSION['usuario_loja'] == $valorForm['loja_destino_id'] )or $_SESSION['adms_niveis_acesso_id'] <= 3) {
                    ?>
                    <div class="form-group col-md-4">
                        <?php
                        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['ordem_nivac'] == STOREPERMITION) {
                            echo "<label><span class='text-danger'>*</span> Confirma recebimento?</label>";
                            if ($valorForm['confirma_receb'] != 1 || $_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
                                echo "<select name='confirma_receb' id='confirma_receb' class='custom-select'>";
                                if ($valorForm['confirma_receb'] == 1) {
                                    echo "<option value=''>Selecione</option>";
                                    echo "<option value='1' selected>Sim</option>";
                                    echo "<option value='2'>Não</option>";
                                } elseif ($valorForm['confirma_receb'] == 2) {
                                    echo "<option value=''>Selecione</option>";
                                    echo "<option value='1'>Sim</option>";
                                    echo "<option value='2' selected>Não</option>";
                                } else {
                                    echo "<option value='' selected>Selecione...</option>";
                                    echo "<option value='1'>Sim</option>";
                                    echo "<option value='2'>Não</option>";
                                }
                                echo "</select>";
                            } else {
                                echo '<input name="confirma_receb" type="text" class="form-control" aria-label="Disabled input" disabled value="';
                                if (isset($valorForm['confirma_receb'])) {
                                    if ($valorForm['confirma_receb'] == 1) {
                                        echo "Sim";
                                    } else {
                                        echo "Não";
                                    }
                                }
                                echo '">';
                            }
                        }
                        ?>
                    </div>
                <?php } ?>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditTransf" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
