#include <QtGui>
#include "mainwindow.h"
#include <qextserialenumerator.h>
#include "qextserialbase.h"
#include "qextserialport.h"
#include "QSerial.h"

int main(int argc, char *argv[])
{
    QApplication app(argc, argv);


    //QSerial::Instance().doIt();
    //QSerial::initialize();
    //extra code
    /*QList<QextPortInfo> ports = QextSerialEnumerator::getPorts();
    printf("List of ports:\n");
    for (int i = 0; i < ports.size(); i++) {
    	//ports.at(i).QextPortInfo
        printf("port name: %s\n", ports.at(i).portName.toLocal8Bit().constData());
        printf("friendly name: %s\n", ports.at(i).friendName.toLocal8Bit().constData());
        printf("physical name: %s\n", ports.at(i).physName.toLocal8Bit().constData());
        printf("enumerator name: %s\n", ports.at(i).enumName.toLocal8Bit().constData());
        printf("===================================\n\n");
    }*/
    //end


 /*
    QString text="test\x0A";//\x0D
    port->write(text.toAscii(),text.size());


    delete port;
    port = NULL;
*/
    if (!QSystemTrayIcon::isSystemTrayAvailable()) {
        QMessageBox::critical(0, "Systray","I couldn't detect any system tray on this system.");
        return 1;
    }
    //qFatal("divide: cannot divide by zero");
    app.setQuitOnLastWindowClosed(false);
    MainWindow w;
    w.show();
    return app.exec();
}
