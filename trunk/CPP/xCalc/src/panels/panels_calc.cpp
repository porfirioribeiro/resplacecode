#include "panels_calc.h"

using namespace Panels;

#include "calc_commands.h"

Calc::Calc(MainWindow *mw) : ui(new Ui::Calc), mw(mw), displayNumber(0), currentValue(0){
    //setParent(mw->ui->calcTab);
    mw->ui->tabWidget->insertTab(0,this,tr("Calc"));
    ui->setupUi(this);
    undoStack=new QUndoStack(this);
    connect(undoStack,SIGNAL(canUndoChanged(bool)),mw->ui->actionUndo,SLOT(setEnabled(bool)));
    connect(undoStack,SIGNAL(canRedoChanged(bool)),mw->ui->actionRedo,SLOT(setEnabled(bool)));
    //connect(undoStack,SIGNAL(redoTextChanged(QString)),mw->ui->actionRedo,SLOT(setToolTip(QString)));

    connect(mw->ui->actionUndo,SIGNAL(triggered()),undoStack,SLOT(undo()));
    connect(mw->ui->actionRedo,SIGNAL(triggered()),undoStack,SLOT(redo()));


    //undoStack->push(new CalcCmd::Add(this, 10));

}

Calc::~Calc()
{
    delete ui;
}

//override default action
void Calc::setVisible(bool visible){
    QWidget::setVisible(visible);
    mw->ui->undoRedoToolbar->setVisible(visible);
}

void Calc::changeEvent(QEvent *e)
{
    switch (e->type()) {
    case QEvent::LanguageChange:
        ui->retranslateUi(this);
        break;
    default:
        break;
    }
}


void Calc::clickNumber(){
    if (QToolButton *btn = qobject_cast<QToolButton*>(sender())){
        ui->lineEdit->insert(btn->text());
    }
}
void Calc::backSpace(){
    QString str=ui->lineEdit->text();
    ui->lineEdit->setText(str.left(str.size()-1));
}

void Calc::clear(){
    if (ui->lineEdit->text().size()==0){
        //clean everything
    }else{
        ui->lineEdit->setText("");
    }
}

void Calc::addiction(){
    if (lastCommand==NULL){

    }
    undoStack->push(lastCommand);

    lastCommand=new CalcCmd::Add(this, displayNumber);
    ui->lineEdit->clear();
}
void Calc::division(){
    undoStack->push(new CalcCmd::Divide(this, displayNumber));
    ui->lineEdit->clear();
}
void Calc::equals(){
    qDebug() << currentValue;
    //undoStack->push(new CalcCmd::Equals(this, currentValue));
    ui->lineEdit->clear();
}
void Calc::multiplication(){
    undoStack->push(new CalcCmd::Multiply(this, displayNumber));
    ui->lineEdit->clear();
}
void Calc::subtraction(){
    undoStack->push(new CalcCmd::Subtract(this, displayNumber));
    ui->lineEdit->clear();
}

void Panels::Calc::on_lineEdit_textChanged(QString str)
{
    displayNumber=str.toFloat();
}
