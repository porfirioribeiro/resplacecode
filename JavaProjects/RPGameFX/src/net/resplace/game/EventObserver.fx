/*
 * EventObserver.fx
 *
 * Created on 22/Dez/2008, 16:46:56
 */

package net.resplace.game;

import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;
import java.awt.event.MouseMotionListener;
import java.awt.event.MouseWheelListener;
import java.awt.event.MouseWheelEvent;
import java.awt.event.KeyListener;
import java.awt.event.KeyEvent;
import java.util.ArrayList;

/**
 * @author Porfirio
 */

public class EventObserver extends MouseListener,MouseMotionListener,MouseWheelListener, KeyListener{
    public-read var mouseInside:Boolean=false;
    public-read var mouseWheelRotation:Number=0;
    var keysDown:ArrayList=new ArrayList();
    
    // <editor-fold defaultstate="collapsed" desc="MouseListener">
    protected override function mouseClicked(e:MouseEvent){
        mouseInside=isMouseInside(e);
        onGlobalMouseClicked(e.getButton());
        if (mouseInside){
            onMouseClicked(e.getButton());
        }
    }

    protected override function mousePressed(e:MouseEvent){
        mouseInside=isMouseInside(e);
        onGlobalMousePressed(e.getButton());
        if (mouseInside){
            onMousePressed(e.getButton());
        }
    }

    protected override function mouseReleased(e:MouseEvent){
        mouseInside=isMouseInside(e);
        onGlobalMouseReleased(e.getButton());
        if (mouseInside){
            onMouseReleased(e.getButton());
        }
    }

    protected override function mouseEntered(e:MouseEvent){
    }//Not needed
    protected override function mouseExited(e:MouseEvent){
    }//Not needed
    protected override function mouseMoved(e:MouseEvent){
        var wasMouseInside:Boolean=mouseInside;
        mouseInside=isMouseInside(e);
        onMouseMove(e.getX(),e.getY());
        if (mouseInside and not wasMouseInside){
            onMouseEnter();
        }else
        if (not mouseInside and wasMouseInside){
            onMouseLeave();
        }
    }

    protected override function mouseDragged(e:MouseEvent){
    }//Not used by now

    protected override function mouseWheelMoved(e:MouseWheelEvent){
        mouseInside=isMouseInside(e);
        mouseWheelRotation=e.getWheelRotation();
        if (mouseWheelRotation > 0){
            onGlobalMouseWheelUp();
            if (mouseInside){
                onMouseWheelUp();
            }
        } else
        if (mouseWheelRotation < 0){
            onGlobalMouseWheelDown();
            if (mouseInside){
                onMouseWheelDown();
            }
        }
    }
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="KeyListener">
    protected override function keyTyped(e:KeyEvent){
    }
    protected override function keyPressed(e:KeyEvent){

    }
    protected override function keyReleased(e:KeyEvent){
    }
    // </editor-fold>

    protected function isMouseInside(x:Number, y:Number):Boolean{
        return true;//Defaults to true
    };
    protected function isMouseInside(e:MouseEvent):Boolean{
        return isMouseInside(e.getX(),e.getY())
    };
    

    public var onMouseMove:function(x:Number, y:Number);
    public var onMouseEnter:function();
    public var onMouseLeave:function();
    public var onMousePressed:function(button:Integer);
    public var onMouseReleased:function(button:Integer);
    public var onMouseClicked:function(button:Integer);
    public var onMouseWheelUp:function();
    public var onMouseWheelDown:function();
    public var onGlobalMousePressed:function(button:Integer);
    public var onGlobalMouseReleased:function(button:Integer);
    public var onGlobalMouseClicked:function(button:Integer);
    public var onGlobalMouseWheelUp:function();
    public var onGlobalMouseWheelDown:function();
    public var evKeyDown:function(key:Number);
    public var evKeyPressed:function(key:Number);
    public var evKeyReleased:function(key:Number);
}
