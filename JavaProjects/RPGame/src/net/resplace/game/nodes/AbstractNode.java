/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game.nodes;

import java.awt.Graphics2D;

/**
 *
 * @author Porfirio
 */
public abstract class AbstractNode implements Node {

    private NodeGroup parent;

    /**
     * {@inheritDoc}
     */
    public void init(NodeGroup parent) {
        this.parent = parent;
    }

    /**
     * {@inheritDoc}
     */
    public NodeGroup getParentNode() {
        return parent;
    }

    /**
     * {@inheritDoc}
     */
    public void create() {
    }

    /**
     * {@inheritDoc}
     */
    public void update(long elapsedTime) {
    }

    /**
     * {@inheritDoc}
     */
    public void draw(Graphics2D g) {
    }

    /**
     * {@inheritDoc}
     */
    public void destroy() {
        getParentNode().removeNode(this);
    }
}
