#include <QtGui>
#include "singleapplication.h"

#include "mainwindow.h"
#include "qserialprinter.h"

void test(){

    QSerialPrinter *printer=new QSerialPrinter("COM2");
    printer->openDrawer("27,112,0,48,0,48");
    printer->print("First word. ");
    printer->println("Second word!");
    printer->println();
    printer->println();
    printer->println();
    printer->println();
    printer->println();
    printer->close();
}

int main(int argc, char *argv[])
{

    //test();
    //return 0;
    QApplication::setApplicationName("xCalc");
    QApplication::setApplicationVersion("1.0");
    QApplication::setOrganizationName("Resplace");
    QApplication::setOrganizationDomain("resplace.net");

    QApplication app(argc, argv);
    if (!QSystemTrayIcon::isSystemTrayAvailable()) {
        QMessageBox::critical(0, "Systray","I couldn't detect any system tray on this system.");
        return 1;
    }

    SingleApplication instance("xCalc", &app);
    if(instance.isRunning()) {
        if(instance.sendMessage("restoreWindow"))
            return 0;
    }
    QString locale = QLocale::system().name();

    QTranslator translator;
    translator.load("locale/xCalc_" + locale);
    app.installTranslator(&translator);
    app.setQuitOnLastWindowClosed(false);
    MainWindow w;
    w.show();
    QObject::connect(&instance, SIGNAL(messageReceived(const QString&)),
                                                 &w, SLOT(handleSingleInstanceMessage(const QString&)));
    return app.exec();
}
