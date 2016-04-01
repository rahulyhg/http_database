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
* Fast and light weight
* Robust queries
* Chain queries
* Authentication
* API Key access
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


URL Queries (Partially Encoded)
-------------------------------

Live Demo (The urls below do work)
----------------------------------

SELECT *:

    https://emz.us/http_database/index.php/get?table=City
    Produces
    SELECT * FROM City

WHERE:

    https://emz.us/http_database/index.php/get?table=City&where=CountryCode%3DUSA%26Population%3E1780000
    Produces
    SELECT * FROM City WHERE CountryCode = USA AND Population > 1780000

OR WHERE (Identical of WHERE, except that multiple instances are joined by OR):

    https://emz.us/http_database/index.php/get?table=City&or_where=Name%21%3DNew%20York%26CountryCode%3DUSA%26Population%3E%3D1780000
    Produces
    SELECT * FROM City WHERE NAME != New York OR CountryCode = USA OR Population >= 1780000

WHERE IN

    https://emz.us/http_database/index.php/get?table=City&where_in=1,2,3,4&variable=ID
    Produces
    SELECT * FROM City WHERE ID IN(1,2,3,4)

OR WHERE IN (Only supports one variable name, so this behaves similar to WHERE IN)

    https://emz.us/http_database/index.php/get?table=City&or_where_in=1,2,3,4&variable=ID
    Produces
    SELECT * FROM City WHERE ID IN(1,2,3,4)

WHERE NOT IN

    https://emz.us/http_database/index.php/get?table=City&where_not_in=1,2,3,4&variable=ID
    Produces
    SELECT * FROM City WHERE ID NOT IN(1,2,3,4)

OR WHERE NOT IN (Only supports one variable name, so this behaves similar to WHERE NOT IN)

    https://emz.us/http_database/index.php/get?table=City&or_where_not_in=1,2,3,4&variable=ID
    Produces
    SELECT * FROM City WHERE ID NOT IN(1,2,3,4)

JOIN (If you need a specific type of JOIN you can specify it via the `join_type` parameter in the URL. Options are: left, right, outer, inner, left outer, and right outer.)

    https://emz.us/http_database/index.php/get?table=Country&join=CountryLanguage.CountryCode = Country.Code&variable=CountryLanguage&join_type=right%20outer
    Produces
    SELECT * FROM Country RIGHT OUTER JOIN CountryLanguage ON CountryLanguage.CountryCode = Country.Code

LIKE:

    https://emz.us/http_database/index.php/get?table=City&like=CountryCode%3DUS
    Produces
    SELECT * FROM City WHERE CountryCode = %US%

OR LIKE (This function is identical to the LIKE, except that multiple instances are joined by OR):

    https://emz.us/http_database/index.php/get?table=City&or_like=CountryCode%3DUS%26District%3DNew
    Produces
    SELECT * FROM City WHERE CountryCode = %US% OR District = %New%

NOT LIKE: (Identical to LIKE, except that it generates NOT LIKE statements):

    https://emz.us/http_database/index.php/get?table=City&not_like=CountryCode%3DUS%26District%3DK
    Produces
    SELECT * FROM City WHERE CountryCode != %US% AND District != %K%

//Not working
OR NOT LIKE: (Identical to OR NOT LIKE, except that multiple instances are joined by OR):

    https://emz.us/http_database/index.php/get?table=City&or_not_like=CountryCode%3DUS%26District%3DNew
    Produces
    SELECT * FROM City WHERE CountryCode != %US%

SELECT (Field1, Field2):

    https://emz.us/http_database/index.php/get?table=City&select=Name,District&where=Id%3D2
    Produces
    SELECT Name, District FROM City WHERE Id = 2

MAX(Field):

    https://emz.us/http_database/index.php/get?table=City&max=Population
    Produces
    SELECT MAX(Population) FROM City

MIN(Field): (Adamstown/PCN only has 43 people?)

    https://emz.us/http_database/index.php/get?table=City&min=Population
    Produces
    SELECT MIN(Population) FROM City

AVG(Field):

    https://emz.us/http_database/index.php/get?table=City&avg=Population
    Produces
    SELECT AVG(Population) FROM City

SUM(Field):

    https://emz.us/http_database/index.php/get?table=City&sum=Population
    Produces
    SELECT SUM(Population) FROM City

