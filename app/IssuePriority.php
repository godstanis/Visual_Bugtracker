<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Issue priority (example: High/Medium/Low)
 *
 * @package App
 */
class IssuePriority extends Model
{
    protected $table = 'issue_priority';
}
