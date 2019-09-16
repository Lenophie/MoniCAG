<?php

namespace App\Console\Commands;

use App\User;
use App\UserRole;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =
        'super-admin:create
        {email : The super admin\'s email (must be different from that of regular users)}
        {password : The super admin\'s password}
        {--first-name=Monika : The super admin\'s (fictional) first name.}
        {--last-name=Root : The super admin\'s (fictional) last name.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the super admin';

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
     */
    public function handle()
    {
        if (User::where('role_id', UserRole::SUPER_ADMINISTRATOR)->count() > 0) {
            $this->error(__('messages.console.super_admin.already_one_super_admin'));
            return;
        }

        // Generate request
        $request = new Request();
        $request->replace([
            'email' => $this->argument('email'),
            'password' => $this->argument('password'),
            'firstName' => $this->option('first-name'),
            'lastName' => $this->option('last-name')
        ]);

        // Validate arguments
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'firstName' => 'required|string|min:1|max:50',
            'lastName' => 'required|string|min:1|max:50',
        ]);

        // Handle validation errors
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->messages();
            $errorMessages = Arr::flatten($errorMessages);

            foreach ($errorMessages as $errorMessage) {
                $this->error($errorMessage);
            }
            return;
        }

        // Create super admin
        try {
            User::create([
                'first_name' => $request->get('firstName'),
                'last_name' => $request->get('lastName'),
                'promotion' => Carbon::now()->format('Y'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
                'role_id' => UserRole::SUPER_ADMINISTRATOR
            ]);
        } catch (Exception $err) {
            // Handle super admin creation failing
            $this->error(__('messages.console.super_admin.creation_error'));
            return;
        }

        $this->info(__('messages.console.super_admin.creation_success'));
    }
}
