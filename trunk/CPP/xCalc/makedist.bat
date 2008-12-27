@echo off
call clean
cls
echo ==Setup envoirement>compile.log
echo ==Setup envoirement
set QTCDIR=D:\QtCreator
set QTDIR=%QTCDIR%\qt
set APPNAME=XCalc

set PATH=%QTCDIR%\mingw\bin;%QTDIR%\bin


echo ==Make project>>compile.log
echo ==Make project

echo ===QMake>>compile.log
qmake>>compile.log
echo ===Make>>compile.log
mingw32-make release>>compile.log

echo ==Clean compile garbage>>compile.log
echo ==Clean compile garbage
mingw32-make release-clean>>compile.log



rmdir /S /Q build\tmp>>compile.log
rmdir /S /Q build\debug>>compile.log
del Makefile*>>compile.log
del object_script.XCalc.*>>compile.log
del XCalc.pro.user>>compile.log

cd build

echo ==Copy Dll's>>..\compile.log
echo ==Copy Dll's
copy %QTCDIR%\mingw\bin\mingwm10.dll>>..\compile.log
copy %QTDIR%\bin\QtCore4.dll>>..\compile.log
copy %QTDIR%\bin\QtGui4.dll>>..\compile.log
copy %QTDIR%\bin\QtSvg4.dll>>..\compile.log
set path=
echo Run %APPNAME%>>..\compile.log
echo -=%APPNAME% Output=-
%APPNAME%
cd ..
echo ==All done!>>compile.log
echo ==All done!


pause
@echo on