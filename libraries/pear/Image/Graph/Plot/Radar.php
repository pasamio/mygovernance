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
 * @version    CVS: $Id: Radar.php 258 2007-04-11 04:02:33Z s.moffatt@toowoomba.qld.gov.au $
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Plot.php
 */
jimport('pear.Image.Graph.Plot');

/**
 * Radar chart.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Plot
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Plot_Radar extends Image_Graph_Plot
{

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
        $p = 10;
        $rx = abs($x1 - $x0) / 2;
        $ry = abs($x1 - $x0) / 2;
        $r = min($rx, $ry);
        $cx = ($x0 + $x1) / 2;
        $cy = ($y0 + $y1) / 2;
        $max = 5;
        for ($i = 0; $i < $p; $i++) {
            $v = 2 * pi() * $i / $p;
            $t = $r * rand(3, $max) / $max;
            $x = $cx + $t * cos($v);
            $y = $cy + $t * sin($v);
            $this->_driver->polygonAdd($x, $y);
        }
        $this->_driver->polygonEnd();
    }

    /**
     * Output the plot
     *
     * @return bool Was the output 'good' (true) or 'bad' (false).
     * @access private
     */
    function _done()
    {
        $this->_driver->startGroup(get_class($this) . '_' . $this->_title);
        if (is_a($this->_parent, 'Image_Graph_Plotarea_Radar')) {
            $keys = array_keys($this->_dataset);
            foreach ($keys as $key) {
                $dataset =& $this->_dataset[$key];
                $maxY = $dataset->maximumY();
                $count = $dataset->count();

                $dataset->_reset();
                while ($point = $dataset->_next()) {
                    $this->_driver->polygonAdd(
                        $this->_pointX($point),
                        $this->_pointY($point)
                    );
                }
                $this->_getFillStyle($key);
                $this->_getLineStyle($key);
                $this->_driver->polygonEnd();
            }
            unset($keys);
        }
        $this->_drawMarker();

        $this->_driver->endGroup();
        return parent::_done();
    }

}

?>