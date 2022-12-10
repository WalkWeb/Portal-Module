
# Структура моделей

Данный проект – это набор доменных моделей для реализации базовой логики сайта: авторизация, аккаунт, карма 
пользователя, загрузка картинок, посты, комментарии, чат.

Проект является экспериментом сразу по нескольким направлениям:

- Разрабатывается на самописном микро-фреймворке [DW-Framework](https://github.com/WalkWeb/DW-Framework)
- ORM не используется. За счет отсутствия большого фреймворка и ORM получается очень высокая производительность

Также для максимальной производительности не используются классические модели/сущности, которые один в один отражают
структуру таблиц в таблице. Применяется более оптимизированный вариант: например, когда базовая модель Auth (отвечающая 
за авторизацию), сразу хранит в себе несколько параметров из таблицы аккаунтов, которые часто используются. И это 
избавляет от множества дополнительных запросов в базу. А самая большая и навороченная модель Account используется в
своем полноценном виде практически только при отображении страницы профиля. Во всех других случаях она слишком 
тяжелая для использования, и заменяется более легкими решениями.

Сайт с таким подходом уже сделан, успешно работает и показывает невероятную производительность: страница профиля, с 
авторизацией, энергией, с массой параметров аккаунта, игровыми персонажами, с выводом последних постов пользователя и 
прочими моделями выводится за:

- Время вывода страницы: 8.06 миллисекунд
- Расход памяти: 292.07 kb
- Количество запросов: 15

Этот проект, по сути, глобальный рефакторинг (базовой части) уже существующего проекта где будет лучше ООП, более 
продуманные интерфейсы и больше unit-тестов.

---------------------------

План основных моделей:

- [ ] `Account` — Аккаунт пользователя. Единственное место где используется — на странице профиля пользователя.
    - [x] `Carma` — Информация по карме пользователя
    - [x] `ChatStatus` — Статус пользователя в чате
    - [x] `Energy` — Энергия пользователя. Создание постов/комментариев требует энергию. Это с одной стороны 
    ограничивает возможности спама, с другой стороны мотивирует пользователей на более осознанную активность
    - [x] `Floor` — Пол пользователя
    - [x] `Group` — Группа пользователя
    - [x] `Notice` — Уведомления пользователя
    - [x] `Status` — Статус пользователя
    - [x] `Upload` — Данные по загруженным файлам и оставшемуся свободному месту, доступного для использования
    - [ ] `Character` — На портале пользователи имеют уровни, на которые завязано много различных механик. Уровни и
    характеристики, которые можно прокачивать по мере роста уровня вынесены в отдельный объект
        - [ ] `Level` — Отвечает за уровень и опыт персонажа (для пользователя — аккаунта) и механику его увеличения
        - [ ] `Era` — Чтобы добавить интерес новым пользователям, с некоторой периодичностью на проекте будут обнуляться 
        все уровни, и открываться новая эра в развитии. Но персонажи не удаляются, а переносятся в архив. Вся эта 
        механика завязана на эры и том, что каждый персонаж привязывается к своей эре
- [x] `Auth` — Объект авторизации. Является урезанным вариантом объекта `Account`, в котором хранятся только наиболее
    частые для использования параметры
- [x] `Container` — Стандартный паттерн, реализующий «синглотон здорового человека»
- [x] `Post` — Единица контента на портале
    - [x] `Author` — Автор поста. Урезанный объект аккаунта, который содержит только ту информацию, которая нужна 
    для отображения поста
    - [ ] `ChangeRating` — Информация об изменении рейтинга поста (или отсутствии изменений) авторизованным 
    пользователем
    - [x] `Comment` — Комментарии к посту
    - [x] `Rating` — Рейтинг поста
    - [x] `Status` — Статус поста
    - [x] `Tag` — Теги поста
- [ ] `Chat` — Чат, в котором пользователи могут пообщаться
    - [x] `ChatUser` — Пользователь чата. Урезанный объект аккаунта, который содержит только ту информацию, которая
    нужна для чата
    - [ ] `Channel` — Каналы чатов
    - [ ] `Message` — Сообщения в чате
