/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game.sprite;

import java.awt.Image;
import java.awt.image.BufferedImage;
import java.net.URL;
import javax.swing.ImageIcon;

/**
 *
 * @author Porfirio
 */
public class StripSprite extends Sprite {

    protected int stripWidth=0;
    protected int stripHeight=0;
    protected int width = 0;
    protected int height = 0;
    protected int hOffset = 0;
    protected int vOffset = 0;
    protected int hSeparation = 0;
    protected int vSeparation = 0;

    public StripSprite(Image image, int width, int height, int hOffset, int vOffset, int hSeparation, int vSeparation) {
        super(image);
        this.stripWidth=image.getWidth(null);
        this.stripHeight=image.getHeight(null);
        this.width = width;
        this.height = height;
        this.hOffset = hOffset;
        this.vOffset = vOffset;
        this.hSeparation = hSeparation;
        this.vSeparation = vSeparation;
    }

    public StripSprite(String image, int width, int height, int hOffset, int vOffset, int hSeparation, int vSeparation) {
        this(new ImageIcon(image).getImage(), width, height, hOffset, vOffset, hSeparation, vSeparation);
    }

    public StripSprite(URL image, int width, int height, int hOffset, int vOffset, int hSeparation, int vSeparation) {
        this(new ImageIcon(image).getImage(), width, height, hOffset, vOffset, hSeparation, vSeparation);
    }

    public StripSprite(Image image, int width, int height, int hOffset, int vOffset) {
        this(image, width, height, hOffset, vOffset, 0, 0);
    }

    public StripSprite(String image, int width, int height, int hOffset, int vOffset) {
        this(image, width, height, hOffset, vOffset, 0, 0);
    }

    public StripSprite(URL image, int width, int height, int hOffset, int vOffset) {
        this(image, width, height, hOffset, vOffset, 0, 0);
    }

    public StripSprite(Image image, int width, int height) {
        this(image, width, height, 0, 0);
    }

    public StripSprite(String image, int width, int height) {
        this(image, width, height, 0, 0);
    }

    public StripSprite(URL image, int width, int height) {
        this(image, width, height, 0, 0);
    }

    @Override
    public int getWidth() {
        return width;
    }

    @Override
    public int getHeight() {
        return height;
    }

    public BufferedImage getImage(int h, int v){
        int y=(h*width) + hOffset;
        if (h>0){
            y+=(h*hSeparation);
        }
        int x=(v*height) + vOffset;
        if (v>0){
            x+=(v*vSeparation);
        }
        /**if ((x + width>stripWidth) || (y + height>stripHeight)){
            throw new Exception("Trying to get a tile out of bounds!");
        }*/
        return image.getSubimage(x, y, width, height);
    }

    public Sprite getSprite(int h, int v){
        return new Sprite(getImage(h, v));
    }

    public AnimatedSprite getSprite(int[][] positions){
        AnimatedSprite sprite= new AnimatedSprite();
        for (int i = 0; i < positions.length; i++) {
            int[] is = positions[i];
            sprite.add(getImage(is[0], is[1]));
        }
        return sprite;
    }
    public AnimatedSprite getSprite(int ...positions){
        AnimatedSprite sprite= new AnimatedSprite();
        for (int i = 0; i < positions.length; i+=2) {
            if (i+1==positions.length){
                break;
            }
            sprite.add(getImage(positions[i], positions[i+1]));
        }
        return sprite;
    }
}
