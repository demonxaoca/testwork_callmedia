# testwork_callmedia

### Запуск

`sh start.sh` - Запустит сервисы Mysql, Rabbitmq, и Консюмеров. А так же создаст БД и зальёт дамп БД

Добавить URL в очередь, пример команды
```sh
docker exec -it php_worker sh -c "php ./app/index.php https://webhook.site/71f19308-9995-4e7b-bb0f-ee2ce5b3554a"
```

`request.sql` - Файл с запросом на выборку по заданию
```text
Создать единый запрос на выборку, в котором будет выводиться как общее кол-во запросов, так и кол-во запросов, в response header которых встречается заголовок 'new' со значением 1 (название заголовка может быть другим, на усмотрение соискателя).
```
