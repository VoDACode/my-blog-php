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
        <div class="post-box">
            <? foreach ($posts as $post) { ?>
                <div class="item">
                    <div class="post" id="post-<?= $post['id'] ?>">
                        <div class="vote">
                            <a class="upvote" selected="<?= $post['my_rating'] == 1 ? true : false ?>" href="/posts/rating?rating=<?= $post['my_rating'] == 1 ? 0 : 1 ?>&post_id=<?= $post['id'] ?>"></a>
                            <div class="rating">
                                <p><?= $post['rating'] ?></p>
                            </div>
                            <a class="downvote" selected="<?= $post['my_rating'] == -1 ? true : false ?>" href="/posts/rating?rating=<?= $post['my_rating'] == -1 ? 0 : -1 ?>&post_id=<?= $post['id'] ?>"></a>
                        </div>
                        <div class="content">
                            <div class="header">
                                <h2 class="title"><?= $post['title'] ?></h2>
                                <div class="date">
                                    <div class="post">
                                        <p><?= $post['created_at'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <? if (count($post['images']) > 0) { ?>
                                <div class="imgs">
                                    <div class="selected-image">
                                        <img src="/fs/download?key=<?= $post['images'][0]['key'] ?>">
                                    </div>
                                    <div class="image-container">
                                        <? foreach ($post['images'] as $image) { ?>
                                            <div>
                                                <img src="/fs/download?key=<?= $image['key'] ?>">
                                            </div>
                                        <? } ?>
                                    </div>
                                </div>
                            <? } ?>
                            <p>
                                <?= $post['content'] ?>
                            </p>
                            <div class="files">
                                <div class="list">
                                    <? foreach ($post['files'] as $file) { ?>
                                        <div class="file">
                                            <div class="file-type">
                                                <img src="<?= URL::asset('img/file.png') ?>">
                                            </div>
                                            <div class="name">
                                                <a href="/fs/download?key=<?= $file['key'] ?>"><?= $file['name'] ?></a>
                                            </div>
                                            <div class="size">
                                                <p><?
                                                    if ($file['size'] < 1024) {
                                                        echo $file['size'] . ' ' . Locale::get('posts.size.b');
                                                    } else if ($file['size'] < 1048576) {
                                                        echo round($file['size'] / 1024, 2) . ' ' . Locale::get('posts.size.kb');
                                                    } else if ($file['size'] < 1073741824) {
                                                        echo round($file['size'] / 1048576, 2) . ' ' . Locale::get('posts.size.mb');
                                                    } else if ($file['size'] < 1099511627776) {
                                                        echo round($file['size'] / 1073741824, 2) . ' ' . Locale::get('posts.size.gb');
                                                    } else {
                                                        echo round($file['size'] / 1099511627776, 2) . ' ' . Locale::get('posts.size.tb');
                                                    }
                                                    ?></p>
                                            </div>
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="comments">
                        <div class="create-comment">
                            <? View::renderPartial('partials.comment-create-form', ['post_id' => $post['id']]) ?>
                        </div>
                        <? if ($post['can_have_comments'] == true) : ?>
                            <div class="content">
                                <? foreach ($post['comments'] as $comment) { ?>
                                    <? View::renderPartial('partials.comment', ['comment' => $comment]) ?>
                                <? } ?>
                            </div>
                        <? endif; ?>
                    </div>
                </div>
            <? } ?>
        </div>
    <? endif; ?>
</main>