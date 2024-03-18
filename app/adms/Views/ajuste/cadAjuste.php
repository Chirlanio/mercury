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
                <h2 class="display-4 titulo">Cadastrar Ajuste de Estoque</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_ajuste']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ajuste/listar-ajuste'; ?>" class="btn btn-outline-info btn-sm"><i class='fas fa-list d-block d-md-none fa-2x'></i> <span class='d-none d-md-block'><i class='fa-solid fa-list'></i></span></a>
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
        <form method="POST" action="" class="was-validated" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Nome</label>
                    <select name="solicitante" id="func_id" class="form-control is-invalid" required autofocus>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['func_id'] as $c) {
                            extract($c);
                            if (isset($valorForm['func_id']) and $valorForm['func_id'] == $id_consul) {
                                echo "<option value='$id_consul' selected>$consul</option>";
                            } else {
                                echo "<option value='$id_consul'>$consul</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Loja</label>
                    <select name="loja_id" id="loja_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['loja_id'] as $l) {
                            extract($l);
                            if (isset($valorForm['loja_id']) and $valorForm['loja_id'] == $lj_id) {
                                echo "<option value='$lj_id' selected>$loja</option>";
                            } else {
                                echo "<option value='$lj_id'>$loja</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Consultora</label>
                    <select name="func_id" id="func_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['func_id'] as $c) {
                            extract($c);
                            if (isset($valorForm['func_id']) and $valorForm['func_id'] == $id_consul) {
                                echo "<option value='$id_consul' selected>$consul</option>";
                            } else {
                                echo "<option value='$id_consul'>$consul</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Cliente</label>
                    <input name="cliente" type="text" class="form-control is-invalid" placeholder="Cliente" value="<?php
                    if (isset($valorForm['cliente'])) {
                        echo strtoupper($valorForm['cliente']);
                    }
                    ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Referência</label>
                    <input name="referencia" id="referencia" type="text" class="form-control is-invalid" placeholder="Referência" value="<?php
                    if (isset($valorForm['referencia'])) {
                        echo $valorForm['referencia'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger text-center">*</span> Tamanho</label>
                    <select name="tam_id" id="tam_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['tams'] as $tam) {
                            extract($tam);
                            if (isset($valorForm['tam_id']) and $valorForm['tam_id'] == $t_id) {
                                echo "<option value='$t_id' selected>$tamanho</option>";
                            } else {
                                echo "<option value='$t_id'>$tamanho</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Qtd</label>
                    <input name="qtde" type="number" class="form-control is-invalid text-center" value="<?php
                    if (isset($valorForm['qtde'])) {
                        if (empty($valorForm['qtde'])) {
                            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Preencha o campo quantidade!</div>";
                        } else {
                            echo $valorForm['qtde'];
                        }
                    }
                    ?>" required>
                </div>
            </div>
            <div class="form-row">
                <label><span class="text-danger">*</span> Grade</label>
                <hr>
                <div class="form-group col-md-12">
                    <div class="form-row">
                        <div class="form-group col-2">
                            <div class="input-group">
                                <div class="input-group">Bolsa</div>
                                <input name="t01" id="t01" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjuste()" value="<?php
                                if (isset($valorForm['t01'])) {
                                    echo $valorForm['t01'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">33</div>
                                <input name="t33" id="t33" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjuste()" value="<?php
                                if (isset($valorForm['t33'])) {
                                    echo $valorForm['t33'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">34</div>
                                <input name="t34" id="t34" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjuste()" value="<?php
                                if (isset($valorForm['t34'])) {
                                    echo $valorForm['t34'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">35</div>
                                <input name="t35" id="t35" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjuste()" value="<?php
                                if (isset($valorForm['t35'])) {
                                    echo $valorForm['t35'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">36</div>
                                <input name="t36" id="t36" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjuste()" value="<?php
                                if (isset($valorForm['t36'])) {
                                    echo $valorForm['t36'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">37</div>
                                <input name="t37" id="t37" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjuste()" value="<?php
                                if (isset($valorForm['t37'])) {
                                    echo $valorForm['t37'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">38</div>
                                <input name="t38" id="t38" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjuste()" value="<?php
                                if (isset($valorForm['t38'])) {
                                    echo $valorForm['t38'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">39</div>
                                <input name="t39" id="t39" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjuste()" value="<?php
                                if (isset($valorForm['t39'])) {
                                    echo $valorForm['t39'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">40</div>
                                <input name="t40" id="t40" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjuste()" value="<?php
                                if (isset($valorForm['t40'])) {
                                    echo $valorForm['t40'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">Total</div>
                                <span name="total"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <label><span class="text-danger">*</span> Grade - Outras Cores</label>
                <hr>
                <div class="form-group col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <div class="input-group"><span tabindex="99999" data-toggle="tooltip" data-placement="top" data-html="true" title="Digite as referências das outras cores nas caixas de texto abaixo, Obs. Caso não tenha outras cores, preencha tudo com '0'">
                                    <i class="fas fa-question-circle"></i>
                                </span>- Referência</div>
                            <input name="referencia_2" type="text" class="form-control is-invalid" value="<?php
                            if (isset($valorForm['referencia_2'])) {
                                echo $valorForm['referencia_2'];
                            }
                            ?>" required>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">Bolsa</div>
                                <input name="t01_2" id="t01_2" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteSecond()" value="<?php
                                if (isset($valorForm['t01_2'])) {
                                    echo $valorForm['t01_2'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">33</div>
                                <input name="t33_2" id="t33_2" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteSecond()" value="<?php
                                if (isset($valorForm['t33_2'])) {
                                    echo $valorForm['t33_2'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">34</div>
                                <input name="t34_2" id="t34_2" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteSecond()" value="<?php
                                if (isset($valorForm['t34_2'])) {
                                    echo $valorForm['t34_2'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">35</div>
                                <input name="t35_2" id="t35_2" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteSecond()" value="<?php
                                if (isset($valorForm['t35_2'])) {
                                    echo $valorForm['t35_2'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">36</div>
                                <input name="t36_2" id="t36_2" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteSecond()" value="<?php
                                if (isset($valorForm['t36_2'])) {
                                    echo $valorForm['t36_2'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">37</div>
                                <input name="t37_2" id="t37_2" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteSecond()" value="<?php
                                if (isset($valorForm['t37_2'])) {
                                    echo $valorForm['t37_2'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">38</div>
                                <input name="t38_2" id="t38_2" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteSecond()" value="<?php
                                if (isset($valorForm['t38_2'])) {
                                    echo $valorForm['t38_2'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">39</div>
                                <input name="t39_2" id="t39_2" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteSecond()" value="<?php
                                if (isset($valorForm['t39_2'])) {
                                    echo $valorForm['t39_2'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">40</div>
                                <input name="t40_2" id="t40_2" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteSecond()" value="<?php
                                if (isset($valorForm['t40_2'])) {
                                    echo $valorForm['t40_2'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">Total</div>
                                <span name='total2'></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <input name="referencia_3" type="text" class="form-control is-invalid" value="<?php
                            if (isset($valorForm['referencia_3'])) {
                                echo $valorForm['referencia_3'];
                            }
                            ?>" required>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <input name="t01_3" id="t01_3" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteThird()" value="<?php
                                if (isset($valorForm['t01_3'])) {
                                    echo $valorForm['t01_3'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <input name="t33_3" id="t33_3" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteThird()" value="<?php
                                if (isset($valorForm['t33_3'])) {
                                    echo $valorForm['t33_3'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <input name="t34_3" id="t34_3" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteThird()" value="<?php
                                if (isset($valorForm['t34_3'])) {
                                    echo $valorForm['t34_3'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <input name="t35_3" id="t35_3" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteThird()" value="<?php
                                if (isset($valorForm['t35_3'])) {
                                    echo $valorForm['t35_3'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <input name="t36_3" id="t36_3" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteThird()" value="<?php
                                if (isset($valorForm['t36_3'])) {
                                    echo $valorForm['t36_3'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <input name="t37_3" id="t37_3" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteThird()" value="<?php
                                if (isset($valorForm['t37_3'])) {
                                    echo $valorForm['t37_3'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <input name="t38_3" id="t38_3" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteThird()" value="<?php
                                if (isset($valorForm['t38_3'])) {
                                    echo $valorForm['t38_3'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <input name="t39_3" id="t39_3" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteThird()" value="<?php
                                if (isset($valorForm['t39_3'])) {
                                    echo $valorForm['t39_3'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <input name="t40_3" id="t40_3" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteThird()" value="<?php
                                if (isset($valorForm['t40_3'])) {
                                    echo $valorForm['t40_3'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <span name='total3'></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <input name="referencia_4" type="text" class="form-control is-invalid" value="<?php
                            if (isset($valorForm['referencia_4'])) {
                                echo $valorForm['referencia_4'];
                            }
                            ?>" required>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <input name="t01_4" id="t01_4" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteFourth()" value="<?php
                                if (isset($valorForm['t01_4'])) {
                                    echo $valorForm['t01_4'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <input name="t33_4" id="t33_4" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteFourth()" value="<?php
                                if (isset($valorForm['t33_4'])) {
                                    echo $valorForm['t33_4'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <input name="t34_4" id="t34_4" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteFourth()" value="<?php
                                if (isset($valorForm['t34_4'])) {
                                    echo $valorForm['t34_4'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <input name="t35_4" id="t35_4" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteFourth()" value="<?php
                                if (isset($valorForm['t35_4'])) {
                                    echo $valorForm['t35_4'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <input name="t36_4" id="t36_4" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteFourth()" value="<?php
                                if (isset($valorForm['t36_4'])) {
                                    echo $valorForm['t36_4'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <input name="t37_4" id="t37_4" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteFourth()" value="<?php
                                if (isset($valorForm['t37_4'])) {
                                    echo $valorForm['t37_4'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <input name="t38_4" id="t38_4" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteFourth()" value="<?php
                                if (isset($valorForm['t38_4'])) {
                                    echo $valorForm['t38_4'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <input name="t39_4" id="t39_4" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteFourth()" value="<?php
                                if (isset($valorForm['t39_4'])) {
                                    echo $valorForm['t39_4'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <input name="t40_4" id="t40_4" type="number" class="form-control is-invalid text-center" onchange="somaTotalRefAjusteFourth()" value="<?php
                                if (isset($valorForm['t40_4'])) {
                                    echo $valorForm['t40_4'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <span name='total4'></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input name="justficativa_id" type="hidden" value="<?php echo 3; ?>">
            <div class="form-group">
                <label><span class="text-danger">*</span> Observação</label>
                <textarea name="obs" id="editor" class="form-control is-invalid editorCK" rows="3" required><?php
                    if (isset($valorForm['obs'])) {
                        echo $valorForm['obs'];
                    }
                    ?>
                </textarea>
            </div>
            <input name="status_aj_id" type="hidden" value="<?php echo 2; ?>">
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadAjuste" type="submit" class="btn btn-success" value="Cadastrar">
        </form>
    </div>
</div>