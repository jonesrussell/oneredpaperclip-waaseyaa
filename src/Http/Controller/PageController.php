<?php

declare(strict_types=1);

namespace OneRedPaperclip\Http\Controller;

use Waaseyaa\Inertia\Inertia;
use Waaseyaa\Inertia\InertiaResponse;

final class PageController
{
    public function home(): InertiaResponse
    {
        return Inertia::render('Welcome', []);
    }

    public function about(): InertiaResponse
    {
        return Inertia::render('About', []);
    }
}
