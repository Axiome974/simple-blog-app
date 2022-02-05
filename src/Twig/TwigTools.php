<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

// La classe qui va contenir tous les filtres twig
class TwigTools extends AbstractExtension{

    public function getFilters()
    {
        return [
            new TwigFilter('badge', [$this, 'badge'], [ "is_safe" => ['html']]),
        ];
    }

    public function badge( string $text, string $color = "bg-primary" ){
        return "<span class='badge $color'>$text</span>";
    }


}