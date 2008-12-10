/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game;

import net.resplace.game.nodes.Group;

/**
 *
 * @author porf
 */
public class ActorGroup extends Group<Actor> {

    public boolean colidesWith(Actor other) {
        for (Actor actor : this) {
            if (actor.colidesWith(other)) {
                return true;
            }
        }
        return false;
    }

    public boolean colidesWith(ActorGroup group) {
        for (int i = 0; i < group.size(); i++) {
            Actor actor = (Actor) group.get(i);
            if (colidesWith(actor)) {
                return true;
            }
        }
        return false;
    }
}
