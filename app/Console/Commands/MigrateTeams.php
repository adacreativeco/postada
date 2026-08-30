<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;
use App\Models\Team;
use App\Models\SocialAccount;
use App\Models\Post;
use App\Models\Media;
use App\Models\TeamInvitation;
use Illuminate\Support\Facades\DB;

class MigrateTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-teams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create personal teams for existing users and migrate their data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::whereNull('current_team_id')->get();

        if ($users->isEmpty()) {
            $this->info('No users found needing migration.');
            return;
        }

        $this->info("Migrating {$users->count()} users...");

        foreach ($users as $user) {
            DB::transaction(function () use ($user) {
                // Create Team
                $team = Team::forceCreate([
                    'user_id' => $user->id,
                    'name' => explode(' ', $user->name, 2)[0] . "'s Team",
                    'personal_team' => true,
                ]);

                /** @var User $user */
                // Set current team
                $user->forceFill(['current_team_id' => $team->id])->save();

                // Re-parent Social Accounts
                SocialAccount::where('user_id', $user->id)
                    ->whereNull('team_id')
                    ->update(['team_id' => $team->id]);

                // Re-parent Posts
                Post::where('user_id', $user->id)
                    ->whereNull('team_id')
                    ->update(['team_id' => $team->id]);

                // Re-parent Media
                Media::where('user_id', $user->id)
                    ->whereNull('team_id')
                    ->update(['team_id' => $team->id]);
            });

            $this->line("Migrated user: {$user->email}");
        }

        $this->info('Migration completed successfully.');
    }
}
