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
import net.resplace.game.Dir;
import net.resplace.game.node.Stage;
import net.resplace.game.node.Node;
import net.resplace.game.shape.Point;
import net.resplace.game.sprite.Sprite;
import net.resplace.game.sprite.StripSprite;
import net.resplace.game.actor.Actor;
import java.awt.Graphics2D;
import java.awt.Color;
import java.awt.Color.*;
import net.resplace.game.Input;
import java.awt.event.KeyEvent;
import java.awt.event.MouseEvent;
import java.util.EventObject;
import java.util.HashMap;
import net.resplace.game.node.Event.*;
import java.awt.Dimension;
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
    def game:FXMain=FXMain{}

    var size:Dimension=new Dimension(400,400);
    game.canvas.setSize(size);
    game.canvas.setMinimumSize(size);
    game.canvas.setPreferredSize(size);
    def frame:JFrame= new JFrame("GameFX!!!!");
    frame.setDefaultCloseOperation(WindowConstants.DO_NOTHING_ON_CLOSE);
    frame.addWindowListener(WindowClose{
        main:game
    });
    //frame.setSize(400, 400);
    
    frame.add(game.canvas);
    frame.pack();
    frame.setLocationRelativeTo(null);
    frame.setVisible(true);
    Input.register(game);
    game.start();
}

public class FXMain extends GameEngine{
    init{
        var map:FXHashMap=new FXHashMap();
    }

    var actors:StripSprite=StripSprite{
        image:Sprite.load("{__DIR__}Actor1.png")
        width:32
        height:32
        };
    var actorDown:Sprite=actors.getSprite([0,0,0,1,0,2,5]);;
    var actorLeft:Sprite=Sprite{
        frames: actors.getImage([[1,0],[1,1],[1,2]]);
        };
    
    var actor:Actor=Actor{
        var color:Color=GREEN;
        var dontDrawSprite=false;
        sprite: bind actorDown
        frameSpeed:5
        x:10
        y:200
        //speed:1
        direction:Dir.ENE
        onMouseEnter:function(e:MouseEv){
            color=RED;
            dontDrawSprite=true;
        }
        onMousePressed:function(e:MouseEv){
            if (e.leftButton){
                color=BLUE
            }
        }
        onMouseReleased:function(e:MouseEv){
            color=RED;
        }
        onMouseLeave:function(e:MouseEv){
            color=GREEN;
            dontDrawSprite=false;
        }
        onMouseMove:function(e:MouseEv){
            java.lang.System.out.println("Actor.onMouseMove: {e.x} - {e.y} - {(e.node as Actor).mouseInside}");
            e.stop();
        }
        onGlobalMouseMove:function(e:MouseEv){
            java.lang.System.out.println("Actor.Global.onMouseMove: {e.x} - {e.y} - {actor.mouseInside} - Gamewidth: {GameEngine.getWidth()}");
        }
        onBeginDraw:function(e:DrawEv, g:Graphics2D){
            e.restoreOriginal();
            g.setColor(color);
            g.fill(actor.outRect);
            e.restore();
            e.stoped=dontDrawSprite;
        }
    }
    public override function load():Void{
        java.lang.System.out.println(actor.sprite);
        stage.add(actor);
    }


    public override var stage=Stage{
        onMouseMove:function(e:MouseEv){
            java.lang.System.out.println("Stage.onMouseMove: {e.x} - {e.y}");
        }
        nodes:[
            Node{
                var width:Integer=100;
                var height:Integer=100;
                x:bind Input.mouseX-width/2;
                y:bind Input.mouseY-height/2;
                onUpdate:function(e:UpdateEv){
                    if (Input.mouseLeft.clicked){
                        //width-=10;
                        //height-=10;
                    }
                    width+=Input.mouseWheelRotation;
                    height+=Input.mouseWheelRotation;
                }
                onDraw:function(e:DrawEv,g:Graphics2D){
                    g.fillRect(0,0,width,height);
                    g.drawString("Mouse wheel to resize",10,-10);
                }
            },
            Node{
                x:10
                y:10
                onKeyPressed:function(e:KeyEv){
                    if (e.key==KeyEvent.VK_LEFT){
                        e.node.x--;
                    }
                    if (e.key==KeyEvent.VK_RIGHT){
                        e.node.x++;
                    }
                }
                onUpdate:function(e:UpdateEv){
                    //e.node.x++;
                }
                onDraw:function(e:DrawEv,g:Graphics2D){
                    e.restoreOriginal();
                    g.setColor(java.awt.Color.green);
                    g.fillRect(0,0,GameEngine.getWidth(),100);
                    e.restore();
                    g.setColor(BLUE);
                    g.fillRect(0,0,50,50);
                }
            }
        ]
    }
}

