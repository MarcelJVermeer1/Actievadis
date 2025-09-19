<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EnrolledActivityItem extends Component
{
    public $activity;

    public function __construct($activity)
    {
        $this->activity = $activity;
    }

    public function render()
    {
        return view('components.enrolled-activity-item');
    }
}
