# Codeigniter

Codeigniter Framework

## Folder Structure

```
codeigniter/
├── modules/
│   ├── auth
│   ├── home
├── public/
│   ├── .htaccess
│   └── index.php
├── src/
├── vendor/
│   └── codeigniter/
│       └── framework/
│           └── system/
├── composer.json
```

## Application

To create MVC stack (controller, model, view) you can use create:app.

Usage example

```php
// Create an MVC stack
php public/index.php matches create:app users

// Create an MVC stack inside admin module
php public/index.php matches create:app admin.users
```

## Controllers

### `create:controller name_of_controller`

You can use Matches to create a Controller file. The command will need at leas a parameter which represents the name of the controller.

You can put the controller inside a module. Directories are delimited with ".". So, if you want to create the controller inside modules/admin/controllers, you can do create:controller admin.name_of_controller.

Usage examples

```php
// Create a Welcome controller
php public/index.php matches create:controller welcome

// Create a User controller inside admin module
php public/index.php matches create:controller admin.user
```

## Models

### `create:model name_of_model`

Creates a model having name_of_model as name. You can put the model inside a module. Directories are delimited with ".". So, if you want to create the model inside modules/admin/models, you can do create model admin.name_of_model.

Usage examples

```php
// Create a user model
php public/index.php matches create:model user

// Create a User model inside admin module
php public/index.php matches create:model admin.user
```

## Views

### `create:view name_of_view`

Creates a view having name_of_view as file name. You can put the view inside a module. Directories are delimited with ".". So, if you want to create the view inside modules/admin/views, you can do create view admin.name_of_view.

Usage examples

```php
// Create an index_view.php
php public/index.php matches create:view user_view

// Create an index_view.php inside users module
php public/index.php matches create:view users.index_view
```

## Migrations

CodeIgniter Matches helps you create, do, undo, and reset migrations.

### `create:migration`

To create a migration you can call create:migration. As a result, a migration will be created in the migrations directory prefixed with version as file name. You can also pass a table name as parameter. If no table name is given, you will have to put the name of the table in the migration file. Below are usage examples:

Usage examples

```php
// Create a migration
php public/index.php matches create:migration create_users_table

// Create a migration with a table inside it
php public/index.php matches create:migration create_users_table table:users

// Create a migration with a table inside it
php public/index.php matches create:migration create_users_table t:users

```

### `do:migration`

do:migration executes the migrations' up() methods. If you pass the version of the migration a parameter, it will stop at that version of the migration.

Usage examples:

```php
// Execute all migrations until the last one
php public/index.php matches do:migration

// Execute all migrations until a certain version of migration
php public/index.php matches do:migration 20150722
```

### `undo:migration`

undo:migration returns you to the previous migration version. This one also can accept a migration version as parameter to return to a migration.

Usage examples:

```php
// Undo last migration
php public/index.php matches undo:migration

// Undo the migrations until a specified migration version
php public/index.php matches undo:migration 20150722
```

### `reset:migration`

reset:migration will reset the migrations until the migration mentioned in $config['migration_version'] (in the migration configuration file).

Usage example:

```php
// Reset the migrations
php public/index.php matches reset:migration
```
