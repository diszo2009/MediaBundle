<?php

/*
 * This file is part of the RzMediaBundle package.
 *
 * (c) mell m. zamora <mell@rzproject.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rz\MediaBundle\Entity;

use Sonata\MediaBundle\Entity\MediaManager as BaseMediaManager;

class MediaManager extends BaseMediaManager
{
    /**
     * {@inheritdoc}
     */
    public function fetchMedia()
    {
        return $this->getRepository()->findAll();
    }
}
