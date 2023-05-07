<?

use \core\Locale;

?>
<div class="item" comment-id="<?= $comment['id'] ?>">
    <div class="post">
        <div class="vote">
            <div class="upvote"></div>
            <div class="rating">
                <p><?= $comment['rating'] ?></p>
            </div>
            <div class="downvote"></div>
        </div>
        <div>
            <div class="header">
                <div class="name" user-id="<?= $comment['user']['id'] ?>">
                    <p><?= $comment['user']['name'] ?></p>
                </div>
                <div class="date">
                    <div class="last-edit">
                        <? if (isset($comment['modified'])) { ?>
                            <p><?= Locale::get('comment.modified') ?>: <?= $comment['modified'] ?></p>
                        <? } ?>
                    </div>
                    <div class="post">
                        <p><?= Locale::get('comment.published') ?>: <?= $comment['date'] ?></p>
                    </div>
                </div>
            </div>
            <div class="comment">
                <p>
                    <?= $comment['text'] ?>
                </p>
            </div>
        </div>
    </div>
    <div class="answers">
        <div class="content">
            <? if ($comment['has_replies'] == true) { ?>
                <span class="create-reply"><?= Locale::get('comment.show-more') ?>...</span><br />
            <? } ?>
            <span class="create-reply"><?= Locale::get('comment.reply') ?>...</span>
        </div>
    </div>
</div>