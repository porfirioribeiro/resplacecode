#ifndef WIDGETS_H
#define WIDGETS_H

#include <QtGui>

class QNumericEditor: public QLineEdit {
public:
    QRegExp *numberExp;
    QNumericEditor(QWidget *parent = 0):QLineEdit(parent){
        numberExp= new QRegExp("^\\d$");
//        qDebug() << QString::number(10.5);
//        qDebug() << tr("-10.5").toFloat();
//        qDebug() << tr("-10,5").toFloat();
    }
    
    void keyPressEvent(QKeyEvent* e){
        QString keyChar=e->text();
        if ((e->key()==Qt::Key_Minus && text().isEmpty()) ||
            (numberExp->exactMatch(keyChar)) ||
            (!text().contains(",") && !text().contains(".") && (e->text()=="." || e->text()==",")) ||
            (e->key()==Qt::Key_Backspace || e->key()==Qt::Key_Delete)){
            QLineEdit::keyPressEvent(e);
        }else{
            QPoint point=pos();
            QWidget *par=parentWidget();
            while (par!=NULL){
                point+=par->pos();
                par=par->parentWidget();
            }
/*QToolTip::showText(point,tr("<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0//EN' 'http://www.w3.org/TR/REC-html40/strict.dtd'>")
                    .append("<html><head><meta name='qrichtext' content='1' /></head><body style=' font-family:'MS Shell Dlg 2'; font-size:8.25pt; font-weight:400; '>")
                    .append("<img src=':/window-close.png' /><span style=' font-weight:600;'>Numeric Only</span><br>")
                    .append("This field is numeric only, it only acepts<br>")
                    .append("0-9 . - characters")
                    .append("</body></html>"),this);*/
QToolTip::showText(point,QString("<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0//EN\" \"http://www.w3.org/TR/REC-html40/strict.dtd\">\n"
"<html><head><meta name=\"qrichtext\" content=\"1\" /></head><body style=\" font-family:'MS Shell Dlg 2'; font-size:8.25pt; font-weight:400; \">\n"
"<img src=\":/window-close.png\" /><span style=\" font-weight:600;\"> "+tr("Numeric Only")+"</span><br>\n"
+tr("This field is numeric only, it only acepts")+"<br>\n"
+tr("0-9 . - characters")),this);
        }
    }

Q_SIGNALS:
    void actionTyped(int);
};


#endif // WIDGETS_H
