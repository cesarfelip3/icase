<?php
class RegistersController extends AppController {

public function index() {
    // Has any form data been POSTed?
    if ($this->request->is('post')) {
        // If the form data can be validated and saved...
        if ($this->Register->save($this->request->data)) {
            // Set a session flash message and redirect.
            $this->Session->setFlash('Recipe Saved!');
            $this->redirect('/login');
        }
    }


}



/*
    public function index() {
	error_reporting(-1);
	ini_set('display_errors', 'On');
    }
*/
}