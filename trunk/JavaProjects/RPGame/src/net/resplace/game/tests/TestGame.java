/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game.tests;

import java.awt.BorderLayout;
import net.resplace.game.*;
import net.resplace.game.input.Input;
import net.resplace.game.nodes.AbstractNode;
import java.awt.Color;
import java.awt.Cursor;
import java.awt.Graphics2D;
import java.awt.Panel;
import java.awt.Rectangle;
import javax.swing.JButton;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.border.EtchedBorder;
import net.resplace.game.nodes.Node;
import net.resplace.game.nodes.NodeGroup;
import org.w3c.dom.NodeList;

/**
 *
 * @author Porfirio
 */
public class TestGame extends GameEngine {

    public TestGame() {
        setSize(400, 400);

        add(new AbstractNode() {

            @Override
            public void draw(Graphics2D g) {
                g.fillRect(0, 0, 500, 500);
            }

        });
        add(new NodePanel());
    }

    public static void main(String[] args) {
        GameRunner.runWindowed(new TestGame(), 400, 400, "TestGame");
    //GameRunner.runFullScreen(new TestGame(), 400, 400);
    }
}

class NodePanel extends NewJPanel implements Node {

    private NodeGroup parent;

    public NodePanel() {
        super();
        
    }

    public void init(NodeGroup parent) {
        this.parent = parent;
    }

    public NodeGroup getParentNode() {
        return parent;
    }

    public void create() {
        setSize(200, 200);
        setLocation(100, 100);
    }

    public void update(long elapsedTime) {
        if (Input.mouse.event != null) {
            processMouseEvent(Input.mouse.event);
        }
    }

    public void draw(Graphics2D g) {
        g.translate(getX(), getY());
        updateUI();
        update(g);
        jButton1.setSize(100, 20);
        jButton1.setLocation(200, 200);
        jButton1.update(g);
    }

    public void destroy() {
    }
}
