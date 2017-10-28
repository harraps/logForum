<?php
    $sec_page = 0;
    $sections = $CONTROLLER->getSectionManager()->getSections( $sec_page );
?>
<div class="page">
    <div class="container">
        <div class="panel">
            <h2>Forum</h2>
        </div>
        <div class="panel section-list">
            <ul>
<?php
    foreach( $sections as $section ){
?>
                <li>
                    <a href="<?= $ROOT_URL.'?VIEW=section&ID='.$section->getId() ?>" class="clearfix section">
                        <div class="name"><?= $section->getName()        ?></div>
                        <div class="info"><?= $section->getDescription() ?></div>
                    </a>
                </li>
<?php
    }
?>
            </ul>
        </div>
<?php
    $nbPages = $CONTROLLER->getSectionManager()->getNbPages( $ID );
    include('components/pagination.php');
?>
    </div>
</div>