/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package net.resplace.game.tests;

import java.applet.Applet;

/**
 *
 * @author Porfirio
 */
public class TestGameApplet extends Applet {

    TestGame game= new TestGame();
    /**
     * Initialization method that will be called after the applet is loaded
     * into the browser.
     */
    @Override
    public void init() {
        game.canvas.setSize(getSize());
        add(game.canvas);
        game.start();
        // TODO start asynchronous download of heavy resources
    }

    @Override
    public void stop() {
        destroy();
    }

    @Override
    public void destroy() {
        game.exit();
    }

    // TODO overwrite start(), stop() and destroy() methods

}
