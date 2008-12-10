package net.resplace.game;


import java.awt.Graphics2D;
import java.awt.Image;
import java.awt.image.BufferedImage;

/**
 *
 * @author porf
 */
public class Sprite {
    private Image image=new BufferedImage(1, 1, BufferedImage.TYPE_INT_ARGB);

    public Sprite(Image image) {
        this.image = image;
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

    /**
     * Not need on static sprites, but might be used on animated sprites!
     */
    void update(long elapsedTime) {

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
            g.drawImage(image, x, y, width, height, null);
        }
    }


}
