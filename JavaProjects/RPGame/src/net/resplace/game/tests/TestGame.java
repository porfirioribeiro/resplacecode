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
import java.awt.Paint;
import java.awt.Rectangle;
import java.awt.Shape;
import java.awt.Stroke;
import net.resplace.game.actor.ActorGroup;
import net.resplace.game.actor.Behaviores;
import net.resplace.game.node.Node;
import net.resplace.game.sprite.StripSprite;

/**
 *
 * @author Porfirio
 */
public class TestGame extends GameEngine {

    public TestGame() {
        setSize(400, 400);

        StripSprite sprite = new StripSprite(getClass().getResource("Actor1.png"), 32, 32);
        /*for (int xi=0;xi<12;xi++){
        for (int yi=0;yi<8;yi++){
        add(new Actor(sprite.getSprite(xi, yi), xi*32, yi*32));
        }
        }*/
        final Sprite actorLeft = sprite.getSprite(1, 0, 1, 1, 1, 2);
        final Sprite actorRight = sprite.getSprite(2, 0, 2, 1, 2, 2);
        final Sprite actorUp = sprite.getSprite(3, 0, 3, 1, 3, 2);
        final Sprite actorDown = sprite.getSprite(0, 0, 0, 1, 0, 2);


        class MyActor extends Actor {

            public MyActor(int x, int y) {
                super(actorDown, x, y);
            }

            @Override
            public void create() {
                behaviors.add(Behaviores.dnd);
            }

            @Override
            public void update(long elapsedTime) {
                super.update(elapsedTime);
                if (mouseIn() && Input.mouse.mid.pressed) {
                    System.out.println("in and press");
                    destroy();
                }
                if (Input.isKeyDown(VK_LEFT)) {
                    sprite = actorLeft;
                    x--;
                } else if (Input.isKeyDown(VK_RIGHT)) {
                    sprite = actorRight;
                    x++;
                } else if (Input.isKeyDown(VK_UP)) {
                    sprite = actorUp;
                    y--;
                } else if (Input.isKeyDown(VK_DOWN)) {
                    sprite = actorDown;
                    y++;
                }
            }
        }
        ActorGroup myActors = new ActorGroup(new Actor[]{
                    new MyActor(10, 10),
                    new MyActor(10, 50),
                    new MyActor(10, 90),
                    new MyActor(10, 130)
                });

        add(myActors);

    }

    public static void main(String[] args) {
        GameRunner.runWindowed(new TestGame(), 400, 400, "TestGame");
    //GameRunner.runFullScreen(new TestGame(), 400, 400);
    }
}


