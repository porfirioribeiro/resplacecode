/*
 * Group.fx
 *
 * Created on 16/Dez/2008, 18:15:44
 */

package net.resplace.game.node;

import java.awt.Graphics2D;

/**
 * @author Porfirio
 */

public class Group extends Node, NodeGroup{
    public override function create(){
        for (node:Node in nodes){
            node.create();
        }
    }
    public override function update(elapsedTime:Number){
        for (node:Node in nodes){
            node.update(elapsedTime);
        }
    }
    public override function draw(g:Graphics2D){
        for (node:Node in nodes){
            node.draw(g);
        }
    }
}
