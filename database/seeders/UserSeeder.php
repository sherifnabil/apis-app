<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->create([
            'name'  =>  'some name',
            'email'  =>  'email@app.app',
            'password'  => bcrypt('password'),
            'remember_token' => Str::random(60)
        ]);
    }
}
