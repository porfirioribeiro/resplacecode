package net.resplace.game;

import net.resplace.game.nodes.AbstractNode;
import java.awt.Graphics2D;

/**
 *
 * @author porf
 */
public class Actor extends AbstractNode {

    public Sprite sprite;
    public int x;
    public int y;
    public int width;
    public int height;

    public Actor(Sprite sprite, int x, int y, int width, int height) {
        this.sprite = sprite;
        this.x = x;
        this.y = y;
        this.width = width;
        this.height = height;
    }

    public Actor(Sprite sprite, int x, int y) {
        this.sprite = sprite;
        this.x = x;
        this.y = y;
        if (sprite != null) {
            this.width = sprite.getWidth();
            this.height = sprite.getHeight();
        }
    }

    public Actor(Sprite sprite) {
        this.sprite = sprite;
    }

    public Actor() {
    }

    /**
     * override it for step event
     */
    @Override
    public void update(long elapsedTime) {
        if (sprite != null) {
            sprite.update(elapsedTime);
        }
    }

    /**
     * overide it for paint
     * @param g
     */
    @Override
    public void draw(Graphics2D g) {
        if (sprite != null) {
            sprite.draw(g, x, y, width, height);
        }
    }

    @Override
    public void destroy() {
    }

    /**
     * Test a simple box collision, returns true if collides
     * @param other
     * @return
     */
    public boolean colidesWith(Actor other) {
        return !((this.x > other.x + other.width) ||
                (this.x + this.width < other.x) ||
                (this.y > other.y + height) ||
                (this.y + this.height < other.y));
    }

    public boolean colidesWith(ActorGroup group) {
        return group.colidesWith(this);
    }
}
