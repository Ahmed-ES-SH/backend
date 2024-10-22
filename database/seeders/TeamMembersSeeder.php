<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamMembersSeeder extends Seeder
{
    public function run()
    {
        DB::table('team_members')->insert([
            [
                'name' => 'John Doe',
                'description' => 'A short description about John Doe.',
                'position' => 'Manager',
                'facebook' => 'https://facebook.com/johndoe',
                'X_Account' => 'https://x.com/johndoe',
                'instagram' => 'https://instagram.com/johndoe',
            ],
            [
                'name' => 'Jane Smith',
                'description' => 'A short description about Jane Smith.',
                'position' => 'Developer',
                'facebook' => 'https://facebook.com/janesmith',
                'X_Account' => 'https://x.com/janesmith',
                'instagram' => 'https://instagram.com/janesmith',
            ],
            [
                'name' => 'Alice Johnson',
                'description' => 'A short description about Alice Johnson.',
                'position' => 'Designer',
                'facebook' => 'https://facebook.com/alicejohnson',
                'X_Account' => 'https://x.com/alicejohnson',
                'instagram' => 'https://instagram.com/alicejohnson',
            ],
            [
                'name' => 'Bob Williams',
                'description' => 'A short description about Bob Williams.',
                'position' => 'Marketing Lead',
                'facebook' => 'https://facebook.com/bobwilliams',
                'X_Account' => 'https://x.com/bobwilliams',
                'instagram' => 'https://instagram.com/bobwilliams',
            ],
            [
                'name' => 'Carol White',
                'description' => 'A short description about Carol White.',
                'position' => 'HR Manager',
                'facebook' => 'https://facebook.com/carolwhite',
                'X_Account' => 'https://x.com/carolwhite',
                'instagram' => 'https://instagram.com/carolwhite',
            ],
            [
                'name' => 'David Brown',
                'description' => 'A short description about David Brown.',
                'position' => 'Operations Director',
                'facebook' => 'https://facebook.com/davidbrown',
                'X_Account' => 'https://x.com/davidbrown',
                'instagram' => 'https://instagram.com/davidbrown',
            ],
            [
                'name' => 'Emma Davis',
                'description' => 'A short description about Emma Davis.',
                'position' => 'Customer Support',
                'facebook' => 'https://facebook.com/emmadavis',
                'X_Account' => 'https://x.com/emmadavis',
                'instagram' => 'https://instagram.com/emmadavis',
            ],
            [
                'name' => 'Frank Moore',
                'description' => 'A short description about Frank Moore.',
                'position' => 'Product Manager',
                'facebook' => 'https://facebook.com/frankmoore',
                'X_Account' => 'https://x.com/frankmoore',
                'instagram' => 'https://instagram.com/frankmoore',
            ],
        ]);
    }
}
