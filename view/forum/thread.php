<?php
    $thread = $CONTROLLER->getThreadManager()->getThread( $ID );
    $posts[] = $CONTROLLER->getPostManager()->getPostFromThread( $ID, $PAGE );
?>
<div class="page">
    <div class="container">
        <div class="panel">
            <h2><?= $thread->getName() ?></h2>
            <p>by <?= $thread->getUser()->getName() ?></p>
        </div>
<?php
    foreach( $posts as $post ){
?>
        <div class="panel post">
            <div class="user">
                <div class="name"><?= $post->getUser()->getName() ?></div>
                <div class="date"><?= $post->getDate() ?></div>
            </div>
            <div class="text"><?= $post->getText() ?></div>
        </div>
<?php
    }
    $nbPages = $CONTROLLER->getPostManager()->getNbPagesFromThread( $ID );
    include('view/common/pagination.php');
?>
    </div>
</div>
