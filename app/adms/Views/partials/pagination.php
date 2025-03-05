<?php

// Verifica se existe a chave 'last_page' dentro do array $this->data['pagination'] 
// e se o valor dela não é igual a 1 (ou seja, se há mais de uma página disponível).
if (($this->data['pagination']['last_page'] ?? false) and ($this->data['pagination']['last_page'] != 1)) {
    ?>

    <nav aria-label="...">
        <ul class="pagination justify-content-center pagination-sm">

            <?php

            // Se a página atual for maior que 1, exibe os links para voltar às páginas anteriores.
            if ($this->data['pagination']['current_page'] > 1) {

                // Cria um link para a primeira página (<<)
                echo "<li class='page-item'><a href='" . $_ENV['URL_ADM'] . ($this->data['pagination']['url_controller'] ?? '') . "/1' class='page-link'> Previous </a></li>";

                // Calcula a página anterior à atual
                $beforePage = $this->data['pagination']['current_page'] - 1;

                // Cria um link para a primeira página (<<)
                echo "<li class='page-item'><a href='" . $_ENV['URL_ADM'] . ($this->data['pagination']['url_controller'] ?? '') . "/" . $beforePage . "' class='page-link'> $beforePage </a></li>";
            }

            // Exibe a página atual 
            $currentPage = ($this->data['pagination']['current_page'] ?? '');
            echo "<li class='page-item active' aria-current='page'> <span class='page-link'>$currentPage</span></li>";

            // Verifica se a página atual é menor que a última página disponível
            if ($this->data['pagination']['current_page'] < $this->data['pagination']['last_page']) {

                // Calcula a próxima página
                $afterPage = $this->data['pagination']['current_page'] + 1;

                // Cria um link para a próxima página
                echo "<li class='page-item'><a href='" . $_ENV['URL_ADM'] . ($this->data['pagination']['url_controller'] ?? '') . "/" . $afterPage . "' class='page-link'> $afterPage </a></li>";

                // Cria um link para a última página (>>)
                echo "<li class='page-item'><a href='" . $_ENV['URL_ADM'] . ($this->data['pagination']['url_controller'] ?? ' ') . "/" . ($this->data['pagination']['last_page'] ?? '') . "' class='page-link'> Next </a></li>";
            }
            ?>
        </ul>
    </nav>

<?php } ?>