# Visual Bugtracker

Bug tracking system with a visual editor.
> Feel free to discuss/contribute to the project by creating an issue/pull request. Any partisipation is welcome.

#### Technologies used in this project:
<p align="center">
<img width="50%" src="https://github.com/StanislavBogatov/BugWall_Visual_Bugtracker/blob/master/github_screenshots/technologies_used.PNG?raw=true"></img>
</p>


#### Application screenshots:

<img height="192px" width="32%" src="https://raw.githubusercontent.com/stasgar/Visual_Bugtracker/master/github_screenshots/pages_screenshots/Projects.png"></img>
<img height="192px" width="32%" src="https://raw.githubusercontent.com/stasgar/Visual_Bugtracker/master/github_screenshots/pages_screenshots/Issues.png"></img>
<img height="192px" width="32%" src="https://raw.githubusercontent.com/stasgar/Visual_Bugtracker/master/github_screenshots/pages_screenshots/Editor.png"></img>

## Project installation:
### Pre requirements:
- Basic LAMP/LEMP or WAMP/WEMP server configuration.
- [PHP >=7.1.3](https://php.net "PHP official website")
    - [Composer](https://getcomposer.org "Composer official website")
    - [Laravel ^5.7](https://laravel.com "Laravel official website")
- [node.js](https://nodejs.org/en/ "nodejs official website") and [npm](https://www.npmjs.com/ "nodejs official website") modules for assets compiling.

#### Installation:
1. [#Composer dependencies](#1-install-composer-dependencies) `composer install`
2. [#Environment variables configuration](#2-create-your-own-env-file-from-envexample-with-your-keys) `.env`
3. [#Migrations](#3-database-migration) `php artisan migrate --seed`
4. [#Storage](#4-storage-configuration) `php artisan bugwall:init --storage`

#### 1. Install composer dependencies:
```
composer install
```

#### 2. Environment variables configuration:
- Create your own **.env** file (from **.env.example**) with your keys.

>You can get more information about Pusher and free limited server on https://pusher.com)

#### 3. Database migration:
Before applying migrations make sure you've created a table which you've set up in your .env file (the default table name is `bugwall_dev`), then run `php artisan migrate --seed`.
> The project has a preset for testing environment. See `phpunit.xml` and `config/database.php`. If you are planning on running tests - make sure you've created a test database table (the default table name is `bugwall_test`). To apply migrations to the testing database use `php artisan migrate --seed --database=mysql_testing` console command.

#### 4. Storage configuration:
- Storage is configurated to be used with S3 Amazon web service, but if you want to use the default local directory to serve files (mostly images) - you should update the `config/filesystems.php`: ` 'default' => 's3' ` to ` 'default' => 'public' ` and run `php artisan storage:link` to create a symlink to the storage directory of the project.
- Use custom project command `php artisan bugwall:init --storage` (it will only touch the required default directories, it's usefull when you want to not only initialize, but also to reset the existing storage default directories) to initialize all the required storage directories and files for the project. If you want to change placeholders images but dont want the actual initialized directories to flush, you can do so by updating the placeholders in `public/images/placeholders/` and running command `php artisan bugwall:init --placeholders` that will only update the placeholders related files.
