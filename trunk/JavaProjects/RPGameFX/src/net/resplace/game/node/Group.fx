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

public class Group extends Node{
    public var nodes:Node[] on replace oldValue[idxA..idxB] = newElement {
        if (sizeof newElement > 0){
            for (node in newElement){
                if (node.parent!=null){
                    node.parent.remove(node);
                }
                node.inUse=true;
                node.parent=this;
            }
        }
        if (sizeof oldValue[idxA .. idxB] > 0){
            for (node in oldValue[idxA..idxB]){
                node.inUse=false;
                node.parent=null;
            }
        }
    };
    public def size:Integer=bind sizeof nodes;
    public def empty:Boolean=bind sizeof nodes == 0;
    public function add(node:Node){
        insert node into nodes;
    }
    public function remove(node:Node){
        delete node from nodes;
    }
    public function remove(i:Integer){
        delete nodes[i];
    }
    public function clear(){
        delete nodes;
    }
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
