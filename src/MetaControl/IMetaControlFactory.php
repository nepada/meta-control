<?php
/**
 * This file is part of the nepada/meta-control.
 * Copyright (c) 2017 Petr Morávek (petr@pada.cz)
 */

declare(strict_types = 1);

namespace Nepada\MetaControl;


interface IMetaControlFactory
{

    /**
     * @return MetaControl
     */
    public function create(): MetaControl;

}
