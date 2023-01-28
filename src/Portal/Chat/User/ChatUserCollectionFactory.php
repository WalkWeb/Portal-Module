<?php

declare(strict_types=1);

namespace Portal\Chat\User;

use Exception;
use Portal\Pieces\Traits\Validation\ValidationTrait;

class ChatUserCollectionFactory
{
    use ValidationTrait;

    private ChatUserFactory $factory;

    public function __construct(ChatUserFactory $chatUserFactory)
    {
        $this->factory = $chatUserFactory;
    }

    /**
     * Создает список пользователей чата (например, в онлайне на текущем канале чата), на основе массива с данными
     *
     * @param array $data
     * @return ChatUserCollection
     * @throws Exception
     */
    public function create(array $data): ChatUserCollection
    {
        $collection = new ChatUserCollection();

        $i = 1;
        foreach ($data as $chatUserData) {
            if (!is_array($chatUserData)) {
                throw new ChatUserException(ChatUserException::EXPECTED_ARRAY . ". Element $i");
            }

            $collection->add($this->factory->create($chatUserData));

            $i++;
        }

        return $collection;
    }
}
