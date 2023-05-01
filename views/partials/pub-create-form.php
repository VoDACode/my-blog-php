<?

use core\URL;
use core\Locale;
?>
<div class="make-post">
    <form action="/posts/create" method="POST" enctype="multipart/form-data">
        <div class="input-box">
            <input type="text" name="title" id="title" placeholder="<?= Locale::get('pub-create-form.title') ?>">
        </div>
        <div class="input-box">
            <div class="imgs">
                <div class="selected-image">
                    <img src="">
                </div>
                <div class="image-container" edit-mode="true" id="make-post-imgs">
                    <div disabled id="add-image">
                        <img src="<?= URL::asset('img/plus.svg') ?>">
                    </div>
                    <div>

                    </div>
                </div>
            </div>
        </div>
        <div class="input-box">
            <textarea name="content" id="text" placeholder="<?= Locale::get('pub-create-form.content') ?>"></textarea>
        </div>
        <div class="input-box">
            <div id="files-drop-area">
                <img src="<?= URL::asset('img/upload.png') ?>">
                <p><?= Locale::get('pub-create-form.drag-and-drop') ?></p>
            </div>
            <div id="uploaded-file-list">
            </div>
            <input type="file" name="file[]" id="input-files" multiple />
        </div>
        <div class="input-box checkbox">
            <label for="canHaveComments"><?= Locale::get('pub-create-form.can-have-comments') ?>: </label>
            <input type="checkbox" name="can_have_comments" id="canHaveComments" checked>
        </div>
        <input type="submit" value="<?= Locale::get('pub-create-form.publish') ?>">
    </form>
</div>