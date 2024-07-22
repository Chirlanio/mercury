<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_moviment'][0])) {
    extract($this->Dados['dados_moviment'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Movimentação de Pessoal - <strong>ID:</strong> <?php echo $id; ?></h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_moviment']) {
                            echo "<a href='" . URLADM . "personnel-moviments/list' class='btn btn-outline-info btn-sm m-1' title='Listar'><i class='fas fa-list'></i></a>";
                        }
                        if ($this->Dados['botao']['edit_moviment']) {
                            echo "<a href='" . URLADM . "edit-personnel-moviments/edit-moviment/$id' class='btn btn-outline-warning btn-sm m-1' title='Editar'><i class='fa-solid fa-pen-to-square'></i></a>";
                        }
                        if ($this->Dados['botao']['del_moviment']) {
                            echo "<a href='" . URLADM . "delete-personnel-moviments/delete-moviment/$id' class='btn btn-outline-danger btn-sm m-1' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none d-print-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_moviment']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "personnel-moviments/list'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_moviment']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-personnel-moviments/edit-moviment/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_moviment']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delete-personnel-moviments/delete-moviment/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <div class="content p1">
                <div class="row">
                    <div class="col-md-4 order-md-2 mb-4">
                        <h4 class="d-flex justify-content-between align-items-center border border-second rounded mb-3 p-3 bg-light shadow-sm">
                            <span class="text-muted">Acompanhamento</span>
                        </h4>
                        <ul class="list-group border border-second mb-3 shadow-sm">
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div class="my-2">
                                    <h6 class="my-2">Cargo Atual</h6>
                                    <small class="lead"><?php echo $office_name; ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Data do Desligamento:</h6>
                                    <small class="text-muted lead"><?php echo date("d/m/Y", strtotime($last_day_worked)); ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condenced">
                                <div class="my-2">
                                    <h6 class="my-2">O que precisa ser devolvido?</h6>
                                    <small style="font-size: 15px;">
                                        <div class="form-group d-block mr-2">
                                            <div class="form-group form-check">
                                                <input name="uniform" type="checkbox" class="form-check-input" id="uniform" value="1" <?php echo (isset($uniform) and $uniform == 1) ? "checked" : ""; ?> disabled />
                                                <label class="form-check-label" for="uniform">Farda</label>
                                            </div>
                                            <div class="form-group form-check">
                                                <input name="phone_chip" type="checkbox" class="form-check-input" id="phone_chip" value="1" <?php echo (isset($phone_chip) and $phone_chip == 1) ? "checked" : ""; ?> disabled />
                                                <label class="form-check-label" for="phone_chip">Chip</label>
                                            </div>
                                            <div class="form-group form-check">
                                                <input name="original_card" type="checkbox" class="form-check-input" id="original_card" value="1" <?php echo (isset($original_card) and $original_card == 1) ? "checked" : ""; ?> disabled />
                                                <label class="form-check-label" for="original_card">Carta Original</label>
                                            </div>
                                            <div class="form-group form-check">
                                                <input name="aso" type="checkbox" class="form-check-input" id="aso" value="1" <?php echo (isset($aso) and $aso == 1) ? "checked" : ""; ?> disabled />
                                                <label class="form-check-label" for="aso">ASO</label>
                                            </div>
                                        </div>
                                    </small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div class="my-2">
                                    <h6 class="my-2">Data assinatura TRCT</h6>
                                    <small class="text-muted lead"><?php echo date("d/m/Y", strtotime($signature_date_trct)); ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div class="my-2">
                                    <h6 class="my-2">ASO Demissional</h6>
                                    <small class="text-muted lead" ><?php echo $aso_resigns == 1 ? "Não" : "Sim"; ?></small>
                                </div>
                                <div class="my-2">
                                    <h6 class="my-2">Guia ASO Demissional</h6>
                                    <small class="lead"><?php echo $send_aso_guide == 1 ? "Não" : "Sim"; ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Atualizado Por:</h6>
                                    <small class="text-muted lead" ><?php echo (!empty($updated_by) ? $updated_by : ""); ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Situação:</h6>
                                    <small class="badge badge-<?php echo $cor; ?> badge-pill lead"><?php echo $status; ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Cadastrado</h6>
                                    <small class="lead"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></small>
                                    <small class="lead"><?php
                                        if (!empty($modified)) {
                                            echo '<h6 class="my-2">Atualizado</h6>';
                                            echo date('d/m/Y H:i:s', strtotime($modified));
                                        }
                                        ?>
                                    </small>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-8 order-md-1">
                        <h4 class="text-muted border border-second rounded mb-3 p-3 bg-light shadow-sm">Dados da Movimentação</h4>
                        <form class="needs-validation" novalidate>
                            <div class="border border-second rounded p-3 mb-3 shadow-sm">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="adms_loja_id">Loja</label>
                                        <input type="text" class="form-control bg-white" id="adms_loja_id" readonly value="<?php echo $store; ?>">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="adms_employee_id">Colaborador</label>
                                        <input type="text" class="form-control bg-white" id="adms_employee_id" value="<?php echo $colaborador; ?>" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="manager_id">Último Dia Trabalhado</label>
                                        <input type="text" class="form-control bg-white" id="manager_id" value="<?php echo date("d/m/Y", strtotime($last_day_worked)); ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-row">

                                    <div class="form-group col-md-3">
                                        <label><span class="text-danger">*</span> Área</label>
                                        <input name="request_area_id" type="text" class="form-control bg-white" id="request_area_id" value="<?php echo $area ?>" readonly />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="requester_id"><span class="text-danger">*</span> Solicitante</label>
                                        <input name="requester_id" type="text" class="form-control bg-white" id="requester_id" value="<?php echo $manager_sector ?>" readonly />
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="board_id"><span class="text-danger">*</span> Diretoria</label>
                                        <input name="board_id" type="text" class="form-control bg-white" id="board_id" value="<?php echo $board_name ?>" readonly />
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <div class="border border-second rounded p-3 shadow-sm">
                                        <h6 for="adms_employee_relation_id" class="mb-2"><span class="text-danger">*</span> Vínculo Contrato</h6>
                                        <div class="form-group d-flex">
                                            <div class="custom-control custom-radio mr-2">
                                                <input id="efetivo" name="adms_employee_relation_id" type="radio" class="custom-control-input" value="1" <?php echo $adms_employee_relation_id == 1 ? "checked" : ""; ?> disabled="" />
                                                <label class="custom-control-label mr-2" for="efetivo">Colaborador efetivo</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input id="experiencia" name="adms_employee_relation_id" type="radio" class="custom-control-input" value="2" <?php echo $adms_employee_relation_id == 2 ? "checked" : ""; ?> disabled />
                                                <label class="custom-control-label mr-2" for="experiencia">Colaborador em experiência</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input id="estagio" name="adms_employee_relation_id" type="radio" class="custom-control-input" value="3" <?php echo $adms_employee_relation_id == 3 ? "checked" : ""; ?> disabled />
                                                <label class="custom-control-label mr-2" for="estagio">Estagiário</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input id="aprendiz" name="adms_employee_relation_id" type="radio" class="custom-control-input" value="4" <?php echo $adms_employee_relation_id == 4 ? "checked" : ""; ?> disabled />
                                                <label class="custom-control-label mr-2" for="aprendiz">Jovem aprendiz</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <div class="border border-second rounded p-3 shadow-sm">
                                        <h6 for="adms_employee_relation_id" class="mb-2"><span class="text-danger">*</span> Motivo</h6>
                                        <div class="form-group d-flex">
                                            <div class="custom-control custom-radio mr-2">
                                                <input id="iniciativa" name="adms_resignation_id" type="radio" class="custom-control-input" value="1" <?php echo $adms_resignation_id == 1 ? "checked" : ""; ?> disabled/>
                                                <label class="custom-control-label mr-2" for="iniciativa">Iniciativa Empresa</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input id="pedido" name="adms_resignation_id" type="radio" class="custom-control-input" value="2" <?php echo $adms_resignation_id == 2 ? "checked" : ""; ?> disabled/>
                                                <label class="custom-control-label mr-2" for="pedido">Pedido de Demissão</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input id="termino" name="adms_resignation_id" type="radio" class="custom-control-input" value="3" <?php echo $adms_resignation_id == 3 ? "checked" : ""; ?> disabled/>
                                                <label class="custom-control-label mr-2" for="termino">Termino de Contrato</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="border border-second rounded p-3 shadow-sm">
                                        <h6 for="early_warning_id" class="mb-2"><span class="text-danger">*</span> Aviso Prévio</h6>
                                        <div class="form-group d-block">
                                            <div class="custom-control custom-radio mr-2">
                                                <input id="worked" name="early_warning_id" type="radio" class="custom-control-input" value="1" <?php echo $early_warning_id == 1 ? "checked" : ""; ?> disabled />
                                                <label class="custom-control-label mr-2" for="worked" aria-describedby="workedHelp">Trabalhado</label>
                                                <small id="workedHelp" class="form-text text-muted">Colaborador cumprirá os 30 dias.</small>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input id="indenizado" name="early_warning_id" type="radio" class="custom-control-input" value="2" <?php echo $early_warning_id == 2 ? "checked" : ""; ?> disabled />
                                                <label class="custom-control-label mr-2" for="indenizado" aria-describedby="workedHelp">Indenizado</label>
                                                <small id="workedHelp" class="form-text text-muted">Pagar ao Colaborador/Empresa.</small>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input id="noPayment" name="early_warning_id" type="radio" class="custom-control-input" value="3" <?php echo $early_warning_id == 3 ? "checked" : ""; ?> disabled />
                                                <label class="custom-control-label mr-2" for="noPayment" aria-describedby="workedHelp">Contrato de experiência</label>
                                                <small id="workedHelp" class="form-text text-muted">Sem pagamento de aviso.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <div class="border border-second rounded p-3 shadow-sm">
                                        <h6 class="mb-2">Motivo(s) de Desligamento:</h6>
                                        <div class="d-flex">
                                            <div class="form-group col-12">
                                                <div class="form-group d-block mr-2">
                                                    <ul class="list-group list-group-flush">
                                                        <?php
                                                        foreach ($this->Dados['reasons'] as $reason) {
                                                            extract($reason);
                                                            ?>
                                                            <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                                                                <?php echo $question_reason; ?>
                                                                <span class="badge badge-primary badge-pill">
                                                                    <i class="fa-solid fa-check"></i>
                                                                </span>
                                                            </li>

                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <div class="border border-second rounded p-3 shadow-sm">
                                        <h6 class="mb-2">Informações para DP:</h6>
                                        <div class="form-group col-md-6">
                                            <div class="form-group d-block">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <input name="fouls" id="fouls" type="checkbox" class="mr-2" aria-label="fouls" value="<?php echo $fouls; ?>" <?php echo (!empty($fouls) and $fouls > 0) ? "checked" : ""; ?> disabled />
                                                            <label class="form-check-label" for="fouls">Faltas</label>
                                                        </div>
                                                    </div>
                                                    <input name="totalFouls" id="totalFouls" type="number" class="form-control text-center" placeholder="0" value="<?php echo (!empty($fouls) and $fouls > 0) ? $fouls : ""; ?>" disabled />
                                                </div>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <input name="days_off" id="days_off" type="checkbox" class="mr-2" aria-label="days_off" value="<?php echo $days_off; ?>" <?php echo (!empty($days_off) and $days_off > 0) ? "checked" : ""; ?> disabled />
                                                            <label class="form-check-label" for="days_off">Folgas</label>
                                                        </div>
                                                    </div>
                                                    <input name="totalDaysOff" id="totalDaysOff" type="number" class="form-control text-center" placeholder="0" value="<?php echo (!empty($days_off) and $days_off > 0) ? $days_off : ""; ?>" disabled />
                                                </div>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <input name="folds" id="folds" type="checkbox" class="mr-2" aria-label="folds" value="<?php echo $folds; ?>" <?php echo (!empty($folds) and $folds != "00:00:00") ? "checked" : ""; ?> disabled />
                                                            <label class="form-check-label" for="folds">Horas Adicionais</label>
                                                        </div>
                                                    </div>
                                                    <input name="totalFolds" id="totalFolds" type="text" id="time" class="form-control text-center" placeholder="00:00:00" value="<?php echo (!empty($folds) and $folds != "00:00:00") ? $folds : ""; ?>" disabled />
                                                </div>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <input name="fixed_fund" id="fixed_fund" type="checkbox" class="mr-2" aria-label="fixed_fund" value="<?php echo $fixed_fund; ?>" <?php echo (!empty($fixed_fund) and $fixed_fund > 0) ? "checked" : ""; ?> disabled />
                                                            <label class="form-check-label" for="fixed_fund">Fundo fixo</label>
                                                        </div>
                                                    </div>
                                                    <input name="totalFund" type="text" id="text1" class="form-control text-center" placeholder="R$ 0,00" value="<?php echo (!empty($fixed_fund) and $fixed_fund > 0) ? $fixed_fund : ""; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <div class="border border-second rounded p-3 shadow-sm">
                                        <h6 class="mb-2">Colaborador Possui:</h6>
                                        <div class="d-flex">
                                            <div class="form-group col-4">
                                                <label class="mb-2">T.I.</label>
                                                <div class="d-flex p-2">
                                                    <div class="form-group d-block mr-2">
                                                        <div class="form-group form-check">
                                                            <input name="access_power_bi" type="checkbox" class="form-check-input" id="access_power_bi" value="1" <?php echo (isset($access_power_bi) and $access_power_bi == 1) ? "checked" : ""; ?> disabled />
                                                            <label class="form-check-label" for="access_power_bi">Acesso Power BI</label>
                                                        </div>
                                                        <div class="form-group form-check">
                                                            <input name="access_zznet" type="checkbox" class="form-check-input" id="access_zznet" value="1" <?php echo (isset($access_zznet) and $access_zznet == 1) ? "checked" : ""; ?> disabled />
                                                            <label class="form-check-label" for="access_zznet">Acesso ZZnet</label>
                                                        </div>
                                                        <div class="form-group form-check">
                                                            <input name="access_cigam" type="checkbox" class="form-check-input" id="access_cigam" value="1" <?php echo (isset($access_cigam) and $access_cigam == 1) ? "checked" : ""; ?> disabled />
                                                            <label class="form-check-label" for="access_cigam">Acesso CIGAM</label>
                                                        </div>
                                                        <div class="form-group form-check">
                                                            <input name="access_camera" type="checkbox" class="form-check-input" id="access_camera" value="1" <?php echo (isset($access_camera) and $access_camera == 1) ? "checked" : ""; ?> disabled />
                                                            <label class="form-check-label" for="access_camera">Acesso Câmeras</label>
                                                        </div>
                                                        <div class="form-group form-check">
                                                            <input name="access_deskfy" type="checkbox" class="form-check-input" id="access_deskfy" value="1" <?php echo (isset($access_deskfy) and $access_deskfy == 1) ? "checked" : ""; ?> disabled />
                                                            <label class="form-check-label" for="access_deskfy">Acesso Deskfy</label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group d-block">
                                                        <div class="form-group form-check">
                                                            <input name="notebook" type="checkbox" class="form-check-input" id="notebook" value="1" <?php echo (isset($notebook) and $notebook == 1) ? "checked" : ""; ?> disabled />
                                                            <label class="form-check-label" for="notebook">Notebook</label>
                                                        </div>
                                                        <div class="form-group form-check">
                                                            <input name="email_corporate" type="checkbox" class="form-check-input" id="email_corporate" value="1" <?php echo (isset($email_corporate) and $email_corporate == 1) ? "checked" : ""; ?> disabled />
                                                            <label class="form-check-label" for="email_corporate">E-mail Corporativo</label>
                                                        </div>
                                                        <div class="form-group form-check">
                                                            <input name="access_meu_atendimento" type="checkbox" class="form-check-input" id="access_meu_atendimento" value="1" <?php echo (isset($access_meu_atendimento) and $access_meu_atendimento == 1) ? "checked" : ""; ?> disabled />
                                                            <label class="form-check-label" for="access_meu_atendimento">Acesso Meu Atendimento</label>
                                                        </div>
                                                        <div class="form-group form-check">
                                                            <input name="access_dito" type="checkbox" class="form-check-input" id="access_dito" value="1" <?php echo (isset($access_dito) and $access_dito == 1) ? "checked" : ""; ?> disabled />
                                                            <label class="form-check-label" for="access_dito">Dito</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-4">
                                                <label>Operações</label>
                                                <div class="d-flex p-2">
                                                    <div class="form-group d-block">
                                                        <div class="form-group form-check">
                                                            <input name="office_parking_card" type="checkbox" class="form-check-input" id="office_parking_card" value="1" <?php echo (isset($office_parking_card) and $office_parking_card == 1) ? "checked" : ""; ?> disabled />
                                                            <label class="form-check-label" for="office_parking_card">Cartão Estacionamento Escritório</label>
                                                        </div>
                                                        <div class="form-group form-check">
                                                            <input name="office_parking_shopping" type="checkbox" class="form-check-input" id="office_parking_shopping" value="1" <?php echo (isset($office_parking_shopping) and $office_parking_shopping == 1) ? "checked" : ""; ?> disabled />
                                                            <label class="form-check-label" for="office_parking_shopping">Cartão Estacionamento Shopping</label>
                                                        </div>
                                                        <div class="form-group form-check">
                                                            <input name="key_office" type="checkbox" class="form-check-input" id="key_office" value="1" <?php echo (isset($key_office) and $key_office == 1) ? "checked" : ""; ?> disabled />
                                                            <label class="form-check-label" for="key_office">Chave Escritório</label>
                                                        </div>
                                                        <div class="form-group form-check">
                                                            <input name="key_store" type="checkbox" class="form-check-input" id="key_store" value="1" <?php echo (isset($key_store) and $key_store == 1) ? "checked" : ""; ?> disabled />
                                                            <label class="form-check-label" for="key_store">Chave Loja</label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group col-4">
                                                <label>Pessoas & Cultura</label>
                                                <div class="d-flex p-2">
                                                    <div class="form-group d-block">
                                                        <div class="form-group form-check">
                                                            <input name="instagram_corporate" type="checkbox" class="form-check-input" id="instagram_corporate" value="1" <?php echo (isset($instagram_corporate) and $instagram_corporate == 1) ? "checked" : ""; ?> disabled />
                                                            <label class="form-check-label" for="instagram_corporate">Instagram Corporativo</label>
                                                        </div>
                                                        <div class="form-group form-check">
                                                            <input name="deactivate_instagram_account" type="checkbox" class="form-check-input" id="deactivate_instagram_account" value="1" <?php echo (isset($deactivate_instagram_account) and $deactivate_instagram_account == 1) ? "checked" : ""; ?> disabled />
                                                            <label class="form-check-label" for="deactivate_instagram_account">Desativar conta do instagram profissional</label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between lh-condensed border-second rounded shadow-sm">
                                        <div>
                                            <h6 class="my-0"><p>Documentos:</p></h6>
                                            <small class="text-muted">
                                                <?php
                                                $types = array('png', 'jpg', 'jpeg', 'gif', 'xls', 'txt', 'doc', 'csv', 'pdf', 'docx', 'xlsx');
                                                $path = 'assets/files/mp/' . $id . '/';
                                                $dir = new DirectoryIterator($path);
                                                foreach ($dir as $fileInfo) {
                                                    $ext = strtolower($fileInfo->getExtension());
                                                    if (in_array($ext, $types)) {
                                                        $arquivo = $fileInfo->getFilename();
                                                        echo "<span class='m-auto lead'>";
                                                        echo $arquivo . " - <a href='" . URLADM . "assets/files/mp/$id/$arquivo' class='btn btn-outline-dark btn-sm' download><i class='fas fa-download'></i> Baixar</a><br>";
                                                        echo "</span>";
                                                    }
                                                }
                                                ?>
                                            </small>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="border border-second p-3 shadow-sm">
                                        <h6 for="observation"><span class="text-danger">*</span> Observações</h6>
                                        <div name="observation" id="observation" class="form-control">
                                            <?php
                                            if (isset($observation)) {
                                                echo $observation;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Nenhuma solicitação encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    $UrlDestino = URLADM . 'personnel-moviments/list';
    header("Location: $UrlDestino");
}    