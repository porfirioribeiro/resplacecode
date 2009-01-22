#ifndef Tax_H
#define Tax_H

#include <QtGui>
#include "mainwindow.h"

namespace Ui {
    class Tax;
}

namespace Panels{

    class Tax: public QWidget {
        Q_OBJECT
        Q_DISABLE_COPY(Tax)
    public:
        explicit Tax(MainWindow*);
        virtual ~Tax();
        Ui::Tax *ui;
        MainWindow *mw;

    public slots:
        void doCalc();

    protected:
            virtual void changeEvent(QEvent *e);
    };

}
#include "ui_Tax.h"
#endif // Tax_H
