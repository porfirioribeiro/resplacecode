/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game.actor;

import net.resplace.game.input.Input;

/**
 *
 * @author Porfirio
 */
public class Behaviores {

    public static final Behavior dnd = new AbstractBehavior() {

        int dragX = 0;
        int dragY = 0;
        boolean dragging = false;

        @Override
        public void update(Actor actor, long emalpsedTime) {
            if (Input.mouse.in) {
                if (dragging) {
                    actor.x = Input.mouse.x - dragX;
                    actor.y = Input.mouse.y - dragY;
                }

                if (actor.mouseIn() && Input.mouse.left.pressed) {
                    dragging = true;
                    dragX = Input.mouse.x - actor.x;
                    dragY = Input.mouse.y - actor.y;
                }
                if (Input.mouse.left.released) {
                    dragging = false;
                }
            } else {
                dragging = false;
            }
        }
    };
}
