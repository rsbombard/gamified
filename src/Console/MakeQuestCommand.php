<?php

namespace Bomb\Gamify\Console;

use Bomb\Gamify\GamifyGroup;
use Bomb\Gamify\Point;
use Bomb\Gamify\Quest;
use Illuminate\Console\GeneratorCommand;

class MakeQuestCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gamify:qyest {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Gamify quest database entry.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Quest';

    public function handle()
    {

        $name               = $this->ask('Quest name?');
        $description        = $this->ask('Quest Description?');
        $url                = $this->ask('Quest Action URL?');
        $image              = $this->ask('Quest Image?');
        $geos               = $this->ask("Geos?");
        $minLevel           = $this->ask("Minimum User Level?");
        $rewardType         = $this->ask("Reward Type?");
        $progressEvent      = $this->ask("Progress Event Name?");
        $numActionsRequired = $this->ask("Number of Actions Required?");
        $reward             = $this->ask("Reward Payout?");
        $maxCompletions     = $this->ask("Max Number of Comppletions Per User?");


        Quest::create([
            'name'                 => $name,
            'description'          => $description,
            'action_url'           => $url,
            'image'                => $image,
            'geos'                 => $geos,
            'min_level'            => $minLevel,
            'reward_type'          => $rewardType,
            'reward'               => $reward,
            'progress_event'       => $progressEvent,
            'actions_required'     => $numActionsRequired,
            'max_user_completions' => $maxCompletions,
            'start_date'           => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

    }
}
