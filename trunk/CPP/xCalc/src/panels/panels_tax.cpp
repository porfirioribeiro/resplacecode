#include "panels_tax.h"

using namespace Panels;

Tax::Tax(MainWindow *mw) : ui(new Ui::Tax),
    mw(mw){
    //setParent(mw->ui->taxTab);
    mw->ui->tabWidget->insertTab(1,this,tr("Tax"));
    ui->setupUi(this);
    doCalc();
}

Tax::~Tax()
{
    delete ui;
}

void Tax::changeEvent(QEvent *e)
{
    switch (e->type()) {
    case QEvent::LanguageChange:
        ui->retranslateUi(this);
        break;
    default:
        break;
    }
}

void Tax::doCalc() {

    qDebug() << ui->Inicial->value();
    double inicial = ui->Inicial->value();
    double descP = ui->DescP->value();
    double desc = inicial * (descP / 100);
    double descT = inicial - desc;
    double taxP = ui->taxP->currentText().toDouble();
    double tax = descT * (taxP / 100);
    double taxT = descT + tax;
    double lucroP = ui->LucroP->value();
    double lucro = taxT * (lucroP / 100);
    double final = taxT + lucro;

    ui->Desc->setText(QString::number(desc));
    ui->DescT->setText(QString::number(descT));
    ui->tax->setText(QString::number(tax));
    ui->taxT->setText(QString::number(taxT));
    ui->Lucro->setText(QString::number(lucro));
    ui->Final->setText(QString::number(final));
}

