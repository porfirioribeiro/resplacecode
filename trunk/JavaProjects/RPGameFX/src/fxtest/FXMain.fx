/*
 * FXMain.fx
 *
 * Created on 16/Dez/2008, 15:00:53
 */

package fxtest;

import javafx.animation.Timeline;
import javafx.animation.KeyFrame;
import net.resplace.game.node.Group;
import net.resplace.game.node.Node;
import net.resplace.game.sprite.Sprite;
import net.resplace.game.sprite.StripSprite;

    /**
     * @author Porfirio
     */
     
    function main(args:String[]){
        FXMain{}
    }
public class FXMain {
    init{
        
        var actors:StripSprite=StripSprite{
            image:Sprite.load("{__DIR__}Actor1.png")
            width:32
            height:32
        }

        def actorDown:Sprite=actors.getSprite([0,0,0,1,0,2,5]);
        def actorLeft:Sprite=Sprite{
            frames: actors.getImage([[1,0],[1,1],[1,2]]);
        }
        java.lang.System.out.println(actorLeft.frameNumber);
        //throw new java.lang.RuntimeException("Oh god no :(");
        //java.lang.System.out.println(actors.getSprite([1,2]));
        /*java.lang.System.out.println(group.empty);
        group.remove(node);
        
        java.lang.System.out.println(group.size);
        java.lang.System.out.println(1h);
        var g=Group{};
        g.add(Node{});
        java.lang.System.out.println(g.size);*/
    }
}
