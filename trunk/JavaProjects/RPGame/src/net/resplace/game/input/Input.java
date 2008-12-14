/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game.input;

import net.resplace.game.*;
import java.awt.Component;
import java.awt.Point;
import java.awt.event.InputEvent;
import java.awt.event.KeyEvent;
import java.awt.event.KeyListener;
import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;
import java.awt.event.MouseMotionListener;
import java.awt.event.MouseWheelEvent;
import java.awt.event.MouseWheelListener;
import java.util.ArrayList;

/**
 *
 * @author Porfirio
 */
public class Input {

    // <editor-fold defaultstate="collapsed" desc="Instance Related">
    protected static Input instance;

    protected static Input getInstance() {
        if (instance == null) {
            instance = new Input();
        }
        return instance;
    }

    public static void register(GameEngine engine) {
        Input input = getInstance();
        input.engine=engine;

        register(engine.canvas);
    }
    public static void register(Component c){
        Input input = getInstance();
        input.component = c;

        c.setFocusTraversalKeysEnabled(false);
        c.addMouseListener(Input.mouse);
        c.addMouseMotionListener(Input.mouse);
        c.addMouseWheelListener(Input.mouse);

        c.addKeyListener(Input.key);
    }
    /**
     * Used to cleanup variables
     * Private use only!
     */
    public static void cleanup() {
        mouse.cleanup();
        key.cleanup();
        event=null;
    }
    // </editor-fold>
    protected Component component;
    protected GameEngine engine;
    public static final Mouse mouse = new Mouse();
    public static final Key key= new Key();
    private static InputEvent event;

    public static boolean isShiftDown(){
        return (event!=null && event.isShiftDown());
    }
    public static boolean isAltDown(){
        return (event!=null && event.isAltDown());
    }
    public static boolean isControlDown(){
        return (event!=null && event.isControlDown());
    }
    public static boolean isMetaDown(){
        return (event!=null && event.isMetaDown());
    }
    public static String getKeyText(int keyCode) {
        return KeyEvent.getKeyText(keyCode);
    }

    /**
     * Current keyboard String
     * This string increases as you type
     */
    public static String keyboardString="";

    public static boolean isKeyDown(int keyCode){
        return key.isKeyDown(keyCode);
    }

    public static class Mouse implements MouseListener, MouseMotionListener, MouseWheelListener {
        public Point point = new Point();
        public int x;
        public int y;
        public int xOnScreen = 0;
        public int yOnScreen = 0;
        public boolean in = false;
        public boolean dragging = false;
        /**
         * This object represents the state of the left mouse button
         */
        public final MouseButtonState left=new MouseButtonState();
        /**
         * This object represents the state of the middle mouse button
         */
        public final MouseButtonState mid=new MouseButtonState();
        /**
         * This object represents the state of the right mouse button
         */
        public final MouseButtonState right=new MouseButtonState();
         
        public int wheelRotation = 0;
        public int clickCount;

        @Override
        public synchronized void mouseClicked(MouseEvent e) {
            event=e;
            if (e.getButton() == MouseEvent.BUTTON1) {
                left.clicked=true;
            }
            clickCount=e.getClickCount();
        }

        @Override
        public synchronized void mousePressed(MouseEvent e) {
            event=e;
            if (e.getButton() == MouseEvent.BUTTON1) {
                left.pressed=true;
                left.down = true;
            }
            if (e.getButton() == MouseEvent.BUTTON2) {
                mid.pressed=true;
                mid.down = true;
            }
            if (e.getButton() == MouseEvent.BUTTON3) {
                right.pressed=true;
                right.down = true;
            }
        }

        @Override
        public synchronized void mouseReleased(MouseEvent e) {
            event=e;
            if (e.getButton() == MouseEvent.BUTTON1) {
                left.released=true;
                left.down = false;
            }
            if (e.getButton() == MouseEvent.BUTTON2) {
                mid.released=true;
                mid.down = false;
            }
            if (e.getButton() == MouseEvent.BUTTON3) {
                mid.released=true;
                right.down = false;
            }
        }

        @Override
        public synchronized void mouseEntered(MouseEvent e) {
            event=e;
            in = true;
        }

        @Override
        public synchronized void mouseExited(MouseEvent e) {
            event=e;
            in = false;
        }

        @Override
        public synchronized void mouseDragged(MouseEvent e) {
            event=e;
            dragging = true;
            mouseMoved(e);
        }

        @Override
        public synchronized void mouseMoved(MouseEvent e) {
            event=e;
            point = e.getPoint();
            x = e.getX();
            y = e.getY();
            xOnScreen = e.getXOnScreen();
            yOnScreen = e.getYOnScreen();
        }

        @Override
        public synchronized void mouseWheelMoved(MouseWheelEvent e) {
            event=e;
            wheelRotation = e.getWheelRotation();
        }

        private synchronized void cleanup() {
            event=null;
            wheelRotation = 0;
            dragging=false;
            clickCount=0;
            left.cleanup();
            mid.cleanup();
            right.cleanup();
        }
    }

    public static class Key implements KeyListener{
        ArrayList<Integer> keyList= new ArrayList<Integer>();

        public int pressed=0;
        public int released=0;

        @Override
        public synchronized void keyTyped(KeyEvent e) {
            event=e;
            Input.keyboardString+=e.getKeyChar();
            e.consume();
        }

        @Override
        public synchronized void keyPressed(KeyEvent e) {
            event=e;
            if (!keyList.contains(e.getKeyCode())){
                pressed=e.getKeyCode();
                keyList.add(e.getKeyCode());
            }
            e.consume();
        }

        @Override
        public synchronized void keyReleased(KeyEvent e) {
            event=e;
            released=e.getKeyCode();
            keyList.remove((Object)e.getKeyCode());
            e.consume();
        }

        public synchronized boolean isKeyDown(int keyCode){
            if (keyCode==InputKeys.VK_ANY){
                return keyList.size()>0;
            }
            if (keyCode==InputKeys.VK_NONE){
                return (keyList.size()==0);
            }
            return keyList.contains(keyCode);
        }
        

        private void cleanup() {
            pressed=0;
            released=0;
        }

    }
    public static class MouseButtonState{
        public boolean down=false;
        public boolean clicked=false;
        public boolean pressed=false;
        public boolean released=false;
        private void cleanup() {
            down=false;
            clicked=false;
            pressed=false;
            released=false;
        }
    }
}

