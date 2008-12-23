/*
 * Event.fx
 *
 * Created on 22/Dez/2008, 16:46:56
 */

package net.resplace.game.node;

import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;
import java.awt.event.MouseMotionListener;
import java.awt.event.MouseWheelListener;
import java.awt.event.MouseWheelEvent;
import java.awt.event.KeyListener;
import java.awt.event.KeyEvent;
import java.util.ArrayList;
import net.resplace.game.node.Node;
import net.resplace.game.DrawState;
import java.awt.event.InputEvent;
import java.lang.Character;
import java.awt.Graphics2D;
import java.awt.geom.AffineTransform;
import java.awt.Paint;
import java.awt.Stroke;
import java.awt.Color;
import java.awt.Font;
import java.awt.Composite;
import java.awt.Shape;
import java.awt.RenderingHints;

/**
 * @author Porfirio
 */
public class NodeEv{
    public-init var node:Node;
    public var stoped:Boolean=false;
    public function stop(){
        stoped=true;
    }
    public override function toString():String{
        return "{getClass().getName()}[node={node}, type={node.getClass().getName()}]"
    }
}

public class InputEv extends NodeEv{
    public-read var altDown:Boolean;
    public-read var altGraphDown:Boolean;
    public-read var controlDown:Boolean;
    public-read var metaDown:Boolean;
    public-read var shiftDown:Boolean;
}
public class MouseEv extends InputEv{
    public-read var x:Number=0;
    public-read var y:Number=0;
    public-read var inside:Boolean=false;
    public-read var button:Number;
    public-read var leftButton:Boolean=false;
    public-read var middleButton:Boolean=false;
    public-read var rightButton:Boolean=false;
}

public class KeyEv extends InputEv{
    public-read var key:Number;
    public-read var keyChar:String;
}

function translateInputEvent(ev:InputEv,e:InputEvent):InputEv{
    ev.altDown=e.isAltDown();
    ev.altGraphDown=e.isAltGraphDown();
    ev.controlDown=e.isControlDown();
    ev.metaDown=e.isMetaDown();
    ev.shiftDown=e.isShiftDown();
    return ev;
}
function translateMouseEvent(src:Observer,e:MouseEvent):MouseEv{
    return translateInputEvent(MouseEv{
        node:src as Node
        x:e.getX()
        y:e.getY()
        inside:src.mouseInside
        button:e.getButton()
        leftButton:e.getButton()==e.BUTTON1
        middleButton:e.getButton()==e.BUTTON2
        rightButton:e.getButton()==e.BUTTON3
    },e) as MouseEv;
}

function translateKeyEvent(src:Observer,e:KeyEvent):KeyEv{
    return translateInputEvent(KeyEv{
        node: src as Node
        key: e.getKeyCode()
        keyChar: Character.toString(e.getKeyChar())
    },e) as KeyEv;
}

public class Observer extends MouseListener,MouseMotionListener,MouseWheelListener, KeyListener{
    public-read var mouseInside:Boolean=false;
    public-read var mouseWheelRotation:Number=0;
    var keysDown:ArrayList=new ArrayList();
   
    // <editor-fold defaultstate="collapsed" desc="MouseListener">
    protected override function mouseClicked(e:MouseEvent){
        mouseInside=isMouseInside(e);
        var ev:MouseEv=translateMouseEvent(this,e);
        if (mouseInside){
            onMouseClicked(ev);
        }
        if (not ev.stoped){
            onGlobalMouseClicked(ev);
        }
    }

    protected override function mousePressed(e:MouseEvent){
        mouseInside=isMouseInside(e);
        var ev:MouseEv=translateMouseEvent(this,e);
        if (mouseInside){
            onMousePressed(ev);
        }
        if (not ev.stoped){
            onGlobalMousePressed(ev);
        }
    }

    protected override function mouseReleased(e:MouseEvent){
        mouseInside=isMouseInside(e);
        var ev:MouseEv=translateMouseEvent(this,e);
        if (mouseInside){
            onMouseReleased(ev);
        }
        if (not ev.stoped){
            onGlobalMouseReleased(ev);
        }
    }

