<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Issue type (example: Bug/Task/Feature)
 *
 * @package App
 */
class IssueType extends Model
{
    protected $table = 'issue_type';
}
