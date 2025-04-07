<?php

namespace Database\Seeders;

use App\Models\ContactInfo;
use Illuminate\Database\Seeder;

class ContactInfoSeeder extends Seeder
{


    public function run(): void
    {
        ContactInfo::create([
            'address_hu' => '1234 Budapest, Példa utca 1.',
            'address_en' => '1234 Budapest, Example Street 1.',
            'phone' => '+36 1 234 5678',
            'email' => 'info@example.com',
            'facebook' => 'https://facebook.com/example',
            'instagram' => 'https://instagram.com/example',
            'linkedin' => 'https://linkedin.com/in/example'
        ]);
    }
}
