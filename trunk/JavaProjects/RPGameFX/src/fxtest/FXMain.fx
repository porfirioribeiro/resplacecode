/*
 * FXMain.fx
 *
 * Created on 16/Dez/2008, 15:00:53
 */

package fxtest;

import javafx.animation.Timeline;
import javafx.animation.KeyFrame;


    /**
     * @author Porfirio
     */
     
    function main(args:String[]){
        java.lang.System.out.println(args[0]);
        FXMain{}
    }
    function run(args:String[]){
        java.lang.System.out.println(args[0]);
        FXMain{}
    }
public class FXMain {
    init{
        var s:String="Works!!";
        java.lang.System.out.println(s);
    }
}
