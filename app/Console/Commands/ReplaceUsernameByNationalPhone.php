<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Propaganistas\LaravelPhone\PhoneNumber;

class ReplaceUsernameByNationalPhone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'username:replace_by_phone';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replace Username By National Phone';

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

        $users = User::whereUserType('rider')->get();

        foreach ($users as $user) {

            $user->old_username = $user->username;
            $phone = new PhoneNumber($user->contact_number, 'VE,EC');

            try {

                $formattedPhone = str_replace("-", "", $phone->formatNational());
                //$formattedPhone = str_replace("0", "", $formattedPhone);
                $formattedPhone = str_replace(" ", "", $formattedPhone);
    
                $user->username = $formattedPhone;
    
                $user->save();

            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                //throw $th;
            }

            $user->save();

        }

        return 'finished';
    }
}
