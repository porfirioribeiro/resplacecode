#ifndef MAINWINDOW_H
#define MAINWINDOW_H

#include <QtGui>
#include <QtCore>
#include <QString>
#include "qproperties.h"
#include "ui_mainwindow.h"

class MainWindow: public QMainWindow {
Q_OBJECT

public:
	QProperties props;
	Ui::MainWindowClass ui;
	QSystemTrayIcon *trayIcon;
	QMenu *trayIconMenu;
	MainWindow(QWidget *parent = 0) :
		QMainWindow(parent) {

		props=QProperties::load(".xCalcrc");
		//QProperties::instance=props;

		trayIconMenu = new QMenu(this);
		trayIcon = new QSystemTrayIcon(this);
		trayIcon->setObjectName("trayIcon");

		ui.setupUi(this);

		trayIconMenu->addAction(ui.actionAbrirGaveta);
		trayIconMenu->addSeparator();
		trayIconMenu->addAction(ui.actionRestore);
		trayIconMenu->addAction(ui.actionClose);
		trayIconMenu->addSeparator();
		trayIconMenu->addAction(ui.actionQuit);
		trayIcon->setIcon(QIcon(":/xcalc.svg"));
		trayIcon->setContextMenu(trayIconMenu);
		trayIcon->show();



	}

	~MainWindow() {
	}

public slots:
	void quit() {
		//QProperties::Instance().save();
		props.save();
		QApplication::instance()->quit();
	}
	void on_trayIcon_activated(QSystemTrayIcon::ActivationReason reason) {
		if (reason == QSystemTrayIcon::DoubleClick) {
			showNormal();
		}
	}
	void on_trayIcon_messageClicked() {
		props.setBool("trayIcon.showbaloon", false);
	}
	void on_chAlwaysOnTop_stateChanged(int state) {
		Qt::WindowFlags flags = Qt::Window;
		if (state == Qt::Checked) {
			flags |= Qt::WindowStaysOnTopHint;
		}
		setWindowFlags(flags);
		this->showNormal();
	}

	void on_actionAbrirGaveta_triggered() {
		QMessageBox::information(this, "", "Abre gaveta ;)");
	}

protected:
	void closeEvent(QCloseEvent *event) {
		/*if (maybeSave()) {
		 writeSettings();
		 event->accept();
		 } else {
		 event->ignore();
		 }*/
		if (props.getBool("trayIcon.showbaloon", true)) {
			trayIcon->showMessage(
					"XCalc",
					"A janela foi fechada.\nMas o XCalc continua em execução!\nClicke aqui para não volta a ver esta informação",
					QSystemTrayIcon::MessageIcon(QSystemTrayIcon::Information));
		}
	}
};

#endif // MAINWINDOW_H
