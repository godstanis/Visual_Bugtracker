<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Init extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bugwall:init {--storage} {--placeholders}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use this command only on a newly created project.';

    protected $defaultDirectories;
    protected $defaultPlaceHolders;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->defaultDirectories = [
            config('images.boards_images_dir'),
            config('images.project_thumb_dir'),
            config('images.user_avatar_dir')
        ];
        $this->defaultPlaceHolders = [
            [
                'remote' => config('images.project_thumb_dir') . '/' . config('images.default_project_thumb'),
                'local' => File::get('public/images/placeholders/project_default.png')
            ],
            [
                'remote' => config('images.user_avatar_dir') . '/' . config('images.default_user_avatar'),
                'local' => File::get('public/images/placeholders/avatar_default.png')
            ]
        ];
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->option('storage')) {
            $this->setStorage();
        }

        if($this->option('placeholders')) {
            $this->copyDefaultPlaceHolders();
        }
    }

    /**
     * Sets the default storage directory structure.
     */
    public function setStorage()
    {
        $directoriesList = '';
        foreach($this->defaultDirectories as $dir) {
            $directoriesList .= '/'.$dir.'/* ';
        }
        $this->info('This command will ERASE these directories (if they exists) WITH ALL OF THE FILES and set up a default directory structure for you:');
        $this->line($directoriesList);
        $question = 'Do you wish to continue?';
        if ($this->confirm($question)) {
            $this->refreshDefaultDirectories();
            $this->copyDefaultPlaceHolders();
            $this->info("Directories were created successfully");
        }
    }
    /**
     * Deletes default directories if set and creates empty directory set.
     * Note: it only deletes and recreates the default directories.
     */
    public function refreshDefaultDirectories()
    {
        foreach ($this->defaultDirectories as $dir) {
            if (Storage::has($dir)) {
                Storage::deleteDirectory($dir);
                $this->info("Deleting directory '$dir' ...");
            }
        }

        foreach ($this->defaultDirectories as $dir) {
            if (!Storage::has($dir)) {
                Storage::makeDirectory($dir);
                $this->info("Creating directory '$dir' ...");
            }
        }
    }

    /**
     * Copy all the placeholders to the storage.
     */
    public function copyDefaultPlaceHolders()
    {
        $this->info("Copying the placeholders...");
        foreach($this->defaultPlaceHolders as $file) {
            Storage::put($file['remote'], $file['local']);
        }
    }
}
