/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package fxtest;

import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.reflect.FXClassType;
import javafx.reflect.FXContext;
import javafx.reflect.FXFunctionMember;
import javafx.reflect.FXFunctionType;
import javafx.reflect.FXLocal;
import javafx.reflect.FXMemberFilter;
import javafx.reflect.FXPrimitiveType;
import javafx.reflect.FXSequenceBuilder;
import javafx.reflect.FXSequenceType;
import javafx.reflect.FXType;
import javafx.reflect.FXValue;

/**
 *
 * @author Porfirio
 */
public class Main {

    public static String[] args;
    private static Method m;

    /**
     * @param args the command line arguments
     */
    @SuppressWarnings("unchecked")
    public static void main(String[] args) {

        /*Method[] methods;
        try {
        Class c = Class.forName("fxtest.FXMain");
        methods = c.getMethods();
        for (Method method : methods) {
        //System.out.println(method);
        }
        c.newInstance();
        } catch (InstantiationException ex) {
        Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
        } catch (IllegalAccessException ex) {
        Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
        } catch (IllegalArgumentException ex) {
        Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
        } catch (SecurityException ex) {
        Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
        } catch (ClassNotFoundException ex) {
        Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
        }*/

        fxmain(args);
    }

    public static void fxmain(String[] args) {
        Main.args = args;
        FXContext context = FXLocal.getContext();
        FXClassType cls = context.findClass("fxtest.FXMain");

        FXSequenceBuilder argsSequence = context.makeSequenceBuilder(context.findClass("java.lang.String"));
        for (String arg : args) {
            argsSequence.append(context.mirrorOf(arg));
        }
        
        List<FXFunctionMember> functions = cls.getFunctions(FXMemberFilter.acceptMethods("main"), true);

        for (FXFunctionMember function : functions) {
            FXFunctionType type = function.getType();
            if (function.isStatic() && type.minArgs() == 1 && "java.lang.String[]".equals(type.getArgumentType(0).toString())) {
                function.invoke(null, argsSequence.getSequence());
                break;
            }
        }
    }
}
