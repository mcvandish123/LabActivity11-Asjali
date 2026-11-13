<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kagawadUser = User::factory()->create([
            'name' => 'Kagawad Benjamin Asjali',
            'email' => 'kagawad.asjali@bulletin.test',
            'password' => 'bulletin2026',
        ]);

        User::factory()->create([
            'name' => 'Lola Asjali',
            'email' => 'lola.asjali@bulletin.test',
            'password' => 'bulletin2026',
        ]);

        Author::where('email', 'kagawad.asjali@bulletin.test')
            ->update(['user_id' => $kagawadUser->id]);

        User::factory()->count(8)->create();
    }
}
