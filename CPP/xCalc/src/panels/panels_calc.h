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

    public slots:
        void clickNumber();
        void addiction();
        void division();
        void equals();
        void multiplication();
        void subtraction();

    protected:
        virtual void changeEvent(QEvent *e);
        virtual void setVisible(bool visible);
    };

}
#include "ui_calc.h"
#endif // CALC_H
