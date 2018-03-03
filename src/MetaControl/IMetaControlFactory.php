<?php
declare(strict_types = 1);

namespace Nepada\MetaControl;


interface IMetaControlFactory
{

    public function create(): MetaControl;

}
