package net.resplace.game.sprite;

import java.net.URL;
import net.resplace.game.actor.BBox;
import java.awt.Graphics2D;
import java.awt.Image;
import java.awt.Point;
import java.awt.image.BufferedImage;
import java.util.ArrayList;
import javax.swing.ImageIcon;

/**
 *
 * @author porf
 */
public class Sprite {

    public final BBox bbox = new BBox(this);
    public final Point origin = new Point(0, 0);
    protected int width = 0;
    protected int height = 0;
    public final ArrayList<BufferedImage> frames = new ArrayList<BufferedImage>();
    public int speed = 1;

    public Sprite() {
    }

    public Sprite(Image image) {
        BufferedImage img = new BufferedImage(image.getWidth(null), image.getHeight(null), BufferedImage.TYPE_INT_ARGB);
        img.getGraphics().drawImage(image, 0, 0, null);
        add(img);
    }

    public Sprite(String image) {
        this(new ImageIcon(image).getImage());
    }

    public Sprite(URL image) {
        this(new ImageIcon(image).getImage());
    }

    public void add(BufferedImage image) {
        if (width == 0 && height == 0) {
            width = image.getWidth();
            height = image.getHeight();
        } else {
            if (image.getWidth() != width || image.getHeight() != height) {
                throw new RuntimeException("All frames of the sprite must have the same size: " + width + " x " + height);
            }
        }
        frames.add(image);
    }

    public BufferedImage get(int i) {
        return frames.get(i);
    }

    public void remove(BufferedImage image) {
        frames.remove(image);
    }

    public void remove(int i) {
        frames.remove(i);
    }

    public int countFrames() {
        return frames.size();
    }

    public int getWidth() {
        return width;
    }

    public int getHeight() {
        return height;
    }

    public void setBBox(int left, int top, int right, int bottom) {
        bbox.setBBox(left, top, right, bottom);
    }

    /**
     * Not need on static sprites, but might be used on animated sprites!
     */
    public void update(long elapsedTime) {
    }

    public void drawFrame(Graphics2D g, int index, int x, int y) {
        BufferedImage image = get(index);
        if (image != null) {
            g.drawImage(image, x - origin.x, y - origin.y, null);
        }
    }
    /**
     * Draw this sprite
     * @param g
     * @param x
     * @param y
     * @param width
     * @param height
     */
    /*    public void draw(Graphics2D g, int x, int y, int width, int height){
    if (image!=null){
    g.drawImage(image, x-origin.x, y-origin.y, width, height, null);
    }
    }
     */
}
