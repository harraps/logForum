<?php
    //$chats = $CONTROLLER->getChatManager()->getChatEntries();
    $chats = [];
?>
<div class="page">
    <div class="container">
        <div class="panel">
            <h2>Chat</h2>
        </div>
<?php
    foreach( $chats as $chat ){
?>
        <div class="panel post">
            <div class="user">
                <div class="name"><?= $chat->getUser()->getName() ?></div>
                <div class="date"><?= $chat->getDate()->format('Y-m-d H:i:s') ?></div>
            </div>
            <div class="text"><?= $chat->getText() ?></div>
        </div>
<?php
    }
?>
    </div>
</div>
