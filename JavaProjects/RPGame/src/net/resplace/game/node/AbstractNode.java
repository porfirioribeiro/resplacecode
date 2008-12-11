/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game.node;

import java.awt.Graphics2D;

/**
 *
 * @author Porfirio
 */
public abstract class AbstractNode implements Node {

    private NodeGroup<Node> parent;

    /**
     * {@inheritDoc}
     */
    @Override
    public void init(NodeGroup<? extends Node> parent) {
        this.parent = (NodeGroup<Node>) parent;
    }

    /**
     * {@inheritDoc}
     */
    @Override
    public NodeGroup<Node> getParentNode() {
        return parent;
    }

    /**
     * {@inheritDoc}
     */
    @Override
    public void create() {
    }

    /**
     * {@inheritDoc}
     */
    @Override
    public void update(long elapsedTime) {
    }

    /**
     * {@inheritDoc}
     */
    @Override
    public void draw(Graphics2D g) {
    }

    /**
     * {@inheritDoc}
     */
    @Override
    public void destroy() {
        getParentNode().removeNode(this);
    }
}
