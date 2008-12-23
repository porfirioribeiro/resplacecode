/*
 * Stage.fx
 *
 * Created on 18/Dez/2008, 12:01:10
 */

package net.resplace.game.node;

import java.awt.Graphics2D;

/**
 * @author Porfirio
 */
public class Stage extends Group{
    //Make this functions public on Stage
    public override function createNode(){
        Group.createNode();
    }
    public override function updateNode(elapsedTime:Number){
        Group.updateNode(elapsedTime);
    }
    public override function drawNode(g:Graphics2D){
        Group.drawNode(g);
    }
}
