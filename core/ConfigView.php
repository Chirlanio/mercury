<?php

namespace Core;

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
            echo 'Erro ao carragar a página ' . $this->Nome . "<br>";
        }
        include 'app/adms/Views/include/rodape_adm.php';
    }

    public function renderizarLogin() {

        include 'app/adms/Views/include/cabecalho.php';
        if (file_exists('app/' . $this->Nome . '.php')) {
            include 'app/' . $this->Nome . '.php';
        } else {
            echo 'Erro ao carragar a página ' . $this->Nome . "<br>";
        }
    }

}
