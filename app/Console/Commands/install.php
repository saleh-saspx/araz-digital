<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Welcome To App Installer');
        $this->info('Developer : Saleh.faezy77@gmail.com');
        $this->info('......................');
        $this->error('run composer update');
        $this->info('......................');
        Artisan::call('migrate');
        $this->info('......................');
        (new User(['name' => 'مدیر سایت' , 'password' => Hash::make('password') , 'email' => 'admin@test.com']))->save();
        $this->info('admin: admin@test.com');
        $this->info('password: password');
        $this->info('......................');
        $this->info('php artisan get:category');
        $this->info('php artisan get:article');
        $this->info('......................');
        $this->info('php artisan serve to view project');
    }
}
