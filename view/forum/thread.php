<?php
    $thread = $CONTROLLER->getThreadManager()->getThread( $id );
    $posts[] = $CONTROLLER->getPostManager()->getPostFromThread( $id, $PAGE );
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
    $nbPages = $CONTROLLER->getPostManager()->getNbPagesFromThread( $id );
    include('view/common/pagination.php');
?>
    </div>
</div>
