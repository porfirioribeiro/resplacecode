/*
 * DrawState.fx
 *
 * Created on 23/Dez/2008, 20:03:49
 */

package net.resplace.game;
import java.awt.Color;
import java.awt.Composite;
import java.awt.Font;
import java.awt.geom.AffineTransform;
import java.awt.Paint;
import java.awt.RenderingHints;
import java.awt.Shape;
import java.awt.Stroke;
import java.awt.Graphics2D;

/**
 * @author Porfirio
 */

public function fromGraphics2D(g:Graphics2D):DrawState{
    return DrawState{
        paint:g.getPaint()
        font:g.getFont()
        stroke:g.getStroke()
        transform:g.getTransform()
        composite:g.getComposite()
        clip:g.getClip()
        background:g.getBackground()
        color:g.getColor()
        renderingHints:g.getRenderingHints().clone() as RenderingHints
    }
}

public class DrawState{
    public-init var paint:Paint;
    public-init var font:Font;
    public-init var stroke:Stroke;
    public-init var transform:AffineTransform;
    public-init var composite:Composite;
    public-init var clip:Shape;
    public-init var background:Color;
    public-init var color:Color;
    public-init var renderingHints:RenderingHints;
    public function apply(g:Graphics2D){
        g.setPaint(paint);
        g.setFont(font);
        g.setTransform(transform);
        g.setStroke(stroke);
        g.setComposite(composite);
        g.setClip(clip);
        g.setBackground(background);
        g.setColor(color);
        g.setRenderingHints(renderingHints)
    }
}