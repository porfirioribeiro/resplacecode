/*
 * GameEngine.fx
 *
 * Created on 18/Dez/2008, 11:42:34
 */

package net.resplace.game;

import java.awt.Canvas;
import java.awt.Graphics2D;
import java.awt.image.BufferStrategy;
import java.awt.Toolkit;
import java.lang.*;
import javafx.animation.KeyFrame;
import javafx.animation.Timeline;
import net.resplace.game.node.Stage;
import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;
import java.awt.event.MouseMotionListener;
import java.awt.event.MouseWheelListener;
import java.awt.event.MouseWheelEvent;
import java.awt.event.KeyListener;
import java.awt.event.KeyEvent;
/**
 * @author Porfirio
 */
public var current:GameEngine;
public function getWidth():Integer{
    if (current!=null and current.canvas!=null){
        return current.canvas.getWidth();
    }
    return 0;
}

//current.canvas.getWidth();

public abstract class GameEngine{
    protected var canvas:Canvas;
    protected var input:InputHandler;
    protected var time:Number=System.nanoTime();
    protected var timeLine:Timeline=Timeline {
        repeatCount: Timeline.INDEFINITE
        keyFrames: [
            KeyFrame {
                time: 1s / 30
                action: function() {
                    var oldTime:Number=time;
                    time=System.nanoTime();
                    var elapsedTime:Number=time - oldTime;
                    stage.updateNode(elapsedTime / 1000000);

                    var strategy:BufferStrategy = canvas.getBufferStrategy();
                    var g:Graphics2D =strategy.getDrawGraphics() as Graphics2D;
                    g.clearRect(0, 0, canvas.getWidth(), canvas.getHeight());
                    stage.drawNode(g);
                    g.dispose();
                    
                    if (not strategy.contentsLost()) {
                        strategy.show();
                    }

                    // Sync the display on some systems.
                    // (on Linux, this fixes event queue problems)
                    Toolkit.getDefaultToolkit().sync();

                    Input.cleanup();


                }
            }
        ]
    };
    public var stage:Stage;
    
    init{
        current=this;
        canvas=new Canvas();
        input=InputHandler{engine:this}
    }

    public function start(){
        canvas.createBufferStrategy(2);
        load();
        timeLine.playFromStart();
        canvas.addMouseListener(input);
        canvas.addMouseMotionListener(input);
        canvas.addMouseWheelListener(input);
        canvas.addKeyListener(input);
    }
    public abstract function load():Void;
    public function exit(){
        timeLine.stop();
    }
}
public class InputHandler extends MouseListener,MouseMotionListener,MouseWheelListener, KeyListener{
    public-init var engine:GameEngine;
//    protected override function mouseClicked(e:MouseEvent){}
//    protected override function mousePressed(e:MouseEvent){}
//    protected override function mouseReleased(e:MouseEvent){}
//    protected override function mouseEntered(e:MouseEvent){}
//    protected override function mouseExited(e:MouseEvent){}
//    protected override function mouseMoved(e:MouseEvent){}
//    protected override function mouseDragged(e:MouseEvent){}
//    protected override function mouseWheelMoved(e:MouseWheelEvent){}
//    protected override function keyTyped(e:KeyEvent){}
//    protected override function keyPressed(e:KeyEvent){}
//    protected override function keyReleased(e:KeyEvent){}
    protected override function mouseClicked(e:MouseEvent){
        if (engine.stage!=null){
            engine.stage.mouseClicked(e);
        }
    }

    protected override function mousePressed(e:MouseEvent){
        if (engine.stage!=null){
            engine.stage.mousePressed(e);
        }
    }

    protected override function mouseReleased(e:MouseEvent){
        if (engine.stage!=null){
            engine.stage.mouseReleased(e);
        }
    }

    protected override function mouseEntered(e:MouseEvent){
        if (engine.stage!=null){
            engine.stage.mouseEntered(e);
        }
    }

    protected override function mouseExited(e:MouseEvent){
        if (engine.stage!=null){
            engine.stage.mouseExited(e);
        }
    }

    protected override function mouseMoved(e:MouseEvent){
        if (engine.stage!=null){
            engine.stage.mouseMoved(e);
        }
    }

    protected override function mouseDragged(e:MouseEvent){
        if (engine.stage!=null){
            engine.stage.mouseDragged(e);
        }
    }

    protected override function mouseWheelMoved(e:MouseWheelEvent){
        if (engine.stage!=null){
            engine.stage.mouseWheelMoved(e);
        }
    }

    protected override function keyTyped(e:KeyEvent){
        if (engine.stage!=null){
            engine.stage.keyTyped(e);
        }
    }

    protected override function keyPressed(e:KeyEvent){
        if (engine.stage!=null){
            engine.stage.keyPressed(e);
        }
    }

    protected override function keyReleased(e:KeyEvent){
        if (engine.stage!=null){
            engine.stage.keyReleased(e);
        }
    }

}
