<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
//
// $Id$

require_once("Image/Color.php"); // package: PEAR::Image_Color

/**
* Class for color-handling
*
* This is used to extend the functionality of the current PEAR::Image_Color v0.4.
* I hope to be allowed to incorporate some of the improvements in a new Image_Color release.
*
* @author   Stefan Neufeind <pear.neufeind@speedpartner.de>
* @package  Image_Graph
* @access   public
*/
class Image_Graph_Color extends Image_Color
{
    /**
    * Allocates a color in the given image.
    * 
    * Userdefined color specifications get translated into 
    * an array of rgb values.
    *
    * @param    resource    Image handle
    * @param    mixed       (Userdefined) color specification
    * @return   resource    Image color handle
    * @see      color2RGB()
    * @access   public
    * @static
    */  
    function allocateColor(&$img, $color) {
        $color = Image_Graph_Color::color2RGB($color);

        if ($color[3] == 255) {
            return imagecolorallocate($img, $color[0], $color[1], $color[2]);
        } else {
            return imagecolorallocatealpha($img, $color[0], $color[1], $color[2], 127-round(($color[3]*127)/255));
        }
    }                 

    /**
    * Convert any color-representation into an array of 4 ints (RGBA).
    * 
    * Userdefined color specifications get translated into 
    * an array of rgb values.
    *
    * @param    mixed       (Userdefined) color specification
    * @return   array       Array of 4 ints (RGBA-representation)
    * @access   public
    * @static
    */  
    function color2RGB($color)
    {
        if (is_array($color)) {
            if (!is_numeric($color[0])) {
                return null; // error
            }
            if (count($color) == 3) { // assume RGB-color
              
                // 255 = alpha-value; full opaque
                return array((int) $color[0],
                             (int) $color[1],
                             (int) $color[2],
                             255);
            }
            if (count($color) == 4) { // assume RGBA-color
              
                // 255 = alpha-value; full opaque
                return array((int) $color[0],
                             (int) $color[1],
                             (int) $color[2],
                             (int) $color[3]);
            }
            return null; // error
        } elseif (is_string($color)) {
            $alphaPos = strpos($color, '@');
            if ($alphaPos === false) {
                $alpha = 255;
            } else {
                $alphaFloat = (float) substr($color, $alphaPos+1);
                // restrict to range 0..1
                $alphaFloat = max(min($alphaFloat, 1), 0);
                $alpha = (int) round((float) 255 * $alphaFloat);
                $color = substr($color, 0, $alphaPos);
            }
            if ($color[0] == '#') {  // hex-color given, e.g. #FFB4B4
                $tempColor = parent::hex2rgb($color);
                return array((int) $tempColor[0],
                             (int) $tempColor[1],
                             (int) $tempColor[2],
                             $alpha);
            }
            if (strpos($color,'%') !== FALSE) {
                $tempColor = parent::percentageColor2RGB($color);
                return array((int) $tempColor[0],
                             (int) $tempColor[1],
                             (int) $tempColor[2],
                             $alpha);
            } else {
                $tempColor = parent::namedColor2RGB($color);
                return array((int) $tempColor[0],
                             (int) $tempColor[1],
                             (int) $tempColor[2],
                             $alpha);
            }
        } else {
            return null; // error
        }
    }

    /**
    *   getRange
    *   Given a degree, you can get the range of colors between one color and
    *   another color.
    *
    *   @access     public
    *   @param      string  $degrees How much each 'step' between the colors we should take.
    *   @return     array   Returns an array of all the colors, one element for each color.
    *   @author     Jason Lotito <jason@lehighweb.com>
    */
    function getRange ($degrees)
    {
        $tempColors = parent::getRange($degrees);

        // now add alpha-channel information
        $steps = count($tempColors);
        for($counter=0;$counter<$steps;$counter++) {
            $tempColors[$counter] = parent::hex2rgb($tempColors[$counter]);
            unset($tempColors[$counter]['hex']);
            $tempColors[$counter][3] = (int) round(
                                         (((float) $this->color1[3]*($steps-$counter))+
                                          ((float) $this->color2[3]*($counter))
                                         ) / $steps
                                                  );
        }
          
        return $tempColors;
    }
    
    /**
    * Internal method to correctly set the colors.
    *
    * @param    mixed     color 1
    * @param    mixed     color 2
    * @access   private
    */
    function _setColors ( $col1, $col2 )
    {
        $this->color1 = Image_Graph_Color::color2RGB($col1);
        $this->color2 = Image_Graph_Color::color2RGB($col2);
    }
}