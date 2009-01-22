
OBJECTS_DIR = ../../tmp/singleapplication
MOC_DIR = ../../tmp/singleapplication
RCC_DIR = ../../tmp/singleapplication
DESTDIR = ../../lib
TEMPLATE = lib
CONFIG += static


include(../common.pri)
HEADERS += singleapplication.h singleapplication_p.h
SOURCES += singleapplication.cpp
