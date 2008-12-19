/*
 * FXMain.fx
 *
 * Created on 16/Dez/2008, 15:00:53
 */

package fxtest;

import fxtest.FXMain;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;
import java.lang.*;
import javax.swing.JFrame;
import javax.swing.WindowConstants;
import net.resplace.game.GameEngine;
import net.resplace.game.node.Stage;
import net.resplace.game.node.Node;
import net.resplace.game.shape.Point;
import net.resplace.game.sprite.Sprite;
import net.resplace.game.sprite.StripSprite;
import java.awt.Graphics2D;
import net.resplace.game.Input;
/**
 * @author Porfirio
 */
class WindowClose extends WindowAdapter{
    public-init var main:FXMain;
    public override function windowClosing(e:WindowEvent){
        main.exit();
        System.exit(0);
    }
}


function main(args:String[]){
    var seq:Integer[]=[1,5,6];
    java.lang.System.out.println(Input.sequenceContains(seq,2));

    def game:FXMain=FXMain{}
    game.canvas.setSize(400, 400);
    def frame:JFrame= new JFrame("GameFX!!!!");
    frame.setDefaultCloseOperation(WindowConstants.DO_NOTHING_ON_CLOSE);
    frame.addWindowListener(WindowClose{
        main:game
    });
    frame.setSize(400, 400);
    frame.setLocationRelativeTo(null);
    frame.add(game.canvas);
    frame.setVisible(true);
    Input.register(game);
    game.start();
}

public class FXMain extends GameEngine{
    var actors:StripSprite;
    var actorDown:Sprite;
    var actorLeft:Sprite;
    public override function load():Void{
        actors=StripSprite{
            image:Sprite.load("{__DIR__}Actor1.png")
            width:32
            height:32
        }
        actorDown=actors.getSprite([0,0,0,1,0,2,5]);
        actorLeft=Sprite{
            frames: actors.getImage([[1,0],[1,1],[1,2]]);
        }
    }
    public override var stage=Stage{
        nodes:[
            Node{
                var width:Integer=100;
                var height:Integer=100;
                x:bind Input.mouseX-width/2;
                y:bind Input.mouseY-height/2;
                onUpdate:function(self:Node,elapsedTime:Number){
                    if (Input.mouseLeft.clicked){
                        //width-=10;
                        //height-=10;
                    }
                    width+=Input.mouseWheelRotation;
                    height+=Input.mouseWheelRotation;
                }
                onDraw:function(self:Node,g:Graphics2D){
                    g.fillRect(0,0,width,height);
                    g.drawString("Hello",10,-10);
                }
            }

        ]

    }
}
