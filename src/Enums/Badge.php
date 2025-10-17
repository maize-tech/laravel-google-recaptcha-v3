<?php

namespace Maize\GoogleRecaptchaV3\Enums;

enum Badge: string
{
    case INLINE = 'inline';
    case BOTTOMLEFT = 'bottomleft';
    case BOTTOMRIGHT = 'bottomright';
    case HIDDEN = 'hidden';
}
