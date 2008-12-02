<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * This is a visual test case, testing driver fundamental driver functionality.
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
 * @subpackage Tests
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: png.php 253 2007-04-11 02:31:39Z s.moffatt@toowoomba.qld.gov.au $
 * @link       http://pear.php.net/package/Image_Graph
 */

// SPECIFY HERE WHERE A TRUETYPE FONT CAN BE FOUND
$testFont = 'c:/windows/fonts/Arial.ttf';

include 'Image/Graph/Driver.php';

$driver =& Image_Graph_Driver::factory('png', array('width' => 600, 'height' => 600));

include './driver_body.php';

?>