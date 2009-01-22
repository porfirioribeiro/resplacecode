#ifndef QSERIALPRINTER_H
#define QSERIALPRINTER_H

#include <QtCore>
#include "qextserialport.h"

class QSerialPrinter
{
public:
    QextSerialPort *port;
    QSerialPrinter();
    QSerialPrinter(const QString & name);
    void close();
    void print(QString str);
    void println(QString str);
    void println();
    void openDrawer(QString sequence);
};

#endif // QSERIALPRINTER_H
