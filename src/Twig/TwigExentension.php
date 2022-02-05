<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigExentension extends AbstractExtension{


    public function getFilters()
    {
        return [
            new TwigFilter('summary', [$this, 'summary']),
        ];
    }

    public function summary(string $text, $long = 300){
        
        $textLenght = strlen($text);

        if( $textLenght > $long ){
            $text = substr($text, 0, $long);
            $text.="[...]";
        }
        return $text;

    }




}