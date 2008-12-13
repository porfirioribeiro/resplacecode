/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package net.resplace.game.tests;

import java.lang.reflect.Field;
import java.lang.reflect.ParameterizedType;
import java.lang.reflect.Type;
import java.lang.reflect.TypeVariable;
import javax.swing.text.Utilities;
import net.resplace.game.input.Input;

/**
 *
 * @author Porfirio
 */
public class TestClasses {

    public static class GenericField<T> {

        private T type;
        protected Object object;
        protected String fieldName;
        protected Field field;

        public GenericField(Object object, String fieldName) {
            this.object = object;
            this.fieldName = fieldName;
            try {
                field = object.getClass().getField(fieldName);
            } catch (java.lang.Exception ex) {
                throw new Exception("Field " + fieldName + " is not acessible!", ex.getCause());
            }
        }

        @SuppressWarnings("unchecked")
        public T get() {
            try {
                return (T) field.get(object);
            } catch (java.lang.Exception ex) {
                throw new Exception("Could not get the value of the field \"" + fieldName + "\" maybe it is final?", ex.getCause());
            }
        }

        public void set(T value) {
            try {
                field.set(object, value);
            } catch (java.lang.Exception ex) {
                throw new Exception("Could not set the value of the field \"" + fieldName + "\" maybe it is final?", ex.getCause());
            }
        }

        public static class Exception extends RuntimeException {

            public Exception(String message, Throwable cause) {
                super(message, cause);
            }
        }
    }

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        class Test {

            public final int x = 0;
        }
        Test test = new Test();

        GenericField<Integer> field = new GenericField<Integer>(Input.mouse, "point");

        field.set(field.get());



    }
}
