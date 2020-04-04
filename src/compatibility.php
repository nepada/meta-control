<?php
declare(strict_types = 1);

namespace Nepada\MetaControl;

if (false) {
    /** @deprecated use MetaControlFactory */
    interface IMetaControlFactory extends MetaControlFactory
    {

    }
} elseif (! interface_exists(IMetaControlFactory::class)) {
    class_alias(MetaControlFactory::class, IMetaControlFactory::class);
}
