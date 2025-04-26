<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'name' => 'John Doe',
                'nim' => '12345678',
                'email' => 'john@example.com',
                'photo' => 'images/members/john_doe.jpg',
                'linkedIn' => 'https://linkedin.com/in/johndoe',
                'github' => 'https://github.com/johndoe',
                'instagram' => 'https://instagram.com/johndoe',
            ],
            [
                'name' => 'Jane Smith',
                'nim' => '87654321',
                'email' => 'jane@example.com',
                'photo' => 'images/members/jane_smith.jpg',
                'linkedIn' => 'https://linkedin.com/in/janesmith',
                'github' => 'https://github.com/janesmith',
                'instagram' => 'https://instagram.com/janesmith',
            ],
        ];

        foreach ($members as $member) {
            Member::create($member);
        }
    }
}
