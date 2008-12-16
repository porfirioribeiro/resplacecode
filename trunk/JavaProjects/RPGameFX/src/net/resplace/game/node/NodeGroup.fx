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
    public var size:Number=bind sizeof nodes;
    public function add(node:Node){
        insert node into nodes;
    }
    public function remove(node:Node){
        delete node from nodes;
    }
}
