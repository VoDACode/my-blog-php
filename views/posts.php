<?

use \core\URL;
use \core\Auth;
use \core\View;
use \core\Locale;

?>

<br /><br /><br /><br />
<main>

    <? if (Auth::check() && (Auth::get()['can_make_post'] == 1 || Auth::get()['id'] == 1)) { ?>
        <div class="create-post">
            <? View::renderPartial('partials.pub-create-form') ?>
        </div>
    <? } ?>

    <? if (count($posts) == 0) : ?>
        <div class="no-posts">
            <h1><?= Locale::get('posts.no-posts') ?></h1>
        </div>
    <? else : ?>
        <div class="post-box" id="posts">
            <? foreach ($posts as $post) { ?>
                <? View::renderPartial('partials.post', ['post' => $post]) ?>
            <? } ?>
        </div>
        <script>
            (() => {
                // scroll page event
                var scrollPage = () => {
                    var scroll = window.scrollY;
                    var height = document.body.scrollHeight - window.innerHeight;
                    var percent = scroll / height;
                    if (percent > 0.8) {
                        loadPosts();
                    }
                };
                window.addEventListener('scroll', scrollPage);
                // load posts
                var offset = <?= count($posts) ?>;
                var limit = 10;
                var loading = false;
                var havePosts = true;

                var loadPosts = async () => {
                    if (loading || !havePosts) {
                        return;
                    }
                    loading = true;
                    var response = await fetch('/posts?offset=' + offset + '&limit=' + limit);
                    var posts = await response.text();
                    if (posts == '') {
                        havePosts = false;
                        loading = false;
                        return;
                    }
                    console.log("Loaded " + limit + " posts");
                    offset += limit;
                    document.getElementById('posts').innerHTML += posts;
                    loading = false;
                }
            })();

            var localData = {};

            async function showMoreComments(postId, commentsCount) {
                if(localData[postId] == null) {
                    localData[postId] = {};
                    localData[postId].offset = commentsCount;
                    localData[postId].haveComments = true;
                    localData[postId].loading = false;
                }
                if (localData[postId].haveComments == false || localData[postId].loading == true) {
                    return;
                }
                localData[postId].loading = true;
                var showMoreButton = document.getElementById('show-more-button-' + postId);
                var commentBox = document.getElementById('comment-content-post-' + postId);
                var offset = localData[postId].offset;
                if (offset == null) {
                    offset = commentsCount;
                }
                var limit = 5;
                var response = await fetch('/posts/getComments?post_id=' + postId + '&offset=' + offset + '&limit=' + limit);
                var comments = await response.text();
                if (comments == '') {
                    showMoreButton.style.display = 'none';
                    localData[postId].haveComments = false;
                    return;
                }
                offset += limit;
                localData[postId].offset = offset;
                commentBox.innerHTML += comments;
                localData[postId].loading = false;
            }
        </script>
    <? endif; ?>
</main>