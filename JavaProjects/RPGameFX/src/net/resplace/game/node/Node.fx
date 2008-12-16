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
    public-read var parent:NodeGroup;
    function setParent(parent:NodeGroup){
        this.parent=parent;
    }
    public function getParent():NodeGroup{
        return parent;
    }
    public function create(){
    }
    public function update(elapsedTime:Number){
    }
    public function draw(g:Graphics2D){
    }
    public function destroy(){
        if (parent!=null){
            parent.remove(this);
        }
    }
}
