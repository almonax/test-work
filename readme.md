# Test work

## Info
- Model: Nested sets.
    - _Employees_ - the main data control class. Use Eloquent and QB
    - _EmployeesValidate_ - custom validator for Employees model
    - _User_ - default model
    > Use nested sets because the tree is large, and the movements will be rarely be used.
- Data seeder: EmployeesSeeder. 
    > This class can generate a symmetric hierarchy tree for a nested set model of any size.
- Controllers:
    - _EmployeesController_ - main business logic controller application
    - _ImageController_ - additional controller for working with images (resize/move/delete)
- Frontend:
    - JQuery (npm)
    - Bootstrap (npm)
    - jqTree (npm)
    - custom script api
    
## Part 1 (DB structure)

- id [_int_]
- fullname [_varchar(40)_]
- salary [_decimal(11,2)_]
- beg_work [_date_]
- photo [_varchar(40)_]
- lft, lft [_int_]
- lvl [_tinyint_]

> To get >50k employees in EmployeesSeeder, you need to set the following parameters:
> - $workClass = 6;
> - $nodesOnLevel = 6;
> - $totalLevel = 6

To calculate the approximate number of inserts, there is a formula
```php
($workClass + ($workClass + $nodesOnLevel + $totalLevel)/2 + 1) ** (($nodesOnLevel + $totalLevel)/3)
``` 

## Part 2 (optional)
1. ~~Create database using Laravel / Symfony migrations.~~ (See /database/migrations)
2. ~~Use Laravel / Symfony seeder to fill database with data.~~ (See /database/seeds)
3. ~~Use Twitter Bootstrap to apply basic styles to your page.~~ (See /resources/assets/.. js && scss)
4. ~~Create another web page with a list of all employees~~ with all employee record fields from the database and implement possibility to order by any field.
    - For the nested set model, there is no particular sense in the duck on any field. But implemented a simple search by fields `id` and `fullname` 
5. Add possibility to search by any field to the page you created in task 4.
6. Add possibility to order (and search if task 5 is implemented) by any field without reloading the whole page (i.e. using ajax).
7. ~~Using standard Laravel / Symfony functionality implement login/password restricted area of the website.~~ 
8. ~~Move functionality implemented in tasks 4, 5 and 6 (including ajax endpoints) to login/password restricted area.~~
9. ~~In the login/password restricted area implement the rest of CRUD functionality for employee record. Please note that all employee fields should be editable including possibility to change employee’s boss.~~ (Go to /edit/{id} or /transfer)
10. ~~Implement possibility to upload employee photo and display it on the employee edit page and add additional column with small resized employee photo to the employee list page.~~ (See ImageController and EmployeesController which uses the first)
11. ~~Implement logic to re-assign employee’s subordinates to employee’s boss in case if employee is being deleted (additional bonus points if you implement it using Laravel / Symfony ORM features).~~ (see Employees::deleteNode())
12. Implement lazy loading for employee tree, i.e. by default show first 2 levels of hierarchy and load tree branch (full or 2 more levels of hierarchy) by clicking on the employee from the 2nd level.
13. Implement possibility to change employee’s boss using drag-n-drop directly in the employee tree.
14. ~~Create database structure first using MySQL Workbench (do not forget to commit MySQL Workbench project file to git) and generate migration files for Laravel / Symfony from existing MySQL database or directly from MySQL Workbench project file.~~ (See /workbench_project)