/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game.input;

import net.resplace.game.*;
import java.awt.Component;
import java.awt.Point;
import java.awt.event.KeyEvent;
import java.awt.event.KeyListener;
import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;
import java.awt.event.MouseMotionListener;
import java.awt.event.MouseWheelEvent;
import java.awt.event.MouseWheelListener;
import java.util.ArrayList;
import java.util.HashMap;

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
        input.component = engine.canvas;

        engine.canvas.setFocusTraversalKeysEnabled(false);
        engine.canvas.addMouseListener(Input.mouse);
        engine.canvas.addMouseMotionListener(Input.mouse);
        engine.canvas.addMouseWheelListener(Input.mouse);

        engine.canvas.addKeyListener(Input.key);
    }
    /**
     * Used to cleanup variables
     * Private use only!
     */
    public static void cleanup() {
        mouse.cleanup();
        key.cleanup();
    }
    // </editor-fold>
    protected Component component;
    protected GameEngine engine;
    public static final Mouse mouse = new Mouse();
    public static final Key key= new Key();
    /**
     * Current keyboard String
     * This string increases as you type
     */
    public static String keyboardString="";

    public static boolean isKeyDown(int keyCode){
        return key.isKeyDown(keyCode);
    }

    public static class Mouse implements MouseListener, MouseMotionListener, MouseWheelListener {
        public MouseEvent event;//experimental
        public Point point = new Point();
        public int x;
        public int y;
        public int xOnScreen = 0;
        public int yOnScreen = 0;
        public boolean in = false;
        public boolean dragging = false;
        public boolean leftButtonDown = false;
        public boolean midButtonDown = false;
        public boolean rightButtonDown = false;
        public boolean leftClick = false;
        public int wheelRotation = 0;
        public int clickCount;

        public void mouseClicked(MouseEvent e) {
            event=e;
            if (e.getButton() == MouseEvent.BUTTON1) {
                leftClick=true;
            }
            clickCount=e.getClickCount();
        }

        public void mousePressed(MouseEvent e) {
            event=e;
            if (e.getButton() == MouseEvent.BUTTON1) {
                leftButtonDown = true;
            }
            if (e.getButton() == MouseEvent.BUTTON2) {
                midButtonDown = true;
            }
            if (e.getButton() == MouseEvent.BUTTON3) {
                rightButtonDown = true;
            }
        }

        public void mouseReleased(MouseEvent e) {
            event=e;
            if (e.getButton() == MouseEvent.BUTTON1) {
                leftButtonDown = false;
            }
            if (e.getButton() == MouseEvent.BUTTON2) {
                midButtonDown = false;
            }
            if (e.getButton() == MouseEvent.BUTTON3) {
                rightButtonDown = false;
            }
        }

        public void mouseEntered(MouseEvent e) {
            event=e;
            in = true;
        }

        public void mouseExited(MouseEvent e) {
            event=e;
            in = false;
        }

        public void mouseDragged(MouseEvent e) {
            event=e;
            dragging = true;
            mouseMoved(e);
        }

        public void mouseMoved(MouseEvent e) {
            event=e;
            point = e.getPoint();
            x = e.getX();
            y = e.getY();
            xOnScreen = e.getXOnScreen();
            yOnScreen = e.getYOnScreen();
        }

        public void mouseWheelMoved(MouseWheelEvent e) {
            event=e;
            wheelRotation = e.getWheelRotation();
        }

        private void cleanup() {
            event=null;
            wheelRotation = 0;
            dragging=false;
            leftClick=false;
            clickCount=0;
        }
    }

    public static class Key implements KeyListener{
        protected ArrayList<Integer> keys= new ArrayList<Integer>();

        public int pressed=0;
        public int released=0;

        public void keyTyped(KeyEvent e) {
            Input.keyboardString+=e.getKeyChar();
            e.consume();
        }

        public void keyPressed(KeyEvent e) {
            pressed=e.getKeyCode();
            if (!keys.contains(e.getKeyCode())){
                keys.add(e.getKeyCode());
            }
            e.consume();
        }

        public void keyReleased(KeyEvent e) {
            released=e.getKeyCode();
            keys.remove((Object)e.getKeyCode());
            e.consume();
        }

        public boolean isKeyDown(int keyCode){
            return keys.contains(keyCode);
        }

        private void cleanup() {
            pressed=0;
            released=0;
        }

    }
}
