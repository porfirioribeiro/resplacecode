# -------------------------------------------------
# Project created by QtCreator 2008-11-20T10:24:26
# -------------------------------------------------
# QT += network opengl script sql svg webkit xml xmlpatterns phonon qtestlib dbus
QT += svg

# TARGET = XCalc
TEMPLATE = app
CONFIG += silent
CONFIG += precompile_header
PRECOMPILED_HEADER = stable.h

# experience
# CONFIG += console
# CONFIG -= app_bundle
# end
OBJECTS_DIR = build/tmp
MOC_DIR = build/tmp
UI_DIR = build/tmp
RCC_DIR = build/tmp
DESTDIR = build
CONFIG(debug, debug|release):TARGET = XCalcd
else:TARGET = XCalc
INCLUDEPATH += properties \
    build/tmp \
    qextserialport \
    panels

# XCalc
SOURCES += properties/QSerial.cpp \
    main.cpp \
    qextserialport/qextserialbase.cpp \
    qextserialport/qextserialport.cpp \
    qextserialport/qextserialenumerator.cpp
HEADERS += properties/QSerial.h \
    panels/serialpanel.h \
    stable.h \
    mainwindow.h \
    properties/qproperties.h \
    qextserialport/qextserialbase.h \
    qextserialport/qextserialport.h \
    qextserialport/qextserialenumerator.h \
    panels/ivapanel.h \
    panels/calcpanel.h \
    panels/widgets.h
FORMS += panels/serialpanel.ui \
    mainwindow.ui \
    panels/ivapanel.ui \
    panels/calcpanel.ui
RESOURCES += res/res.qrc
unix { 
    HEADERS += qextserialport/posix_qextserialport.h
    SOURCES += qextserialport/posix_qextserialport.cpp
    DEFINES += _TTY_POSIX_
    VERSION = 1.2.0
}
win32 { 
    HEADERS += qextserialport/win_qextserialport.h
    SOURCES += qextserialport/win_qextserialport.cpp
    DEFINES += _TTY_WIN_
    LIBS += -lsetupapi
    RC_FILE += res/win.rc
}
