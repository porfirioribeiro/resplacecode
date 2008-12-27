#ifndef CALCPANEL_H
#define CALCPANEL_H

#include <QtGui>
#include "ui_calcpanel.h"

class CalcPanel: public QWidget {
Q_OBJECT

public:
	explicit CalcPanel(QWidget *parent = 0) :
		QWidget(parent) {
		ui.setupUi(this);
	}

public slots:
	void pressNumber() {
		QToolButton *b = (QToolButton*) sender();

		QMessageBox::information(this, "", b->text());
		//ui.input.setText(b->text());
		ui.input->setText(ui.input->text() + b->text());
	}
	void actionTyped(int act) {

	}

protected:
	virtual void changeEvent(QEvent *e) {
		switch (e->type()) {
		case QEvent::LanguageChange:
			ui.retranslateUi(this);
			break;
		default:
			break;
		}
	}

private:
	Ui::CalcPanel ui;
};

#endif // CALCPANEL_H
