<?php
    $sec_page = 0;
    $section = $CONTROLLER->getSectionManager()->getSection( $ID );
    $threads = $CONTROLLER->getThreadManager ()->getThreadsFromSection( $ID, $PAGE );
?>
<div class="page">
    <div class="container">
        <div class="panel">
            <h2><?= $section->getName() ?></h2>
        </div>
        <div class="panel thread-list">
            <ul>
<?php
    foreach( $threads as $thread ){
?>
                <li>
                    <a href="<?= $ROOT_URL.'?VIEW=thread&ID='.$thread->getId() ?>" class="clearfix section">
                        <div class="name"><?= $thread->getName() ?></div>
                        <div class="info">Last Post</div>
                        <div class="info"><?= $thread->getDate()->format('Y-m-d H:i') ?></div>
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
