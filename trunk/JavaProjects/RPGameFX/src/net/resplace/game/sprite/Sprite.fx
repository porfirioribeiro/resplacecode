/*
 * Sprite.fx
 *
 * Created on 17/Dez/2008, 16:17:15
 */

package net.resplace.game.sprite;

import java.awt.Image;
import java.awt.image.BufferedImage;
import java.net.URL;
import javax.swing.ImageIcon;
import net.resplace.game.sprite.Sprite;
import java.awt.Point;
import java.awt.Graphics2D;
import java.lang.Thread;
import java.io.File;

    /**
    * @author Porfirio
     */
    class BBox{
        public var left:Number=0;
        public var top:Number=0;
        public var right:Number=0;
        public var bottom:Number=0;
    }
    public function load(image:Image):BufferedImage{
        var img:BufferedImage = new BufferedImage(
            image.getWidth(null),
            image.getHeight(null), BufferedImage.TYPE_INT_ARGB);
        img.getGraphics().drawImage(image, 0, 0, null);
        return img;
    }
    public function load(file:String):BufferedImage{
        var f:File=new File(file);
        if (f.exists()){
            return load(new ImageIcon(file).getImage());
        }
        try {
            return load( new ImageIcon(new URL(file)).getImage());
        } catch (e) {
        }
        return null;
    }
    public function load(file:URL):BufferedImage{
        return load(new ImageIcon(file).getImage());
    }

public class Sprite {
    public var frames:BufferedImage[];
    public def frameNumber:Integer=bind sizeof frames;
    package public-read var width:Number;
    package public-read var height:Number;
    public var bbox:BBox=BBox{} on replace{
        if (bbox==null){
            bbox=BBox{};
        }
    };
    public var origin:Point=new Point(0,0) on replace{
        if (origin == null){
            origin=new Point(0,0);
        }
    };
    public function setBBox(left:Number, top:Number, right:Number, bottom:Number){
        bbox=Sprite.BBox{
            left:left, 
            top:top,
            right:right,
        bottom:bottom};
    }
    public function add(image:BufferedImage){
        insert image into frames;
        if (width==0){
            width=image.getWidth();
        }
        if (height==0){
            height=image.getHeight();
        }
    }
    public function add(file:String){
        add(load(file));
    }
    public function add(url:URL){
        add(load(url));
    }
    public function remove(image:BufferedImage){
        delete image from frames;
    }
    public function remove(i:Integer){
        delete frames[i];
    }
    public function get(i:Integer):BufferedImage{
        return frames[i];
    }
    public function drawFrame(g:Graphics2D, index:Integer, x:Number, y:Number){
        var image:BufferedImage=frames[index];
        if (image != null){
            g.drawImage(image, x - origin.x, y - origin.y, null);
        }
    }
}
