/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game.sprite;

import java.awt.Graphics2D;
import java.awt.image.BufferedImage;
import java.util.ArrayList;

/**
 *
 * @author Porfirio
 */
public class AnimatedSprite extends Sprite {

    public final ArrayList<BufferedImage> frames = new ArrayList<BufferedImage>();
    private int currentFrameIndex=0;
    public void add(BufferedImage BufferedImage) {
        frames.add(BufferedImage);
    }

    public BufferedImage get(int i) {
        return frames.get(i);
    }
    public BufferedImage getCurrentFrame() {
        return get(currentFrameIndex);
    }
    public void remove(BufferedImage BufferedImage) {
        frames.remove(BufferedImage);
    }

    public void remove(int i) {
        frames.remove(i);
    }

    public int countFrames() {
        return frames.size();
    }

    @Override
    public void update(long elapsedTime) {
        image=getCurrentFrame();
        currentFrameIndex++;
        if (currentFrameIndex==frames.size()){
            currentFrameIndex=0;
        }
    }

    @Override
    public void draw(Graphics2D g, int x, int y, int width, int height) {
        super.draw(g, x, y, width, height);
        System.out.println(width);
    }

    @Override
    public int getWidth() {
        return getCurrentFrame().getWidth();
    }

    @Override
    public int getHeight() {
        return getCurrentFrame().getHeight();
    }


}