GROUP BY:

    https://emz.us/http_database/index.php/get?table=City&where=CountryCode%3DUSA%26Population%3E%3D178000&like=Name%3DNew&group_by=Population
    Produces
    SELECT FROM City WHERE CountryCode = USA AND Population >= 178000 AND  Name LIKE %New% GROUP BY Population

DISTINCT:

    https://emz.us/http_database/index.php/get?table=City&where=CountryCode%3DUSA&distinct
    Produces
    SELECT DISTINCT FROM City Where CountryCode = USA

HAVING:

    https://emz.us/http_database/index.php/get?table=City&group_by=District&having=ID%3C%3D909%26Population%21%3D111700
    Produces
    SELECT FROM City GROUP BY District HAVING ID <= 909 AND Population != 111700

OR HAVING (Identical of HAVING, except that multiple instances are joined by OR:):

    https://emz.us/http_database/index.php/get?table=City&group_by=District&or_having=ID%3C%3D909%26Population%21%3D111700
    Produces
    SELECT FROM City GROUP BY District HAVING ID <= 909 OR Population != 111700

ORDER BY (asc, desc random):

    https://emz.us/http_database/index.php/get?table=City&order_by=ID,asc,Name,desc
    Produces
    SELECT * FROM City ORDER BY ID ASC, NAME DESC

LIMIT, OFFSET (Default 20, 0):

    https://emz.us/http_database/index.php/get?table=City&group_by=District&having=ID%3C%3D909%26Population%21%3D111700&order_by=ID,asc,Name,desc&limit=10&offset=10
    Produces
    SELECT * FROM City GROUP BY District HAVING ID <= 909 AND Population != 1117000 ORDER BY ID ASC, Name DESC LIMIT 10, 10

Content Type
------------

HTTP GET JSON:

    https://emz.us/http_database/index.php/get?table=City&where=CountryCode%3DUSA%26Population>%3D1780000
    https://emz.us/http_database/index.php/get?table=City&where=CountryCode%3DUSA%26Population>%3D1780000"&format=json

HTTP GET XML:

    https://emz.us/http_database/index.php/get?table=City&where=CountryCode%3DUSA%26Population>%3D1780000&format=xml

This can be flaky with URI segments, so the recommend approach is using the HTTP Accept header:

    curl -H "Accept: application/json"

Complex Queries
---------------

Build complex queries by combining common queries together

    Combining SELECT, WHERE, NOT LIKE, GROUP BY, ORDER BY together
    https://emz.us/http_database/index.php/get?table=City&not_like=Name%3DNew&where=Population%3E%3D100000%26CountryCode%3DUSA&group_by=Name&select=Name,%20Population&order_by=Population,desc
    Produces
    SELECT Name, Population FROM City WHERE Population >= 10000 AND CountryCode = USA AND Name NOT LIKE %New% GROUP BY Name ORDER BY Population DESC

    Combining SELECT, WHERE, JOIN, ORDER BY
    https://emz.us/http_database/index.php/get?table=Country&select=Code,Name&where=Code%3DUSA&join=CountryLanguage.CountryCode%20=%20Country.Code&variable=CountryLanguage&join_type=right%20outer&order_by=Code,asc&limit=1&offset=1
    Produces
    SELECT Code, Name FROM Country RIGHT OUTER JOIN CountryLanguage ON CountryLanguage.CountryCode = Country.Code WHERE Code = USA ORDER BY Code ASC LIMIT 1, 1

When to Encode Characters
-------------------------
These character(s) need encoding if they are in expressions


    & = ! < >
    eg, where=CountryCode=USA%26Population%3E%3D1780000


[HTML URL Encoding Reference](http://www.w3schools.com/tags/ref_urlencode.asp)

When PHP looks at `where=Name=New York&Population>100000`, it will treat the & symbol as a separator for HTTP parameters.
It'll create a _GET array similar to `array('where' => '"Name=New York', 'Population' => '')`. Population is separated into another key.
What we really wanted is having it create something like ` array('where' => '"Name=New York&Population>=1780000')`. To tell it to ignore the & symbol,
encode & as %26.
To avoid weirdness inside the condition, encode special characters like & = ! < >

Authentication
--------------

* Basic
* Digest
* Whitelist IP

[Setup instructions](https://github.com/chriskacerguis/codeigniter-restserver/blob/master/README.md#authentication)

API Keys
--------

Read doc [here](https://github.com/chriskacerguis/codeigniter-restserver/blob/master/README.md#api-keys)


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
