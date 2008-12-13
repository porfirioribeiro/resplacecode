/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game.node;

import java.awt.Graphics2D;
import java.util.ArrayList;
import java.util.Iterator;

/**
 *
 * @author Porfirio
 */
public class Group<T extends Node> implements NodeGroup<T>{

    private ArrayList<T> nodes=new ArrayList<T>();
    private NodeGroup<Node> parent;
    private ArrayList<Node> nodesToRemove=new ArrayList<Node>();

    public Group() {
    }

    public Group(T[] arrayOfNodes) {
        add(arrayOfNodes);
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
    @SuppressWarnings("unchecked")
    public void init(NodeGroup<? extends Node> parent) {
        this.parent=(NodeGroup<Node>) parent;
    }

    @Override
    public T add(T e) {
        e.init(this);
        nodes.add(e);
        return e;
    }
    @Override
    public T[] add(T[] arrayOfNodes){
        for (T node : arrayOfNodes) {
            add(node);
        }
        return arrayOfNodes;
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
    public void remove(T node) {
        nodesToRemove.add(node);
    }
    private void removeNodes(){
        if (!nodesToRemove.isEmpty()){
            nodes.removeAll(nodesToRemove);
            nodesToRemove.clear();
        }
    }
    /**
     * {@inheritDoc}
     */
    @Override
    public void destroy() {
        getParentNode().remove(this);
    }
    /**
     * {@inheritDoc}
     */
    @Override
    public Iterator<T> iterator() {
        return nodes.iterator();
    }
    /**
     * {@inheritDoc}
     */
    @Override
    public T get(int index) {
        return nodes.get(index);
    }
    /**
     * {@inheritDoc}
     */
    @Override
    public int size() {
        return nodes.size();
    }

}
