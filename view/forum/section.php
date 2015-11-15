<?php
    $sec_page = 0;
    $section = $CONTROLLER->getSectionManager()->getSection( $ID );
    $sections[] = $CONTROLLER->getSectionManager()->getSectionsFromParent( $ID, $sec_page );
    $threads [] = $CONTROLLER->getThreadManager ()->getThreadsFromSection( $ID, $PAGE );
?>
<div class="page">
    <div class="container">
        <div class="panel">
            <h2><?= $section->getName() ?></h2>
            <p>by <?= $section->getUser()->getName() ?></p>
        </div>
        <div class="panel section-list">
            <ul>
<?php
    foreach( $sections as $sec ){
?>
                <li>
                    <a href="<?= $ROOT_URL.'?VIEW=section&ID='.$sec->getId() ?>" class="clearfix section">
                        <div class="name"><?= $sec->getName() ?></div>
                        <div class="info">Last Thread</div>
                        <div class="info">2015-10-08 12:45:39</div>
                    </a>
                </li>
<?php
    }
?>
            </ul>
        </div>
<?php
    $nbPages = $CONTROLLER->getPostManager()->getNbPagesFromThread( $ID );
    include('view/common/pagination.php');
?>
    </div>
</div>
