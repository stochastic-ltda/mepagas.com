<?php

    // obtengo pagina actual
    $page = 0;
    if(isset($_REQUEST['p']) && !is_null($_REQUEST['p'])) $page = $_REQUEST['p'];
    $page++;

    // total de paginas
    $totalPages = (int) ($total / 5);
    if($total % 20 > 0) $totalPages++;

    $url = current(explode("?",$_SERVER['REQUEST_URI']));

    $url_init = $url;
    $url_prev = $url . "?p=" . ($page-2);
    $url_next = $url . "?p=" . ($page);
    $url_last = $url . "?p=" . ($totalPages-1);
    
?>


        <? if($page > 1) : ?>
            <a href="<?=$url_init?>" class="btn"><img src="/assets/img/first_page.png"></a>
            <a href="<?=$url_prev?>" class="btn"><img src="/assets/img/previous_page.png"></a>
        <? endif; ?>

        <a href="#" class="btn" id="paginador_info">Página <?=$page?> de <?=number_format($totalPages,0,",",".")?></a>

        <? if($page < $totalPages): ?>
            <a href="<?=$url_next?>" class="btn"><img src="/assets/img/next_page.png"></i></a>
            <a href="<?=$url_last?>" class="btn"><img src="/assets/img/last_page.png"></i></a>
        <? endif; ?>
