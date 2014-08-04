<div class="margined">
    <form method="post" action="/submit.php" class="paste">
        <label for="make">Paste your text here!</label>
        <textarea id="make" name="text" placeholder="<?= get('text') ?>"></textarea>
        <label for="syntax">Pick a syntax language for highlighting!</label>
        <select id="syntax" name="syntax">
            <?= $handler->getLanguages_html() ?>
        </select>
        <button type="submit">Submit!</button>
    </form>
</div>
