<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Image_Graph - Main class for the graph creation.
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
 * @subpackage Text
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: Title.php 258 2007-04-11 04:02:33Z s.moffatt@toowoomba.qld.gov.au $
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Layout.php
 */
jimport('pear.Image.Graph.Layout');

/**
 * Title
 * 
 * @category   Images
 * @package    Image_Graph
 * @subpackage Text
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Title extends Image_Graph_Layout
{

    /**
     * The text to print
     * @var string
     * @access private
     */
    var $_text;

    /**
     * The font to use
     * @var Font
     * @access private
     */
    var $_font;

    /**
     * Create the title.
     *
     * Pass a Image_Graph_Font object - preferably by-ref (&amp;) as second
     * parameter, the font size in pixels or an associated array with some or
     * all of the followin keys:
     *
     * 'size' The size of the title
     *
     * 'angle' The angle at which to write the title (in degrees or 'vertical')
     *
     * 'color' The font-face color
     *
     * @param sting $text The text to represent the title
     * @param mixed $fontOptions The font to use in the title
     */
    function &Image_Graph_Title($text, $fontOptions = false)
    {
        parent::Image_Graph_Layout();
        if (is_object($fontOptions)) {
            $this->_font =& $fontOptions;
        } else {
            if (is_array($fontOptions)) {
                $this->_fontOptions = $fontOptions;
            } else {
                $this->_fontOptions['size'] = $fontOptions;
            }
        }
        $this->setText($text);
    }

    /**
     * Set the text
     *
     * @param string $text The text to display
     */
    function setText($text)
    {
        $this->_text = $text;
    }

    /**
     * Returns the calculated "auto" size
     *
     * @return int The calculated auto size
     * @access private
     */
    function _getAutoSize()
    {
        if ($this->_defaultFontOptions !== false) {
            $this->_driver->setFont($this->_defaultFontOptions);
        } else {        
            $this->_driver->setFont($this->_getFont());
        }

        return $this->_driver->textHeight($this->_text);
    }

    /**
     * Output the text
     *
     * @return bool Was the output 'good' (true) or 'bad' (false).
     * @access private
     */
    function _done()
    {
        if ($this->_defaultFontOptions !== false) {
            $this->_driver->setFont($this->_defaultFontOptions);
        } else {        
            $this->_driver->setFont($this->_getFont());
        }

        if (is_a($this->_parent, 'Image_Graph_Plotarea')) {            
            $this->_setCoords(
                $this->_parent->_left,
                $this->_parent->_top,
                $this->_parent->_right,
                $this->_parent->_top + $this->_driver->textHeight($this->_text)
            );
        } elseif (!is_a($this->_parent, 'Image_Graph_Layout')) {
            $this->_setCoords(
                $this->_parent->_fillLeft(),
                $this->_parent->_fillTop(),
                $this->_parent->_fillRight(),
                $this->_parent->_fillTop() + $this->_driver->textHeight($this->_text)
            );
        }

        if (parent::_done() === false) {
            return false;
        }

        $x = ($this->_left + $this->_right) / 2;
        $y = ($this->_top + $this->_bottom) / 2;

        $this->write(
            $x,
            $y,
            $this->_text,
            IMAGE_GRAPH_ALIGN_CENTER_X + IMAGE_GRAPH_ALIGN_CENTER_Y
        );
        return true;
    }

}

?>