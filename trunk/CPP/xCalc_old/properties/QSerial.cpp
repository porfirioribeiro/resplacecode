/*
 * QSerial.cpp
 *
 *  Created on: 30/Nov/2008
 *      Author: Porfirio
 */

#include "QSerial.h"

QSerial::QSerial() {
	baudRateMap.insert("50", BAUD50);
	baudRateMap.insert("110", BAUD110);
	baudRateMap.insert("134", BAUD134);
	baudRateMap.insert("150", BAUD150);
	baudRateMap.insert("200", BAUD200);
	baudRateMap.insert("300", BAUD300);
	baudRateMap.insert("600", BAUD600);
	baudRateMap.insert("1200", BAUD1200);
	baudRateMap.insert("1800", BAUD1800);
	baudRateMap.insert("2400", BAUD2400);
	baudRateMap.insert("4800", BAUD4800);
	baudRateMap.insert("9600", BAUD9600);
	baudRateMap.insert("14400", BAUD14400);
	baudRateMap.insert("19200", BAUD19200);
	baudRateMap.insert("38400", BAUD38400);
	baudRateMap.insert("56000", BAUD56000);
	baudRateMap.insert("57600", BAUD57600);
	baudRateMap.insert("76800", BAUD76800);
	baudRateMap.insert("115200", BAUD115200);
	baudRateMap.insert("128000", BAUD128000);
	baudRateMap.insert("256000", BAUD256000);

	parityMap.insert("Par", PAR_EVEN);
	parityMap.insert("Ímpar", PAR_ODD);
	parityMap.insert("Nenhum", PAR_NONE);
	parityMap.insert("Marca", PAR_MARK);
	parityMap.insert("Espaço", PAR_SPACE);

	dataBitsMap.insert("5", DATA_5);
	dataBitsMap.insert("6", DATA_6);
	dataBitsMap.insert("7", DATA_7);
	dataBitsMap.insert("8", DATA_8);

	stopBitsMap.insert("1", STOP_1);
	stopBitsMap.insert("1.5", STOP_1_5);
	stopBitsMap.insert("2", STOP_2);

}

QSerial::~QSerial() {
	// TODO Auto-generated destructor stub
}

QSerial* QSerial::CurrentInstance = NULL;

QSerial *QSerial::Instance(){
	if (QSerial::CurrentInstance == NULL) {
		QSerial::CurrentInstance = new QSerial;
	}
	return QSerial::CurrentInstance;
}

void QSerial::doIt(){
	printf("Doing it!");
}




