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

/**
 * @author Porfirio
 */

public abstract class GameEngine{
    protected var canvas:Canvas;
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
        canvas=new Canvas();
    }

    public function start(){
        canvas.createBufferStrategy(2);
        timeLine.playFromStart();
    }
    public abstract function load():Void;
    public function exit(){
        timeLine.stop();
    }
}
