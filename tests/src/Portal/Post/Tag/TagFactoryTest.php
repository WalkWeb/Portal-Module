<?php

declare(strict_types=1);

namespace Tests\src\Portal\Post\Tag;

use Portal\Post\Tag\TagException;
use Portal\Post\Tag\TagFactory;
use Portal\Traits\Validation\ValidationException;
use SplObjectStorage;
use Tests\AbstractUnitTest;

class TagFactoryTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание тега на основе массива параметров
     *
     * @dataProvider successDataProvider
     * @param array $data
     * @throws ValidationException
     */
    public function testTagFactoryCreateSuccess(array $data): void
    {
        $tag = $this->getFactory()->create($data);

        self::assertEquals($data['id'], $tag->getId());
        self::assertEquals($data['name'], $tag->getName());
        self::assertEquals($data['slug'], $tag->getSlug());
        self::assertEquals($data['icon'], $tag->getIcon());
        self::assertEquals($data['preview_post_id'], $tag->getPreviewPostId());
        self::assertEquals($data['approved'], $tag->isApproved());
    }

    /**
     * Тест на различные варианты невалидных данных
     *
     * @dataProvider failDataProvider
     * @param array $data
     * @param string $error
     * @throws ValidationException
     */
    public function testTagFactoryCreateFail(array $data, string $error): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage($error);
        $this->getFactory()->create($data);
    }

    /**
     * @return array
     */
    public function successDataProvider(): array
    {
        return [
            [
                [
                    'id'              => '83d9fb1c-c417-4528-8745-adfd0af24f2c',
                    'name'            => 'новости',
                    'slug'            => 'novosti',
                    'icon'            => 'icon-1.png',
                    'preview_post_id' => '9ee22e72-13f3-4675-a612-d28844b43f40',
                    'approved'        => true,
                ],
            ],
            [
                [
                    'id'              => '3bf4f5b2-d79c-45c6-b6c3-7f8dee8bf8a5',
                    'name'            => 'статьи',
                    'slug'            => 'stati',
                    'icon'            => 'icon-2.png',
                    'preview_post_id' => '',
                    'approved'        => false,
                ],
            ],
        ];
    }

    public function failDataProvider(): array
    {
        return [
            // отсутствует id
            [
                [
                    'name'            => 'новости',
                    'slug'            => 'novosti',
                    'icon'            => 'icon-1.png',
                    'preview_post_id' => '9ee22e72-13f3-4675-a612-d28844b43f40',
                    'approved'        => true,
                ],
                TagException::INVALID_ID,
            ],
            // id некорректного типа
            [
                [
                    'id'              => 10,
                    'name'            => 'новости',
                    'slug'            => 'novosti',
                    'icon'            => 'icon-1.png',
                    'preview_post_id' => '9ee22e72-13f3-4675-a612-d28844b43f40',
                    'approved'        => true,
                ],
                TagException::INVALID_ID,
            ],
            // отсутствует name
            [
                [
                    'id'              => '83d9fb1c-c417-4528-8745-adfd0af24f2c',
                    'slug'            => 'novosti',
                    'icon'            => 'icon-1.png',
                    'preview_post_id' => '9ee22e72-13f3-4675-a612-d28844b43f40',
                    'approved'        => true,
                ],
                TagException::INVALID_NAME,
            ],
            // name некорректного типа
            [
                [
                    'id'              => '83d9fb1c-c417-4528-8745-adfd0af24f2c',
                    'name'            => [],
                    'slug'            => 'novosti',
                    'icon'            => 'icon-1.png',
                    'preview_post_id' => '9ee22e72-13f3-4675-a612-d28844b43f40',
                    'approved'        => true,
                ],
                TagException::INVALID_NAME,
            ],
            // отсутствует slug
            [
                [
                    'id'              => '83d9fb1c-c417-4528-8745-adfd0af24f2c',
                    'name'            => 'новости',
                    'icon'            => 'icon-1.png',
                    'preview_post_id' => '9ee22e72-13f3-4675-a612-d28844b43f40',
                    'approved'        => true,
                ],
                TagException::INVALID_SLUG,
            ],
            // slug некорректного типа
            [
                [
                    'id'              => '83d9fb1c-c417-4528-8745-adfd0af24f2c',
                    'name'            => 'новости',
                    'slug'            => 10.20,
                    'icon'            => 'icon-1.png',
                    'preview_post_id' => '9ee22e72-13f3-4675-a612-d28844b43f40',
                    'approved'        => true,
                ],
                TagException::INVALID_SLUG,
            ],
            // отсутствует icon
            [
                [
                    'id'              => '83d9fb1c-c417-4528-8745-adfd0af24f2c',
                    'name'            => 'новости',
                    'slug'            => 'novosti',
                    'preview_post_id' => '9ee22e72-13f3-4675-a612-d28844b43f40',
                    'approved'        => true,
                ],
                TagException::INVALID_ICON,
            ],
            // icon некорректного типа
            [
                [
                    'id'              => '83d9fb1c-c417-4528-8745-adfd0af24f2c',
                    'name'            => 'новости',
                    'slug'            => 'novosti',
                    'icon'            => null,
                    'preview_post_id' => '9ee22e72-13f3-4675-a612-d28844b43f40',
                    'approved'        => true,
                ],
                TagException::INVALID_ICON,
            ],
            // отсутствует preview_post_id
            [
                [
                    'id'              => '83d9fb1c-c417-4528-8745-adfd0af24f2c',
                    'name'            => 'новости',
                    'slug'            => 'novosti',
                    'icon'            => 'icon-1.png',
                    'approved'        => true,
                ],
                TagException::INVALID_PREVIEW_POST_ID,
            ],
            // preview_post_id некорректного типа
            [
                [
                    'id'              => '83d9fb1c-c417-4528-8745-adfd0af24f2c',
                    'name'            => 'новости',
                    'slug'            => 'novosti',
                    'icon'            => 'icon-1.png',
                    'preview_post_id' => new SplObjectStorage(),
                    'approved'        => true,
                ],
                TagException::INVALID_PREVIEW_POST_ID,
            ],
            // отсутствует approved
            [
                [
                    'id'              => '83d9fb1c-c417-4528-8745-adfd0af24f2c',
                    'name'            => 'новости',
                    'slug'            => 'novosti',
                    'icon'            => 'icon-1.png',
                    'preview_post_id' => '9ee22e72-13f3-4675-a612-d28844b43f40',
                ],
                TagException::INVALID_APPROVED,
            ],
            // approved некорректного типа
            [
                [
                    'id'              => '83d9fb1c-c417-4528-8745-adfd0af24f2c',
                    'name'            => 'новости',
                    'slug'            => 'novosti',
                    'icon'            => 'icon-1.png',
                    'preview_post_id' => '9ee22e72-13f3-4675-a612-d28844b43f40',
                    'approved'        => 1,
                ],
                TagException::INVALID_APPROVED,
            ],
        ];
    }

    /**
     * @return TagFactory
     */
    private function getFactory(): TagFactory
    {
        return new TagFactory();
    }
}