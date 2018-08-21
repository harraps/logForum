<?php
    $sections = $CONTROLLER->getSectionManager()->getSections( $PAGE );
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
    $nbPages = $CONTROLLER->getSectionManager()->getNbPages();
    include($ROOT_DIR.'components/pagination.php');
?>
        <div class="panel">
            <form action="<?= $ROOT_DIR.'controller/creators/create_section.php' ?>" method="post">
                <h3>Create new Section</h3>
                <table class="form">
                    <tr>
                        <td class="label">Name</td>
                        <td><input type="text" name="name" class="field" /></td>
                        <td rowspan="2" class="hide-small"><input type="submit" value="Create" class="button" style="height: 44px" /></td>
                    </tr>
                    <tr>
                        <td class="label">Description</td>
                        <td><input type="text" name="desc" class="field" /></td>
                    </tr>
                </table>
                <input type="submit" value="Create" class="button show-small" />
            </form>      
        </div>
    </div>
</div>