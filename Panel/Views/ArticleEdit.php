<form>
    <div class="topBarButtons">
        <button class="button" type="button"><span class="icon-cancel"></span><?= t("Core.Panel.Common.Cancel") ?></button>
        <button class="button"><span class="icon-save"></span><?= t("Core.Panel.Common.Save") ?></button>
    </div>
    <div class="grid page-Article page-Article-edit">
        <input name="id" type="hidden">
        <section class="card" data-width="6">
            <header>
                <h1>Article</h1>
            </header>
            <label>
                <span><?= t("CoreLib.Article.Panel.Fields.title") ?></span>
                <input name="title">
            </label>
            <label>
                <span><?= t("CoreLib.Article.Panel.Fields.content") ?></span>
                <div class="editor-container"></div>
            </label>
        </section>
    </div>
</form>