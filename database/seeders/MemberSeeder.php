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
                'name' => 'Laksmana Chairutama',
                'nim' => '2205181045',
                'email' => 'laksmanachairutama@gmail.com',
                'photo' => 'laksmana.webp',
                'linkedIn' => 'https://www.linkedin.com/in/laksmana-chairutama/',
                'github' => 'https://github.com/laksa-ajaa',
                'instagram' => 'https://www.instagram.com/laksa_ajaa/',
            ],
            [
                'name' => 'Laksmana Chairutama',
                'nim' => '2205181046',
                'email' => 'laksmanachairutama1@gmail.com',
                'photo' => 'laksmana.webp',
                'linkedIn' => 'https://www.linkedin.com/in/laksmana-chairutama/',
                'github' => 'https://github.com/laksa-ajaa',
                'instagram' => 'https://www.instagram.com/laksa_ajaa/',
            ],
            [
                'name' => 'Laksmana Chairutama',
                'nim' => '2205181047',
                'email' => 'laksmanachairutama2@gmail.com',
                'photo' => 'laksmana.webp',
                'linkedIn' => 'https://www.linkedin.com/in/laksmana-chairutama/',
                'github' => 'https://github.com/laksa-ajaa',
                'instagram' => 'https://www.instagram.com/laksa_ajaa/',
            ],
            [
                'name' => 'Laksmana Chairutama',
                'nim' => '2205181048',
                'email' => 'laksmanachairutama3@gmail.com',
                'photo' => 'laksmana.webp',
                'linkedIn' => 'https://www.linkedin.com/in/laksmana-chairutama/',
                'github' => 'https://github.com/laksa-ajaa',
                'instagram' => 'https://www.instagram.com/laksa_ajaa/',
            ],
            [
                'name' => 'Laksmana Chairutama',
                'nim' => '2205181049',
                'email' => 'laksmanachairutama4@gmail.com',
                'photo' => 'laksmana.webp',
                'linkedIn' => 'https://www.linkedin.com/in/laksmana-chairutama/',
                'github' => 'https://github.com/laksa-ajaa',
                'instagram' => 'https://www.instagram.com/laksa_ajaa/',
            ],
            [
                'name' => 'Laksmana Chairutama',
                'nim' => '2205181050',
                'email' => 'laksmanachairutama5@gmail.com',
                'photo' => 'laksmana.webp',
                'linkedIn' => 'https://www.linkedin.com/in/laksmana-chairutama/',
                'github' => 'https://github.com/laksa-ajaa',
                'instagram' => 'https://www.instagram.com/laksa_ajaa/',
            ],
        ];

        foreach ($members as $member) {
            Member::create($member);
        }
    }
}
