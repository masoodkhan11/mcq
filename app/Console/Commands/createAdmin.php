<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Admin;

class createAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Admin';

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
     * @return int
     */
    public function handle()
    {
        $name = $this->askForName();

        $email = $this->askForEmail();

        $password = $this->secret('What is the password?');

        Admin::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('Admin created successfully!');
    }

    protected function askForName()
    {
        $name = $this->ask('Enter your Name');

        if (! $name) {
            $this->error('Enter Valid Name!');
            return $this->askForName();
        }

        return $name;
    }

    protected function askForEmail()
    {
        $email = $this->ask('Enter your Email');

        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $this->error('Enter Valid Email!');
            return $this->askForEmail();
        }

        $emailExists = Admin::whereEmail($email)->exists();
        if ($emailExists) {
            $this->error('Email already exists!');
            return $this->askForEmail();
        }

        return $email;
    }
}
