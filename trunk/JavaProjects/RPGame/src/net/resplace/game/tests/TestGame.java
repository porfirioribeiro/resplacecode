/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game.tests;

import java.awt.BorderLayout;
import net.resplace.game.*;
import net.resplace.game.input.Input;
import net.resplace.game.nodes.AbstractNode;
import java.awt.Color;
import java.awt.Cursor;
import java.awt.Graphics2D;
import java.awt.Panel;
import java.awt.Rectangle;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.border.EtchedBorder;
import net.resplace.game.nodes.Node;
import net.resplace.game.nodes.NodeGroup;
import org.w3c.dom.NodeList;

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
                g.fillRect(0, 0, 500, 500);
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
                g.draw(getColisionRect());
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


