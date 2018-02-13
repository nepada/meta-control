<?php
declare(strict_types = 1);

namespace Nepada\MetaControl;


interface IMetaControlFactory
{

    /**
     * @return MetaControl
     */
    public function create(): MetaControl;

}
