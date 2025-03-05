<?php

// Inclui o cabeçalho da página. Este arquivo contém elementos comuns ao topo de todas as páginas, como links para CSS e scrips Javascript
include 'app/adms/Views/partials/head.php';
?>
<body class="bg-dark d-flex flex-column min-vh-100">

<div id="layoutAuthentication_content">
    <main>
        <div class="container">
            <div class="row justify-content-center">


<?php
// Inclui o conteúdo principal da página, que é especificado pela propriedade $this->view. Este arquivo é dinâmico e pode varias conforme a lógica do controlador ou o contexto do página.
include $this->view;

?>
<?php include 'app/adms/Views/partials/footer.php'; ?>

