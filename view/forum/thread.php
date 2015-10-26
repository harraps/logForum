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
    $begPage = $PAGE-2;
    $endPage = $PAGE+2;
    while( $begPage < 0 )        ++$begPage;
    while( $endPage > $nbPages ) --$endPage;
?>
        <div class="panel pagination">
            <ul>
<?php
    if( $PAGE > 0 ){
?>
                <li>
                    <a href="<?= $URL.'&PAGE=0' ?>" > << </a>
                </li>
<?php
    }
    for( $i = $begPage; $i < $endPage; ++$i ){
?>
                <li>
                    <a href="<?= $URL.'&PAGE='.$i ?>" > <?= $i+1 ?> </a>
                </li>
<?php
    }
    if( $PAGE < ($nbPages-1) ){
?>
                <li>
                    <a href="<?= $URL.'&PAGE='.($nbPages-1) ?>" > >> </a>
                </li>
<?php
    }
?>
            </ul>
        </div>
    </div>
</div>
