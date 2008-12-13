/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package net.resplace.game.actor;

import java.awt.Graphics2D;

/**
 *
 * @author Porfirio
 */
public interface Behavior {
    public void create(Actor actor);
    public void update(Actor actor,long emalpsedTime);
    public void draw(Actor actor,Graphics2D g);
}
