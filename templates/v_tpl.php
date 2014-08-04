<?php
if(isset($pass[1])):
    $page = $handler->get($pass[0], $pass[1]);
?>
<div class="margined">
    <h2 class="header">Viewing paste <?= $pass[0] ?> - <?=$page['syntax']?></h2>
    <span><a href="/_raw/<?=$pass[0]?>/<?=$pass[1]?>/">(raw)</a></span>
    <pre data-language="<?=$page['syntax']?>">
<?=$page['text'];?>
    </pre>
</div>
<?php endif; ?>