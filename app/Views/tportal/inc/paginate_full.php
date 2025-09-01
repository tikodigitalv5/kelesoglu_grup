<?php $pager->setSurroundCount(2);
        if(session()->getFlashdata('pagination_filters')){
            $filters = session()->getFlashdata('pagination_filters');
        } else {
            $filters = '';
        }
?>

<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
    <ul class="pagination">
        <?php if ($pager->hasPreviousPage()) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getFirst().$filters ?>" aria-label="İlk">
                    <span aria-hidden="true">İlk</span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getPreviousPage().$filters ?>" aria-label="Geri">
                    <span aria-hidden="true">Geri</span>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link):
        ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'].$filters ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNextPage()) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getNextPage().$filters ?>" aria-label="İleri">
                    <span aria-hidden="true">İleri</span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getLast().$filters ?>" aria-label="Son">
                    <span aria-hidden="true">Son</span>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>