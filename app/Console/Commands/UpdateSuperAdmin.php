<?php

namespace App\Console\Commands;

use App\User;
use App\UserRole;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UpdateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =
        'super-admin:update
        {--email= : The super admin\'s new email (must be different from that of regular users)}
        {--password= : The super admin\'s new password}
        {--first-name= : The super admin\'s (fictional) new first name.}
        {--last-name= : The super admin\'s (fictional) new last name.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the super admin';

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
        // Check if there is a super admin
        if (User::where('role_id', UserRole::SUPER_ADMINISTRATOR)->count() == 0) {
            $this->error(__('messages.console.super_admin.no_super_admin'));
            return;
        }

        // Check if at least one option was filled
        if ($this->option('email') == null
            && $this->option('password') == null
            && $this->option('first-name') == null
            && $this->option('last-name') == null) {
            $this->error(__('messages.console.super_admin.no_update_option'));
            return;
        }

        // Generate request
        $request = new Request();
        if ($this->option('email') != null)
            $request->merge(['email' => $this->option('email')]);
        if ($this->option('password') != null)
            $request->merge(['password' => $this->option('password')]);
        if ($this->option('first-name') != null)
            $request->merge(['first_name' => $this->option('first-name')]);
        if ($this->option('last-name') != null)
            $request->merge(['last_name' => $this->option('last-name')]);

        // Validate arguments
        $validator = Validator::make($request->all(), [
            'email' => 'sometimes|email|unique:users,email',
            'password' => 'sometimes|string|min:6',
            'first_name' => 'sometimes|string|min:1|max:50',
            'last_name' => 'sometimes|string|min:1|max:50',
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

        // Update super admin
        try {
            DB::transaction(function () use ($request) {
                $superAdmin = User::where('role_id', UserRole::SUPER_ADMINISTRATOR)->first();
                $superAdmin->update($request->all());
            });
        } catch (Exception $err) {
            // Handle super admin update failing
            $this->error(__('messages.console.super_admin.update_error'));
            return;
        }

        $this->info(__('messages.console.super_admin.update_success'));
    }
}
