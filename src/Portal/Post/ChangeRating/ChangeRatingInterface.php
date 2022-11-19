<?php

declare(strict_types=1);

namespace Portal\Post\ChangeRating;

use DateTimeInterface;

/**
 * Отображает данные о том, лайкал или дизлайкал авторизованный пользователь данный пост, и если да - то это был лайк
 * или дизлайк
 *
 * Соответственно если авторизованный пользователь не лайкал/дизлайкал - ему нужно отобразить соответствующие кнопки, а
 * если лайкал/дизлайкал - подсветить ту кнопку, которую он нажимал.
 *
 * На уровне базы данные хранятся так:
 *
 * post_id | account_id | change | created_at
 *
 * @package Portal\Post\ChangeRating
 */
interface ChangeRatingInterface
{
    /**
     * @return bool
     */
    public function isLike(): bool;

    /**
     * @return bool
     */
    public function isDislike(): bool;
}
