<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ActivityList extends Component
{
    public $activities;

    public $role;

    public function __construct($activities = [], $role = "activity")
    {
        $this->activities = $activities;
        $this->role = $role;
    }

    public function render()
    {
        return view('components.activity-list');
    }
}