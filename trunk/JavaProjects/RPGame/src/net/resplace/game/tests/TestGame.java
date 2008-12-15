/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game.tests;

import net.resplace.game.sprite.Sprite;
import net.resplace.game.actor.Actor;
import net.resplace.game.*;
import net.resplace.game.input.Input;
import net.resplace.game.actor.ActorGroup;
import net.resplace.game.actor.Behaviores;
import net.resplace.game.sprite.StripSprite;

/**
 *
 * @author Porfirio
 */
public class TestGame extends GameEngine {

    public TestGame() {
        setSize(400, 400);

        StripSprite sprite = new StripSprite(getClass().getResource("Actor1.png"), 32, 32);

        final Sprite actorLeft = sprite.getSprite(1, 0, 1, 1, 1, 2);
        final Sprite actorRight = sprite.getSprite(2, 0, 2, 1, 2, 2);
        final Sprite actorUp = sprite.getSprite(3, 0, 3, 1, 3, 2);
        final Sprite actorDown = sprite.getSprite(0, 0, 0, 1, 0, 2);


        class MyActor extends Actor {

            
            public MyActor(int x, int y) {
                super(actorDown, x, y);
                //setMotion(45, 2);
                motion.set(0, 1);
            }

            @Override
            public void create() {
                behaviors.add(new Behaviores.DnD());
                
            }

            @Override
            public void update(long elapsedTime) {
                super.update(elapsedTime);
                if (Input.mouse.left.pressed){
                    motion.setDirection(motion.getDirection()-5);
                    System.out.println(motion.getDirection()-5);
                }
                
                if (mouseIn() && Input.mouse.mid.pressed) {
                    System.out.println("in and press");
                    destroy();
                }
                if (Input.key.pressed==VK_LEFT) {
                    sprite = actorLeft;
                    frameSpeed=5;
                    hspeed=-1;
                    //x--;
                } else if (Input.key.pressed==VK_RIGHT) {
                    sprite = actorRight;
                    frameSpeed=5;
                    hspeed=1;
                } else if (Input.key.pressed==VK_UP) {
                    sprite = actorUp;
                    frameSpeed=5;
                    vspeed=-1;
                } else if (Input.key.pressed==VK_DOWN) {
                    sprite = actorDown;
                    frameSpeed=5;
                    vspeed=1;
                }
                if (Input.key.released!=0){
                    frameSpeed=0;
                    hspeed=0;
                    vspeed=0;
                    //frameIndex=0;
                }
            }
        }
        ActorGroup myActors = new ActorGroup(new Actor[]{
                    /*new MyActor(10, 10),
                    new MyActor(10, 50),
                    new MyActor(10, 90),*/
                    new MyActor(10, 130)
                });

        add(myActors);

    }

    public static void main(String[] args) {
        GameRunner.runWindowed(new TestGame(), 400, 400, "TestGame");
    //GameRunner.runFullScreen(new TestGame(), 400, 400);
    }
}


