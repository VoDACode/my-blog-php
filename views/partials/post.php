<?

use core\Locale;
use core\URL;
use core\View;

?>

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
                        <img src="/fs/download?key=<?= $post['images'][1]['key'] ?>">
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
                <?= nl2br($post['content']) ?>
            </p>
            <div class="files">
                <div class="list">
                    <? if (count($post['files']) > 0) { ?>
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
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="comments">
        <? if ($post['can_have_comments'] == true) : ?>
            <div class="create-comment">
                <? View::renderPartial('partials.comment-create-form', ['post_id' => $post['id']]) ?>
            </div>
            <div class="content" id="comment-content-post-<?= $post['id'] ?>">
                <? foreach ($post['comments'] as $comment) { ?>
                    <? View::renderPartial('partials.comment', ['comment' => $comment]) ?>
                <? } ?>
            </div>
            <div>
                <div>
                    <div class="show-more" id="show-more-button-<?= $post['id'] ?>" style="display:<?= count($post['comments']) > 0 ? 'block' : 'none' ?>" >
                        <span onclick="showMoreComments(<?= $post['id'] ?>, <?= count($post['comments']) ?>)">Show more comments</span>
                    </div>
                </div>
            </div>
        <? elseif ($post['can_have_comments'] == false) : ?>
            <div class="content" id="comment-content-post-<?= $post['id'] ?>">
                <div class="no-comments">
                    <p><?= Locale::get('posts.no-comments') ?></p>
                </div>
            </div>
        <? endif; ?>
    </div>
</div>