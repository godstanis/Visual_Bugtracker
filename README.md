# BugWall Visual Bugtracker

Bug tracking system with a visual editor.


#### Technologies used in this project:
<p align="center">
<img width="50%" src="https://github.com/StanislavBogatov/BugWall_Visual_Bugtracker/blob/master/github_screenshots/technologies_used.PNG?raw=true"></img>
</p>


#### Application screenshots:

<img height="280px" width="48%" src="https://raw.githubusercontent.com/stasgar/Visual_Bugtracker/master/github_screenshots/pages_screenshots/Projects.png"></img>
<img height="280px" width="48%" src="https://raw.githubusercontent.com/stasgar/Visual_Bugtracker/master/github_screenshots/pages_screenshots/Issues.png"></img>
<img height="280px" width="48%" src="https://raw.githubusercontent.com/stasgar/Visual_Bugtracker/master/github_screenshots/pages_screenshots/Team.png"></img>
<img height="280px" width="48%" src="https://raw.githubusercontent.com/stasgar/Visual_Bugtracker/master/github_screenshots/pages_screenshots/Editor.png"></img>
---

## Project installation:
### Pre requirenments:
- Basic LAMP/LNMP or WAMP/WNMP server configuration.
- [PHP >=7.1.3](https://php.net "PHP official website")
    - [Composer](https://getcomposer.org "Composer official website")
    - [Laravel ^5.7](https://laravel.com "Laravel official website")
- npm and node.js modules for assets compiling.

#### 1. Update composer dependencies:
```
composer update
```

#### 2. Create your own **.env** file (from **.env.example**) with your keys:
Pusher allows users to see each other's changes made to the board in real time. Follow the configuration proccess:
- Set the valid keys in your .env (you can get more information and free limited server on https://pusher.com)
- Set the key and change the authorization router (authEndpoint) in `/resources/js/bootstrap.js` according to you server settings. Run `npm run dev`.
> Official pusher documentation: https://pusher.com/docs

#### 3. Migrate tables with default field values:
Before applying migrations make sure you've created a table which you've set up in your .env file (the default table name is `bugwall_dev`), then run `php artisan migrate --seed`.
> The project has a preset for testing environment. See `phpunit.xml` and `config/database.php`. If you are planning on running tests - make sure you've created a test database table (the default table name is `bugwall_test`). To apply migrations to the testing database use `php artisan migrate --seed --database=mysql_testing` console command.

#### 4. Storage settings:
Storage is configurated to be used with S3 Amazon web service, but if you want to use the default local directory to serve files(mostly images) - you should update the `config/filesystems.php`: ` 'default' => 's3' ` to ` 'default' => 'public' ` and run `php artisan storage:link` to create a symlink to the storage directory of the project.

> Feel free to contribute or discuss the project details with PR/Issue creation.
