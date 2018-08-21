<?php
    $thread = $CONTROLLER->getThreadManager()->getThread( $ID );
    $posts = $CONTROLLER->getPostManager()->getPostsFromThread( $ID, $PAGE );
    
    // get the section of the thread to return to it
    $section = $thread->getSection();
?>
<div class="page">
    <div class="container">
        <div class="panel">
            <h2><?= $thread->getName() ?></h2>
            <p>in <a href="<?= $ROOT_URL.'?VIEW=section&ID='.$section->getId() 
                ?>" class="link"><?= $section->getName() ?></a></p>
            <p>by <?= $thread->getUserIp() ?></p>
        </div>
<?php
    foreach( $posts as $post ){
?>
        <div class="panel post">
            <table class="user">
                <tr>
                    <td><?= $post->getUserIp() ?></td>
                    <td class="label"><?= $post->getDate()->format('Y-m-d H:i') ?></td>
                </tr>
            </table>
            <div class="text"><?= $post->getText() ?></div>
        </div>
<?php
    }
    $nbPages = $CONTROLLER->getPostManager()->getNbPagesFromThread( $ID );
    include($ROOT_DIR.'components/pagination.php');
?>
        <div class="panel">
            <form action="<?= $ROOT_DIR.'controller/creators/create_post.php' ?>" method="post">
                <h3>Post a comment</h3>
                <input type="hidden" name="tid" value="<?= $ID ?>" />
                <textarea name="text" rows="10" cols=10 class="textarea" ></textarea><br/>
                <input type="submit" value="Post" class="button" />
            </form>      
        </div>
    </div>
</div>
