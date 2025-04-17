<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CancellationReason;

class CancellationReasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CancellationReason::create([
            'name' => 'Change of plans',
            'description' => 'The user no longer needs the service.',
            'active' => true,
        ]);

        CancellationReason::create([
            'name' => 'Long wait time',
            'description' => 'The wait time exceeded expectations.',
            'active' => true,
        ]);

        CancellationReason::create([
            'name' => 'Driver issues',
            'description' => 'There was a problem with the assigned driver.',
            'active' => true,
        ]);

        CancellationReason::create([
            'name' => 'Unexpected price',
            'description' => 'The final price was higher than expected.',
            'active' => true,
        ]);

        CancellationReason::create([
            'name' => 'Incorrect address',
            'description' => 'The pickup or drop-off location was incorrect.',
            'active' => true,
        ]);

        CancellationReason::create([
            'name' => 'Alternative transportation',
            'description' => 'The user chose another mode of transportation.',
            'active' => true,
        ]);

        CancellationReason::create([
            'name' => 'Other',
            'description' => 'User specified a different reason.',
            'active' => true,
        ]);
    }
}
