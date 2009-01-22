#include "qserialprinter.h"

QSerialPrinter::QSerialPrinter()
{
}

QSerialPrinter::QSerialPrinter(const QString & name)
{
    port=new QextSerialPort(name);
    port->open(QIODevice::WriteOnly);
}
void QSerialPrinter::close(){
    if (port != NULL){
        port->close();
    }
}
void QSerialPrinter::print(QString str){
    if (port != NULL){
        port->write(str.toAscii(),str.size());
    }
}
void QSerialPrinter::println(QString str){
    print(str.append("\x0A"));
}
void QSerialPrinter::println(){
    print("\x0A");
}

void QSerialPrinter::openDrawer(QString sequence){
    if (port != NULL){
        QByteArray b;
        QStringList l=sequence.split(",");
        for (int i=0;i< l.size();i++){
            b.append(l.at(i).toInt());
        }
        port->write(b);
    }
}
