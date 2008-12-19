/*
 * Util.fx
 *
 * Created on 19/Dez/2008, 20:05:22
 */

package net.resplace.game;

/**
 * @author Porfirio
 */

public class Util {

}
    public function sequenceContains(seq:Object[],value:Object):Boolean{//TODO: Remove public!
        for (item in seq){
            if (item.equals(value)){
                return true;
            }
        }
        return false;
    }