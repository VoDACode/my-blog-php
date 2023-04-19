<?
    use core\URL;
?>
<div class="make-post">
    <form action="" method="POST">
        <div class="input-box">
            <input type="text" name="title" id="title" placeholder="Title">
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
                        <img src="http://placeimg.com/640/480/any">
                    </div>
                </div>
            </div>
        </div>
        <div class="input-box">
            <textarea name="text" id="text" placeholder="Content"></textarea>
        </div>
        <div class="input-box">
            <div id="files-drop-area">
                <img src="<?= URL::asset('img/upload.png') ?>">
                <p>Drag and drop files here</p>
            </div>
            <div id="uploaded-file-list">
            </div>
            <input type="file" name="file" id="input-files" multiple="true" />
        </div>
        <div class="input-box">
            <input type="text" name="tags" id="tags" placeholder="Tags">
        </div>
        <div class="input-box checkbox">
            <label for="canHaveComments">Can have comments: </label>
            <input type="checkbox" name="canHaveComments" id="canHaveComments" checked>
        </div>
        <input type="submit" value="Publish post">
    </form>
</div>