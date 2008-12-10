/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game.nodes;

/**
 *
 * @author Porfirio
 */
public interface NodeGroup<T> extends Node {

    /**
     * Add one node to this group
     * @param node
     * @return
     */
    public boolean add(T node);
    /**
     * Remove one node from this group
     * @param node
     */
    public boolean remove(T node);
}
