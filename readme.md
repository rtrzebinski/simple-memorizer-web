## About

Simple memorizer helps efficiently memorizing any question-answer sets.

[Application live demo](https://simple-memorizer.online)

[![Build Status](https://travis-ci.com/rtrzebinski/simple-memorizer-3.svg?branch=master)](https://travis-ci.com/rtrzebinski/simple-memorizer-3)

### How does it work

- User can subscribe and learn one of lessons created by other users or create own lesson.

- Lessons created by user might be public (can be used by other users) or private (visible for lesson creator only).

- Each lesson contains number of exercises. Exercises has question and answer.

- While learning, user is asked if he knows the answer to a question. User might gives app the feedback simply pressing one of 2 buttons - if he knows the answer or not. App stores this information and uses it to adjust order of questions being asked.

- Generally questions that user knows less are served more often and questions that user knows better are served less often.

- App engine is analysing previous answers of a user, and serves next questions is optimal order, to ensure most efficient learning process.

### Implementation details

- Application is developed with [PHP 7](http://php.net) and [Laravel framework](https://laravel.com).

- Frontend interface is based on [Bootstrap 3](http://getbootstrap.com). Views are generated by PHP, separated frontend app is not used at the moment. [jQuery](https://jquery.com) is utilised to add dynamic UI elements.

- [MySQL](https://mysql.com) database serves as data store

- App is covered by automated tests written with [PHPUnit](https://phpunit.de) framework. Tests are set up to run using in memory [SQLite](sqlite) database, which significantly speeds up testing process.

### REST API

Application provides WEB interface as well as REST API, which allows integration with external client apps.

[REST API documentation](https://github.com/rtrzebinski/simple-memorizer-3/wiki/REST-API)

## Docker support

Thanks to [Laradock](https://laradock.io) project has a built in [Docker](https://www.docker.com) support. If you have [Docker](https://www.docker.com) installed you can **easily run and develop application locally** using few simple commands listed below.

### Prerequisites

- [docker](https://www.docker.com/)
- [docker-compose](https://docs.docker.com/compose/)
- [make](https://www.gnu.org/software/make/)
- `sh`

### Commands

To start local environment simply run `$ make start`.

```
simple-memorizer-3 $ make
target                         help
------                         ----
help                           Show this help
clean                          Stop all running docker containers (recommended to run before 'start' command to ensure ports are not taken)
start                          Create and start containers, composer dependencies, db migrate and seed etc. - everything in one command
build                          Build or re-build containers
up                             Start containers
down                           Stop and remove containers, networks, images, and volumes
composer-install               Composer install
composer-update                Composer update
db-create                      Create dev mysql database
db-migrate                     Migrate dev mysql database
db-seed                        Seed dev mysql database
bash                           SSH workspace container (run bash)
test                           Run all unit tests or given test file
test-filter                    Run unit tests of given class or test method
paratest                       Run test with paratest
```
