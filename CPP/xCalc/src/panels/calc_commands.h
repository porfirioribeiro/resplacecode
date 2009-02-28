#ifndef CALC_COMMANDS_H
#define CALC_COMMANDS_H
#include <QtCore>
#include <QtGui>

namespace Panels{
    class Calc;
}
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
            calc->currentValue-=value;
            Basic::undo();
        }
        void redo(){
            calc->currentValue+=value;
            Basic::redo();
        }
    };
    class Subtract: public Basic{
    public:
        Calc *calc;
        int pos;
        Subtract(Calc *calc,float n): Basic(calc){
            setText(QObject::tr("%1 -").arg(n));
            value=n;
        }
        void undo(){
            calc->currentValue+=value;
            Basic::undo();
        }
        void redo(){
            calc->currentValue-=value;
            Basic::redo();
        }
    };
    class Multiply: public Basic{
    public:
        Calc *calc;
        int pos;
        Multiply(Calc *calc,float n): Basic(calc){
            setText(QObject::tr("%1 *").arg(n));
            value=n;
        }
        void undo(){
            calc->currentValue/=value;
            Basic::undo();
        }
        void redo(){
            calc->currentValue*=value;
            Basic::redo();
        }
    };
    class Divide: public Basic{
    public:
        Calc *calc;
        int pos;
        Divide(Calc *calc,float n): Basic(calc){
            setText(QObject::tr("%1 /").arg(n));
            value=n;
        }
        void undo(){
            calc->currentValue*=value;
            Basic::undo();
        }
        void redo(){
            calc->currentValue/=value;
            Basic::redo();
        }
    };
    class Equals: public Basic{
    public:
        Calc *calc;
        int pos;
        float oldVal;
        Equals(Calc *calc,float n): Basic(calc){
            setText(QObject::tr("%1 =").arg(n));
            value=n;
        }
        void undo(){
            calc->currentValue=oldVal;
            Basic::undo();
        }
        void redo(){
            oldVal=calc->currentValue;
            calc->currentValue=0;
            Basic::redo();
        }
    };
}
#endif // CALC_COMMANDS_H
