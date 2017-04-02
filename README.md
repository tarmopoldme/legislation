Search prototype for legislative information based on centrality measures
=========

Requirements
=========

* PHP >= 7
* MariaDB >= 10.1.9

Resources
=========
Development:

* HTML skin: TODO
* Demo environment: TODO

Setup instructions
==================

1. Checkout from github: https://github.com/tarmopoldme/legislation.git
2. Install framework and modules with [composer](https://getcomposer.org/)
3. Create database for your dev application
4. Change your database dsn in `app/config/parameters.yml`
5. Run `php bin/console propel:migration:migrate` to initilize db

Command reference
=================
#### Import acts
```
php bin/console legislation:acts:import
```
Imports all acts from [here](https://www.riigiteataja.ee/lyhendid.html) to local database.

#### Find references between acts (acts network)
```
php bin/console legislation:acts:find-references
```
Finds references between acts and stores references to local database.

#### Calculate conformity weights for acts
```
php bin/console legislation:acts:analyze-confirmity
```
Executes acts conformity analyzer. Analyzed results are stored per act to local database.