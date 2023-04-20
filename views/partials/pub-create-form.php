<?
    use core\URL;
?>
<div class="make-post">
    <form action="/posts/create" method="POST" enctype="multipart/form-data">
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
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="input-box">
            <textarea name="content" id="text" placeholder="Content"></textarea>
        </div>
        <div class="input-box">
            <div id="files-drop-area">
                <img src="<?= URL::asset('img/upload.png') ?>">
                <p>Drag and drop files here</p>
            </div>
            <div id="uploaded-file-list">
            </div>
            <input type="file" name="file[]" id="input-files" multiple/>
        </div>
        <div class="input-box checkbox">
            <label for="canHaveComments">Can have comments: </label>
            <input type="checkbox" name="can_have_comments" id="canHaveComments" checked>
        </div>
        <input type="submit" value="Publish post">
    </form>
</div>