/*
 * QSerial.h
 *
 *  Created on: 30/Nov/2008
 *      Author: Porfirio
 */

#ifndef QSERIAL_H_
#define QSERIAL_H_

class QSerial {
public:
	QSerial();
	virtual ~QSerial();
	static QSerial* Instance();
	void doIt();
	QMap<QString, BaudRateType> baudRateMap;
	QMap<QString, ParityType> parityMap;
	QMap<QString, DataBitsType> dataBitsMap;
	QMap<QString, StopBitsType> stopBitsMap;

	BaudRateType baudRateFromString(QString baudRate) {
		return baudRateMap.value(baudRate);
	}
	ParityType parityFromString(QString parity) {
		return parityMap.value(parity);
	}
	DataBitsType dataBitsFromString(QString dataBits) {
		return dataBitsMap.value(dataBits);
	}
	StopBitsType stopBitsFromString(QString stopBits) {
		return stopBitsMap.value(stopBits);
	}

private:
	static QSerial* CurrentInstance;

};

#endif /* QSERIAL_H_ */
