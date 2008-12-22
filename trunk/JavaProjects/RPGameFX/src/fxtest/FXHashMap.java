/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package fxtest;

import java.util.HashMap;

/**
 *
 * @author Porfirio
 */
public class FXHashMap<K, V> extends HashMap<K, V> {

    public V get(K key, V defaultValue) {
        if (containsKey(key)) {
            return get(key);
        }
        return defaultValue;
    }
}
