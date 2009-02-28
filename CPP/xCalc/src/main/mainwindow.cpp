#include "mainwindow.h"
#include "panels_calc.h"
#include "panels_tax.h"

MainWindow::MainWindow(QWidget *parent) :
    QMainWindow(parent), ui(new Ui::MainWindow)
{
    trayIconMenu = new QMenu(this);
    trayIcon = new QSystemTrayIcon(this);
    trayIcon->setObjectName("trayIcon");
    ui->setupUi(this);

    calcPanel=new Panels::Calc(this);
    taxPanel=new Panels::Tax(this);

    ui->actionRestore->setVisible(false);
    trayIconMenu->addAction(ui->actionOpenDrawer);
    trayIconMenu->addSeparator();
    trayIconMenu->addAction(ui->actionRestore);
    trayIconMenu->addAction(ui->actionClose);
    trayIconMenu->addSeparator();
    trayIconMenu->addAction(ui->actionExit);
    trayIcon->setIcon(QIcon(":/xcalc.svg"));
    trayIcon->setContextMenu(trayIconMenu);
    trayIcon->show();
    ui->tabWidget->setCurrentIndex(0);

    ui->chStayOnTop->setChecked(settings.value("window.stayOnTop",false).toBool());

}

MainWindow::~MainWindow()
{
    delete ui;
}

//events
void MainWindow::changeEvent(QEvent *e)
{
    switch (e->type()) {
    case QEvent::LanguageChange:
        ui->retranslateUi(this);
        break;
    default:
        break;
    }
}
void MainWindow::closeEvent(QCloseEvent *event) {
    /*if (maybeSave()) {
        writeSettings();
        event->accept();
    } else {
        event->ignore();
    }*/
    ui->actionRestore->setVisible(true);
    ui->actionClose->setVisible(false);
    if (settings.value("trayIcon/showBaloon",true).toBool()) {
        trayIcon->showMessage(
        "XCalc",
        tr("The window was closed.\nBut xCalc is still being executed!\nClicke here if you dont want to see this info again!"),
        QSystemTrayIcon::MessageIcon(QSystemTrayIcon::Critical));
    }
}
//SingleInstance messages
void MainWindow::handleSingleInstanceMessage(const QString& message){
    if (message=="restoreWindow"){
        if (isVisible()==false){
            restoreWindow();
        }else{
            QApplication::setActiveWindow(this);
            activateWindow();
            raise();
        }
    }
}
//actions
void MainWindow::openDrawer(){
    QMessageBox::information(this, "", tr("Open the Drawer ;)"));
}
void MainWindow::restoreWindow(){
    ui->actionRestore->setVisible(false);
    ui->actionClose->setVisible(true);
    showNormal();
}
void MainWindow::quit(){
    QApplication::instance()->quit();
}
//tray
void MainWindow::on_trayIcon_activated(QSystemTrayIcon::ActivationReason reason) {
    if (reason == QSystemTrayIcon::DoubleClick) {
        showNormal();
    }
}
void MainWindow::on_trayIcon_messageClicked() {
    settings.setValue("trayIcon/showBaloon",false);
}
//other
void MainWindow::setAllwaysOnTop(bool visible){
    settings.setValue("window.stayOnTop",visible);
    if (visible && !(windowFlags() & Qt::WindowStaysOnTopHint)){
        setWindowFlags(windowFlags() | Qt::WindowStaysOnTopHint);
    }else{
        setWindowFlags(windowFlags() ^ Qt::WindowStaysOnTopHint);
    }

    show();
}
