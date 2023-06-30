<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($_FILES());
//var_dump($this->Dados['select']['adms_bandeira_id']);
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
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5 || $_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<select name="loja_id" id="loja_id" class="form-control is-invalid">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['loja_id'] as $lj) {
                            extract($lj);
                            if ($valorForm['loja_id'] == $loja_id) {
                                echo "<option value='$loja_id' selected>$loja</option>";
                            } else {
                                echo "<option value='$loja_id'>$loja</option>";
                            }
                        }
                        echo "</select>";
                    } else {
                        echo '<select name="loja_id" id="loja_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['loja_id'] as $lj) {
                            extract($lj);
                            if ($valorForm['loja_id'] == $loja_id) {
                                echo "<option value='$loja_id' selected>$loja</option>";
                            } else {
                                echo "<option value='$loja_id'>$loja</option>";
                            }
                        }
                        echo "</select>";
                    }
                    ?>

                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Consultora</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5 || $_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<select name="adms_func_id" id="adms_func_id" class="form-control is-invalid">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['adms_func_id'] as $fc) {
                            extract($fc);
                            if ($valorForm['adms_func_id'] == $adms_func_id) {
                                echo "<option value='$adms_func_id' selected>$func</option>";
                            } else {
                                echo "<option value='$adms_func_id'>$func</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="adms_func_id" id="adms_func_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['adms_func_id'] as $fc) {
                            extract($fc);
                            if ($valorForm['adms_func_id'] == $adms_func_id) {
                                echo "<option value='$adms_func_id' selected>$func</option>";
                            } else {
                                echo "<option value='$adms_func_id'>$func</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Cliente</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5 || $_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<input name="nome_cliente" type="text" class="form-control is-invalid" placeholder="Nome completo do Cliente" value="';
                        if (isset($valorForm['nome_cliente'])) {
                            echo $valorForm['nome_cliente'];
                        }
                    } else {
                        echo '<input name="nome_cliente" type="text" class="form-control is-valid" aria-label="Disabled input" disabled placeholder="Nome completo do Cliente" value ="';
                        if (isset($valorForm['nome_cliente'])) {
                            echo $valorForm['nome_cliente'];
                        }
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> CPF</label>
                    <input name="cpf_cliente" type="text" <?php
                    if (!isset($valorForm['cpf_cliente'])) {
                        echo 'id="cpf_cliente"';
                    } else {
                        echo 'id="cpf"';
                    }
                    echo ($_SESSION['adms_niveis_acesso_id'] == 5 || $_SESSION['adms_niveis_acesso_id'] == 1) ? '' : ' disabled';
                    ?> class="form-control<?php echo ($_SESSION['adms_niveis_acesso_id'] != 5 || $_SESSION['adms_niveis_acesso_id'] != 1) ? ' is-valid' : ' is-invalid'; ?>" placeholder="CPF do Cliente" value="<?php
                           if (isset($valorForm['cpf_cliente'])) {
                               echo $valorForm['cpf_cliente'];
                           }
                           ?>" autocomplete="off" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Valor Registrado</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5 || $_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<input name="valor_lancado" id="valor_lancado" type="text" class="form-control is-invalid" value="';
                        if (isset($valorForm['valor_lancado'])) {
                            echo $valorForm['valor_lancado'];
                        }
                    } else {
                        echo '<input name="valor_lancado" id="valor_lancado" type="text" class="form-control is-valid" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['valor_lancado'])) {
                            echo $valorForm['valor_lancado'];
                        }
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Valor Correto</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5 || $_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<input name="valor_correto" id="valor_correto" type="text" class="form-control is-invalid" value="';
                        if (isset($valorForm['valor_correto'])) {
                            echo $valorForm['valor_correto'];
                        }
                    } else {
                        echo '<input name="valor_correto" id="valor_correto" type="text" class="form-control is-valid" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['valor_correto'])) {
                            echo $valorForm['valor_correto'];
                        }
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Valor Estorno</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5 || $_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<input name="valor_estorno" id="valor_estorno" type="text" class="form-control is-invalid" value="';
                        if (isset($valorForm['valor_estorno'])) {
                            echo $valorForm['valor_estorno'];
                        }
                    } else {
                        echo '<input name="valor_estorno" id="valor_estorno" type="text" class="form-control is-valid" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['valor_estorno'])) {
                            echo $valorForm['valor_estorno'];
                        }
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Cupom - Nota Fiscal</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5 || $_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<input name="doc_nf" id="doc_nf" type="number" class="form-control is-invalid" value="';
                        if (isset($valorForm['doc_nf'])) {
                            echo $valorForm['doc_nf'];
                        }
                    } else {
                        echo '<input name="doc_nf" id="doc_nf" type="number" class="form-control is-valid" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['doc_nf'])) {
                            echo $valorForm['doc_nf'];
                        }
                    }
                    ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Forma de Pagamento</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5 || $_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<select name="tb_forma_pag_id" id="tb_forma_pag_id" class="form-control is-valid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['tb_forma_pag_id'] as $sit) {
                            extract($sit);
                            if ($valorForm['tb_forma_pag_id'] == $tb_forma_pag_id) {
                                echo "<option value='$tb_forma_pag_id' selected>$forma_pag</option>";
                            } else {
                                echo "<option value='$tb_forma_pag_id'>$forma_pag</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="tb_forma_pag_id" id="tb_forma_pag_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['tb_forma_pag_id'] as $sit) {
                            extract($sit);
                            if ($valorForm['tb_forma_pag_id'] == $tb_forma_pag_id) {
                                echo "<option value='$tb_forma_pag_id' selected>$forma_pag</option>";
                            } else {
                                echo "<option value='$tb_forma_pag_id'>$forma_pag</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Bandeiras</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5 || $_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<select name="adms_bandeira_id" id="adms_bandeira_id" class="form-control is-valid">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['adms_bandeira_id'] as $tpart) {
                            extract($tpart);
                            if (isset($valorForm['adms_bandeira_id']) == $adms_bandeira_id) {
                                echo "<option value='$adms_bandeira_id' selected>$bandeira</option>";
                            } else {
                                echo "<option value='$adms_bandeira_id'>$bandeira</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        ?>
                    <select name="adms_bandeira_id" id="adms_bandeira_id" class="form-control is-valid" aria-label="Disabled input" disabled>
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
                            echo '</select>';
                        }
                        ?>
                </div>
                <div class="form-group col-md-4">
                    <label> Parcelas</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5 || $_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<input name="qtd_parcelas" id="qtd_parcelas" type="number" class="form-control is-valid" value="';
                        if (isset($valorForm['qtd_parcelas']) && !empty($valorForm['qtd_parcelas'])) {
                            echo $valorForm['qtd_parcelas'];
                        }
                        echo '">';
                    } else {
                        echo '<input name="qtd_parcelas" id="qtd_parcelas" type="number" class="form-control is-valid" aria-label="Disabled input" value ="';
                        if (isset($valorForm['qtd_parcelas']) && !empty($valorForm['qtd_parcelas'])) {
                            echo $valorForm['qtd_parcelas'];
                        }
                        echo '" disabled>';
                    }
                    ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>NSU</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5 || $_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<input name="nsu" id="nsu" type="number" class="form-control" value="';
                        if (isset($valorForm['nsu'])) {
                            echo $valorForm['nsu'];
                        }
                    } else {
                        echo '<input name="nsu" id="nsu" type="number" class="form-control" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['nsu'])) {
                            echo $valorForm['nsu'];
                        }
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>Autorização Cartão</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5 || $_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<input name="auto_cartao" id="auto_cartao" type="number" class="form-control" value="';
                        if (isset($valorForm['auto_cartao'])) {
                            echo $valorForm['auto_cartao'];
                        }
                    } else {
                        echo '<input name="auto_cartao" id="auto_cartao" type="number" class="form-control" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['auto_cartao'])) {
                            echo $valorForm['auto_cartao'];
                        }
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Tipo de Estorno</label>                    
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5 || $_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<select name="adms_tps_est_id" id="adms_tps_est_id" class="form-control is-valid" required>';
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
                    } else {
                        echo '<select name="adms_tps_est_id" id="adms_tps_est_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
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
                    }
                    ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Motivo do Estorno</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5 || $_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<select name="adms_mot_est_id" id="adms_mot_est_id" class="form-control is-invalid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['id_mot'] as $mot) {
                            extract($mot);
                            if ($valorForm['adms_mot_est_id'] == $adms_mot_est_id) {
                                echo "<option value='$adms_mot_est_id' selected>$motivo</option>";
                            } else {
                                echo "<option value='$adms_mot_est_id'>$motivo</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="adms_mot_est_id" id="adms_mot_est_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['id_mot'] as $mot) {
                            extract($mot);
                            if ($valorForm['adms_mot_est_id'] == $adms_mot_est_id) {
                                echo "<option value='$adms_mot_est_id' selected>$motivo</option>";
                            } else {
                                echo "<option value='$adms_mot_est_id'>$motivo</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
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
                    <input name="file_antigo" type="hidden" value="<?php
                    if (isset($valorForm['file_antigo'])) {
                        echo $valorForm['file_antigo'];
                    } elseif (isset($valorForm['file_novo'])) {
                        echo $valorForm['file_novo'];
                    }
                    ?>">

                    <label><span class="text-danger">*</span> Novo Documento</label>
                    <input name="file_novo" type="file" class="custom-file">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Responsável</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<select name="adms_resp_aut_id" id="adms_resp_aut_id" class="form-control is-valid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['adms_resp_aut_id'] as $resp) {
                            extract($resp);
                            if ($valorForm['adms_resp_aut_id'] == $adms_resp_aut_id) {
                                echo "<option value='$adms_resp_aut_id' selected>$resp_aut</option>";
                            } else {
                                echo "<option value='$adms_resp_aut_id'>$resp_aut</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="adms_resp_aut_id" id="adms_resp_aut_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['adms_resp_aut_id'] as $resp) {
                            extract($resp);
                            if ($valorForm['adms_resp_aut_id'] == $adms_resp_aut_id) {
                                echo "<option value='$adms_resp_aut_id' selected>$resp_aut</option>";
                            } else {
                                echo "<option value='$adms_resp_aut_id'>$resp_aut</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
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
                    <textarea name="obs" id="editor" class="form-control editorCK" rows="3">
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
