package net.resplace.game.sprite;


import java.net.URL;
import net.resplace.game.actor.BBox;
import java.awt.Graphics2D;
import java.awt.Image;
import java.awt.Point;
import java.awt.image.BufferedImage;
import javax.swing.ImageIcon;

/**
 *
 * @author porf
 */
public class Sprite {
    public final BBox bbox=new BBox(this);
    public final Point origin= new Point(0, 0);
    protected BufferedImage image=new BufferedImage(1, 1, BufferedImage.TYPE_INT_ARGB);

    public int speed=1;

    public Sprite() {
    }

    public Sprite(Image image) {
        this.image=new BufferedImage(image.getWidth(null), image.getHeight(null), BufferedImage.TYPE_INT_ARGB);
        this.image.getGraphics().drawImage(image, 0, 0, null);
    }

    public Sprite(String image) {
        this(new ImageIcon(image).getImage());
    }

    public Sprite(URL image) {
        this(new ImageIcon(image).getImage());
    }
    
    public Image getImage() {
        return image;
    }

    public int getWidth(){
        return (image!=null)?image.getWidth(null):0;
    }

    public int getHeight(){
        return (image!=null)?image.getHeight(null):0;
    }

    public void setBBox(int left, int top, int right, int bottom) {
        bbox.setBBox(left, top, right, bottom);
    }



    /**
     * Not need on static sprites, but might be used on animated sprites!
     */
    public void update(long elapsedTime) {

    }
    
    /**
     * Draw this sprite
     * @param g
     * @param x
     * @param y
     * @param width
     * @param height
     */
    public void draw(Graphics2D g, int x, int y, int width, int height){
        if (image!=null){
            g.drawImage(image, x-origin.x, y-origin.y, width, height, null);
        }
    }


}
