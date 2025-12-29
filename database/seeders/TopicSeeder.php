<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\Post;
use App\Support\PostFixtures;
use App\Models\User;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'slug' => 'general',
                'name' => 'General',
                'description' => 'Any and all things about films and movies',
            ],
            [   'slug' => 'reviews',
                'name' => 'Reviews',
                'description' => 'What\'s the census on that latest flick? Read all about it here!',
        ],
            [   'slug' => 'questions',
                'name' => 'Questions',
                'description' => 'Didn\'t quite understand that one plot pointe? There are no stupid questions here.',
        ],
            [   'slug' => 'conspiracies',
                'name' => 'Conspiracies',
                'description' => 'Got a wild idea about how the Incredibles and Monster\'s Ink are connected?',
    ],

            [   'slug' => 'fan-fic',
                'name' => 'Fan Fiction',
                'description' => 'Got a great idea for a sequel? Tell us all about it and get the audience opinion.',
            ]
        ];

        Topic::upsert($data, ['slug']);
    }
}
