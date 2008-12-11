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
import net.resplace.game.sprite.StripSprite;

/**
 *
 * @author Porfirio
 */
public class TestGame extends GameEngine {

    Sonic sonic1, sonic2;

    public TestGame() {
        setSize(400, 400);

        StripSprite sprite=new StripSprite(getClass().getResource("Actor1.png"), 32, 32);
        /*for (int xi=0;xi<12;xi++){
            for (int yi=0;yi<8;yi++){
                add(new Actor(sprite.getSprite(xi, yi), xi*32, yi*32));
            }
        }*/

        add(new Actor(sprite.getSprite(new int[][]{{0,0},{0,1},{0,2}}), 10, 10));



    }

    @Override
    public void update(long elapsedTime) {
        super.update(elapsedTime);
    }

    public static void main(String[] args) {
        GameRunner.runWindowed(new TestGame(), 400, 400, "TestGame");
    //GameRunner.runFullScreen(new TestGame(), 400, 400);
    }
}


