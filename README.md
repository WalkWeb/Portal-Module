
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

- [ ] Account
    - [x] Carma 
    - [x] ChatStatus
    - [x] Energy
    - [x] Floor
    - [x] Group
    - [x] Notice
    - [x] Status
    - [x] Upload
- [x] Auth
- [x] Container
- [x] Post
    - [x] Author
    - [x] Comment
    - [x] Rating
    - [x] Tag
- [ ] Chat
    - [x] ChatUser
    - [ ] Channel
    - [ ] Message
