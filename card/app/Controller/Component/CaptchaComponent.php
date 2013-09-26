<?php  

require_once APP . 'Vendor' . DS . 'Captcha/php-captcha.inc.php';

class CaptchaComponent extends Component 
{ 
    var $controller; 
    var $session = "captcha_admin";
  
//    function startup( &$controller ) { 
//        $this->controller = &$controller; 
//    } 

    function image(){ 
         
        $imagesPath = realpath(APP . 'Vendor' . DS . 'Captcha').'/fonts/'; 
         
        $aFonts = array( 
            $imagesPath.'VeraBd.ttf', 
            $imagesPath.'VeraIt.ttf', 
            $imagesPath.'Vera.ttf' 
        ); 
         
        $oVisualCaptcha = new PhpCaptcha($aFonts, 200, 60); 
        $oVisualCaptcha->session = $this->session;
        $oVisualCaptcha->UseColour(true); 
        //$oVisualCaptcha->SetOwnerText('Source: '.FULL_BASE_URL); 
        $oVisualCaptcha->SetNumChars(5); 
        $oVisualCaptcha->Create(); 
    } 
     
    function audio(){ 
        $oAudioCaptcha = new AudioPhpCaptcha('/usr/bin/flite', '/tmp/'); 
        $oAudioCaptcha->Create(); 
    } 
     
    function check($userCode, $caseInsensitive = true){ 
        if ($caseInsensitive) { 
            $userCode = strtoupper($userCode); 
        } 
         
        if (!empty($_SESSION[$this->session]) && $userCode == $_SESSION[$this->session]) { 
            // clear to prevent re-use 
            unset($_SESSION[$this->session]); 
             
            return true; 
        } 
        
        return false;
         
    } 
} 
?>