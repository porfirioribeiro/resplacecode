/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game.node;

/**
 *
 * @author Porfirio
 */
public interface NodeGroup<T extends Node> extends Node {

    /**
     * Add one node to this group
     * @param node
     * @return
     */
    public void addNode(T node);

    /**
     * Remove one node from this group
     * @param node
     */
    public void removeNode(T node);
}
