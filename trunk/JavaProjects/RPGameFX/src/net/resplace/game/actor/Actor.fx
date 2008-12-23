/*
 * Actor.fx
 *
 * Created on 20/Dez/2008, 20:27:34
 */

package net.resplace.game.actor;

import java.awt.Graphics2D;
import java.lang.Math;
import net.resplace.game.node.Node;
import net.resplace.game.sprite.Sprite;
import java.awt.Rectangle;
import net.resplace.game.node.Event.*;
/**
 * @author Porfirio
 */


public class Actor extends Node{
    public var sprite:Sprite on replace{
        if (sprite == null){
            frameIndex=0;
        }else if (sprite.frameNumber > frameIndex){
            frameIndex=sprite.frameNumber - 1;
        }
    }
    public-read var width:Number=bind sprite.width;
    public-read var height:Number= bind sprite.height;
    public-read var outRect:Rectangle=bind new Rectangle(x,y,width,height);
    public var frameSpeed:Integer;
    public var frameIndex:Integer on replace{
        if (frameIndex < 0 or frameIndex >= sprite.frameNumber){
            frameIndex=0;//TODO: Throw error!!
        }
    }
    var currentTime:Number=0;
    public var speed:Number=0 on replace{
        set_motion(direction, speed);
    }
    public var direction:Number=0 on replace{
        set_motion(direction, speed);
    }
    function set_motion(direction:Number, speed:Number){
        var dir = 180-direction;
        /*var d:Number = (Math.floor(dir) mod 360);
        if (d < 0) {
            dir = 360 + dir;
        }*/
        var xdir = Math.sin(Math.PI * dir / 180);
        var ydir = Math.cos(Math.PI * dir / 180);
        hspeed = xdir * speed;
        vspeed = ydir * speed;
    }
    public function setMotion(direction:Number, speed:Number){
        this.direction=direction;
        this.speed=speed;
    }
    public var hspeed:Number;
    public var vspeed:Number;
    public override var onUpdate=function (e:UpdateEv){
        //Update sprite
        currentTime += e.elapsedTime;
        if (frameSpeed > 0) {
            if (currentTime > (1000 / frameSpeed)) {
                frameIndex++;
                currentTime = 0;
            }
        }
        if (frameIndex == sprite.frameNumber) {
            frameIndex = 0;
        }
        //update position acording to speed
        x += hspeed;
        y += vspeed;
        //Do behaviors
        /*for (Behavior behavior : behaviors) {
            behavior.update(this, elapsedTime);
        }*/

    }
    public override var onDraw=function (e:DrawEv,g:Graphics2D){
        if (sprite!=null){
            sprite.drawFrame(g,frameIndex,0,0);
        }
    }

    protected override function isMouseInside(mx:Number,my:Number):Boolean{
        //java.lang.System.out.println(sprite.width);
        //outRect.contains(mx, my);
        //Rectangle
        //java.lang.System.out.println("inside");
        //return ((mx >= x) and (mx <= x + width)) and ((my > y) and (my <= y + height));
        var w:Number = width;
        var h:Number = height;
        if (w < 0 or h < 0) {
            // At least one of the dimensions is negative...
            return false;
        }
        // Note: if either dimension is zero, tests below must return false...
        var xx = x;
        var yy = y;
        if (mx < xx or my < yy) {
            return false;
        }
        w += xx;
        h += yy;
        //    overflow || intersect
        
        return ((w < xx or w > mx) and (h < yy or h > my));
    }
}
