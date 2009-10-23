
QT              += svg #network opengl script sql svg webkit xml xmlpatterns phonon qtestlib dbus
CONFIG		*= qt
QT		*= core network
CONFIG		+= debug_and_release
CONFIG		*= qt thread warn_on
CONFIG		-= exceptions rtti

CONFIG(debug, debug|release){
    TARGET    = XCalcd
    DEFINES  += QT_DEBUG
}else{
    TARGET    = XCalc
    DEFINES  += QT_RELEASE
    CONFIG   += static
    QTPLUGIN += qsvg
}


OBJECTS_DIR = ../../tmp/main
MOC_DIR     = ../../tmp/main
RCC_DIR     = ../../tmp/main
DESTDIR     = ../../build

TRANSLATIONS += ../ts/xCalc_pt.ts

HEADERS    += mainwindow.h
SOURCES    += mainwindow.cpp \
              main.cpp
FORMS      += mainwindow.ui
RESOURCES  += ../res/res.qrc
RC_FILE    += ../res/win.rc

include(../common.pri)

LIBS  += -L../../lib -lpanels -lqextserialport -lsingleapplication

#win32:LIBS             += -lsetupapi
unix:DEFINES += _TTY_POSIX_
win32:DEFINES += _TTY_WIN_
