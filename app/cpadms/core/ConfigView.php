<?php

namespace App\cpadms\core;

/**
 * Description of ConfigView
 *
 * @author Chirlanio Silva - Grupo Meia Sola
 */
class ConfigView {

    private $Nome;
    private $Dados;

    public function __construct($Nome, array $Dados = null) {
        $this->Nome = (string) $Nome;
        $this->Dados = $Dados;
    }

    public function renderizar() {
        include 'app/adms/Views/include/cabecalho_adm.php';
        include 'app/adms/Views/include/header.php';
        include 'app/adms/Views/include/sidebar.php';
        if (file_exists('app/' . $this->Nome . '.php')) {
            include 'app/' . $this->Nome . '.php';
        } else {
            echo "Erro ao carregar a Página: {$this->Nome}";
        }
        include 'app/cpadms/Views/include/rodape_cpadm.php';
    }

    public function renderizarListar() {
        if (file_exists('app/' . $this->Nome . '.php')) {
            include 'app/' . $this->Nome . '.php';
        } else {
            echo "Erro ao carregar a Página: {$this->Nome}";
        }
    }

}
