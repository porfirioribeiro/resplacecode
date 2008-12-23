/*
 * Node.fx
 *
 * Created on 16/Dez/2008, 18:04:50
 */

package net.resplace.game.node;

import java.awt.Graphics2D;
import net.resplace.game.node.Group;
import net.resplace.game.shape.Point;
import java.awt.geom.AffineTransform;
import net.resplace.game.node.Event.*;
/**
 * @author Porfirio
 */

public class Node extends Event.Observer{
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
    public var onBeginUpdate:function (e:UpdateEv);
    public var onUpdate:function (e:UpdateEv);
    public var onEndUpdate:function (e:UpdateEv);
    package function updateNode(elapsedTime:Number){
        var e:UpdateEv=UpdateEv{
            node:this
            elapsedTime:elapsedTime
        }
        onBeginUpdate(e);
        if (not e.stoped){
            onUpdate(e);
            if (not e.stoped){
                onEndUpdate(e);
            }
        }
    }
    //draw
    public var onBeginDraw:function (e:DrawEv,g:Graphics2D);
    public var onDraw:function (e:DrawEv,g:Graphics2D);
    public var onEndDraw:function (e:DrawEv,g:Graphics2D);
    package function drawNode(g:Graphics2D){
        var e:DrawEv=DrawEv{
            node:this
            g:g
        }
        g.translate(x, y);
        onBeginDraw(e,g);
        if (not e.stoped){
            onDraw(e,g);
            if (not e.stoped){
                onEndDraw(e,g);
            }
        }
        e.restoreOriginal(true);
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
