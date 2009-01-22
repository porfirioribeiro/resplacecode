#ifndef WIDGETS_H
#define WIDGETS_H

#include <QtGui>

class QNumericEditor: public QLineEdit {
public:
    QNumericEditor(QWidget *parent = 0):QLineEdit(parent){

    }
    
    void keyPressEvent(QKeyEvent* e){
        QMessageBox::information(this->parentWidget(),"",this->text());
        QLineEdit::keyPressEvent(e);
    }

Q_SIGNALS:
    void actionTyped(int);
};


#endif // WIDGETS_H
