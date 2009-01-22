INCLUDEPATH +=../panels
INCLUDEPATH +=../qextserialport
INCLUDEPATH +=../singleapplication
INCLUDEPATH +=../main

#OBJECTS_DIR = ../../tmp/$$TARGET
#MOC_DIR     = ../../tmp/$$TARGET
#RCC_DIR     = ../../tmp/$$TARGET

unix:DEFINES += _TTY_POSIX_
win32:DEFINES += _TTY_WIN_


contains(TEMPLATE, lib){
    # Force Relink when we change a library project
    QMAKE_POST_LINK = $$QMAKE_DEL_FILE ..\..\build\xCalc*
}
