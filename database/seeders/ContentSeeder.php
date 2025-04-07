<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $contents = [
            [
                'key' => 'about',
                'title' => 'Rólunk',
                'content' => '<p>Mi vagyunk a legjobb választás, ha minőségi szolgáltatásra van szüksége.</p>',
                'sort_order' => 2,
                'is_active' => true
            ],
        ];

        foreach ($contents as $content) {
            Content::create($content);
        }
    }
}
