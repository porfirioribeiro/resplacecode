/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game.node;

/**
 *
 * @author Porfirio
 */
public interface SimpleGroup<T extends Node> extends Iterable<T>{

    /**
     * Add one node to this group
     * @param node
     * @return
     */
    public T add(T node);
    /**
     * Add an array of nodes
     * @param nodes
     * @return
     */
    public T[] add(T[] nodes);

    /**
     * Remove one node from this group
     * @param node
     */
    public void remove(T node);

    /**
     * Get a Node from the group
     * @param index
     * @return
     */
    public T get(int index);
    /**
     * Returns the number of nodes in this group
     * @return
     */
    public int size();

}
