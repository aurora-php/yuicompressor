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
 * 
 * @copyright   copyright (c) 2013-2016 by Harald Lapp
 * @author      Harald Lapp <harald@octris.org>
 */
trait CompressTrait
{
    /**
     * Additional options for yuicompressor.
     *
     * @type    array
     */
    protected $options = array();

    /**
     * Extension for output file.
     *
     * @type    string
     */
    protected $file_ext;

    /**
     * Set YUI compressor options.
     * 
     * @param   array       $options    Options for YUI compressor.
     */
    public function setOptions(array $options)
    {
        $this->options = array_map(function($k, $v) {
            if ($k == 'type') {
                $this->file_ext = '.' . $v;
            }
            
            return escapeshellarg('--' . $k . ' ' .$v);
        }, array_keys($options), array_values($options));
    }

    /**
     * Process (combine) collected files.
     *
     * @param   array       $files      Files to combine.
     * @return  string                  Destination name.
     */
    public function processFiles(array $files)
    {
        $files = array_map(function ($file) {
            return escapeshellarg($file);
        }, $files);

        $tmp = tempnam('/tmp', 'oct');

        $cmd = sprintf(
            'cat %s | java -jar %s/yuicompressor.jar %s -o %s 2>&1',
            implode(' ', $files),
            __DIR__ . '/../bin',
            implode(' ', $this->options),
            $tmp
        );

        $ret = array();
        $ret_val = 0;
        exec($cmd, $ret, $ret_val);

        $md5  = md5_file($tmp);
        $name = $md5 . $this->file_ext;
        rename($tmp, $this->dst . '/' . $name);

        return $name;
    }
}
