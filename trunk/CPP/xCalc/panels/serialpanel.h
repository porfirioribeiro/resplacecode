#ifndef SERIALPANEL_H
#define SERIALPANEL_H

#include <QtGui/QWidget>
#include <QtCore>
#include "QSerial.h"
#include "qextserialbase.h"
#include "qextserialport.h"
#include "ui_serialpanel.h"

class SerialPanel: public QWidget {
Q_OBJECT

public:
	Ui::SerialPanelClass ui;
	SerialPanel(QWidget *parent = 0) :
		QWidget(parent) {
		ui.setupUi(this);
		ui.comPort->insertItems(0, QStringList()
#ifdef _TTY_WIN_
		<< "COM1"
		<< "COM2"
		<< "COM3"
		<< "COM4"
#else
#ifdef _TTY_POSIX_
		<< "/dev/ttyS0"
		<< "/dev/ttyS1"
		<< "/dev/ttyS2"
		<< "/dev/ttyS3"
#endif
#endif
		);
		//ui.velocMax->insertItems(0,QSerial::Instance()->baudRateMap.keys());
		//ui.bParidade->insertItems(0,QSerial::Instance()->parityMap.keys());
		//ui.bDados->insertItems(0,QSerial::Instance()->dataBitsMap.keys());
		//ui.bParagem->insertItems(0,QSerial::Instance()->stopBitsMap.keys());
	}
	~SerialPanel() {
	}
	QextSerialPort* abrePorta() {
		QextSerialPort *port = new QextSerialPort(ui.comPort->itemText(ui.comPort->currentIndex()));

		port->setBaudRate(QSerial::Instance()->baudRateFromString(ui.velocMax->itemText(ui.velocMax->currentIndex())));
		port->setParity(QSerial::Instance()->parityFromString(ui.bParidade->itemText(ui.bParidade->currentIndex())));
		port->setDataBits(QSerial::Instance()->dataBitsFromString(ui.bDados->itemText(ui.bDados->currentIndex())));
		port->setStopBits(QSerial::Instance()->stopBitsFromString(ui.bParagem->itemText(ui.bParagem->currentIndex())));

		port->open(QIODevice::WriteOnly);

		return port;
	}

public slots:
	void save() {

	}
	void test() {
		QextSerialPort* port=abrePorta();
		if (!port->isOpen() || !port->isWritable()) {
			QMessageBox::critical(this,"Serial","Impossivel abrir esta porta para escrita.\nMude as defenições ou certifique-se que o equipamento está ligado!");
		}else{
		    QString text="A testar a porta...\x0A";//\x0D
		    port->write(text.toAscii(),text.size());
		}
		delete port;
		port=NULL;
	}
	void abrirGaveta() {
		QextSerialPort* port=abrePorta();
		if (!port->isOpen()) {
			QMessageBox::critical(this,"Serial","Impossivel abrir esta porta para escrita.\nMude as defenições ou certifique-se que o equipamento está ligado!");
		}else{
			QByteArray b;
			QStringList l=ui.seqGaveta->text().split(",");
			for (int i=0;i< l.size();i++){
				printf(l.at(i).toAscii());
				b.append(l.at(i).toInt());
			}
		    port->write(b);
		}
		delete port;
		port=NULL;
	}

};

#endif // SERIALPANEL_H
