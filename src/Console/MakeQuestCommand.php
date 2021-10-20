<?php

namespace Bomb\Gamify\Console;

use Bomb\Gamify\GamifyGroup;
use Bomb\Gamify\Xp;
use Bomb\Gamify\Quest;
use Illuminate\Console\Command;

class MakeQuestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gamify:quest';

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

        $name                 = $this->ask('Quest name?');
        $description          = $this->ask('Quest Description?');
        $url                  = $this->ask('Quest Action URL?');
        $image                = $this->ask('Quest Image?');
        $geos                 = $this->ask("Geos?");
        $minLevel             = $this->ask("Minimum User Level?");
        $rewardType           = $this->ask("Reward Type?");
        $requirementType       = $this->ask("Requirement Type?");
        $requirementConditions = $this->ask("Requirement Conditions?");
        $progressEvent        = $this->ask("Progress Event Name?");
        $numActionsRequired   = $this->ask("Number of Actions Required?");
        $reward               = $this->ask("Reward Payout?");
        $maxCompletions       = $this->ask("Max Number of Completions Per User?");
        $endInDays            = $this->ask("End In how many days?");
        $premiumOnly           = $this->anticipate('Premium Only?', [false, true]);


        Quest::create([
            'name'                   => $name,
            'description'            => $description,
            'action_url'             => $url,
            'image'                  => $image,
            'geos'                   => $geos,
            'min_level'              => $minLevel,
            'reward_type'            => $rewardType,
            'reward'                 => $reward,
            'requirement_type'       => $requirementType,
            'requirement_conditions' => $requirementConditions,
            'progress_event'         => $progressEvent,
            'actions_required'       => $numActionsRequired,
            'max_user_completions'   => $maxCompletions,
            'premium_only'          => (bool) $premiumOnly,
            'completions'            => 0,
            'start_date'             => \Carbon\Carbon::now()->toDateTimeString(),
            'end_date'               => \Carbon\Carbon::now()->addDays($endInDays)->toDateTimeString(),
        ]);

    }
}
