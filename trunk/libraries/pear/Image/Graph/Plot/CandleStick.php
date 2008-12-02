<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Image_Graph - PEAR PHP OO Graph Rendering Utility.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This library is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation; either version 2.1 of the License, or (at your
 * option) any later version. This library is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
 * General Public License for more details. You should have received a copy of
 * the GNU Lesser General Public License along with this library; if not, write
 * to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 * 02111-1307 USA
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Plot
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: CandleStick.php 253 2007-04-11 02:31:39Z s.moffatt@toowoomba.qld.gov.au $
 * @link       http://pear.php.net/package/Image_Graph
 * @since      File available since Release 0.3.0dev2
 */

/**
 * Include file Image/Graph/Plot.php
 */
require_once 'Image/Graph/Plot.php';

/**
 * Candlestick chart.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Plot
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/Image_Graph
 * @since      Class available since Release 0.3.0dev2
 */
class Image_Graph_Plot_CandleStick extends Image_Graph_Plot
{

    /**
     * (Add basic description here)
     *
     * @access private
     */
    function _drawCandleStick($x, $w, $y_min, $y_open, $y_close, $y_max, $ID) 
    {
        $this->_getLineStyle($ID);
        $this->_driver->line($x, min($y_open, $y_close), $x, $y_max);
        $this->_getLineStyle($ID);
        $this->_driver->line($x, max($y_open, $y_close), $x, $y_min);
    
        $this->_getLineStyle($ID);
        $this->_getFillStyle($ID);
        $this->_driver->rectangle($x - $w, min($y_open, $y_close), $x + $w, max($y_open, $y_close));
    }

    /**
     * Perform the actual drawing on the legend.
     *
     * @param int $x0 The top-left x-coordinate
     * @param int $y0 The top-left y-coordinate
     * @param int $x1 The bottom-right x-coordinate
     * @param int $y1 The bottom-right y-coordinate
     * @access private
     */
    function _drawLegendSample($x0, $y0, $x1, $y1)
    {
        $x = round(($x0 + $x1) / 2);
        $h = abs($y1 - $y0) / 4;
        $w = round(abs($x1 - $x0) / 5);
        $this->_drawCandleStick($x, $w, $y1, $y1 - $h, $y0 + $h, $y0, 'green');
    }

    /**
     * Output the plot
     *
     * @return bool Was the output 'good' (true) or 'bad' (false).
     * @access private
     */
    function _done()
    {
        if (parent::_done() === false) {
            return false;
        }

        if (!is_array($this->_dataset)) {
            return false;
        }

        $this->_driver->startGroup(get_class($this) . '_' . $this->_title);

        if ($this->_multiType == 'stacked100pct') {
            $total = $this->_getTotals();
        }
        $current = array();
        $number = 0;
        $width = floor(0.8 * $this->_parent->_labelDistance(IMAGE_GRAPH_AXIS_X) / 2);

        $keys = array_keys($this->_dataset);
        foreach ($keys as $key) {
            $dataset =& $this->_dataset[$key];
            $dataset->_reset();
            while ($data = $dataset->_next()) {
                $point['X'] = $data['X'];
                $y = $data['Y'];

                $point['Y'] = $data['Y']['open'];
                $x = $this->_pointX($point);
                $y_open = $this->_pointY($point);

                $point['Y'] = $data['Y']['close'];
                $y_close = $this->_pointY($point);

                $point['Y'] = $data['Y']['min'];
                $y_min = $this->_pointY($point);

                $point['Y'] = $data['Y']['max'];
                $y_max = $this->_pointY($point);

                if ($data['Y']['close'] < $data['Y']['open']) {
                    $ID = 'red';
                } else {
                    $ID = 'green';
                }

                $this->_drawCandleStick($x, $width, $y_min, $y_open, $y_close, $y_max, $ID);
            }
        }
        unset($keys);
        $this->_drawMarker();
        
        $this->_driver->endGroup($this->_title);
        
        return true;
    }

}

?>