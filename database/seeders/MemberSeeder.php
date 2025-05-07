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
                'name' => 'Brema Arihta Siregar',
                'nim' => '2205181078',
                'email' => 'bremasiregar@Gmail.com',
                'photo' => 'brema.webp',
                'linkedIn' => '',
                'github' => '',
                'instagram' => 'https://www.instagram.com/bremaarihta/',
            ],
            [
                'name' => 'Erza Nugraha Ginting',
                'nim' => '2205181057',
                'email' => 'erzaginting123@gmail.com',
                'photo' => 'erza.webp',
                'linkedIn' => '',
                'github' => '',
                'instagram' => 'https://www.instagram.com/ezangrhag/',
            ],
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
                'name' => 'Muhammad Khoiril Amri',
                'nim' => '2205181017',
                'email' => 'amrikhoiril695@gmail.com',
                'photo' => 'khoiril.webp',
                'linkedIn' => '',
                'github' => '',
                'instagram' => 'https://www.instagram.com/amrikhoiril695/',
            ],
            [
                'name' => 'Viona Ester Patricia Siahaan',
                'nim' => '2205181030',
                'email' => 'viona9haan07@gmail.com',
                'photo' => 'viona.webp',
                'linkedIn' => 'https://www.linkedin.com/in/viona-siahaan',
                'github' => 'https://github.com/Vio-Shn',
                'instagram' => 'https://www.instagram.com/hereimvi/',
            ],
            [
                'name' => 'Wizdanil Yumna Nawar',
                'nim' => '2205181063',
                'email' => 'yumna123yumna@gmail.com',
                'photo' => 'yumna.webp',
                'linkedIn' => '',
                'github' => '',
                'instagram' => 'https://www.instagram.com/yumiiyay/',
            ]
        ];
        foreach ($members as $member) {
            Member::create($member);
        }
    }
}
