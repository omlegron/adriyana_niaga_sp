<?php

namespace App\Http;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Basic;

class Extended extends Basic
{
    public function configure()
    {
        parent::configure();
        
        $this->addDirective(Directive::DEFAULT, 'self')
            ->addDirective(Directive::FORM_ACTION, 'self')
            ->addDirective(Directive::IMG, 'www.w3.org')
            ->addDirective(Directive::IMG, 'data:')
            ->addDirective(Directive::MEDIA, 'self', 'data:;')
            ->addDirective(Directive::SCRIPT, 'www.w3.org')
            ->addDirective(Directive::SCRIPT, 'tools.ietf.org')
            ->addDirective(Directive::SCRIPT, 'www.macromedia.com')
            ->addDirective(Directive::SCRIPT, 'schemas.openxmlformats.org')
            ->addDirective(Directive::SCRIPT, 'datatables.net')
            ->addDirective(Directive::SCRIPT, 'stuk.github.io')
            ->addDirective(Directive::SCRIPT, 'cdn.datatables.net')
            ->addDirective(Directive::SCRIPT, 'www.youtube.com')
            ->addDirective(Directive::SCRIPT, 'self', Keyword::UNSAFE_INLINE)
            ->addDirective(Directive::SCRIPT_ATTR, 'unsafe-inline', Keyword::UNSAFE_INLINE)
            ->addDirective(Directive::FRAME_ANCESTORS, 'self', Keyword::UNSAFE_INLINE)
            ->addDirective(Directive::FRAME, 'www.youtube.com')
            ->addDirective(Directive::FRAME, 'self', Keyword::UNSAFE_INLINE)
            ->addDirective(Directive::STYLE, 'www.w3.org')
            ->addDirective(Directive::STYLE, 'tools.ietf.org')
            ->addDirective(Directive::STYLE, 'www.macromedia.com')
            ->addDirective(Directive::STYLE, 'schemas.openxmlformats.org')
            ->addDirective(Directive::STYLE, 'datatables.net')
            ->addDirective(Directive::STYLE, 'stuk.github.io')
            ->addDirective(Directive::STYLE, 'cdn.datatables.net')
            ->addDirective(Directive::STYLE, 'www.youtube.com')
            ->addDirective(Directive::STYLE, 'self', Keyword::UNSAFE_INLINE)
            ->addDirective(Directive::CONNECT, 'www.youtube.com')
            ->addDirective(Directive::CONNECT, 'self', Keyword::UNSAFE_INLINE)
            ->addNonceForDirective(Directive::SCRIPT)
            ->addNonceForDirective(Directive::STYLE);
    }
}
