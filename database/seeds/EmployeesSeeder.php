<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesSeeder extends Seeder
{
    /**
     * Table name
     * @var string
     */
    public $tableName = 'employees';

    /**
     * @var \Faker\Generator
     */
    public $Faker;

    /**
     * People in submission at the lowest level
     * @var int
     */
    public $workClass = 3;

    /**
     * Nodes at each level
     * @var int
     */
    public $nodesOnLevel = 3;

    /**
     * Of all hierarchy levels
     * @var int
     */
    public $totalLevel = 4;

    /**
     * Level from which to start building a tree
     * @var int
     */
    public $curLevel = 1;

    /**
     * Level filling ( see function sumLevelFill() )
     * @var array
     */
    private $lvlFill = [];

    /**
     * Step of right keys
     * @var array
     */
    private $stepKeys = [];

    /**
     * EmployeesSeeder constructor.
     */
    public function __construct()
    {
        $this->beforeRun();
        $this->computeKeyStep();
        $this->generateArrayLvlFill();
        $this->Faker = Faker\Factory::create();
    }

    /**
     * EmployeesSeeder destructor.
     */
    public function __destruct()
    {
        $this->afterRun();
    }

    /**
     * Main control method
     */
    public function run()
    {
        $left = 1;
        $curLvl = $this->curLevel; // for shortly code
        $maxLeft = ( ($this->workClass + ($this->workClass + $this->nodesOnLevel + $this->totalLevel)/2 + 1)
            ** (($this->nodesOnLevel + $this->totalLevel)/3) ) * 2;
        $maxLeft = ceil($maxLeft);
        // or $maxLeft = 200000;

        while ($left < $maxLeft) {
            $left++;
            if ($curLvl == $this->totalLevel) {
                // add nodes working class employees

                for ($j = 0; $j < $this->workClass; $j++) {
                    $this->createEmployee($left, $left + 1, $curLvl);
                    $left += 2;
                }

                // calculate sum nodes on top levels, if sum full then break loop
                if ($this->sumLevelFill()) break;
                $curLvl--;
            } elseif ($this->lvlFill[$curLvl] < $this->nodesOnLevel) {
                // add node manager employee

                $this->createEmployee($left, $left + $this->stepKeys[$curLvl], $curLvl);
                $this->lvlFill[$curLvl]++;
                $curLvl++;

            } elseif ($curLvl == 1) {
                // if at the highest level
                if ($this->lvlFill[$this->totalLevel] < $this->nodesOnLevel) {
                    // if bottom level empty continue, else break
                    $curLvl++;
                    $left--;
                    continue;
                } else break;
            } else {
                $this->lvlFill[$curLvl] = 0;
                $curLvl--;
                continue;
            }
        }
    }

    /**
     * Compute steps right keys of tree
     */
    private function computeKeyStep()
    {
        for ($i = $this->totalLevel; $i >= $this->curLevel; $i--) {
            if ($i == $this->totalLevel) {
                $this->stepKeys[$i] = 1;
            } elseif ($i == $this->totalLevel - 1) {
                $this->stepKeys[$i] = $this->workClass * 2 + 1;
            } else {
                $this->stepKeys[$i] = ($this->stepKeys[$i + 1] + 1) * $this->nodesOnLevel + 1;
            }
        }
    }

    /**
     * Generate empty array for $this->lvlFill
     * Used for moved on the tree
     */
    private function generateArrayLvlFill()
    {
        for ($i = $this->totalLevel; $i >= 1; $i--)
            $this->lvlFill[$i] = 0;
    }

    /**
     * Sum of node on level
     * @return bool (true => break loop; false => continue;)
     */
    private function sumLevelFill()
    {
        $sum = 0;
        for ($i = $this->curLevel; $i < $this->totalLevel; $i++) {
            $sum += $this->lvlFill[$i];
        }
        return ($sum == (($this->totalLevel - 1) * $this->nodesOnLevel)) ? true : false;
    }

    /**
     * Generate fake data and insert node in table
     *
     * @param   int $lft (left key)
     * @param   int $rht (right key)
     * @param   int $lvl (level)
     */
    private function createEmployee($lft, $rht, $lvl)
    {
        DB::transaction(function() use($lft, $rht, $lvl) {
            DB::table($this->tableName)
                ->insert([
                    'fullname' => $this->Faker->firstName() . ' ' . $this->Faker->lastName(),
                    'lft' => $lft,
                    'rht' => $rht,
                    'lvl' => $lvl,
                    'salary' => ceil($this->Faker->numberBetween(1470, 1800) * (1 / $lvl)),
                    'beg_work' => $this->Faker->date()
                ]);
        });
    }

    /**
     * Added root node of tree
     */
    private function beforeRun()
    {
        DB::table($this->tableName)
            ->insert([
                'fullname'   => 'Scrooge McDuck',
                'lft'       => 1,
                'rht'       => 0,
                'lvl'       => 0,
                'salary'    => 24700,
                'beg_work'  => '1947-05-12'
            ]);
    }

    /**
     * Updated right key in root node
     */
    private function afterRun()
    {
        DB::transaction(function() {
            DB::table($this->tableName)
                ->where('id', '=', 1)
                ->update([
                    'rht' => DB::table($this->tableName)->max('rht') + 1
                ]);
        });
        $countRecords = DB::table($this->tableName)->count();
        $this->command->info('<info>Generation complete. Inserted '. $countRecords .' records</info>');
    }

}
