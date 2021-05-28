<?php if ($paginator['paginator']->hasPages()): ?>

    <ul class="pagination">
        <?php if ($paginator['paginator']->onFirstPage()): ?>
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>

        <?php else: ?>
            <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['REDIRECT_URL'] . $paginator['paginator']->previousPageUrl(); ?>" rel="prev">&laquo;</a></li>
        <?php endif;?>

        <?php if ($paginator['paginator']->hasMorePages()): ?>
            <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['REDIRECT_URL'] . $paginator['paginator']->nextPageUrl(); ?>" rel="next">&raquo;</a></li>

        <?php else: ?>
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        <?php endif;?>
    </ul>

<?php endif;?>