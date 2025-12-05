<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    public string $title;
    public string $description;

    public function __construct(string $title = null, string $description = null)
    {
        $this->title = $title ?? config('app.name', 'Laravel');
        $this->description = $description ?? '';
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('layouts.guest');
    }
}
