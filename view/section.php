<?php
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
                    <a href="<?= $ROOT_URL.'?VIEW=thread&ID='.$thread->getId() ?>" class="clearfix thread">
                        <div class="name"><?= $thread->getName() ?></div>
                        <div class="info"><?= $thread->getDate()->format('Y-m-d H:i') ?></div>
                    </a>
                </li>
<?php
    }
?>
            </ul>
        </div>
<?php
    $nbPages = $CONTROLLER->getThreadManager()->getNbPagesFromSection( $ID );
    include($ROOT_DIR.'components/pagination.php');
?>
        <div class="panel">
            <form action="<?= $ROOT_DIR.'controller/creators/create_thread.php' ?>" method="post">
                <h3>Create new Thread</h3>
                <input type="hidden" name="sid" value="<?= $ID ?>" />
                <table class="form">
                    <tr>
                        <td class="label">Name</td>
                        <td><input type="text" name="name" class="field" /></td>
                        <td><input type="submit" value="Create" class="button" /></td>
                    </tr>
                </table>
            </form>      
        </div>
    </div>
</div>
