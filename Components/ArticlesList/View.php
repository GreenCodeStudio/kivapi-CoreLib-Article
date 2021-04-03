<div>
    <?php
    foreach ($this->list as $article) {
        ?>
        <a href="" class="articleWrapper">
            <article>
                <h1><?= htmlspecialchars($article->title) ?></h1>
                <div class="date"><?= $article->stamp ?></div>
                <div class="article-content">
                    <?=$article->content?>
                </div>
            </article>
        </a>
        <?php
    }
    ?>
</div>