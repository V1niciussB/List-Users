<?php

if (isset($this->data['errors'])) {

    foreach ($this->data['errors'] as $error) {

        echo "<div class='alert alert-danger' role='alert'> $error </div>";
    }
}

if (isset($_SESSION['error'])) {

    echo "<div class='alert alert-danger' role='alert'> {$_SESSION['error']} </div>";

    unset($_SESSION['error']);
}

if (isset($_SESSION['mensagem'])) {

    echo "<div class='alert alert-success' role='alert'> {$_SESSION['mensagem']} </div>";

    unset($_SESSION['mensagem']);
}

?>