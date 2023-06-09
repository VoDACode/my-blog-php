<form action="/api/comment/create" method="POST">
    <input type="hidden" name="post_id" value="<?= $post_id ?>">
    <textarea name="text" placeholder="Comment"></textarea>
    <input type="submit" value="Submit">
</form>