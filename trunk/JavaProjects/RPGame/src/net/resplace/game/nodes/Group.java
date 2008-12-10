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
    private ArrayList<Node> nodesToRemove=new ArrayList<Node>();
    /**
     * {@inheritDoc}
     */
    @Override
    public NodeGroup getParentNode() {
        return parent;
    }
    /**
     * {@inheritDoc}
     */
    @Override
    public void init(NodeGroup parent) {
        this.parent=parent;
    }

    @Override
    public boolean addNode(T e) {
        e.init(this);
        return super.add(e);
    }

    /**
     * {@inheritDoc}
     */
    @Override
    public void create() {
        for (Node node : this) {
            node.create();
        }
    }
    /**
     * {@inheritDoc}
     */
    @Override
    public void update(long elapsedTime) {
        for (Node node : this) {
            node.update(elapsedTime);
        }
        removeNodes();
    }
    /**
     * {@inheritDoc}
     */
    @Override
    public void draw(Graphics2D g) {
        for (Node node : this) {
            node.draw(g);
        }
        removeNodes();
    }
    /**
     * {@inheritDoc}
     */
    @Override
    public boolean removeNode(T node) {
        nodesToRemove.add(node);
        return true;
    }
    private void removeNodes(){
        if (!nodesToRemove.isEmpty()){
            this.removeAll(nodesToRemove);
            nodesToRemove.clear();
        }
    }
    /**
     * {@inheritDoc}
     */
    @Override
    public void destroy() {
        getParentNode().removeNode(this);
    }

}
