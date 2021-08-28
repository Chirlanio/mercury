<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['select']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Ajuste de Estoque</h2>
            </div>
            <?php
            if ($this->Dados['botao']['vis_ajuste']) {
            ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ver-ajuste/ver-ajuste/' . $valorForm['id']; ?>" class="btn btn-outline-primary btn-sm"><i class='fas fa-eye d-block d-md-none fa-2x'></i> <span class='d-none d-md-block'>Visualizar</span></a>
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
        <form method="POST" action="" enctype="multipart/form-data">
            <input name="id" type="hidden" value="<?php
                                                    if (isset($valorForm['id'])) {
                                                        echo $valorForm['id'];
                                                    }
                                                    ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Nome</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        echo '<select name="solicitante" id="solicitante" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['func_id_sol'] as $sol) {
                            extract($sol);
                            if ($valorForm['func_id_sol'] == $func_id_sol) {
                                echo "<option value='$func_id_sol' selected>$consul_sol</option>";
                            } else {
                                echo "<option value='$func_id_sol'>$consul_sol</option>";
                            }
                        }
                    } else {
                        echo '<select name="solicitante" id="solicitante" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['func_id_sol'] as $sol) {
                            extract($sol);
                            if ($valorForm['func_id_sol'] == $func_id_sol) {
                                echo "<option value='$func_id_sol' selected>$consul_sol</option>";
                            } else {
                                echo "<option value='$func_id_sol'>$consul_sol</option>";
                            }
                        }
                    }
                    echo "</select>";
                    ?>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Loja</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        echo '<select name="loja_id" id="loja_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['loja_id'] as $loja) {
                            extract($loja);
                            if ($valorForm['loja_id'] == $loja_id) {
                                echo "<option value='$loja_id' selected>$loja</option>";
                            } else {
                                echo "<option value='$loja_id'>$loja</option>";
                            }
                        }
                    } else {
                        echo '<select name="loja_id" id="loja_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['loja_id'] as $loja) {
                            extract($loja);
                            if ($valorForm['loja_id'] == $loja_id) {
                                echo "<option value='$loja_id' selected>$loja</option>";
                            } else {
                                echo "<option value='$loja_id'>$loja</option>";
                            }
                        }
                    }
                    ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Consultora</label>
                    <select name="func_id" id="func_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['func_id'] as $consul) {
                            extract($consul);
                            if ($valorForm['func_id'] == $func_id) {
                                echo "<option value='$func_id' selected>$consul</option>";
                            } else {
                                echo "<option value='$func_id'>$consul</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Cliente</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        echo '<input name="cliente" type="text" class="form-control" aria-label="Disabled input" disabled placeholder="Nome da Consultora da venda" value="';
                        if (isset($valorForm['cliente'])) {
                            echo $valorForm['cliente'];
                        }
                    } else {
                        echo '<input name="cliente" type="text" class="form-control" placeholder="Nome do solicitante do ajuste" value ="';
                        if (isset($valorForm['cliente'])) {
                            echo $valorForm['cliente'];
                        }
                    }
                    ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Referência</label>
                    <input name="referencia" type="text" class="form-control" placeholder="Referência" value="<?php
                                                                                                                if (isset($valorForm['referencia'])) {
                                                                                                                    echo $valorForm['referencia'];
                                                                                                                }
                                                                                                                ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger text-center">*</span> Tamanho</label>
                    <select name="tam_id" id="tam_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['tam_id'] as $tam) {
                            extract($tam);
                            if ($valorForm['tam_id'] == $id_tam) {
                                echo "<option value='$id_tam' selected>$tam</option>";
                            } else {
                                echo "<option value='$id_tam'>$tam</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Qtd</label>
                    <input name="qtde" type="number" class="form-control text-center" value="<?php
                                                                                                if (isset($valorForm['qtde'])) {
                                                                                                    echo $valorForm['qtde'];
                                                                                                }
                                                                                                ?>">
                </div>
            </div>
            <!-- Aqui começa a grade da referência com saldo insuficiente-->
            <div class="form-row">
                <label><span class="text-danger">*</span> Grade</label>
                <hr>
                <div class="form-group col-md-12">
                    <div class="form-row">
                        <div class="form-group col-auto">
                            <div class="input-group">
                                <div class="input-group">Bolsa</div>
                                <input name="t01" id="t01" type="number" class="form-control text-center" value="<?php
                                                                                                                    if (isset($valorForm['t01'])) {
                                                                                                                        echo $valorForm['t01'];
                                                                                                                    }
                                                                                                                    ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">33</div>
                                <input name="t33" id="t33" type="number" class="form-control text-center" value="<?php
                                                                                                                    if (isset($valorForm['t33'])) {
                                                                                                                        echo $valorForm['t33'];
                                                                                                                    }
                                                                                                                    ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">34</div>
                                <input name="t34" id="t34" type="number" class="form-control text-center" value="<?php
                                                                                                                    if (isset($valorForm['t34'])) {
                                                                                                                        echo $valorForm['t34'];
                                                                                                                    }
                                                                                                                    ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">35</div>
                                <input name="t35" id="bolsa" type="number" class="form-control text-center" value="<?php
                                                                                                                    if (isset($valorForm['t35'])) {
                                                                                                                        echo $valorForm['t35'];
                                                                                                                    }
                                                                                                                    ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">36</div>
                                <input name="t36" id="t36" type="number" class="form-control text-center" value="<?php
                                                                                                                    if (isset($valorForm['t36'])) {
                                                                                                                        echo $valorForm['t36'];
                                                                                                                    }
                                                                                                                    ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">37</div>
                                <input name="t37" id="t37" type="number" class="form-control text-center" value="<?php
                                                                                                                    if (isset($valorForm['t37'])) {
                                                                                                                        echo $valorForm['t37'];
                                                                                                                    }
                                                                                                                    ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">38</div>
                                <input name="t38" id="t38" type="number" class="form-control text-center" value="<?php
                                                                                                                    if (isset($valorForm['t38'])) {
                                                                                                                        echo $valorForm['t38'];
                                                                                                                    }
                                                                                                                    ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">39</div>
                                <input name="t39" id="t39" type="number" class="form-control text-center" value="<?php
                                                                                                                    if (isset($valorForm['t39'])) {
                                                                                                                        echo $valorForm['t39'];
                                                                                                                    }
                                                                                                                    ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">40</div>
                                <input name="t40" id="t40" type="number" class="form-control text-center" value="<?php
                                                                                                                    if (isset($valorForm['t40'])) {
                                                                                                                        echo $valorForm['t40'];
                                                                                                                    }
                                                                                                                    ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Aqui termina a grade da referência com saldo insuficiente-->
            <hr>
            <label><span class="text-danger">*</span> Grade - Outras Cores</label>
            <!-- Aqui começa a grade das outras cores-->
            <div class="form-row">
                <div class="input-group col-md-2">
                    <input name="referencia_2" id="referencia_2" type="text" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['referencia_2'])) {
                                                                                                                            echo $valorForm['referencia_2'];
                                                                                                                        }
                                                                                                                        ?>">
                </div>
                <div class="form-group col-md-12">
                    <div class="form-row">
                        <div class="form-group col-auto">
                            <div class="input-group">
                                <div class="input-group">Bolsa</div>
                                <input name="t01_2" id="t01_2" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t01_2'])) {
                                                                                                                            echo $valorForm['t01_2'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">33</div>
                                <input name="t33_2" id="t33_2" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t33_2'])) {
                                                                                                                            echo $valorForm['t33_2'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">34</div>
                                <input name="t34_2" id="t34_2" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t34_2'])) {
                                                                                                                            echo $valorForm['t34_2'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">35</div>
                                <input name="t35_2" id="t35_2" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t35_2'])) {
                                                                                                                            echo $valorForm['t35_2'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">36</div>
                                <input name="t36_2" id="t36_2" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t36_2'])) {
                                                                                                                            echo $valorForm['t36_2'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">37</div>
                                <input name="t37_2" id="t37_2" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t37_2'])) {
                                                                                                                            echo $valorForm['t37_2'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">38</div>
                                <input name="t38_2" id="t38_2" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t38_2'])) {
                                                                                                                            echo $valorForm['t38_2'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">39</div>
                                <input name="t39_2" id="t39_2" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t39_2'])) {
                                                                                                                            echo $valorForm['t39_2'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">40</div>
                                <input name="t40_2" id="t40_2" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t40_2'])) {
                                                                                                                            echo $valorForm['t40_2'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="input-group col-md-2">
                    <input name="referencia_3" id="referencia_3" type="text" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['referencia_3'])) {
                                                                                                                            echo $valorForm['referencia_3'];
                                                                                                                        }
                                                                                                                        ?>">
                </div>
                <div class="form-group col-md-12">
                    <div class="form-row">
                        <div class="form-group col-auto">
                            <div class="input-group">
                                <div class="input-group">Bolsa</div>
                                <input name="t01_3" id="t01_3" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t01_3'])) {
                                                                                                                            echo $valorForm['t01_3'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">33</div>
                                <input name="t33_3" id="t33_3" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t33_3'])) {
                                                                                                                            echo $valorForm['t33_3'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">34</div>
                                <input name="t34_3" id="t34_3" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t34_3'])) {
                                                                                                                            echo $valorForm['t34_3'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">35</div>
                                <input name="t35_3" id="t35_3" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t35_3'])) {
                                                                                                                            echo $valorForm['t35_3'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">36</div>
                                <input name="t36_3" id="t36_3" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t36_3'])) {
                                                                                                                            echo $valorForm['t36_3'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">37</div>
                                <input name="t37_3" id="t37_3" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t37_3'])) {
                                                                                                                            echo $valorForm['t37_3'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">38</div>
                                <input name="t38_3" id="t38_3" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t38_3'])) {
                                                                                                                            echo $valorForm['t38_3'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">39</div>
                                <input name="t39_3" id="t39_3" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t39_3'])) {
                                                                                                                            echo $valorForm['t39_3'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">40</div>
                                <input name="t40_3" id="t40_3" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t40_3'])) {
                                                                                                                            echo $valorForm['t40_3'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="input-group col-md-2">
                    <input name="referencia_4" id="referencia_4" type="text" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['referencia_4'])) {
                                                                                                                            echo $valorForm['referencia_4'];
                                                                                                                        }
                                                                                                                        ?>">
                </div>
                <div class="form-group col-md-12">
                    <div class="form-row">
                        <div class="form-group col-auto">
                            <div class="input-group">
                                <div class="input-group">Bolsa</div>
                                <input name="t01_4" id="t01_4" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t01_4'])) {
                                                                                                                            echo $valorForm['t01_4'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">33</div>
                                <input name="t33_4" id="t33_4" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t33_4'])) {
                                                                                                                            echo $valorForm['t33_4'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">34</div>
                                <input name="t34_4" id="t34_4" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t34_4'])) {
                                                                                                                            echo $valorForm['t34_4'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">35</div>
                                <input name="t35_4" id="t35_4" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t35_4'])) {
                                                                                                                            echo $valorForm['t35_4'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">36</div>
                                <input name="t36_4" id="t36_4" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t36_4'])) {
                                                                                                                            echo $valorForm['t36_4'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">37</div>
                                <input name="t37_4" id="t37_4" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t37_4'])) {
                                                                                                                            echo $valorForm['t37_4'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">38</div>
                                <input name="t38_4" id="t38_4" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t38_4'])) {
                                                                                                                            echo $valorForm['t38_4'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">39</div>
                                <input name="t39_4" id="t39_4" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t39_4'])) {
                                                                                                                            echo $valorForm['t39_4'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="form-group col-1">
                            <div class="input-group">
                                <div class="input-group">40</div>
                                <input name="t40_4" id="t40_4" type="number" class="form-control text-center" value="<?php
                                                                                                                        if (isset($valorForm['t40_4'])) {
                                                                                                                            echo $valorForm['t40_4'];
                                                                                                                        }
                                                                                                                        ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label><span class="text-danger">*</span> Observação</label>
                <textarea name="obs" id="editor" class="form-control" rows="3"><?php
                                                                                if (isset($valorForm['obs'])) {
                                                                                    echo $valorForm['obs'];
                                                                                }
                                                                                ?>
                </textarea>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Situação</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        echo '<select name="status_aj_id" id="status_aj_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sit_id'] as $sit) {
                            extract($sit);
                            if ($valorForm['sit_id'] == $sit_id) {
                                echo "<option value='$sit_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$sit_id'>$sit</option>";
                            }
                        }
                    } else {
                        echo '<select name="status_aj_id" id="status_aj_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sit_id'] as $sit) {
                            extract($sit);
                            if ($valorForm['sit_id'] == $sit_id) {
                                echo "<option value='$sit_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$sit_id'>$sit</option>";
                            }
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
            <input name="EditAjuste" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>