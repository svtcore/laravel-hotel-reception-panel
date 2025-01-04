<?php

namespace App\CSP;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;

class CustomPolicy extends Basic
{
    public function configure()
    {
        parent::configure();

        $this->addDirective(Directive::DEFAULT, ['self']);

        $this->addDirective(Directive::SCRIPT, [
            'self',
            'https://code.jquery.com',
            'https://cdn.jsdelivr.net',
            'https://cdn.datatables.net',
            'https://adminlte.io',

        ]);

        $this->addDirective(Directive::STYLE, [
            'self',
            'https://cdn.jsdelivr.net',
            'https://cdn.datatables.net',
        ]);

        $this->addDirective(Directive::IMG, [
            'self',
            'data:',
        ]);

        $this->addDirective(Directive::FONT, [
            'self',
            'https://cdn.jsdelivr.net',
        ]);

        $this->addDirective(Directive::CONNECT, [
            'self',
            'https://restcountries.com/v3.1/all',
        ]);

        $this->addDirective(Directive::FRAME_ANCESTORS, ['none']);
        
        $this->addDirective(Directive::FORM_ACTION, ['self']);
    }
}
