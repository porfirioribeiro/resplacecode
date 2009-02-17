#ifndef WIDGETS_H
#define WIDGETS_H

#include <QtGui>

class QNumericEditor: public QLineEdit {
    //Q_OBJECT
    //Q_PROPERTY(float value READ value WRITE setValue)
public:
    QRegExp *numberExp;
    QNumericEditor(){}
    QNumericEditor(QWidget *parent = 0):QLineEdit(parent){
        numberExp= new QRegExp("^\\d$");
    }
    
    void keyPressEvent(QKeyEvent* e){
        QString str=e->text();
        if (str.size()==0 || e->key()==Qt::Key_Backspace || e->key()==Qt::Key_Delete){
            QLineEdit::keyPressEvent(e);
        }else{
            insert(str);
        }
    }
    void insert(QString str){
        if (str=="."){
            str=",";
        }
        if (validateInput(str)){
            QLineEdit::insert(str);
        }else{
            showErrorMessage();
        }
        //emit valueChanged(value());
    }
    float value(){
        return text().toFloat();
    }
public slots:
    void setValue(float val){
        setText(QString::number(val));
        //emit valueChanged(value());
    }

private:
    bool validateInput(QString str){
        return ((str=="-" && text().isEmpty()) ||
                (numberExp->exactMatch(str)) ||
                (!text().contains(",") && !text().contains(".") && (str=="." || str==",")));
    }
    void showErrorMessage(){
        QPoint point=pos();
        QWidget *par=parentWidget();
        while (par!=NULL){
            point+=par->pos();
            par=par->parentWidget();
        }
        QToolTip::showText(point,QString("<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0//EN\" \"http://www.w3.org/TR/REC-html40/strict.dtd\">\n"
                                         "<html><head><meta name=\"qrichtext\" content=\"1\" /></head><body style=\" font-family:'MS Shell Dlg 2'; font-size:8.25pt; font-weight:400; \">\n"
                                         "<img src=\":/window-close.png\" /><span style=\" font-weight:600;\"> "+tr("Numeric Only")+"</span><br>\n"
                                         +tr("This field is numeric only, it only acepts")+"<br>\n"
                                         +tr("0-9 . - characters")),this);
    }
//signals:
    //void valueChanged(float newValue);
};


#endif // WIDGETS_H
