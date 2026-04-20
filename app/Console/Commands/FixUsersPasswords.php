<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixUsersPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-users-passwords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix all user passwords to proper Bcrypt hashes (default: password)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = User::count();
        
        if ($count === 0) {
            $this->warn('No users found in database.');
            return;
        }
        
        User::query()->update(['password' => Hash::make('password')]);
        
        $this->info("✅ Successfully updated {$count} user(s) passwords to bcrypt('password')");
        $this->line('All users can now login with their email + password: "password"');
        $this->line('');
        $this->line('User emails:');
        
        foreach (User::select('email')->cursor() as $user) {
            $this->line('  - ' . $user->email);
        }
        
        $this->line('');
        $this->info('Next: Test login, then users should change their password.');
    }
}
