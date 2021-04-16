<?php

namespace SilverHead\TagBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SilverHeadTagBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
