Database to REST API
====================

Read database content with REST APIs. Built on [CodeIgniter 3.0.6](https://github.com/bcit-ci/CodeIgniter "CodeIgniter") with [CodeIgniter Rest Server 2.7.3](https://github.com/chriskacerguis/codeigniter-restserver "CodeIgniter Rest Server")

Format Supported
----------------

* JSON
* XML
* HTML

Databases Supported
-------------------

* MySQL
* MySQLi
* MS SQL
* Postgres
* Oracle
* SQLite
* ODBC

API Structure (Documenting)
---------------------------

* all rows in a table: `http://example.com/index.php/get?table=Country`
* where clause in a table: `http://example.com/index.php/get?table=City&where="CountryCode=USA%26Population>1780000"`
* like clause in a table: `http://example.com/index.php/get?table=City&where="CountryCode=US"`

Additional Parameters (Not Yet Implemented)
-------------------------------------------

* `order_by`: name of column to sort by
* `direction`: direction to sort, either `asc` or `desc` (default `asc`)
* `limit`: number, maximum number of results to return

e.g., ``

Requirements
------------

* PHP
* Database
* Database drivers (such as PDO, PostgreSQL, Oracle, ODBC)

Installation Instructions
-------------------------

* Unzip the package.
* Upload the CodeIgniter folders and files to your server. Normally the index.php file will be at your root.
* Rename database.template.php with database.php.
* (Optional step)

```sh
mysql -u username –-password=password world < sample/world.sql
```

Read CodeIgniter installation instructions [here](https://codeigniter.com/user_guide/installation/index.html)

Database Configuration
----------------------

CodeIgniter has a config file that lets you store your database connection values (username, password, database name, etc.).
The config file is located at application/config/database.php (If you see database.template.php, rename database.template.php with database.php).
You can also set database connection values for specific environments by placing database.php in the respective environment config folder.

The config settings are stored in a multi-dimensional array with this prototype:

```php

$db['default'] = array(
        'dsn'   => '',
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => 'password',
        'database' => 'world',
        'dbdriver' => 'mysqli',
        'dbprefix' => '',
        'pconnect' => TRUE,
        'db_debug' => TRUE,
        'cache_on' => FALSE,
        'cachedir' => '',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci',
        'swap_pre' => '',
        'encrypt' => FALSE,
        'compress' => FALSE,
        'stricton' => FALSE,
        'failover' => array()
);

```

Some database drivers (such as PDO, PostgreSQL, Oracle, ODBC) might require a full DSN string to be provided.
If that is the case, you should use the ‘dsn’ configuration setting, as if you’re using the driver’s underlying native PHP extension, like this:

Here is a `config.php` file for a MySQL database named “world,” accessed with a MySQL user named “root” and a password of “password,” with MySQL running on the same server as the website, with the standard port of 3306. All tables may be accessed by *Database to API* except for “cache” and “passwords,” and among the accessible tables, the “password_hint” column may not be accessed via *Database to API*. All of this is registered to create an API named “facility-inspections”.

```php

// PDO
$db['default']['dsn'] = 'pgsql:host=localhost;port=5432;dbname=database_name';

// Oracle
$db['default']['dsn'] = '//localhost/XE';

```

Read CodeIgniter database configuration [here](https://www.codeigniter.com/userguide3/database/configuration.html)


License
-------

The MIT License (MIT)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
