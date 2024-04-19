<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['select']['loja_id']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Movimentação de Pessoal</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_moviment']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'personnel-moviments/list'; ?>" class="btn btn-outline-info btn-sm"><i class='fa-solid fa-list'></i></a>
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
        <form method="POST" action="" enctype="multipart/form-data" class="was-validated">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Loja</label>
                    <select name="adms_loja_id" id="adms_loja_id" class="form-control is-invalid" required autofocus>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['name_stores'] as $stp) {
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
                <div class="form-group col-md-7">
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

                <div class="form-group col-md-2">
                    <label for="last_day_worked"><span class="text-danger">*</span> Último Dia Trabalhado</label>
                    <input name="last_day_worked" type="date" id="last_day_worked" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['last_day_worked'])) {
                        echo $valorForm['last_day_worked'];
                    }
                    ?>" required>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Área</label>
                    <select name="request_area_id" id="request_area_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['areas'] as $area) {
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

                <div class="form-group col-md-5">
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

                <div class="form-group col-md-5">
                    <label><span class="text-danger">*</span> Diretoria</label>
                    <select name="board_id" id="board_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['manager'] as $fc) {
                            extract($fc);
                            if (isset($valorForm['board_id']) and $valorForm['board_id'] == $m_id) {
                                echo "<option value='$m_id' selected>$board_name</option>";
                            } else {
                                echo "<option value='$m_id'>$board_name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <div class="border border-dark rounded p-3">
                        <label for="adms_employee_relation_id" class="mb-2"><span class="text-danger">*</span> Vínculo Contrato</label>
                        <div class="form-group d-flex">
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
                    <div class="border border-dark rounded p-3 h-100">
                        <label for="adms_employee_relation_id" class="mb-2"><span class="text-danger">*</span> Motivo</label>
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
                        <label for="early_warning_id" class="mb-2"><span class="text-danger">*</span> Aviso Prévio</label>
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
                        <label class="mb-2">Motivo(s) do Desligamento:</label>
                        <div class="d-flex">
                            <div class="form-group col-12">
                                <div class="border rounded d-flex p-2">
                                    <div class="form-group d-block mr-2">
                                        <div class="form-group form-check">
                                            <?php
                                            $grip = "";
                                            if (isset($valorForm['grip']) and $valorForm['grip'] == 1) {
                                                $grip = 2;
                                            }
                                            ?>
                                            <input name="grip" type="checkbox" class="form-check-input" id="grip" value="1" <?php echo $grip == 2 ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="grip">Falta de aderência à cultura da empresa.</label>
                                        </div>
                                        <div class="form-group form-check">
                                            <?php
                                            $conduct = "";
                                            if (isset($valorForm['conduct']) and $valorForm['conduct'] == 1) {
                                                $conduct = 2;
                                            }
                                            ?>
                                            <input name="conduct" type="checkbox" class="form-check-input" id="conduct" value="1" <?php echo $conduct == 2 ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="conduct">Violação de conduta e mau procedimento.</label>
                                        </div>
                                        <div class="form-group form-check">
                                            <?php
                                            $productivity = "";
                                            if (isset($valorForm['productivity']) and $valorForm['productivity'] == 1) {
                                                $productivity = 2;
                                            }
                                            ?>
                                            <input name="productivity" type="checkbox" class="form-check-input" id="productivity" value="1" <?php echo $productivity == 2 ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="productivity">Baixa produtividade.</label>
                                        </div>
                                        <div class="form-group form-check">
                                            <?php
                                            $team_work = "";
                                            if (isset($valorForm['team_work']) and $valorForm['team_work'] == 1) {
                                                $team_work = 2;
                                            }
                                            ?>
                                            <input name="team_work" type="checkbox" class="form-check-input" id="team_work" value="1" <?php echo $team_work == 2 ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="team_work">Dificuldades em trabalhar em equipe e comportamentos inadequados.</label>
                                        </div>
                                        <div class="form-group form-check">
                                            <?php
                                            $performance = "";
                                            if (isset($valorForm['performance']) and $valorForm['performance'] == 1) {
                                                $performance = 2;
                                            }
                                            ?>
                                            <input name="performance" type="checkbox" class="form-check-input" id="performance" value="1" <?php echo $performance == 2 ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="performance">Baixa Performance.</label>
                                        </div>
                                        <div class="form-group form-check">
                                            <?php
                                            $new_opportunity = "";
                                            if (isset($valorForm['new_opportunity']) and $valorForm['new_opportunity'] == 1) {
                                                $new_opportunity = 2;
                                            }
                                            ?>
                                            <input name="new_opportunity" type="checkbox" class="form-check-input" id="new_opportunity" value="1" <?php echo $new_opportunity == 2 ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="new_opportunity">Nova oportunidade de trabalho.</label>
                                        </div>
                                    </div>

                                    <div class="form-group d-block">
                                        <div class="form-group form-check">
                                            <?php
                                            $structure_adjustment = "";
                                            if (isset($valorForm['structure_adjustment']) and $valorForm['structure_adjustment'] == 1) {
                                                $structure_adjustment = 2;
                                            }
                                            ?>
                                            <input name="structure_adjustment" type="checkbox" class="form-check-input" id="structure_adjustment" value="1" <?php echo $structure_adjustment == 2 ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="structure_adjustment">Ajuste de estrutura na empresa.</label>
                                        </div>
                                        <div class="form-group form-check">
                                            <?php
                                            $career_change = "";
                                            if (isset($valorForm['career_change']) and $valorForm['career_change'] == 1) {
                                                $career_change = 2;
                                            }
                                            ?>
                                            <input name="career_change" type="checkbox" class="form-check-input" id="career_change" value="1" <?php echo $career_change == 2 ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="career_change">Mudança de carreira.</label>
                                        </div>
                                        <div class="form-group form-check">
                                            <?php
                                            $inadequacy = "";
                                            if (isset($valorForm['inadequacy']) and $valorForm['inadequacy'] == 1) {
                                                $inadequacy = 2;
                                            }
                                            ?>
                                            <input name="inadequacy" type="checkbox" class="form-check-input" id="inadequacy" value="1" <?php echo $inadequacy == 2 ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="inadequacy">Inadequação ao perfil da posição.</label>
                                        </div>
                                        <div class="form-group form-check">
                                            <?php
                                            $indiscipline_insubordination = "";
                                            if (isset($valorForm['indiscipline_insubordination']) and $valorForm['indiscipline_insubordination'] == 1) {
                                                $indiscipline_insubordination = 2;
                                            }
                                            ?>
                                            <input name="indiscipline_insubordination" type="checkbox" class="form-check-input" id="indiscipline_insubordination" value="1" <?php echo $indiscipline_insubordination == 2 ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="indiscipline_insubordination">Ato de indisciplina ou insubordinação.</label>
                                        </div>
                                        <div class="form-group form-check">
                                            <?php
                                            $frequent_absences = "";
                                            if (isset($valorForm['frequent_absences']) and $valorForm['frequent_absences'] == 1) {
                                                $frequent_absences = 2;
                                            }
                                            ?>
                                            <input name="frequent_absences" type="checkbox" class="form-check-input" id="frequent_absences" value="1" <?php echo $frequent_absences == 2 ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="frequent_absences">Ausências frequentes.</label>
                                        </div>
                                    </div>
                                </div>
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
                                            ?>
                                            <input name="fouls" id="fouls" type="checkbox" class="mr-2" aria-label="fouls" value="<?php echo $fouls; ?>" <?php echo ($fouls == 2) ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="fouls">Faltas</label>
                                        </div>
                                    </div>
                                    <input name="totalFouls" id="totalFouls" type="number" class="form-control text-center" placeholder="Qtde de faltas" value="<?php echo ($fouls == 2) ? $valorForm['totalFouls'] : ""; ?>" <?php echo ($fouls == 2) ? "" : "disabled"; ?>>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <?php
                                            $days_off = 1;
                                            if (isset($valorForm['days_off']) and $valorForm['days_off'] == 2) {
                                                $days_off = 2;
                                            }
                                            ?>
                                            <input name="days_off" id="days_off" type="checkbox" class="mr-2" aria-label="days_off" value="<?php echo $days_off; ?>" <?php echo ($days_off == 2) ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="days_off">Folgas</label>
                                        </div>
                                    </div>
                                    <input name="totalDaysOff" id="totalDaysOff" type="number" class="form-control text-center" placeholder="Qtde de folgas" value="<?php echo ($days_off == 2) ? $valorForm['totalDaysOff'] : ""; ?>" <?php echo ($days_off == 2) ? "" : "disabled"; ?>>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <?php
                                            $folds = 1;
                                            if (isset($valorForm['folds']) and $valorForm['folds'] == 2) {
                                                $folds = 2;
                                            }
                                            ?>
                                            <input name="folds" id="folds" type="checkbox" class="mr-2" aria-label="folds" value="<?php echo $folds; ?>" <?php echo ($folds == 2) ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="folds">Horas Adicionais</label>
                                        </div>
                                    </div>
                                    <input name="totalFolds" id="totalFolds" type="text" id="time" class="form-control text-center" placeholder="00:00:00" value="<?php echo ($folds == 2) ? $valorForm['totalFolds'] : ""; ?>" <?php echo ($folds == 2) ? "" : "disabled"; ?>>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <?php
                                            $fixed_fund = 1;
                                            if (isset($valorForm['fixed_fund']) and $valorForm['fixed_fund'] == 2) {
                                                $fixed_fund = 2;
                                            }
                                            ?>
                                            <input name="fixed_fund" id="fixed_fund" type="checkbox" class="mr-2" aria-label="fixed_fund" value="<?php echo $fixed_fund; ?>" <?php echo ($fixed_fund == 2) ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="fixed_fund">Fundo fixo</label>
                                        </div>
                                    </div>
                                    <input name="totalFund" type="text" id="text1" class="form-control text-center" placeholder="R$ 0,00" value="<?php echo ($fixed_fund == 2) ? $valorForm['totalFund'] : ""; ?>" <?php echo ($fixed_fund == 2) ? "" : "disabled"; ?>>
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
                    <label for="file_name">Arquivo</label>
                    <input class="form-control-file is-valid" name="file_name[]" id="file_name" type="file" multiple/>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="AddMoviment" type="submit" class="btn btn-warning btn-submit" value="Salvar">
        </form>
    </div>
</div>