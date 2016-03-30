HTTP Database
=============

Read database content via HTTP.

How Does It Work
----------------

HTTP Database provides read-only access to database through HTTP GET methods.
By providing the appropriate URL Parameters, the controller generates an equivalence SQL query and execute it against the database.
The controller then returns the result in HTTP Response in either JSON or XML format.

Why It's Awesome
----------------

* Almost zero configuration
* Works in common web hosting
* Scale and light weight
* Robust queries
* Chain queries
* Built on [CodeIgniter 3.0.6](https://github.com/bcit-ci/CodeIgniter "CodeIgniter")
* With [CodeIgniter Rest Server 2.7.3](https://github.com/chriskacerguis/codeigniter-restserver "CodeIgniter Rest Server")

Format Supported
----------------

* JSON
* XML

Databases Supported
-------------------

* MySQL (5.1+) via the mysql (deprecated), mysqli and pdo drivers
* Oracle via the oci8 and pdo drivers
* PostgreSQL via the postgre and pdo drivers
* MS SQL via the mssql, sqlsrv (version 2005 and above only) and pdo drivers
* SQLite via the sqlite (version 2), sqlite3 (version 3) and pdo drivers
* CUBRID via the cubrid and pdo drivers
* Interbase/Firebird via the ibase and pdo drivers
* ODBC via the odbc and pdo drivers (you should know that ODBC is actually an abstraction layer)


URL Queries (%26 is encoding of &)
----------------------------------

The URLs below are aliased by my localhost name as `localhost/~xiaoerge/http_database`.

SELECT *:

    http://localhost/~xiaoerge/http_database/index.php/get?table=City
    Produces
    SELECT * FROM City

WHERE:

    http://localhost/~xiaoerge/http_database/index.php/get?table=City&where="CountryCode=USA%26Population>1780000"
    Produces
    SELECT * FROM City WHERE CountryCode = USA AND Population > 1780000

OR WHERE (Identical of WHERE, except that multiple instances are joined by OR):

    http://localhost/~xiaoerge/http_database/index.php/get?table=City&or_where=%22Name!=New%20York%26CountryCode=USA%26Population%3E=1780000%22
    Produces
    SELECT * FROM City WHERE NAME != New York OR CountryCode = USA OR Population >= 1780000

LIKE:

    http://localhost/~xiaoerge/http_database/index.php/get?table=City&like="CountryCode=US"
    Produces
    SELECT * FROM City WHERE CountryCode = %US%

NOT LIKE: (Identical to LIKE, except that it generates NOT LIKE statements):

    http://localhost/~xiaoerge/http_database/index.php/get?table=City&not_like="CountryCode=US"
    Produces
    SELECT * FROM City WHERE CountryCode != %US%

SELECT (Field1, Field2):

    http://localhost/~xiaoerge/http_database/index.php/get?table=City&select="Name,District"&where="Id=2"
    Produces
    SELECT Name, District FROM City WHERE Id = 2

MAX(Field):

    http://localhost/~xiaoerge/http_database/index.php/get?table=City&max=Population
    Produces
    SELECT MAX(Population) FROM City

MIN(Field):

    http://localhost/~xiaoerge/http_database/index.php/get?table=City&min=Population
    Produces
    SELECT MIN(Population) FROM City

AVG(Field):

    http://localhost/~xiaoerge/http_database/index.php/get?table=City&avg=Population
    Produces
    SELECT AVG(Population) FROM City

SUM(Field):

    http://localhost/~xiaoerge/http_database/index.php/get?table=City&sum=Population
    Produces
    SELECT SUM(Population) FROM City

GROUP BY:

    http://localhost/~xiaoerge/http_database/index.php/get?table=City&where=%22CountryCode=USA%26Population%3E=178000%22&like=%22Name=New%22&group_by=Population
    Produces
    SELECT FROM City WHERE CountryCode = USA AND Population >= 178000 AND  Name LIKE %New% GROUP BY Population

DISTINCT:

    http://localhost/~xiaoerge/http_database/index.php/get?table=City&where=%22CountryCode=USA%22&distinct
    Produces
    SELECT DISTINCT FROM City Where CountryCode = USA

HAVING:

    http://localhost/~xiaoerge/http_database/index.php/get?table=City&group_by=%22District%22&having=%22ID%3C=909%26Population!=111700%22
    Produces
    SELECT FROM City GROUP BY District HAVING ID <= 909 AND Population != 111700

OR HAVING (Identical of HAVING, except that multiple instances are joined by OR:):

    http://localhost/~xiaoerge/http_database/index.php/get?table=City&group_by=%22District%22&or_having=%22ID%3C=909%26Population!=111700%22
    Produces
    SELECT FROM City GROUP BY District HAVING ID <= 909 OR Population != 111700

ORDER BY (asc, desc random):

    http://localhost/~xiaoerge/http_database/index.php/get?table=City&order_by=%22ID,asc,Name,desc%22
    Produces
    SELECT * FROM City ORDER BY ID ASC, NAME DESC

LIMIT, OFFSET (Default 20, 0):

    http://localhost/~xiaoerge/http_database/index.php/get?table=City&group_by=%22District%22&having=%22ID%3C=909%26Population!=111700%22&order_by=%22ID,asc,Name,desc%22&limit=%2210%22&offset=10
    Produces
    SELECT * FROM City GROUP BY District HAVING ID <= 909 AND Population != 1117000 ORDER BY ID ASC, Name DESC LIMIT 10, 10

HTTP GET JSON:

    http://localhost/~xiaoerge/http_database/index.php/get?table=City&where="CountryCode=USA%26Population>=1780000"
    http://localhost/~xiaoerge/http_database/index.php/get?table=City&where="CountryCode=USA%26Population>=1780000"&format=json

HTTP GET XML:

    http://localhost/~xiaoerge/http_databaseindex.php/get?table=City&where="CountryCode=USA%26Population>=1780000"&format=xml

Complex Queries
---------------

Build complex queries by combining common queries together

    Combining SELECT, WHERE, NOT LIKE, GROUP BY, ORDER BY together
    http://localhost/~xiaoerge/http_database/index.php/get?table=City&not_like=%22Name=New%22&where=%22Population%3E=100000%26CountryCode=USA%22&group_by=%22Name%22&select=%22Name,%20Population%22&order_by=%22Population,desc%22
    Produces
    SELECT Name, Population FROM City WHERE Population >= 10000 AND CountryCode = USA AND Name NOT LIKE %New% GROUP BY Name ORDER BY Population DESC

Special Characters
------------------
These character(s) need encoding if they are within quotes [HTML URL Encoding Reference](http://www.w3schools.com/tags/ref_urlencode.asp)

    & (ampersand) eg where query, where="CountryCode=USA%26Population>=1780000"

When PHP looks at `where="Name=New York&Population>100000"`, it will treat the & symbol inside quotation as a separator for HTTP parameters.
It'll create a _GET array similar to `array('where' => '"Name=New York', 'Population' => '')`. Population is separated into another key.
What we really wanted is having it create something like ` array('where' => '"Name=New York&Population>=1780000')`. To tell it to ignore the & symbol,
surround the value with quotation and encode & as %26.


Requirements
------------

PHP version 5.4 or newer is recommended.

* PHP
* Database
* Database drivers (such as PDO, PostgreSQL, Oracle, ODBC)

Installation Instructions
-------------------------

* Unzip the package.
* Upload the http_database folders and files to your server. Normally the index.php file will be at your root.
* Rename database.template.php with database.php.
* (Optional step)

```sh
mysql -u username –-password=password world < sample/world.sql
```

Read CodeIgniter installation instructions [here](https://codeigniter.com/user_guide/installation/index.html)

Database Configuration
----------------------

HTTP Database has a config file that lets you store your database connection values (username, password, database name, etc.).
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

Here is a `config.php` file for a MySQL database named “world,” accessed with a MySQL user named “root” and a password of “password,” with MySQL running on the same server as the website, with the standard port of 3306.

Some database drivers (such as PDO, PostgreSQL, Oracle, ODBC) might require a full DSN string to be provided.
If that is the case, you should use the ‘dsn’ configuration setting, as if you’re using the driver’s underlying native PHP extension, like this:

```php

// PDO
$db['default']['dsn'] = 'pgsql:host=localhost;port=5432;dbname=database_name';

// Oracle
$db['default']['dsn'] = '//localhost/XE';

```

Read CodeIgniter database configuration [here](https://www.codeigniter.com/userguide3/database/configuration.html)


Third-Party Licenses
--------------------
[CodeIgniter License ](https://github.com/bcit-ci/CodeIgniter/blob/develop/license.txt)
[CodeIgniter Rest Server License ](https://github.com/chriskacerguis/codeigniter-restserver/blob/master/LICENSE)

Licenses
--------
The MIT License (MIT)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
