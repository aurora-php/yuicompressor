<?php

/*
 * This file is part of the 'octris/yuicompressor' package.
 *
 * (c) Harald Lapp <harald@octris.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Octris\Yuicompressor;

/**
 * Combine multiple source files into a single file and compress it with yuicompressor.
 *
 * @copyright   copyright (c) 2010-2016 by Harald Lapp
 * @author      Harald Lapp <harald@octris.org>
 */
class CompressCss extends \Octris\Core\Tpl\Postprocess\CombineCss
{
    use CompressTrait;
    
    /**
     * Constructor.
     *
     * @param   array       $mappings   Array of path-prefix to real-path mappings.
     * @param   string      $dst        Destination directory for created files.
     * @param   array       $options    Optional additional options for yui compressor.
     */
    public function __construct(array $mappings, $dst, array $options = array())
    {
        parent::__construct($mappings, $dst);

        $this->setOptions(array_merge($options, ['type' => 'css']));
    }
}
