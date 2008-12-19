/*
 * Input.fx
 *
 * Created on 18/Dez/2008, 14:21:05
 */

package net.resplace.game;

import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;
import java.awt.event.MouseMotionListener;
import java.awt.event.MouseWheelEvent;
import java.awt.event.MouseWheelListener;
import java.awt.event.KeyEvent;
import java.awt.event.KeyListener;
import java.awt.Component;
import net.resplace.game.shape.Point;


    /**
     * @author Porfirio
     */
    // <editor-fold defaultstate="collapsed" desc="Instance">
    public-read var instance:Input=Input{};

    protected var component:Component;
    protected var engine:GameEngine;
    public function register(engine:GameEngine) {
        instance.engine=engine;
        register(engine.canvas);
    }
    public function register(c:Component){
        instance.component = c;
        c.setFocusTraversalKeysEnabled(false);
        c.addMouseListener(Input.instance);
        c.addMouseMotionListener(Input.instance);
        c.addMouseWheelListener(Input.instance);
        //c.addKeyListener(Input.instance);

    }
    public function cleanup(){
        mouseEvent=null;
        mouseWheelRotation = 0;
        mouseDragging=false;
        mouseClickCount=0;
        mouseLeft.cleanup();
        mouseMid.cleanup();
        mouseRight.cleanup();
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Mouse variables">
    public-read var mouseX:Integer=0;
    public-read var mouseXOnScreen:Integer=0;
    public-read var mouseY:Integer=0;
    public-read var mouseYOnScreen:Integer=0;
    public-read var mouseLocation:Point=Point{};
    public-read var mouseEvent:MouseEvent;
    public-read var mouseWheelRotation:Integer=0;
    public-read var mouseInsideCanvas:Boolean=false;
    public-read var mouseDragging:Boolean=false;
    public-read var mouseClickCount:Integer=0;
    public-read var mouseLeft:MouseButtonState=MouseButtonState{};
    public-read var mouseMid:MouseButtonState=MouseButtonState{};
    public-read var mouseRight:MouseButtonState=MouseButtonState{};
// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Key variables">
    public-read var keyEvent:KeyEvent;
    public-read var keyDownList:Integer[];
    public-read var keyPressed:Integer=0;
    public-read var keyReleased:Integer=0;
    public-read var keyboardString:String="";

// </editor-fold>
public class Input extends MouseListener, MouseMotionListener, MouseWheelListener, KeyListener{
    // <editor-fold defaultstate="collapsed" desc="Mouse events">
    public override function mouseClicked(e:MouseEvent) {
        mouseEvent=e;
        if (e.getButton() == MouseEvent.BUTTON1) {
            mouseLeft.clicked=true;
        }
        mouseClickCount=e.getClickCount();
    }

        
    public override function mousePressed(e:MouseEvent) {
        mouseEvent=e;
        if (e.getButton() == MouseEvent.BUTTON1) {
            mouseLeft.pressed=true;
            mouseLeft.down = true;
        }
        if (e.getButton() == MouseEvent.BUTTON2) {
            mouseMid.pressed=true;
            mouseMid.down = true;
        }
        if (e.getButton() == MouseEvent.BUTTON3) {
            mouseRight.pressed=true;
            mouseRight.down = true;
        }
    }

        
    public override function mouseReleased(e:MouseEvent) {
        mouseEvent=e;
        mouseDragging=false;
        if (e.getButton() == MouseEvent.BUTTON1) {
            mouseLeft.released=true;
            mouseLeft.down = false;
        }
        if (e.getButton() == MouseEvent.BUTTON2) {
            mouseMid.released=true;
            mouseMid.down = false;
        }
        if (e.getButton() == MouseEvent.BUTTON3) {
            mouseMid.released=true;
            mouseRight.down = false;
        }
    }

        
    public override function mouseEntered(e:MouseEvent) {
        mouseEvent=e;
        mouseInsideCanvas = true;
    }

        
    public override function mouseExited(e:MouseEvent) {
        mouseEvent=e;
        mouseInsideCanvas = false;
    }

        
    public override function mouseDragged(e:MouseEvent) {
        mouseEvent=e;
        mouseDragging = true;
        mouseMoved(e);
    }

        
    public override function mouseMoved(e:MouseEvent) {
        mouseEvent=e;
        mouseLocation.setLocation(e.getPoint());
        mouseX = e.getX();
        mouseY = e.getY();
        mouseXOnScreen = e.getXOnScreen();
        mouseYOnScreen = e.getYOnScreen();
    }

        
    public override function mouseWheelMoved(e:MouseWheelEvent) {
        mouseEvent=e;
        mouseWheelRotation = e.getWheelRotation();
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Key events">
        
        public override function keyTyped(e:KeyEvent) {
            keyEvent=e;
            keyboardString+=e.getKeyChar();
            e.consume();
        }

        
        public override function keyPressed(e:KeyEvent) {
            keyEvent=e;
            /*if (!keyDownList.contains(e.getKeyCode())){
                keyPressed=e.getKeyCode();
                keyDownList.add(e.getKeyCode());
            }*/
            e.consume();
        }

        
        public override function keyReleased(e:KeyEvent) {
            keyEvent=e;
            Input.keyReleased=e.getKeyCode();
            delete e.getKeyCode() from keyDownList;
            e.consume();
        }


        public function isKeyDown(keyCode:Integer):Boolean{
            /*if (keyCode==InputKeys.VK_ANY){
                return keyDownList.size()>0;
            }
            if (keyCode==InputKeys.VK_NONE){
                return (keyDownList.size()==0);
            }
            return keyDownList.contains(keyCode);*/
            return false;
        }
    // </editor-fold>
}

    // <editor-fold defaultstate="collapsed" desc="Helpers">
    public function sequenceContains(seq:Object[],value:Object):Boolean{//TODO: Remove public!
        for (item in seq){
            if (item.equals(value)){
                return true;
            }
        }
        return false;
    }
    public class MouseButtonState{
        public-read var down:Boolean=false;
        public-read var clicked:Boolean=false;
        public-read var pressed:Boolean=false;
        public-read var released:Boolean=false;
        function cleanup() {
            down=false;
            clicked=false;
            pressed=false;
            released=false;
        }
    }
// </editor-fold>