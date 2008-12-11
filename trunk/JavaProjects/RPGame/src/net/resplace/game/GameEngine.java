/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game;

import net.resplace.game.input.Input;
import net.resplace.game.input.InputKeys;
import net.resplace.game.node.Group;
import net.resplace.game.node.Node;
import java.awt.Canvas;
import java.awt.Color;
import java.awt.Cursor;
import java.awt.Graphics2D;
import java.awt.Toolkit;
import java.awt.image.BufferStrategy;

/**
 *
 * @author Porfirio
 */

public class GameEngine implements InputKeys{

    private boolean paused;
    private boolean running;
    private Group<Node> nodes=new Group<Node>();
    public Canvas canvas;
    public Color backgroundColor=Color.WHITE;
    
    public GameEngine() {
        canvas=new Canvas();
        Input.register(this);
        gameLoop();
    }

    public void add(Node node){
        nodes.add(node);
        node.init(nodes);
        node.create();
    }

    public boolean isPaused() {
        return paused;
    }

    public void setPaused(boolean paused) {
        this.paused = paused;
    }

    public boolean isRunning() {
        return running;
    }

    public void start(){
        canvas.createBufferStrategy(2);
        paused=false;
        running=true;
        new Thread("Game Thread"){

            @Override
            public void run() {
                gameLoop();
            }
        }.start();
    }

    public boolean exit(){
        running=false;
        return true;
    }

    protected void gameLoop() {
        long currTime = System.nanoTime();
        long currTimeMS = System.currentTimeMillis();
        while (running && !paused) {
            long elapsedTime = System.nanoTime() - currTime;
            currTime += elapsedTime;

            long elapsedTimeMS= System.currentTimeMillis() - currTimeMS;
            currTimeMS+=elapsedTimeMS;
            // update the sprites
            update(elapsedTime/1000000);

            // draw the screen
            BufferStrategy strategy = canvas.getBufferStrategy();
            Graphics2D g = (Graphics2D) strategy.getDrawGraphics();
            g.clearRect(0, 0, canvas.getWidth(), canvas.getHeight());
            draw(g);
            g.dispose();
            if (!strategy.contentsLost()) {
                strategy.show();
            }

        // Sync the display on some systems.
        // (on Linux, this fixes event queue problems)
        Toolkit.getDefaultToolkit().sync();

            Input.cleanup();
            // take a nap
            try {
                Thread.sleep(20);
            } catch (InterruptedException ex) {
            }
        }
    }
    public void update(long elapsedTime){
        nodes.update(elapsedTime);
        /*for (Node node : nodes) {
            node.update(elapsedTime);
        }*/
    }

    public void draw(Graphics2D g){
        g.setColor(backgroundColor);
        g.fillRect(0, 0, canvas.getWidth(), canvas.getHeight());
        g.setColor(Color.black);
        nodes.draw(g);
        /*for (Node node : nodes) {
            node.draw(g);
        }*/
    }

    public Cursor getCursor() {
        return canvas.getCursor();
    }

    public void setCursor(Cursor cursor) {
        canvas.setCursor(cursor);
    }

    public void setSize(int width, int height){
        canvas.setSize(width, height);
    }
}
