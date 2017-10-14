<?php


class PersonCest 
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function CreatePersonTest(FunctionalTester $I)
    {
        
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->see('Mirador Panamericano - Sistema de Gestión'); 
        $I->amOnPage('/index.php/backend/person/create');
    
      // crear persona
        $elemen=[
                  'identity_type'=>'V',
                  'first_name'=>'example',
                  'last_name'=>'example2',
                  'identity_code'=>'2157',
                  'Person_group_person_id'=>'2',
                  'full_name'=>'S/N'
                ];
        $I->dontSeeInField(['name' => 'Person[full_name]'], 'Person[full_name]');    
        $I->submitForm(
             '#person-form',
             [
                  'Person' => [ 'identity_type'=>$elemen['identity_type'],
                                'first_name'=>$elemen['first_name'],
                                'last_name'=>$elemen['last_name'],
                                'identity_code'=>$elemen['identity_code'],
                                'group_person_id'=>$elemen['Person_group_person_id'],
                                    
                      ]
             ],
             'submitButton'
         );
        $form = [
                    'Person[identity_type]'=>$elemen['identity_type'],
                    'Person[first_name]'=>$elemen['first_name'],
                    'Person[last_name]'=>$elemen['last_name'],
                    'Person[identity_code]'=>$elemen['identity_code'],
                    'Person[group_person_id]'=>$elemen['Person_group_person_id'],
                    'Person[full_name]'=>$elemen['full_name']
               ];
        $I->submitForm('#person-form', $form, 'submitButton');
// verifica que se guardo 
        $Person=Person::model()->find('identity_code=:identity_code', array(':identity_code'=>$elemen['identity_code']));
        $I->amOnPage('/index.php/backend/person/view/id/'.$Person->id);
        $I->see($Person->identity_code);
        // creacion de correo 
        $I->amOnpage('/index.php/backend/personEmail/admin/person_id/'.$Person->id);
        $I->canSee('Manage Person Emails');
        $I->amOnpage('/index.php/backend/personEmail/create/person_id/'.$Person->id);
        $I->canSee('Create PersonEmail'); 
        $email=['email'=>'july.suarez@koiosoft.com'];
        $I->fillField(['name'=>'PersonEmail[email]'],$email['email']); 
        $I->checkOption('#PersonEmail_is_main');
        // creacion de telefono
        $PersonEmail=PersonEmail::model()->find('person_id=:person_id', array(':person_id'=>$Person->id));
        $I->see($Person->first_name); 
        $I->amOnPage('/index.php/backend/personPhone/admin/person_id/'.$Person->id);
        $I->see('Manage Person Phones');
        $I->amOnPage('/index.php/backend/personPhone/create/person_id/'.$Person->id);
        $I->see('Crear Teléfono');
        $I->see($Person->first_name);
        $data=[
                  'PersonPhone_country_id'=>'46',
                  'PersonPhone_type'=>'P',
                  'prefix'=>'0426',
                  'number'=>'278965',
                  'PersonPhone_is_main'=>TRUE
            ];
        $I->selectOption(['name'=>'PersonPhone[country_id]'],$data['PersonPhone_country_id']);       
        $I->selectOption(['name'=>'PersonPhone[type]'],$data['PersonPhone_type']);
        $I->fillField(['name'=>'PersonPhone[prefix]'],$data['prefix']);
        $I->fillField(['name'=>'PersonPhone[number]'],$data['number']);
        $I->checkOption('#PersonPhone_is_main');
        $I->click(['name'=>'yt0']);   
        $PersonPhone= PersonPhone::model()->find('person_id=:person_id', array(':person_id'=>$Person->id));
        $I->see($data['number']);
        
    }
    

    
    
    public function CreatePersonEmailfailedTest(FunctionalTester $I)
    {
        // creacion de correo fallida datos incorrectos
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->see('Mirador Panamericano - Sistema de Gestión'); 
        $I->amOnPage('/index.php/backend/personEmail/create/person_id/704');
        $I->see('Create PersonEmail');
        $email=['email'=>'july.suarez@koiosoft.com'];
        $I->fillField(['name'=>'PersonEmail[email]'],$email['email']); 
        $I->checkOption('#PersonEmail_is_main');
        $I->click(['name'=>'yt0']);
        $I->see('View PersonEmail');
        $I->amOnPage('/index.php/backend/personPhone/create/person_id/704');
        $I->see('Crear Teléfono');
        
        
          $elemen=[
                    'PersonPhone_country_id'=>'46',
                    'PersonPhone_type'=>'P',
                    'last_name'=>'example2',
                    'PersonPhone_prefix'=>'',
                    'PersonPhone_number'=>'',
                    'PersonPhone_is_main'=>TRUE
              ];
    
     
      $I->submitForm(
             '#person-phone-form',
             [
                  'PersonPhone' => [
                                    'country_id'=>$elemen['PersonPhone_country_id'],
                                    'type'=>$elemen['PersonPhone_type'],
                                    'last_name'=>$elemen['PersonPhone_prefix'],
                                    'prefix'=>$elemen['PersonPhone_number'],
                                    'is_main'=>$elemen['PersonPhone_is_main'],
                                ]
             ],
             'submitButton'
         );
      $I->canSee('Prefix no puede ser nulo.');
      $I->canSee('Número no puede ser nulo.');   
      
     
    }
    
    
    public function CreateNumberFaild(FunctionalTester $I)
    { // creacion de numero telefonico
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->see('Mirador Panamericano - Sistema de Gestión'); 
        $I->amOnPage('/index.php/backend/personPhone/create/person_id/704');
        $I->see('Crear Teléfono');      
        $elemen=[
                    'PersonPhone_country_id'=>'46',
                    'PersonPhone_type'=>'P',
                    'last_name'=>'example2',
                    'PersonPhone_prefix'=>'0426',
                    'PersonPhone_number'=>'2969571',
                    'PersonPhone_is_main'=>TRUE
               ];
       $I->submitForm(
             '#person-phone-form',
             [
                  'PersonPhone' => [
                                    'country_id'=>$elemen['PersonPhone_country_id'],
                                    'type'=>$elemen['PersonPhone_type'],
                                    'prefix'=>$elemen['PersonPhone_prefix'],
                                    'number'=>$elemen['PersonPhone_number'],
                                    'is_main'=>$elemen['PersonPhone_is_main'],
                                ]
             ],
             'submitButton'
         );
      
      
       $form = [
                'PersonPhone[country_id]'=>$elemen['PersonPhone_country_id'],
                'PersonPhone[type]'=>$elemen['PersonPhone_type'],
                'PersonPhone[prefix]'=>$elemen['PersonPhone_prefix'],
                'PersonPhone[number]'=>$elemen['PersonPhone_number'],
                'PersonPhone[prefix]'=>$elemen['PersonPhone_is_main'],
            ];
      $I->submitForm('#person-phone-form', $form, 'submitButton');
      $I->see('View PersonPhone ');
      
    }
    
    public function CreateOwnerTest(FunctionalTester $I)
    { // creacion de parcela
        
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->see('Mirador Panamericano - Sistema de Gestión');
        $I->amOnPage('/index.php/backend/owner/create');
        $I->canSee('Crear Propietario');
        $elemen=[
                  'location_id'=>'',
                  'Owner_person_id'=>'',
                  'Owner_begin_date'=>'',
                 
             ];
        $I->submitForm(
           '#owner-form',
           [
                'Owner' => [
                                  'location_id'=>$elemen['location_id'],
                                  'person_id'=>$elemen['Owner_person_id'],
                                  'begin_date'=>$elemen['Owner_begin_date'],
                                  
                              ]
           ],
           'submitButton'
         ); 
        
        $I->canSee('Parcela no puede ser nulo.');
        $elemen=[
                  'location_id'=>'2',
                  'Owner_person_id'=>'690',
                  'Owner_begin_date'=>'20/02/2017',
                 
             ];
        $I->submitForm(
           '#owner-form',
           [
                'Owner' => [
                            'location_id'=>$elemen['location_id'],
                            'person_id'=>$elemen['Owner_person_id'],
                            'begin_date'=>$elemen['Owner_begin_date'],
                                  
                            ]
           ],
           'submitButton'
         );
      
      
       $form = [
                   'Owner[location_id]'=>$elemen['location_id'],
                   'Owner[person_id]'=>$elemen['Owner_person_id'],
                   'Owner[begin_date]'=>$elemen['Owner_begin_date'],
               ];
      $I->submitForm('#owner-form', $form, 'submitButton');
      $I->see('Ver Propietario');
      $Owner=Owner::model()->find('person_id=person_id',array(':person_id'=>$elemen['location_id']));
     // print_r($Owner->attributes);
      $I->see('Ver Propietario #');
            
    
    }
    
    
    
    public function CreateGroupPeopleTes(FunctionalTester $I)
    {
        
        
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->see('Mirador Panamericano - Sistema de Gestión');
        $I->amOnPage('/index.php/backend/groupPerson/create'); 
        $I->canSee('Crear Grupo de Personas');
        $elemen=[
                  'name'=>'690',
                  'type'=>'F',
                  'active'=>TRUE
                ];
        $I->submitForm(
           '#group-person-form',
           [
            'GroupPerson' => [
                                'name'=>$elemen['name'],
                                'type'=>$elemen['type'],
                                'active'=>$elemen['active'],
                            ]
           ],
           'submitButton'
         );
      
      
       $form = [
                   'GroupPerson[name]'=>$elemen['name'],
                   'GroupPerson[type]'=>$elemen['type'],
            ];
       $I->submitForm('#group-person-form', $form, 'submitButton');
       $I->canSee('Ver Grupo de Personas');
       
        
    }
    
    
    public function RequestUserTest(FunctionalTester $I)
    {     
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->see('Mirador Panamericano - Sistema de Gestión');
        $I->amOnPage('/index.php/backend/person/create');
        // persona
        $person=[
                  'identity_type'=>'V',
                  'first_name'=>'prue',
                  'last_name'=>'prueba',
                  'identity_code'=>'2157',
                  'Person_group_person_id'=>'2',
                  'full_name'=>'S/N',
                  'Person[active]'=>TRUE
                ];

         $form = [
                    'Person[first_name]'=>$person['identity_type'],
                    'Person[last_name]'=>$person['first_name'],
                    'Person[last_name]'=>$person['last_name'],
                    'Person[identity_code]'=>$person['identity_code'],
                    'Person[full_name]'=>$person['full_name'],
                    'Person[group_person_id]'=>$person['Person_group_person_id'],
                    'Person[active]'=>$person['Person[active]']
               ];
        $I->submitForm('#person-form', $form, 'submitButton');
        $I->see('Ver Persona ');
        $People=Person::model()->find('identity_code=:identity_code', array(':identity_code'=>$person['identity_code']));
        /// phone 
          $I->amOnPage('/index.php/backend/personPhone/create/person_id/'.$People->id);
            $I->see('Crear Teléfono');      
            $phone=[
                        'PersonPhone_country_id'=>'46',
                        'PersonPhone_type'=>'P',
                        'last_name'=>'example2',
                        'PersonPhone_prefix'=>'0426',
                        'PersonPhone_number'=>'2969571',
                        'PersonPhone_is_main'=>TRUE
                   ];
            $I->submitForm(
                 '#person-phone-form',
                 [
                      'PersonPhone' => [
                                        'country_id'=>$phone['PersonPhone_country_id'],
                                        'type'=>$phone['PersonPhone_type'],
                                        'prefix'=>$phone['PersonPhone_prefix'],
                                        'number'=>$phone['PersonPhone_number'],
                                        'is_main'=>$phone['PersonPhone_is_main'],
                                    ]
                 ],
                 'submitButton'
             );
        /// email 
        $I->amOnPage('/index.php/backend/personEmail/create/person_id/'.$People->id);
        $I->see('Create PersonEmail');
        $email=['email'=>'july.suarez@koiosoft.com'];
        $I->fillField(['name'=>'PersonEmail[email]'],$email['email']); 
        $I->checkOption('#PersonEmail_is_main');
        $I->click(['name'=>'yt0']);
    // solicitud de usuario   
        $elemen=[
                'identity_type'=>'V',
                'identity_code'=>'2157',
                'first_name'=>'prue',
		'last_name'=>'prueba',
		'full_name'=>'prue',
		'status'=>'0', 
		'reference'=>'sss', 
                'phone_prefix'=>'0426',
                'phonefirst_name_prefix'=>'0426',
		'phone_number'=>'2969581',
		'phone_type'=>'P',
		'person_email'=>'ju@gmmail.com',
                'person_email_confirm'=>'ju@gmmail.com',
                'user_name'=>'dd',
		'user_password'=>'Abc123',
                'user_password_confirm'=>'Abc123',
              ];
         $I->amOnPage('/index.php/backend/registerRequest/create');
         $I->canSee('Crear Solicitud de Registro'); 
         $form = [
                    'RegisterRequest[identity_type]'=>$elemen['identity_type'],
                    'RegisterRequest[identity_code]'=>$person['identity_code'],
                    'RegisterRequest[first_name]'=>$person['first_name'],
                    'RegisterRequest[last_name]'=>$person['last_name'],
                    'RegisterRequest[full_name]'=>$elemen['full_name'],
                    'RegisterRequest[identity_code]'=>$person['identity_code'],
                    'RegisterRequest[identity_type]'=>$elemen['identity_type'],
                    'RegisterRequest[status]'=>$elemen['status'], 
                    'RegisterRequest[reference]'=>$elemen['reference'], 
                    'RegisterRequest[phonefirst_name_prefix]'=>$elemen['phonefirst_name_prefix'],
                    'RegisterRequest[phone_prefix]'=>$elemen['phone_prefix'],   
                    'RegisterRequest[phone_number]'=>$elemen['phone_number'],
                    'RegisterRequest[phone_type]'=>$elemen['phone_type'],
                    'RegisterRequest[person_email]'=>$elemen['person_email'], 
                    'RegisterRequest[person_email_confirm]'=>$elemen['person_email_confirm'],
                    'RegisterRequest[user_name]'=>$elemen['user_name'],
                    'RegisterRequest[user_password]'=>$elemen['user_password'],
                    'RegisterRequest[user_password_confirm]'=>$elemen['user_password_confirm']
               ];
        $I->submitForm('#register-request-form', $form, 'submitButton');
       
        $RegisterRequest=RegisterRequest::model()->find('identity_code=:identity_code', array(':identity_code'=>$elemen['identity_code']));
        $I->see($person['identity_code']);
        $I->amOnPage('/index.php/backend/registerRequest/beginProcessRequest/id/'.$RegisterRequest->id);
        $I->canSee('Begin Process Register Request');
        $I->click(['name'=>'yt0']);
        $I->canSee('Process Register Request');
        $I->checkOption('#confirm');
        $I->canSee('solicitud');
        

    }
    
    
    public function ResidentTest(FunctionalTester $I){
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->see('Mirador Panamericano - Sistema de Gestión');
        $I->amOnPage('/index.php/backend/residentAssociation/admin');
        $I->canSee('Administrar Junta Directiva');
        $I->amOnPage('/index.php/backend/residentAssociation/create');
        
           $elemen=[
                    'person_id'=>'750',
                    'association_position_id'=>'1',
                    ];
         $form = [
                    'ResidentAssociation[person_id]'=>$elemen['person_id'],
                    'ResidentAssociation[association_position_id]'=>$elemen['association_position_id'],
                 ];
        $I->submitForm('#resident-association-form', $form, 'submitButton');
        $ResidentAssociation=ResidentAssociation::model()->find('person_id=:person_id', array(':person_id'=>$elemen['person_id']));
        if($ResidentAssociation){
            $I->see('Miembro Junta Directiva');
        }

    }
    
}
    