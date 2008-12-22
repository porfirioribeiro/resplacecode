/*
 * Node.fx
 *
 * Created on 16/Dez/2008, 18:04:50
 */

package net.resplace.game.node;

import java.awt.Graphics2D;
import net.resplace.game.node.Group;
import net.resplace.game.shape.Point;
import net.resplace.game.EventObserver;
/**
 * @author Porfirio
 */

public class Node extends EventObserver{
    package public-read var parent:Group;
    package public-read var inUse=false;
    
    public var x:Number=0;
    public var y:Number=0;
    //create
    public var onCreate:function(node:Node);
    package function createNode(){
        onCreate(this);
    }
    //update
    public var onBeginUpdate:function (node:Node,elapsedTime:Number);
    public var onUpdate:function (node:Node,elapsedTime:Number);
    public var onEndUpdate:function (node:Node,elapsedTime:Number);
    package function updateNode(elapsedTime:Number){
        onBeginUpdate(this,elapsedTime);
        onUpdate(this,elapsedTime);
        onEndUpdate(this,elapsedTime);
    }
    //draw
    public var onBeginDraw:function (node:Node,g:Graphics2D);
    public var onDraw:function (node:Node,g:Graphics2D);
    public var onEndDraw:function (node:Node,g:Graphics2D);
    package function drawNode(g:Graphics2D){
        g.translate(x, y);
        onBeginDraw(this,g);
        onDraw(this,g);
        onEndDraw(this,g);
        g.translate(-x, -y);
    }
    //destroy
    public var onDestroy:function(node:Node);
    public function destroy(){
        if (parent != null){
            parent.remove(this);
            onDestroy(this);
        }
    }
}
