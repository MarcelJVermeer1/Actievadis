<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ActivityList extends Component
{
    public $activities;

    public function __construct($activities = [])
    {
        $this->activities = $activities;
    }

    public function render()
    {
        return view('components.activity-list');
    }
}
