#ifndef CALC_H
#define CALC_H

#include <QtGui>
#include "mainwindow.h"

namespace Ui {
    class Calc;
}

namespace Panels{

    class Calc: public QWidget {
        Q_OBJECT
        Q_DISABLE_COPY(Calc)
    public:
        explicit Calc(MainWindow*);
        virtual ~Calc();
        Ui::Calc *ui;
        MainWindow *mw;
        QUndoStack *undoStack;
        QUndoCommand *lastCommand;
        float displayNumber;
        float currentValue;

    public slots:
        void clickNumber();
        void backSpace();
        void clear();
        void addiction();
        void division();
        void equals();
        void multiplication();
        void subtraction();

    protected:
        virtual void changeEvent(QEvent *e);
        virtual void setVisible(bool visible);

private slots:
    void on_lineEdit_textChanged(QString );
};

}
#include "ui_calc.h"
#endif // CALC_H
