<?php


class emailCest
{
    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }

    // tests
    public function tryToTest(UnitTester $I)
    { 
        $email='julyevg@gmail.com';
        $addres='frontend/forget/email_recovery';
        $username='july';
        /*$result=Yii::app()->dpsMailer->sendByView(
				array( $email ),
				$addres, // template email view
				array( 'sUsername' =>$username,
				'sToken'=>$user->token,
				'sLogoPicPath' => Yii::app()->theme->basePath . '/img/logo_mirador_small.jpg',
				'sEmail'=>$this->email)
				);*/
        $I->assertTrue(FALSE,'fail send email');
    }
}
