/*
 * NodeGroup.fx
 *
 * Created on 16/Dez/2008, 18:11:15
 */

package net.resplace.game.node;

/**
 * @author Porfirio
 */

public class NodeGroup {
    public var nodes:Node[];
    public var size:Integer=bind sizeof nodes;
    public var empty:Boolean=bind sizeof nodes==0;
    public function add(node:Node){
        insert node into nodes;
    }
    public function remove(node:Node){
        delete node from nodes;
    }
}
