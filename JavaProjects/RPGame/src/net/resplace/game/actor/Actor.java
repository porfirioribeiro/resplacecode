package net.resplace.game.actor;

import net.resplace.game.sprite.Sprite;
import net.resplace.game.*;
import net.resplace.game.node.AbstractNode;
import java.awt.Graphics2D;
import java.awt.Rectangle;

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

    public Rectangle getColisionRect(){
        return new Rectangle(x+sprite.bbox.left, y+sprite.bbox.top, width-sprite.bbox.left-sprite.bbox.right, height-sprite.bbox.top-sprite.bbox.bottom);
    }

    public Rectangle getOutRect(){
        return new Rectangle(x, y, width, height);
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
