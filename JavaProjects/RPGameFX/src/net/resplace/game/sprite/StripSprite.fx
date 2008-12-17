/*
 * StripSprite.fx
 *
 * Created on 17/Dez/2008, 16:52:35
 */

package net.resplace.game.sprite;

import java.awt.image.BufferedImage;

/**
 * @author Porfirio
 */

public class StripSprite {
    public-init var image:BufferedImage;
    public-init var width:Number = 0;
    public-init var height:Number = 0;
    public-init var hOffset:Number = 0;
    public-init var vOffset:Number = 0;
    public-init var hSeparation:Number = 0;
    public-init var vSeparation:Number = 0;
    public-read var stripWidth:Number = 0;
    public-read var stripHeight:Number = 0;
    init{
        if(image != null){
            stripWidth=image.getWidth();
            stripHeight=image.getHeight();
        }
    }
    public function getImage(h:Integer, v:Integer):BufferedImage {
        var y:Number = (h * width) + hOffset;
        if (h > 0) {
            y += (h * hSeparation);
        }
        var x:Number = (v * height) + vOffset;
        if (v > 0) {
            x += (v * vSeparation);
        }
        /**if ((x + width>stripWidth) || (y + height>stripHeight)){
        throw new Exception("Trying to get a tile out of bounds!");
        }*/
        return image.getSubimage(x, y, width, height);
    }
    public function getSprite(h:Integer, v:Integer):Sprite {
        return Sprite{
            frames: [getImage(h, v)]
        };
    }

    public function getImage(positions:Integer[]):BufferedImage[]{
        var images:BufferedImage[];
        var size=(sizeof positions)-1;
        for (i in [0..size step 2]){
            if (i + 1 == sizeof positions) {
                break;
            }
            insert getImage(positions[i], positions[i + 1]) into images;
        }
        return images;
    }
    public function getSprite(positions:Integer[]):Sprite{
        return Sprite{
            frames: getImage(positions)
        };
    }
    public function getIt(positions:Number):Sprite{
        return null;
    }

}