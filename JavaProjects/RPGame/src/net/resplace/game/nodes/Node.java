/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game.nodes;

import net.resplace.game.input.InputKeys;
import java.awt.Graphics2D;

/**
 *
 * @author Porfirio
 */
public interface Node extends InputKeys {

    /**
     * Initializes this Node and sets its parent
     * Called internal, call this function might break
     * @param parent
     */
    public void init(NodeGroup parent);
    /**
     * Get the parent Node of this node
     * @return
     */
    public NodeGroup getParentNode();

    /**
     * Called when the node is created
     * overide this for create event.
     */
    public void create();

    /**
     * Overide this and put you game logic that needs to be updated each step
     * @param elapsedTime
     */
    public void update(long elapsedTime);
    /**
     * Overide this and put your draw code here
     * @param g
     */
    public void draw(Graphics2D g);

    /**
     * Destroy this element by removing it from parent node
     */
    public void destroy();

}
