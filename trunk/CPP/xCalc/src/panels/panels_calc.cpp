#include "panels_calc.h"

using namespace Panels;

#include "calc_commands.h"

Calc::Calc(MainWindow *mw) : ui(new Ui::Calc),
    mw(mw){
    //setParent(mw->ui->calcTab);
    mw->ui->tabWidget->insertTab(0,this,tr("Calc"));
    ui->setupUi(this);
    undoStack=new QUndoStack(this);
    connect(undoStack,SIGNAL(canUndoChanged(bool)),mw->ui->actionUndo,SLOT(setEnabled(bool)));
    connect(undoStack,SIGNAL(canRedoChanged(bool)),mw->ui->actionRedo,SLOT(setEnabled(bool)));
    connect(mw->ui->actionUndo,SIGNAL(triggered()),undoStack,SLOT(undo()));
    connect(mw->ui->actionRedo,SIGNAL(triggered()),undoStack,SLOT(redo()));
    undoStack->push(new CalcCmd::Add(this, 10));
    //ui->listWidget->addItem(
    //ui->listWidget->item(0)->setTextAlignment(Qt::AlignRight);
    //setVisible(true);

}

Calc::~Calc()
{
    delete ui;
}
void Calc::setVisible(bool visible){
    QWidget::setVisible(visible);
    mw->ui->actionUndo->setVisible(visible);
    mw->ui->actionRedo->setVisible(visible);
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
    QToolButton *b = (QToolButton*) sender();
    //ui->lineEdit->insert(b->text());
}


void Calc::addiction(){
}
void Calc::division(){
}
void Calc::equals(){
}
void Calc::multiplication(){
}
void Calc::subtraction(){
}
