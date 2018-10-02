<?php

use Illuminate\Database\Seeder;

use App\IssueType;
use App\IssuePriority;

/**
 * This class is used to generate default values for issue type and priority tables.
 */
class IssueTablesDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultTypes = array(
            array('id'=>1, 'title'=>'Bug'),
            array('id'=>2, 'title'=>'Task')
        );
        $defaultPriorities = array(
            array('id'=>1, 'title'=>'Low'),
            array('id'=>2, 'title'=>'Medium'),
            array('id'=>3, 'title'=>'High')
        );

        IssueType::insert($defaultTypes);
        IssuePriority::insert($defaultPriorities);
    }
}