    protected override function mouseEntered(e:MouseEvent){
    }//Not needed
    protected override function mouseExited(e:MouseEvent){
    }//Not needed
    protected override function mouseMoved(e:MouseEvent){
        var wasMouseInside:Boolean=mouseInside;
        mouseInside=isMouseInside(e);
        var ev:MouseEv=translateMouseEvent(this,e);
        if (mouseInside){
            onMouseMove(ev);
        }
        if (not ev.stoped){
            onGlobalMouseMove(ev);
        }
        if (mouseInside and not wasMouseInside){
            onMouseEnter(ev);
        }else if (not mouseInside and wasMouseInside){
            onMouseLeave(ev);
        }
    }

    protected override function mouseDragged(e:MouseEvent){
    }//Not used by now

    protected override function mouseWheelMoved(e:MouseWheelEvent){
        mouseInside=isMouseInside(e);
        var ev:MouseEv=translateMouseEvent(this,e);
        mouseWheelRotation=e.getWheelRotation();
        if (mouseWheelRotation > 0){
            if (mouseInside){
                onMouseWheelUp(ev);
            }
            if (not ev.stoped){
                onGlobalMouseWheelUp(ev);
            }
        } else if (mouseWheelRotation < 0){
            if (mouseInside){
                onMouseWheelDown(ev);
            }
            if (not ev.stoped){
                onGlobalMouseWheelDown(ev);
            }
        }
    }
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="KeyListener">
    protected override function keyTyped(e:KeyEvent){
    }
    protected override function keyPressed(e:KeyEvent){
        var ev:KeyEv=translateKeyEvent(this, e);
        onKeyPressed(ev);
    }
    protected override function keyReleased(e:KeyEvent){
        var ev:KeyEv=translateKeyEvent(this, e);
        onKeyReleased(ev);
    }
    // </editor-fold>

    protected function isMouseInside(x:Number, y:Number):Boolean{
        return true;//Defaults to true, override it
    };
    protected function isMouseInside(e:MouseEvent):Boolean{
        return isMouseInside(e.getX(),e.getY())
    };
    

    public var onMouseMove:function(e:MouseEv);
    public var onMouseEnter:function(e:MouseEv);
    public var onMouseLeave:function(e:MouseEv);
    public var onMousePressed:function(e:MouseEv);
    public var onMouseReleased:function(e:MouseEv);
    public var onMouseClicked:function(e:MouseEv);
    public var onMouseWheelUp:function(e:MouseEv);
    public var onMouseWheelDown:function(e:MouseEv);
    public var onGlobalMouseMove:function(e:MouseEv);
    public var onGlobalMousePressed:function(e:MouseEv);
    public var onGlobalMouseReleased:function(e:MouseEv);
    public var onGlobalMouseClicked:function(e:MouseEv);
    public var onGlobalMouseWheelUp:function(e:MouseEv);
    public var onGlobalMouseWheelDown:function(e:MouseEv);
    public var onKeyDown:function(e:KeyEv);
    public var onKeyPressed:function(e:KeyEv);
    public var onKeyReleased:function(e:KeyEv);
}

public class UpdateEv extends NodeEv{
    public-init var elapsedTime:Number;
}

public class DrawEv extends NodeEv{
    public-init var g:Graphics2D;
    protected var initialState:DrawState;
    protected var states:DrawState[];
    init{
        initialState=DrawState.fromGraphics2D(g);
    }
    public function saveState():DrawState{
        return DrawState.fromGraphics2D(g);
    }
    public function restoreState(state:DrawState){
        state.apply(g);
    }
    public function save(){
        insert saveState() into states;
    }
    public function restore(){
        var state:DrawState=states[sizeof states-1];
        restoreState(state);
        delete state from states;
    }
    public function restoreOriginal(noSave:Boolean){
        if (not noSave){
            save();
        }
        initialState.apply(g);
    }
    public function restoreOriginal(){
        restoreOriginal(false);
    }
}