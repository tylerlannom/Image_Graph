<?php
// +--------------------------------------------------------------------------+
// | Image_Graph                                                              |
// +--------------------------------------------------------------------------+
// | Copyright (C) 2003, 2004 Jesper Veggerby                                 |
// | Email         pear.nosey@veggerby.dk                                     |
// | Web           http://pear.veggerby.dk                                    |
// | PEAR          http://pear.php.net/package/Image_Graph                    |
// +--------------------------------------------------------------------------+
// | This library is free software; you can redistribute it and/or            |
// | modify it under the terms of the GNU Lesser General Public               |
// | License as published by the Free Software Foundation; either             |
// | version 2.1 of the License, or (at your option) any later version.       |
// |                                                                          |
// | This library is distributed in the hope that it will be useful,          |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of           |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU        |
// | Lesser General Public License for more details.                          |
// |                                                                          |
// | You should have received a copy of the GNU Lesser General Public         |
// | License along with this library; if not, write to the Free Software      |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA |
// +--------------------------------------------------------------------------+

/**
 * Image_Graph - PEAR PHP OO Graph Rendering Utility.
 * @package Image_Graph
 * @subpackage Fill     
 * @category images
 * @copyright Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
 * @author Jesper Veggerby <pear.nosey@veggerby.dk>
 * @version $Id$
 */ 

/**
 * Include file Image/Graph/Fill.php
 */
require_once 'Image/Graph/Fill.php';

/**
 * Solid colored fill.
 */
class Image_Graph_Fill_Solid extends Image_Graph_Fill 
{

    /**
     * The solid fill color
     * @var mixed
     * @access private
     */
    var $_color = null;

    /**
     * Image_Graph_SolidFill [Constructor]
     * @param mixed $color The color to use as a solid fill 
     */
    function &Image_Graph_Fill_Solid($color)
    {
        parent::Image_Graph_Fill();
        $this->_color = $color;
    }

    /**
     * Return the fillstyle
     * @return int A GD fillstyle
     * @access private 
     */
    function _getFillStyle($ID = false)
    {
        if ($this->_color != null) {
            return $this->_color($this->_color);
        } else {
            return parent::_getFillStyle($ID);
        }
    }

}

?>