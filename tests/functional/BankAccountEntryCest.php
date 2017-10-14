<?php


class BankAccountEntryCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->amOnPage('index.php');
        $I->seeCurrentUrlEquals('/index.php/site/login');
        $I->canSee('acceso privado');
        $I->fillField(['name'=>'LoginForm[username]'], "admin");
        $I->fillField(['name'=>'LoginForm[password]'], "12345678");
        $I->click('yt0');
        $I->seeCurrentUrlEquals('/index.php/backend');
        

    }
}
