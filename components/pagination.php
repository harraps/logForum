<?php
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
