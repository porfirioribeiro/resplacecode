#ifndef QPROPERTIES_H
#define QPROPERTIES_H

#include <QMap>
#include <QString>
#include <QFile>
#include <QDataStream>

class QProperties {
protected:
	QProperties(QMap<QString, QString> map) {
		this->map = map;
	}

public:
	QProperties() {
	}

	QMap<QString, QString> map;//TODO make protected
	QString fileName;
	static QProperties load(QString fileName) {
		QProperties p;
		QMap<QString, QString> map;
		if (fileName.isEmpty())
			return p;
		else {
			p.fileName = fileName;
			QFile file(fileName);
			if (!file.open(QIODevice::ReadOnly)) {
				return p;
			}
			QDataStream in(&file);
			in.setVersion(QDataStream::Qt_4_4);
			in >> map;
			p = map;
			return p;
		}
	}
	bool save(QString fileName) {
		QFile file(fileName);
		if (!file.open(QIODevice::WriteOnly)) {
			//QMessageBox::information(map, tr("Unable to open file"),file.errorString());
			return false;
		}
		QDataStream out(&file);
		out.setVersion(QDataStream::Qt_4_4);
		out << this->map;

		return true;
	}
	bool save() {
		return this->save(this->fileName);
	}

	int count() {
		return map.count();
	}

	//get
	QString getString(QString key, QString defaultValue) {
		return map.value(key, defaultValue);
	}
	bool getBool(QString key, bool defaultValue) {
		return (map.value(key, defaultValue ? "true" : "false") == "true");
	}
	int getInt(QString key, int defaultValue) {
		return getString(key, QString::number(defaultValue)).toInt();
	}
	double getDouble(QString key, double defaultValue) {
		return getString(key, QString::number(defaultValue)).toDouble();
	}
	float getFloat(QString key, float defaultValue) {
		return getString(key, QString::number(defaultValue)).toFloat();
	}
	//set
	void setString(QString key, QString value) {
		map.remove(key);
		map.insert(key, value);
	}
	void setBool(QString key, bool v) {
		setString(key, v ? "true" : "false");
	}
	void setInt(QString key, int v) {
		setString(key, QString::number(v));
	}
	void setDouble(QString key, double v) {
		setString(key, QString::number(v));
	}
	void setFloat(QString key, float v) {
		setString(key, QString::number(v));
	}
};

#endif // QPROPERTIES_H
