<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Sequence;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $videos_ids = collect([
            'uxLdDPcd-Ko',
            'vRu7yWotnws',
            'XEDufniRATc',
            'Y1LcPmjhyAo',
            'YE9U4WU2j4A',
            'THsNkkN75f8'
        ]);

        Video::factory()
            ->count(100)
            ->state(new Sequence(
                fn ($sequence) => ['videoId' => $videos_ids->random()],
            ))
            ->create();
    }
}
