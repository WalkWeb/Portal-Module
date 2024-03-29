<?php

declare(strict_types=1);

namespace Portal\Account\Notice\Repository;

use Portal\Account\Notice\NoticeInterface;

/**
 * Доменная модель ничего не знает и не должна знать о хранилище данных. Здесь представлен лишь требуемый интерфейс для
 * работы. Конкретная реализация должна быть сделана непосредственном в самом проекте, который уже будет знать о базе, в
 * которой будут храниться данные
 *
 * @package Portal\Account\Energy
 */
interface NoticeRepositoryInterface
{
    /**
     * Получает данные из базы и создает объект уведомления пользователя
     *
     * @param string $id
     * @return NoticeInterface
     */
    public function get(string $id): NoticeInterface;

    /**
     * Сохраняет обновленные данные по уведомлению в базе
     *
     * @param NoticeInterface $notice
     */
    public function save(NoticeInterface $notice): void;
}
