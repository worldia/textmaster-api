<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Textmaster\Exception;

class MappingNotFoundException extends \InvalidArgumentException
{
    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        parent::__construct(sprintf(
            'Couldnt find property mapping for "%s".',
            is_object($value) ? get_class($value) : gettype($value)
        ));
    }
}
