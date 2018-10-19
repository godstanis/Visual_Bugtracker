# BugWall Visual Bugtracker

Bug tracking system with a visual editor.

---

#### Technologies used in this project:
<img src="https://github.com/StanislavBogatov/BugWall_Visual_Bugtracker/blob/master/github_screenshots/technologies_used.PNG?raw=true"></img>

---

#### Application screenshots:

<img height="280px" width="48%" src="https://raw.githubusercontent.com/stasgar/Visual_Bugtracker/master/github_screenshots/pages_screenshots/Projects.png"></img>
<img height="280px" width="48%" src="https://raw.githubusercontent.com/stasgar/Visual_Bugtracker/master/github_screenshots/pages_screenshots/Issues.png"></img>
<img height="280px" width="48%" src="https://raw.githubusercontent.com/stasgar/Visual_Bugtracker/master/github_screenshots/pages_screenshots/Team.png"></img>
<img height="280px" width="48%" src="https://raw.githubusercontent.com/stasgar/Visual_Bugtracker/master/github_screenshots/pages_screenshots/Editor.png"></img>
---

## Project installation:
#### 1. Update composer dependencies:
```
composer update
```

#### 2. Migrate tables with default field values:
```
php artisan migrate --seed
```

#### 3. Create your own **.env** file (from **.env.example**) with your keys
