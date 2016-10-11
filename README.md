This web app allow to:
=====================

* register abiturient;
* show registered abiturients (by 5 at page);
* search abiturients by all fields, exept id, password, gender and registry.

**Authentication is providing by generation password and autosaving it in browser's cookie at registering.**


Requirements:
------------

* PHP 5.5.12 or above
* mySLQ 5.6.17 or above


Installing:
-----------

1. Download project repository.
2. Create SLQ database.
3. Import SQL dump "abiturients.sql". 
4. Set up your database configuration in file: ../Abiturientlist/app/config.ini