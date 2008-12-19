/*
 * Point.fx
 *
 * Created on 18/Dez/2008, 14:19:00
 */

package net.resplace.game.shape;

/**
 * @author Porfirio
 */

public class Point extends java.awt.Point{
    public var x:Integer=0;
    public var y:Integer=0;
    public function setLocation(point:Point){
        x=point.x;
        y=point.y;
    }
}
