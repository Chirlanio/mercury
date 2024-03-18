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
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Movimentação de Pessoal</h2>
            </div>
            <span class="d-none d-md-block">
                <?php
                if ($this->Dados['botao']['list_moviment']) {
                    echo "<a href='" . URLADM . "personnel-moviments/list' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                }
                if ($this->Dados['botao']['view_moviment']) {
                    echo "<a href='" . URLADM . "view-personnel-moviments/view-moviment/{$valorForm['id']}' class='btn btn-outline-primary btn-sm'><i class='fa-solid fa-eye'></i></a> ";
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
        <form method="POST" action="" enctype="multipart/form-data" class="was-validated">
            <div class="row">
                <input name="id" type="hidden" value="<?php
                if (!empty($valorForm['id'])) {
                    echo $valorForm['id'];
                }
                ?>" >
                <div class="col-md-3 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="mb-3">Acompanhamento</span>
                    </h4>
                    <ul class="list-group border border-dark mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-condensed</table>">
                            <div class="my-2">
                                <h6 class="my-2">Cargo Atual</h6>
                                <small class="lead"><?php echo $valorForm['office_name']; ?></small>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-2">Data do Desligamento:</h6>
                                <input class="form-control is-invalid col-12" type='date' value="<?php echo $valorForm['last_day_worked']; ?>">
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-condenced">
                            <div class="my-2">
                                <h6 class="my-2">O que precisa ser devolvido?</h6>
                                <small style="font-size: 15px;">
                                    <div class="form-group d-block mr-2">
                                        <div class="form-group form-check">
                                            <input name="uniform" type="checkbox" class="form-check-input" id="uniform" value="1" <?php echo (isset($valorForm['uniform']) and $valorForm['uniform'] == 1) ? "checked" : ""; ?> />
                                            <label class="form-check-label" for="uniform">Farda</label>
                                        </div>
                                        <div class="form-group form-check">
                                            <input name="chip_phone" type="checkbox" class="form-check-input" id="chip_phone" value="1" <?php echo (isset($valorForm['phone_chip']) and $valorForm['phone_chip'] == 1) ? "checked" : ""; ?> />
                                            <label class="form-check-label" for="chip_phone">Chip</label>
                                        </div>
                                        <div class="form-group form-check">
                                            <input name="original_card" type="checkbox" class="form-check-input" id="original_card" value="1" <?php echo (isset($valorForm['original_card']) and $valorForm['original_card'] == 1) ? "checked" : ""; ?> />
                                            <label class="form-check-label" for="original_card">Carta Original</label>
                                        </div>
                                        <div class="form-group form-check">
                                            <input name="aso" type="checkbox" class="form-check-input" id="aso" value="1" <?php echo (isset($valorForm['aso_resigns']) and $valorForm['aso_resigns'] == 1) ? "checked" : ""; ?> />
                                            <label class="form-check-label" for="aso">ASO</label>
                                        </div>
                                    </div>
                                </small>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div class="my-2">
                                <h6 class="my-2">Data assinatura TRCT</h6>
                                <small class="text-muted lead"><?php echo date("d/m/Y", strtotime($valorForm['signature_date_trct'])); ?></small>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div class="my-2">
                                <h6 class="my-2">ASO Demissional</h6>
                                <div class="d-block my-3">
                                    <div class="custom-control custom-radio">
                                        <input id="aso_resignsYes" name="aso_resigns" type="radio" class="custom-control-input is-invalid" value="1" <?php echo $valorForm['aso_resigns'] == 1 ? "checked" : ""; ?> required>
                                        <label class="custom-control-label" for="aso_resignsYes">Não</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="aso_resignsNo" name="aso_resigns" type="radio" class="custom-control-input is-invalid" value="2" <?php echo $valorForm['aso_resigns'] == 2 ? "checked" : ""; ?> required>
                                        <label class="custom-control-label" for="aso_resignsNo">Sim</label>
                                    </div>
                                </div>
                            </div>
                            <div class="my-2">
                                <h6 class="my-2">Guia ASO Demissional</h6>
                                <div class="d-block my-3">
                                    <div class="custom-control custom-radio">
                                        <input id="send_aso_guideYes" name="send_aso_guide" type="radio" class="custom-control-input is-invalid" value="1" <?php echo $valorForm['send_aso_guide'] == 1 ? "checked" : ""; ?> required>
                                        <label class="custom-control-label" for="send_aso_guideYes">Pendente</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="send_aso_guideNo" name="send_aso_guide" type="radio" class="custom-control-input is-invalid" value="2" <?php echo $valorForm['send_aso_guide'] == 2 ? "checked" : ""; ?> required>
                                        <label class="custom-control-label" for="send_aso_guideNo">Enviado</label>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-2">Atualizado Por:</h6>
                                <small class="text-muted lead" ><?php echo (!empty($valorForm['updated_by']) ? $valorForm['updated_by'] : ""); ?></small>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-2">Situação:</h6>
                                <small class="badge badge-<?php echo $valorForm['cor']; ?> badge-pill lead"><?php echo $valorForm['status']; ?></small>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-2">Cadastrado</h6>
                                <small class="lead"><?php echo date('d/m/Y H:i:s', strtotime($valorForm['created'])); ?></small>
                                <small class="lead"><?php
                                    if (!empty($modified)) {
                                        echo '<h6 class="my-2">Atualizado</h6>';
                                        echo date('d/m/Y H:i:s', strtotime($valorForm['modified']));
                                    }
                                    ?>
                                </small>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="col-md-9 order-md-1">
                    <h4 class="mb-3">Dados da Movimentação</h4>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label><span class="text-danger">*</span> Loja</label>
                            <select name="adms_loja_id" id="adms_loja_id" class="form-control is-invalid" required autofocus>
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->Dados['select']['store'] as $stp) {
                                    extract($stp);
                                    if (isset($valorForm['adms_loja_id']) and $valorForm['adms_loja_id'] == $s_id) {
                                        echo "<option value='$s_id' selected>$store</option>";
                                    } else {
                                        echo "<option value='$s_id'>$store</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label><span class="text-danger">*</span> Colaborador</label>
                            <select name="adms_employee_id" id="adms_employee_id" class="form-control is-invalid" required>
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->Dados['select']['employee'] as $fc) {
                                    extract($fc);
                                    if (isset($valorForm['adms_employee_id']) and $valorForm['adms_employee_id'] == $f_id) {
                                        echo "<option value='$f_id' selected>$colaborador</option>";
                                    } else {
                                        echo "<option value='$f_id'>$colaborador</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="last_day_worked"><span class="text-danger">*</span> Último Dia Trabalhado</label>
                            <input name="last_day_worked" type="date" id="last_day_worked" class="form-control is-invalid" value="<?php
                            if (isset($valorForm['last_day_worked'])) {
                                echo $valorForm['last_day_worked'];
                            }
                            ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="border border-dark rounded p-3">
                                <label class="mb-2"><span class="text-danger">*</span> Vínculo Contrato</label>
                                <div class="form-group d-block">
                                    <div class="custom-control custom-radio mr-2">
                                        <input id="efetivo" name="adms_employee_relation_id" type="radio" class="custom-control-input is-invalid" value="1" required <?php echo (isset($valorForm['adms_employee_relation_id']) and $valorForm['adms_employee_relation_id'] == 1) ? "checked" : ""; ?>>
                                        <label class="custom-control-label mr-2" for="efetivo">Colaborador efetivo</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="experiencia" name="adms_employee_relation_id" type="radio" class="custom-control-input" value="2" required <?php echo (isset($valorForm['adms_employee_relation_id']) and $valorForm['adms_employee_relation_id'] == 2) ? "checked" : ""; ?>>
                                        <label class="custom-control-label mr-2" for="experiencia">Colaborador em experiência</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="estagio" name="adms_employee_relation_id" type="radio" class="custom-control-input" value="3" required <?php echo (isset($valorForm['adms_employee_relation_id']) and $valorForm['adms_employee_relation_id'] == 3) ? "checked" : ""; ?>>
                                        <label class="custom-control-label mr-2" for="estagio">Estagiário</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="aprendiz" name="adms_employee_relation_id" type="radio" class="custom-control-input" value="4" required <?php echo (isset($valorForm['adms_employee_relation_id']) and $valorForm['adms_employee_relation_id'] == 4) ? "checked" : ""; ?>>
                                        <label class="custom-control-label mr-2" for="aprendiz">Jovem aprendiz</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="border border-dark rounded h-100 p-3">
                                <label class="mb-2"><span class="text-danger">*</span> Motivo</label>
                                <div class="form-group d-flex">
                                    <div class="custom-control custom-radio mr-2">
                                        <input id="iniciativa" name="adms_resignation_id" type="radio" class="custom-control-input" value="1" required <?php echo (isset($valorForm['adms_resignation_id']) and $valorForm['adms_resignation_id'] == 1) ? "checked" : ""; ?>>
                                        <label class="custom-control-label mr-2" for="iniciativa">Iniciativa Empresa</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="pedido" name="adms_resignation_id" type="radio" class="custom-control-input" value="2" required <?php echo (isset($valorForm['adms_resignation_id']) and $valorForm['adms_resignation_id'] == 2) ? "checked" : ""; ?>>
                                        <label class="custom-control-label mr-2" for="pedido">Pedido de Demissão</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="termino" name="adms_resignation_id" type="radio" class="custom-control-input" value="3" required <?php echo (isset($valorForm['adms_resignation_id']) and $valorForm['adms_resignation_id'] == 3) ? "checked" : ""; ?>>
                                        <label class="custom-control-label mr-2" for="termino">Termino de Contrato</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <div class="border border-dark rounded p-3">
                                <label class="mb-2"><span class="text-danger">*</span> Aviso Prévio</label>
                                <div class="form-group d-block">
                                    <div class="custom-control custom-radio mr-2">
                                        <input id="worked" name="early_warning_id" type="radio" class="custom-control-input" value="1" required <?php echo (isset($valorForm['early_warning_id']) and $valorForm['early_warning_id'] == 1) ? "checked" : ""; ?>>
                                        <label class="custom-control-label mr-2" for="worked" aria-describedby="workedHelp">Trabalhado</label>
                                        <small id="workedHelp" class="form-text text-muted">Colaborador cumprirá os 30 dias.</small>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="indenizado" name="early_warning_id" type="radio" class="custom-control-input" value="2" required <?php echo (isset($valorForm['early_warning_id']) and $valorForm['early_warning_id'] == 2) ? "checked" : ""; ?>>
                                        <label class="custom-control-label mr-2" for="indenizado" aria-describedby="workedHelp">Indenizado</label>
                                        <small id="workedHelp" class="form-text text-muted">Pagar ao Colaborador/Empresa.</small>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="noPayment" name="early_warning_id" type="radio" class="custom-control-input" value="3" required <?php echo (isset($valorForm['early_warning_id']) and $valorForm['early_warning_id'] == 3) ? "checked" : ""; ?>>
                                        <label class="custom-control-label mr-2" for="noPayment" aria-describedby="workedHelp">Contrato de experiência</label>
                                        <small id="workedHelp" class="form-text text-muted">Sem pagamento de aviso.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <div class="border border-dark rounded p-3">
                                <label class="mb-2">Informações para DP:</label>
                                <div class="form-group col-md-4">
                                    <div class="form-group d-block">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <?php
                                                    $fouls = 1;
                                                    if (isset($valorForm['fouls']) and $valorForm['fouls'] == 2) {
                                                        $fouls = 2;
                                                    }
                                                    if (isset($valorForm['totalFouls']) and !empty($valorForm['totalFouls'])) {
                                                        $totalFouls = $valorForm['totalFouls'];
                                                    }
                                                    ?>
                                                    <input name="fouls" id="fouls" type="checkbox" class="mr-2" aria-label="fouls" value="<?php echo $fouls; ?>" <?php echo ($fouls == 2) ? "checked" : ""; ?>>
                                                    <label class="form-check-label" for="fouls">Faltas</label>
                                                </div>
                                            </div>
                                            <input name="totalFouls" id="totalFouls" type="number" class="form-control text-center" placeholder="Qtde de faltas" value="<?php echo (isset($totalFouls) and !empty($totalFouls)) ? $totalFouls : ""; ?>" <?php echo ($fouls == 2) ? "" : "disabled"; ?>>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <?php
                                                    $days_off = 1;
                                                    if (isset($valorForm['days_off']) and $valorForm['days_off'] == 2) {
                                                        $days_off = 2;
                                                    }
                                                    if (isset($valorForm['totalDaysOff']) and !empty($valorForm['totalDaysOff'])) {
                                                        $totalDaysOff = $valorForm['totalDaysOff'];
                                                    }
                                                    ?>
                                                    <input name="days_off" id="days_off" type="checkbox" class="mr-2" aria-label="days_off" value="<?php echo $days_off; ?>" <?php echo ($days_off == 2) ? "checked" : ""; ?>>
                                                    <label class="form-check-label" for="days_off">Folgas</label>
                                                </div>
                                            </div>
                                            <input name="totalDaysOff" id="totalDaysOff" type="number" class="form-control text-center" placeholder="Qtde de folgas" value="<?php echo (isset($totalDaysOff) and !empty($totalDaysOff)) ? $totalDaysOff : ""; ?>" <?php echo ($days_off == 2) ? "" : "disabled"; ?>>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <?php
                                                    $folds = 1;
                                                    if (isset($valorForm['folds']) and $valorForm['folds'] == 2) {
                                                        $folds = 2;
                                                    }
                                                    if (isset($valorForm['totalFolds']) and !empty($valorForm['totalFolds'])) {
                                                        $totalFolds = $valorForm['totalFolds'];
                                                    }
                                                    ?>
                                                    <input name="folds" id="folds" type="checkbox" class="mr-2" aria-label="folds" value="<?php echo $folds; ?>" <?php echo ($folds == 2) ? "checked" : ""; ?>>
                                                    <label class="form-check-label" for="folds">Horas Adicionais</label>
                                                </div>
                                            </div>
                                            <input name="totalFolds" id="totalFolds" type="text" id="time" class="form-control text-center" placeholder="00:00:00" value="<?php echo (isset($totalFolds) and !empty($totalFolds)) ? $totalFolds : ""; ?>" <?php echo ($folds == 2) ? "" : "disabled"; ?>>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <?php
                                                    $fixed_fund = 1;
                                                    if (isset($valorForm['fixed_fund']) and $valorForm['fixed_fund'] == 2) {
                                                        $fixed_fund = 2;
                                                    }
                                                    if (isset($valorForm['totalFund']) and !empty($valorForm['totalFund'])) {
                                                        $totalFund = $valorForm['totalFund'];
                                                    }
                                                    ?>
                                                    <input name="fixed_fund" id="fixed_fund" type="checkbox" class="mr-2" aria-label="fixed_fund" value="<?php echo $fixed_fund; ?>" <?php echo ($fixed_fund == 2) ? "checked" : ""; ?>>
                                                    <label class="form-check-label" for="fixed_fund">Fundo fixo</label>
                                                </div>
                                            </div>
                                            <input name="totalFund" type="text" id="text1" class="form-control text-center" placeholder="R$ 0,00" value="<?php echo (isset($totalFund) and !empty($totalFund)) ? $totalFund : ""; ?>" <?php echo ($fixed_fund == 2) ? "" : "disabled"; ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <div class="border border-dark rounded p-3">
                                <label class="mb-2">Colaborador Possui:</label>
                                <div class="d-flex">
                                    <div class="form-group col-4">
                                        <label class="mb-2">T.I.</label>
                                        <div class="border rounded d-flex p-2">
                                            <div class="form-group d-block mr-2">
                                                <div class="form-group form-check">
                                                    <?php
                                                    $access_power_bi = "";
                                                    if (isset($valorForm['access_power_bi']) and $valorForm['access_power_bi'] == 1) {
                                                        $access_power_bi = 2;
                                                    }
                                                    ?>
                                                    <input name="access_power_bi" type="checkbox" class="form-check-input" id="access_power_bi" value="1" <?php echo $access_power_bi == 2 ? "checked" : ""; ?>>
                                                    <label class="form-check-label" for="access_power_bi">Acesso Power BI</label>
                                                </div>
                                                <div class="form-group form-check">
                                                    <?php
                                                    $access_zznet = "";
                                                    if (isset($valorForm['access_zznet']) and $valorForm['access_zznet'] == 1) {
                                                        $access_zznet = 2;
                                                    }
                                                    ?>
                                                    <input name="access_zznet" type="checkbox" class="form-check-input" id="access_zznet" value="1" <?php echo $access_zznet == 2 ? "checked" : ""; ?>>
                                                    <label class="form-check-label" for="access_zznet">Acesso ZZnet</label>
                                                </div>
                                                <div class="form-group form-check">
                                                    <?php
                                                    $access_cigam = "";
                                                    if (isset($valorForm['access_cigam']) and $valorForm['access_cigam'] == 1) {
                                                        $access_cigam = 2;
                                                    }
                                                    ?>
                                                    <input name="access_cigam" type="checkbox" class="form-check-input" id="access_cigam" value="1" <?php echo $access_cigam == 2 ? "checked" : ""; ?>>
                                                    <label class="form-check-label" for="access_cigam">Acesso CIGAM</label>
                                                </div>
                                                <div class="form-group form-check">
                                                    <?php
                                                    $access_camera = "";
                                                    if (isset($valorForm['access_camera']) and $valorForm['access_camera'] == 1) {
                                                        $access_camera = 2;
                                                    }
                                                    ?>
                                                    <input name="access_camera" type="checkbox" class="form-check-input" id="access_camera" value="1" <?php echo $access_camera == 2 ? "checked" : ""; ?>>
                                                    <label class="form-check-label" for="access_camera">Acesso Câmeras</label>
                                                </div>
                                                <div class="form-group form-check">
                                                    <?php
                                                    $access_deskfy = "";
                                                    if (isset($valorForm['access_deskfy']) and $valorForm['access_deskfy'] == 1) {
                                                        $access_deskfy = 2;
                                                    }
                                                    ?>
                                                    <input name="access_deskfy" type="checkbox" class="form-check-input" id="access_deskfy" value="1" <?php echo $access_deskfy == 2 ? "checked" : ""; ?>>
                                                    <label class="form-check-label" for="access_deskfy">Acesso Deskfy</label>
                                                </div>
                                            </div>

                                            <div class="form-group d-block">
                                                <div class="form-group form-check">
                                                    <?php
                                                    $notebook = "";
                                                    if (isset($valorForm['notebook']) and $valorForm['notebook'] == 1) {
                                                        $notebook = 2;
                                                    }
                                                    ?>
                                                    <input name="notebook" type="checkbox" class="form-check-input" id="notebook" value="1" <?php echo $notebook == 2 ? "checked" : ""; ?>>
                                                    <label class="form-check-label" for="notebook">Notebook</label>
                                                </div>
                                                <div class="form-group form-check">
                                                    <?php
                                                    $email_corporate = "";
                                                    if (isset($valorForm['email_corporate']) and $valorForm['email_corporate'] == 1) {
                                                        $email_corporate = 2;
                                                    }
                                                    ?>
                                                    <input name="email_corporate" type="checkbox" class="form-check-input" id="email_corporate" value="1" <?php echo $email_corporate == 2 ? "checked" : ""; ?>>
                                                    <label class="form-check-label" for="email_corporate">E-mail Corporativo</label>
                                                </div>
                                                <div class="form-group form-check">
                                                    <?php
                                                    $access_meu_atendimento = "";
                                                    if (isset($valorForm['access_meu_atendimento']) and $valorForm['access_meu_atendimento'] == 1) {
                                                        $access_meu_atendimento = 2;
                                                    }
                                                    ?>
                                                    <input name="access_meu_atendimento" type="checkbox" class="form-check-input" id="access_meu_atendimento" value="1" <?php echo $access_meu_atendimento == 2 ? "checked" : ""; ?>>
                                                    <label class="form-check-label" for="access_meu_atendimento">Acesso Meu Atendimento</label>
                                                </div>
                                                <div class="form-group form-check">
                                                    <?php
                                                    $access_dito = "";
                                                    if (isset($valorForm['access_dito']) and $valorForm['access_dito'] == 1) {
                                                        $access_dito = 2;
                                                    }
                                                    ?>
                                                    <input name="access_dito" type="checkbox" class="form-check-input" id="access_dito" value="1" <?php echo $access_dito == 2 ? "checked" : ""; ?>>
                                                    <label class="form-check-label" for="access_dito">Dito</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-4">
                                        <label>Operações</label>
                                        <div class="border rounded d-flex p-2">
                                            <div class="form-group d-block">
                                                <div class="form-group form-check">
                                                    <?php
                                                    $office_parking_card = "";
                                                    if (isset($valorForm['office_parking_card']) and $valorForm['office_parking_card'] == 1) {
                                                        $office_parking_card = 2;
                                                    }
                                                    ?>
                                                    <input name="office_parking_card" type="checkbox" class="form-check-input" id="office_parking_card" value="1" <?php echo $office_parking_card == 2 ? "checked" : ""; ?>>
                                                    <label class="form-check-label" for="office_parking_card">Cartão Estacionamento Escritório</label>
                                                </div>
                                                <div class="form-group form-check">
                                                    <?php
                                                    $office_parking_shopping = "";
                                                    if (isset($valorForm['office_parking_shopping']) and $valorForm['office_parking_shopping'] == 1) {
                                                        $office_parking_shopping = 2;
                                                    }
                                                    ?>
                                                    <input name="office_parking_shopping" type="checkbox" class="form-check-input" id="office_parking_shopping" value="1" <?php echo $office_parking_shopping == 2 ? "checked" : ""; ?>>
                                                    <label class="form-check-label" for="office_parking_shopping">Cartão Estacionamento Shopping</label>
                                                </div>
                                                <div class="form-group form-check">
                                                    <?php
                                                    $key_office = "";
                                                    if (isset($valorForm['key_office']) and $valorForm['key_office'] == 1) {
                                                        $key_office = 2;
                                                    }
                                                    ?>
                                                    <input name="key_office" type="checkbox" class="form-check-input" id="key_office" value="1" <?php echo $key_office == 2 ? "checked" : ""; ?>>
                                                    <label class="form-check-label" for="key_office">Chave Escritório</label>
                                                </div>
                                                <div class="form-group form-check">
                                                    <?php
                                                    $key_store = "";
                                                    if (isset($valorForm['key_store']) and $valorForm['key_store'] == 1) {
                                                        $key_store = 2;
                                                    }
                                                    ?>
                                                    <input name="key_store" type="checkbox" class="form-check-input" id="key_store" value="1" <?php echo $key_store == 2 ? "checked" : ""; ?>>
                                                    <label class="form-check-label" for="key_store">Chave Loja</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group col-4">
                                        <label>Pessoas & Cultura</label>
                                        <div class="border rounded d-flex p-2">
                                            <div class="form-group d-block">
                                                <div class="form-group form-check">
                                                    <?php
                                                    $instagram_corporate = "";
                                                    if (isset($valorForm['instagram_corporate']) and $valorForm['instagram_corporate'] == 1) {
                                                        $instagram_corporate = 2;
                                                    }
                                                    ?>
                                                    <input name="instagram_corporate" type="checkbox" class="form-check-input" id="instagram_corporate" value="1" <?php echo $instagram_corporate == 2 ? "checked" : ""; ?>>
                                                    <label class="form-check-label" for="instagram_corporate">Instagram Corporativo</label>
                                                </div>
                                                <div class="form-group form-check">
                                                    <?php
                                                    $deactivate_instagram_account = "";
                                                    if (isset($valorForm['deactivate_instagram_account']) and $valorForm['deactivate_instagram_account'] == 1) {
                                                        $deactivate_instagram_account = 2;
                                                    }
                                                    ?>
                                                    <input name="deactivate_instagram_account" type="checkbox" class="form-check-input" id="deactivate_instagram_account" value="1" <?php echo $deactivate_instagram_account == 2 ? "checked" : ""; ?>>
                                                    <label class="form-check-label" for="deactivate_instagram_account">Desativar conta do instagram profissional</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">

                        <div class="form-group col-md-2">
                            <label><span class="text-danger">*</span> Área</label>
                            <select name="request_area_id" id="request_area_id" class="form-control is-invalid" required>
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->Dados['select']['area'] as $area) {
                                    extract($area);
                                    if (isset($valorForm['request_area_id']) and $valorForm['request_area_id'] == $a_id) {
                                        echo "<option value='$a_id' selected>$area_name</option>";
                                    } else {
                                        echo "<option value='$a_id'>$area_name</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label><span class="text-danger">*</span> Solicitante</label>
                            <select name="requester_id" id="requester_id" class="form-control is-invalid" required>
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->Dados['select']['manager_sector'] as $fc) {
                                    extract($fc);
                                    if (isset($valorForm['requester_id']) and $valorForm['requester_id'] == $f_id) {
                                        echo "<option value='$f_id' selected>$manager_sector</option>";
                                    } else {
                                        echo "<option value='$f_id'>$manager_sector</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label><span class="text-danger">*</span> Diretoria</label>
                            <select name="board_id" id="board_id" class="form-control is-invalid" required>
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->Dados['select']['manager'] as $mang) {
                                    extract($mang);
                                    if (isset($valorForm['board_id']) and $valorForm['board_id'] == $m_id) {
                                        echo "<option value='$m_id' selected>$manager</option>";
                                    } else {
                                        echo "<option value='$m_id'>$manager</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label><span class="text-danger">*</span> Situação</label>
                            <select name="adms_sits_personnel_mov_id" id="adms_sits_personnel_mov_id" class="form-control is-invalid" required>
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->Dados['select']['status'] as $sit) {
                                    extract($sit);
                                    if (isset($valorForm['adms_sits_personnel_mov_id']) and $valorForm['adms_sits_personnel_mov_id'] == $s_id) {
                                        echo "<option value='$s_id' selected>$status</option>";
                                    } else {
                                        echo "<option value='$s_id'>$status</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label><span class="text-danger">*</span> Observações</label>
                            <textarea name="observation" id="editor" class="form-control editorCK" rows="3">
                                <?php
                                if (isset($valorForm['observation'])) {
                                    echo $valorForm['observation'];
                                }
                                ?>
                            </textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <div class="mb-3">
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0">Arquivos</h6>
                                            <small class="text-muted">
                                                <?php
                                                $types = array('png', 'jpg', 'jpeg', 'doc', 'pdf', 'docx', 'xlsx', 'xls');
                                                $path = 'assets/files/mp/' . $valorForm['id'] . '/';
                                                try {
                                                    $dir = new DirectoryIterator($path);
                                                    if ($dir) {
                                                        foreach ($dir as $fileInfo) {
                                                            $ext = strtolower($fileInfo->getExtension());
                                                            if (in_array($ext, $types)) {
                                                                $arquivo = $fileInfo->getFilename();
                                                                echo "<span class='m-auto lead'>";
                                                                echo $arquivo . " - <a href='" . URLADM . "assets/files/mp/" . $valorForm['id'] . "/$arquivo' class='btn btn-dark btn-sm mr-1' download><i class='fas fa-download'></i> Baixar</a>";
                                                                echo "<a href='" . URLADM . "edit-personnel-moviments/edit-moviment/" . $valorForm['id'] . "?id=" . $valorForm['id'] . "&file=$arquivo' class='btn btn-dark btn-sm'><i class='fa-solid fa-trash'></i></a><br>";
                                                                echo "</span>";
                                                            }
                                                        }
                                                    }
                                                } catch (Exception $exc) {
                                                    echo 'Nenhum arquivo encontrado';
                                                }
                                                ?>
                                            </small>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <label for="file_name">Arquivo</label>
                            <input name="file_name[]" id="file_name" type="file" class="custom-file" multiple>
                        </div>
                    </div>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditMoviment" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>

