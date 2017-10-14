
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
    public function TestPasswordRecovery(UnitTester $I)
    {
      //$I->assertTrue(FALSE); // recibe una comparacion  saber si es verdadero o falso un resultado 
            
        $personEmail = PersonEmail::model()->find("email = :email", array(":email"=>'july.suarez@koiosoft.com'));                
        $person = Person::model()->findByPk($personEmail->person_id);
        $user = User::model()->find('person_id = :person_id', array(':person_id'=>$personEmail->person_id));                
		if($user)
		{
                    $userExist = true;
                    $getToken=rand(0, 99999);
                    $getTime=date("H:i:s");
                    $user->token  = md5($getToken.$getTime);
                    $data = array('email' => $personEmail->email, 'name' => $person->getFullNameEmail(),'token' =>$user->token ,'url'=>'/home/july_suarez/Documents/projects/koiosoft/mirador/src/web/themes/frontend/img/logo_mirador_small.jpg');
                        if( $user->save(false) )
                        {    
                                $result=Yii::app()->dpsMailer->sendByView(
                                array( $personEmail->email =>$data['email']),
                                'frontend/forget/email_recovery', // template email view
                                array( 'sUsername' =>$data['name'],
                                'sToken'=>$data['token'],
                                'sLogoPicPath' =>$data['url'],
                                'sEmail'=>$data['email'])
                                );
                                $result=TRUE;
                        } 
			
			
		}
                    $I->assertTrue($result,'fail send email');
    }
}
