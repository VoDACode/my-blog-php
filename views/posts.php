<?

use \core\URL;
use \core\Auth;
use \core\View;
?>

<main>

    <? if (Auth::check() && (Auth::get()['can_make_post'] == 1 || Auth::get()['id'] == 1)) { ?>
        <div class="create-post">
            <? View::renderPartial('partials.pub-create-form') ?>
        </div>
    <? } ?>

    <div class="post-box">
        <? foreach ($posts as $post) { ?>
            <div class="post" id="<?= $post['id'] ?>">
                <div class="vote">
                    <div class="upvote"></div>
                    <div class="rating">
                        <p><?= $post['rating'] ?></p>
                    </div>
                    <div class="downvote"></div>
                </div>
                <div class="content">
                    <div class="header">
                        <h2 class="title"><?= $post['title'] ?></h2>
                        <div class="date">
                            <div class="post">
                                <p><?= $post['date'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="imgs">
                        <div class="selected-image">
                            <img src="">
                        </div>
                        <div class="image-container">
                            <? foreach ($post['images'] as $image) { ?>
                                <div>
                                    <img src="<?= $image ?>">
                                </div>
                            <? } ?>
                        </div>
                    </div>
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
                                        <a href="/fs/d?id=<?= $file['id'] ?>"><?= $file['name'] ?></a>
                                    </div>
                                    <div class="size">
                                        <p><?
                                            if ($file['size'] < 1024) {
                                                echo $file['size'] . ' B';
                                            } else if ($file['size'] < 1048576) {
                                                echo round($file['size'] / 1024, 2) . ' KB';
                                            } else if ($file['size'] < 1073741824) {
                                                echo round($file['size'] / 1048576, 2) . ' MB';
                                            } else if ($file['size'] < 1099511627776) {
                                                echo round($file['size'] / 1073741824, 2) . ' GB';
                                            } else {
                                                echo round($file['size'] / 1099511627776, 2) . ' TB';
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
        <? } ?>
    </div>
</main>