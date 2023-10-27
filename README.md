## Desenvolvimento de Aplicações Back-End

Back-End aplication development discipline project

- Teacher: Diego Marczal
- Couse: Tecnologia Em Sistemas Para Internet
- Student: Samuel Patrick Meneses

### Dependências

-   Docker
-   Docker Compose

### Enviroment
the enviroment variables must declared in the ./.env file, are they:

##### DB_NAME
the database name, usade by db and php containers.

##### DB_HOST
the database host, usade by db and php containers, defalt value db.

##### DB_PORT
the database port, usade by db and php containers, defalt value 3306.

##### DB_PASSWORD
the aplication database password, usade by db and php containers.

##### DB_USER
the aplication database user, usade by db and php containers.

##### MYSQL_ROOT_PASSWORD
the database root password, used by db container.

##### MYSQL_ROOT_USER
the database root user, used by db container.

### Run

```
$ git clone git@github.com:SI-DABE/todo-list.git
$ cd todo-list
$ docker compose run --rm composer composer install
$ docker compose up -d
```

### Run tests 
```
$ docker compose exec php ./vendor/bin/phpunit tests --color
```

Access http://localhost

