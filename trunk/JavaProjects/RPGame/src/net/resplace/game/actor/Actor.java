package net.resplace.game.actor;

import net.resplace.game.sprite.Sprite;
import net.resplace.game.node.AbstractNode;
import java.awt.Graphics2D;
import java.awt.Rectangle;
import java.awt.image.BufferedImage;
import java.util.ArrayList;
import net.resplace.game.input.Input;

/**
 *
 * @author porf
 */
public class Actor extends AbstractNode {

    public Sprite sprite;
    protected BufferedImage image;
    private long currentTime = 0;
    public int frameSpeed = 0;
    public int frameIndex = 0;
    public int x;
    public int y;
    public int width;
    public int height;
    public double hspeed=0;
    public double vspeed=0;
    public final ArrayList<Behavior> behaviors = new ArrayList<Behavior>();

    public Actor() {
        for (Behavior behavior : behaviors) {
            behavior.create(this);
        }
    }

    public Actor(Sprite sprite) {
        this();
        this.sprite = sprite;
    }

    public Actor(Sprite sprite, int x, int y) {
        this(sprite);
        this.x = x;
        this.y = y;
        if (sprite != null) {
            this.width = sprite.getWidth();
            this.height = sprite.getHeight();
        }
    }

    public Rectangle getColisionRect() {
        return new Rectangle(x + sprite.bbox.left - sprite.origin.x, y + sprite.bbox.top - sprite.origin.y, width - sprite.bbox.left - sprite.bbox.right, height - sprite.bbox.top - sprite.bbox.bottom);
    }

    public Rectangle getOutRect() {
        return new Rectangle(x - sprite.origin.x, y - sprite.origin.y, width, height);
    }

    /**
     * override it for step event
     */
    @Override
    public void update(long elapsedTime) {
        //Update sprite
        currentTime += elapsedTime;
        System.out.println(currentTime);
        if (frameSpeed > 0) {
            if (currentTime > (1000 / frameSpeed)) {
                frameIndex++;
                currentTime = 0;
            }
        }
        if (frameIndex == sprite.countFrames()) {
            frameIndex = 0;
        }

        //update position acording to speed
        x+=hspeed;
        y+=vspeed;
        //Do behaviors
        for (Behavior behavior : behaviors) {
            behavior.update(this, elapsedTime);
        }
    }

    /**
     * overide it for paint
     * @param g
     */
    @Override
    public void draw(Graphics2D g) {
        if (sprite != null) {
            sprite.drawFrame(g, frameIndex, x, y);
        }
        for (Behavior behavior : behaviors) {
            behavior.draw(this, g);
        }
    }

    public boolean mouseIn(boolean colisionRect) {
        if (colisionRect) {
            return getColisionRect().contains(Input.mouse.point);
        } else {
            return getOutRect().contains(Input.mouse.point);
        }
    }

    public boolean mouseIn() {
        return mouseIn(false);
    }

    /**
     * Test a simple box collision, returns true if collides
     * @param other
     * @return
     */
    public boolean colidesWith(Actor other) {
        Rectangle thisR = this.getColisionRect();
        Rectangle otherR = other.getColisionRect();
        //return getColisionRect().intersects(other.getColisionRect());
        /*return !((this.x > other.x + other.width) ||
        (this.x + this.width < other.x) ||
        (this.y > other.y + other.height) ||
        (this.y + this.height < other.y));*/
        return !((thisR.x > otherR.x + otherR.width) ||
                (thisR.x + thisR.width < otherR.x) ||
                (thisR.y > otherR.y + otherR.height) ||
                (thisR.y + thisR.height < otherR.y));
    }

    public boolean colidesWith(ActorGroup group) {
        return group.colidesWith(this);
    }
}
