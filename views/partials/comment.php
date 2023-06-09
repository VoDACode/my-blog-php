<?

use \core\Locale;

?>
<div class="item" id="comment-<?= $comment['id'] ?>">
    <div class="post">
        <div class="vote">
            <a class="upvote" selected="<?= $comment['my_rating'] == 1 ? true : false ?>" href="/api/comment/rating?rating=<?= $comment['my_rating'] == 1 ? 0 : 1 ?>&comment_id=<?= $comment['id'] ?>"></a>
            <div class="rating">
                <p><?= $comment['rating'] ?></p>
            </div>
            <a class="downvote" selected="<?= $comment['my_rating'] == -1 ? true : false ?>" href="/api/comment/rating?rating=<?= $comment['my_rating'] == -1 ? 0 : -1 ?>&comment_id=<?= $comment['id'] ?>"></a>
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
                        <p><?= Locale::get('comment.published') ?>: <?= $comment['created_at'] ?></p>
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
            <? if (isset($comment['has_replies']) && $comment['has_replies'] == true) { ?>
                <span class="create-reply"><?= Locale::get('comment.show-more') ?>...</span><br />
            <? } ?>
            <span class="create-reply"><?= Locale::get('comment.reply') ?>...</span>
        </div>
    </div>
</div>