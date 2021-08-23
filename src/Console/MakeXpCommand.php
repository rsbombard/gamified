<?php

namespace Bomb\Gamify\Console;

use Bomb\Gamify\GamifyGroup;
use Bomb\Gamify\Xp;
use Illuminate\Console\GeneratorCommand;

class MakeXpCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gamify:xp {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Gamify xp type class.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Xp';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/xp.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace The root namespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Gamify\Xp';
    }


    /**
     * Execute the console command.
     *
     * @return bool|null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        if ($this->confirm('Do you wanna create database record ?')) {

            $name = $this->ask('Xp name?');
            $description = $this->ask('Xp description?');
            $group = $this->ask('Xp Group?');
            $xp = $this->ask('Xp value?');
            $allow_duplicate = false;

            if ($this->confirm('Allow duplicate ?')) {
                $allow_duplicate = true;
            }

            $group = GamifyGroup::firstOrCreate(['name' => $group, 'type' => 'xp']);

            Xp::create([
                'name'            => $name,
                'description'     => $description,
                'allow_duplicate' => $allow_duplicate,
                'xp'           => $xp,
                'gamify_group_id' => $group->id,
                'class'           => $this->qualifyClass($this->argument('name')),
            ]);
        }


        return parent::handle();
    }
}
