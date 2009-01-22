OBJECTS_DIR = ../../tmp/panels
MOC_DIR = ../../tmp/panels
RCC_DIR = ../../tmp/panels
DESTDIR = ../../lib
TEMPLATE = lib
CONFIG += static
include(../common.pri)

#RESOURCES  += res.qrc
TRANSLATIONS += ../ts/xCalc_pt.ts

HEADERS += panels_tax.h \
    panels_calc.h \
    calc_commands.h \
    widgets.h
SOURCES += panels_tax.cpp \
    panels_calc.cpp
FORMS += tax.ui \
    calc.ui
#d:\Qt\4.4.3\bin\uic.exe tax.ui -o ui_tax.h

system("$$QMAKE_UIC ../main/mainwindow.ui -o ../main/ui_mainwindow.h")


