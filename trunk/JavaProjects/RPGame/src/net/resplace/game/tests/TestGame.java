/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game.tests;

import net.resplace.game.sprite.Sprite;
import net.resplace.game.actor.Actor;
import net.resplace.game.*;
import net.resplace.game.input.Input;
import net.resplace.game.node.AbstractNode;
import java.awt.Color;
import java.awt.Graphics2D;
import javax.swing.ImageIcon;

/**
 *
 * @author Porfirio
 */
public class TestGame extends GameEngine {

    public TestGame() {
        setSize(400, 400);

        final Sprite sonicSprite= new Sprite(new ImageIcon(getClass().getResource("/net/resplace/game/sonic.png")).getImage());
        sonicSprite.setBBox(10,30,10,5);
        
        add(new AbstractNode() {

            @Override
            public void draw(Graphics2D g) {
                //g.fillRect(0, 0, 500, 500);
            }

        });

        class Sonic extends Actor{

            public Sonic(int width, int height) {
                super(sonicSprite, width, height);
            }

            @Override
            public void update(long elapsedTime) {
                super.update(elapsedTime);
                if (Input.isKeyDown(VK_LEFT)) {
                    x--;
                }
                if (Input.isKeyDown(VK_RIGHT)) {
                    x++;
                }
                if (Input.isKeyDown(VK_UP)) {
                    y--;
                }
                if (Input.isKeyDown(VK_DOWN)) {
                    y++;
                }
                if (getOutRect().contains(Input.mouse.point) && Input.mouse.leftButtonDown){
                    destroy();
                }

            }

            @Override
            public void draw(Graphics2D g) {
                super.draw(g);
                g.setColor(Color.red);
                if (getColisionRect().contains(Input.mouse.point)){
                    g.fill(getColisionRect());
                }else{
                    g.draw(getColisionRect());
                }
                
            }

        }
        add(new Sonic(10, 10));
        add(new Sonic(110, 10));
    }

    public static void main(String[] args) {
        GameRunner.runWindowed(new TestGame(), 400, 400, "TestGame");
    //GameRunner.runFullScreen(new TestGame(), 400, 400);
    }
}


