/*
 * Node.fx
 *
 * Created on 16/Dez/2008, 18:04:50
 */

package net.resplace.game.node;

import java.lang.Long;
import java.awt.Graphics2D;

/**
 * @author Porfirio
 */

public class Node {
    protected var parent:Node;
    function setParent(parent:Node){
        this.parent=parent;
    }
    public function getParent():Node{
        return parent;
    }
    public function create(){
    }
    public function update(elapsedTime:Long){
    }
    public function draw(g:Graphics2D){
    }
    public function destroy(){
        if (parent!=null){
            //TODO: parent remove
        }
    }
}
