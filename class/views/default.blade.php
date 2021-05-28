<?php if ($paginator['paginator']->hasPages()): ?>

    <ul class="pagination">
        <?php if ($paginator['paginator']->onFirstPage()): ?>
            <li class="disabled"><span>&laquo;</span></li>

        <?php else: ?>
            <li><a href="<?php echo $_SERVER['REDIRECT_URL'] . $paginator['paginator']->previousPageUrl(); ?>" rel="prev">&laquo;</a></li>

        <?php endif;?>

        <?php foreach ($paginator['elements'] as $element): ?>

            <?php if (is_string($element)): ?>
                <li class="disabled"><span><?php echo $element; ?></span></li>
            <?php endif;?>

            <?php if (is_array($element)): ?>
                <?php foreach ($element as $page => $url): ?>

                    <?php if ($page == $paginator['paginator']->currentPage()): ?>
                        <li class="active"><span><?php echo $page; ?></span></li>

                    <?php else: ?>
                        <li><a href="<?php echo $_SERVER['REDIRECT_URL'] . $url; ?>"><?php echo $page; ?></a></li>
                    <?php endif;?>

                <?php endforeach;?>

            <?php endif;?>

        <?php endforeach;?>

        <?php if ($paginator['paginator']->hasMorePages()): ?>
            <li><a href="<?php echo $_SERVER['REDIRECT_URL'] . $paginator['paginator']->nextPageUrl(); ?>" rel="next">&raquo;</a></li>

        <?php else: ?>
            <li class="disabled"><span>&raquo;</span></li>

        <?php endif;?>
    </ul>

<?php endif;?>