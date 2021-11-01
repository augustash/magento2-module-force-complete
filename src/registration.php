<?php

/**
 * Force Order Complete Status Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Augustash_ForceComplete',
    __DIR__
);
