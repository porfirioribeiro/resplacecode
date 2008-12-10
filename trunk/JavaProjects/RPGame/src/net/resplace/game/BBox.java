/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package net.resplace.game;

/**
 *
 * @author porf
 */
public class BBox {
    protected Sprite sprite;
    public int left=0;
    public int top=0;
    public int right=0;
    public int bottom=0;

    public BBox(Sprite sprite, int left, int top, int right, int bottom) {
        this.sprite=sprite;
        this.left=left;
        this.top=top;
        this.right=right;
        this.bottom=bottom;
    }

    public BBox(Sprite sprite) {
        this.sprite = sprite;
    }
    public void setBBox(int left, int top, int right, int bottom) {
        this.left=left;
        this.top=top;
        this.right=right;
        this.bottom=bottom;
    }
}
