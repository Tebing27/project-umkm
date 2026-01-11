<?php

namespace App\View\Composers;

use App\Models\Content;
use Illuminate\View\View;

class NavigationComposer
{
    /**
     * Bind data to the navigation view.
     */
    public function compose(View $view): void
    {
        $view->with([
            'logoShowImage' => Content::get('logo_show_image', '0'),
            'logoShowText' => Content::get('logo_show_text', '1'),
            'logoText' => Content::get('logo_text', 'Logo'),
            'logoImage' => Content::get('logo_image'),
        ]);
    }
}
