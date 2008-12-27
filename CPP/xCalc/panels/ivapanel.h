#ifndef IVAPANEL_H
#define IVAPANEL_H

#include <QtGui>
#include "ui_ivapanel.h"

class IvaPanel: public QWidget {
Q_OBJECT
	Q_DISABLE_COPY(IvaPanel)

public:
	explicit IvaPanel(QWidget *parent = 0) :
		QWidget(parent) {
		ui.setupUi(this);
		doCalc();
	}

public slots:
	void doCalc() {
		double inicial = ui.iva_Inicial->value();
		double descP = ui.iva_DescP->value();
		double desc = inicial * (descP / 100);
		double descT = inicial - desc;
		double ivaP = ui.iva_IvaP->currentText().toDouble();
		double iva = descT * (ivaP / 100);
		double ivaT = descT + iva;
		double lucroP = ui.iva_LucroP->value();
		double lucro = ivaT * (lucroP / 100);
		double final = ivaT + lucro;

		ui.iva_Desc->setText(QString::number(desc));
		ui.iva_DescT->setText(QString::number(descT));
		ui.iva_Iva->setText(QString::number(iva));
		ui.iva_IvaT->setText(QString::number(ivaT));
		ui.iva_Lucro->setText(QString::number(lucro));
		ui.iva_Final->setText(QString::number(final));
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
	Ui::IvaPanel ui;
};

#endif // IVAPANEL_H
