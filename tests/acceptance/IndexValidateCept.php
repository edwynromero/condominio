<?php 
$I = new AcceptanceTester($scenario);

$I->am('a person');
$I->wantTo('perform actions and see result');
$I->amOnPage('http://mirador_remoto.local/index.php/site/login');
$I->seeCurrentUrlEquals('/index.php/site/login');
$I->see("Mirador Panamericano");
$I->fillField(['name'=>'LoginForm[username]'], 'admin');
$I->fillField(['name'=>'LoginForm[password]'], '12345678');
$I->click('yt0');
$I->seeCurrentUrlEquals('/index.php/backend');
$I->see("Mirador Panamericano - Sistema de Gestión");
$I->amOnPage('http://mirador_remoto.local/index.php/backend/bankAccount/admin');
$I->see("OPERATIONS");
$I->amOnPage('http://mirador_remoto.local/index.php/backend/bankAccountSummary?bank_account_id=1');
$I->amOnPage('http://mirador_remoto.local/index.php/backend/bankAccountSummary/create/bank_account_id/1');
$I->selectOption('BankAccountSummary[year]','2013');
$I->selectOption('BankAccountSummary[month]','2');
$I->click("yt0");