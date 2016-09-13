This web app allow to:
- register student;
- show registered students (by 5 at page);
- search students by all fields, exept id, password, gender and registry.

Authentication is providing by generation password and autosaving it in browser's cookie at registering.

Requirements:
- PHP 5.5.12 or above
- SLQ 5.6.17 or above

Installing:
1. Download project repository.
2. Create SLQ database.
3. Import SQL dump "abiturients.sql".
Also you can create table by using SQL commands from file: sql-command-to-create-table.txt,
to fill the table use commands from file: sql-command-to-fill-table.txt
4. Set up your database configuration in file: ..\Studentlist\app\config.ini