/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game;

import java.awt.GraphicsDevice;
import java.awt.GraphicsEnvironment;
import java.awt.event.KeyAdapter;
import java.awt.event.KeyEvent;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;
import javax.swing.JFrame;
import javax.swing.WindowConstants;
import net.resplace.game.input.Input;

/**
 *
 * @author Porfirio
 */
public class GameRunner {

    protected static JFrame createFrame(final GameEngine game, int width, int height) {
        game.canvas.setSize(width, height);

        JFrame frame = new JFrame();
        frame.setSize(width, height);
        frame.setLocationRelativeTo(null);
        frame.setResizable(false);
        frame.setDefaultCloseOperation(WindowConstants.DO_NOTHING_ON_CLOSE);
        frame.add(game.canvas);
        frame.addWindowListener(new WindowAdapter() {

            @Override
            public void windowClosing(WindowEvent e) {
                if (game.exit()) {
                    System.exit(0);
                }
            }
        });
        frame.addKeyListener(new KeyAdapter() {

            @Override
            public void keyPressed(KeyEvent e) {
                if (e.getKeyCode() == KeyEvent.VK_ESCAPE) {
                    if (game.exit()) {
                        System.exit(0);
                    }
                }
                e.consume();
            }
        });
        return frame;
    }

    public static void runWindowed(final GameEngine game, int width, int height, String title) {
        JFrame frame = createFrame(game, width, height);
        frame.setTitle(title);
        frame.setVisible(true);
        Input.register(frame);
        game.start();
    }

    public static void runFullScreen(GameEngine game, int width, int height) {
        GraphicsEnvironment ge = GraphicsEnvironment.getLocalGraphicsEnvironment();
        GraphicsDevice gd = ge.getDefaultScreenDevice();

        JFrame frame = createFrame(game, width, height);

        frame.setUndecorated(true);
        gd.setFullScreenWindow(frame);
        game.start();

    }
}
