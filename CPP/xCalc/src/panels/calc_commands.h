#ifndef CALC_COMMANDS_H
#define CALC_COMMANDS_H
#include <QtCore>
#include <QtGui>

namespace CalcCmd{
    class Basic: public QUndoCommand {
    public:
        Calc *calc;
        int pos;
        float value;
        QListWidgetItem *widget;
        Basic(Calc *calc){
            this->calc=calc;
            value=0;
            widget=new QListWidgetItem(text());
            widget->setTextAlignment(Qt::AlignRight);
        }
        void undo(){
            calc->ui->listWidget->takeItem(pos);
        }
        void redo(){
            widget->setText(text());
            calc->ui->listWidget->addItem(widget);
            pos=calc->ui->listWidget->count()-1;
        }
    };

    class Add: public Basic{
    public:
        Calc *calc;
        int pos;
        Add(Calc *calc,float n): Basic(calc){
            setText(QObject::tr("%1 +").arg(n));
            value=n;
        }
        void undo(){
            //undo stuff
            Basic::undo();
        }
        void redo(){
            //redo stuff
            Basic::redo();
        }
    };
}
#endif // CALC_COMMANDS_H
