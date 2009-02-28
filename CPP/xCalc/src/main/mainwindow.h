#ifndef MAINWINDOW_H
#define MAINWINDOW_H

#include <QtGui>

namespace Panels{
    class Calc;
    class Tax;
}

namespace Ui{
    class MainWindow ;
}

class MainWindow : public QMainWindow {
    Q_OBJECT
    //Q_DISABLE_COPY(MainWindow)
public:
    QSystemTrayIcon *trayIcon;
    QMenu *trayIconMenu;
    QSettings settings;
    explicit MainWindow(QWidget *parent = 0);
    virtual ~MainWindow();
    Ui::MainWindow *ui;
    Panels::Calc *calcPanel;
    Panels::Tax *taxPanel;

protected:
    virtual void changeEvent(QEvent *e);
    void closeEvent(QCloseEvent *event);

public slots:
    void handleSingleInstanceMessage(const QString& message);
    void setAllwaysOnTop(bool);
    //actions
    void openDrawer();
    void quit();
    void restoreWindow();
    //tray
    void on_trayIcon_activated(QSystemTrayIcon::ActivationReason reason);
    void on_trayIcon_messageClicked();
};
#include "ui_mainwindow.h"
#endif // MAINWINDOW_H
