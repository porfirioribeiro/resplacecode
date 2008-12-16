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

    /**
     * @author Porfirio
     */
     
    function main(args:String[]){
        FXMain{}
    }
public class FXMain {
    init{
        var node=Node{}
        var group=Group{
            nodes: [
                node
            ]
        }
        java.lang.System.out.println(group.empty);
        group.remove(node);
        
        java.lang.System.out.println(group.size);
    }
}
