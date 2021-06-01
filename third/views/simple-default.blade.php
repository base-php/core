<?php if ($paginator['paginator']->hasPages()): ?>

    <ul class="pagination">
        <?php if ($paginator['paginator']->onFirstPage()): ?>
            <li class="disabled"><span>&laquo;</span></li>

        <?php else: ?>
            <li><a href="<?php echo $_SERVER['REDIRECT_URL'] . $paginator['paginator']->previousPageUrl(); ?>" rel="prev">&laquo;</a></li>
        <?php endif;?>

        <?php if ($paginator['paginator']->hasMorePages()): ?>
            <li><a href="<?php echo $_SERVER['REDIRECT_URL'] . $paginator['paginator']->nextPageUrl(); ?>" rel="next">&raquo;</a></li>

        <?php else: ?>
            <li class="disabled"><span>&raquo;</span></li>

        <?php endif;?>

    </ul>
<?php endif;?>
