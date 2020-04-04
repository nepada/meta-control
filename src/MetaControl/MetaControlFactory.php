<?php
declare(strict_types = 1);

namespace Nepada\MetaControl;

interface MetaControlFactory
{

    public function create(): MetaControl;

}
