/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game.nodes;

import java.awt.Graphics2D;
import java.util.ArrayList;

/**
 *
 * @author Porfirio
 */
public class Group<T extends Node> extends ArrayList<T> implements NodeGroup<T> {

    private NodeGroup parent;
    /**
     * {@inheritDoc}
     */
    public NodeGroup getParentNode() {
        return parent;
    }
    /**
     * {@inheritDoc}
     */
    public void init(NodeGroup parent) {
        this.parent=parent;
    }

    @Override
    public boolean add(T e) {
        e.init(this);
        return super.add(e);
    }

    /**
     * {@inheritDoc}
     */
    public void create() {
        for (Node node : this) {
            node.create();
        }
    }
    /**
     * {@inheritDoc}
     */
    public void update(long elapsedTime) {
        for (Node node : this) {
            node.update(elapsedTime);
        }
    }
    /**
     * {@inheritDoc}
     */
    public void draw(Graphics2D g) {
        for (Node node : this) {
            node.draw(g);
        }
    }
    /**
     * {@inheritDoc}
     */
    public boolean remove(T node) {
        return remove((Object) node);
    }
    /**
     * {@inheritDoc}
     */
    public void destroy() {
        getParentNode().remove(this);
    }

}
