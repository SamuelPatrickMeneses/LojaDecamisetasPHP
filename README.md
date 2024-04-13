# Desenvolvimento de Aplicações Back-End

Back-End aplication development discipline project

- Teacher: Diego Marczal
- Couse: Tecnologia Em Sistemas Para Internet
- Student: Samuel Patrick Meneses

## project requirements

- [x] 1. Uma área administrativa restrita (acesso por meio de usuário e senha).
- [x] 2. Uma área de usuário restrita (acesso por meio de usuário e senha).
- [x] 3. No mínimo um CRUD, CREATE, RETRIVE, UPDATE, DELETE.
- [x] 4. Permitir upload de Imagem.
- [x] 5. Deve existir pelo menos uma relação 1xN.
- [ ] 6. Deve existir pelo menos uma relação NxN.
- [ ] 7. Todas as devidas validações devem ser realizadas.
- [ ] 8. O sistema deve fazer uso dos seguintes tipos de campos:
- - [x] a. Input, text, e-mail, password, date, file
- - [x] b. Select
- - [x] c. Checkbox
- - [ ] d. Radio
- [ ] 9. Deve ter pelo menos uma requisição usando Ajax.
- [x] 10. Todo o código deve ser escrito em inglês.
- [ ] 11. Não deve existir temas iguais entre os alunos/duplas.

for more details see de [wik](https://github.com/SamuelPatrickMeneses/LojaDecamisetasPHP/wiki).

## description

This application is a t-shirt web store written in php, server side render based.

Key Features:

- User Account Management
- Shopping Cart System
- Checkout and Payment Integration
- Responsive Design
- Admin area
- Database Integration

Development Technologies:
- Frontend: HTML5, CSS3, JavaScript, jQuery, Bootstrap css
- Backend: PHP 8.2.10
- Database: MySQL 8.1.0
- Server: Nginx
- Build  Tools/dependency management: Composer 
- Environment Build: Docker Compose

## how to run

### Tools

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

##### PAGBANK_API
the babanck api url, used by php container.

##### PAGBANK_API_TOKEN
the pagbank api token, used by php containher.

##### DATASET
according to the value select a data set in the database folder, used by database/generateUserAndDB.
values:
-   development = database/dev.sql
-   test = database/test.sql

in case of anofer value, it try use the value as the dataset file path. 

### Run

```
$ git clone https://github.com/SamuelPatrickMeneses/LojaDecamisetasPHP.git
$ cd /LojaDecamisetasPHP/
$ ./run composer install
$ ./run composer dump-autoload
$ ./run up -d
$ ./run db:reset 
```

### Run tests 
```
$ ./run <test path> 
```

Access http://localhost

## Contribute
   see the [wiki](https://github.com/SamuelPatrickMeneses/LojaDecamisetasPHP/wiki/contribute)
