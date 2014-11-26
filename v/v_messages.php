
<?php foreach ($messages as $message) :?>
    <?php if ($message['viewed'] == 'yes'): ?>
        <div class="jumbotron message_viewed">
    <?php else: ?>
        <div class="jumbotron">
    <?php endif; ?>
        <h4><?=$message['title']?></h4>
        <div class="message_body"><?=$message['content']?></div>
        <div>
            <?php if ($message['viewed'] == 'no'): ?>
                <a class="btn btn-primary btn-xs" href="index.php?act=MarkMessageAsViewed&id=<?=$message['id']?>&returnPage=<?=$_GET['act']?>">Пометить как прочитанное</a>
            <?php endif; ?>
            <a class="btn btn-primary btn-xs" href="index.php?act=DeleteMessage&id=<?=$message['id']?>&returnPage=<?=$_GET['act']?>">Удалить</a>
        </div>
    </div>
<?php endforeach; ?>



