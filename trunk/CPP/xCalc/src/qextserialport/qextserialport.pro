PROJECT = qextserialport
TEMPLATE = lib
CONFIG += debug_and_release
CONFIG += qt
CONFIG += warn_on
CONFIG += thread
CONFIG += staticlib
QT -= gui
include(../common.pri)
DEPENDDIR = .
INCLUDEDIR = .
OBJECTS_DIR = ../../tmp/qextserialport
MOC_DIR = ../../tmp/qextserialport
RCC_DIR = ../../tmp/qextserialport
DESTDIR = ../../lib
HEADERS = qextserialbase.h \
    qextserialport.h \
    qextserialenumerator.h \
    qserialprinter.h
SOURCES = qextserialbase.cpp \
    qextserialport.cpp \
    qextserialenumerator.cpp \
    qserialprinter.cpp
unix:HEADERS += posix_qextserialport.h
unix:SOURCES += posix_qextserialport.cpp
unix:DEFINES += _TTY_POSIX_
win32:HEADERS += win_qextserialport.h
win32:SOURCES += win_qextserialport.cpp
win32:DEFINES += _TTY_WIN_
win32:LIBS += -lsetupapi
unix:VERSION = 1.2.0
