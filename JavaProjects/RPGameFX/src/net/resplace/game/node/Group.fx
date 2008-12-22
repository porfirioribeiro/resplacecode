/*
 * Group.fx
 *
 * Created on 16/Dez/2008, 18:15:44
 */

package net.resplace.game.node;

import java.awt.Graphics2D;
import java.awt.event.MouseEvent;
import java.awt.event.MouseWheelEvent;
import java.awt.event.KeyEvent;

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
    package override function createNode(){
        for (node:Node in nodes){
            node.createNode();
        }
    }
    package override function updateNode(elapsedTime:Number){
        for (node:Node in nodes){
            node.updateNode(elapsedTime);
        }
    }
    package override function drawNode(g:Graphics2D){
        for (node:Node in nodes){
            node.drawNode(g);
        }
    }
    protected override function mouseClicked(e:MouseEvent){
        for (node:Node in nodes){
            node.mouseClicked(e);
        }
    }

    protected override function mousePressed(e:MouseEvent){
        for (node:Node in nodes){
            node.mousePressed(e);
        }
    }
    protected override function mouseReleased(e:MouseEvent){
        for (node:Node in nodes){
            node.mouseReleased(e);
        }
    }
    protected override function mouseEntered(e:MouseEvent){
        for (node:Node in nodes){
            node.mouseEntered(e);
        }
    }
    protected override function mouseExited(e:MouseEvent){
        for (node:Node in nodes){
            node.mouseExited(e);
        }
    }
    protected override function mouseMoved(e:MouseEvent){
        for (node:Node in nodes){
            node.mouseMoved(e);
        }
    }
    protected override function mouseDragged(e:MouseEvent){
        for (node:Node in nodes){
            node.mouseDragged(e);
        }
    }
    protected override function mouseWheelMoved(e:MouseWheelEvent){
        for (node:Node in nodes){
            node.mouseWheelMoved(e);
        }
    }
    protected override function keyTyped(e:KeyEvent){
        for (node:Node in nodes){
            node.keyTyped(e);
        }
    }
    protected override function keyPressed(e:KeyEvent){
        for (node:Node in nodes){
            node.keyPressed(e);
        }
    }
    protected override function keyReleased(e:KeyEvent){
        for (node:Node in nodes){
            node.keyReleased(e);
        }
    }
}
