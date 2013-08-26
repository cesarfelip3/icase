<?php  

require_once APP . 'Vendor' . DS . 'Captcha/php-captcha.inc.php';

class CaptchaComponent extends Component 
{ 
    var $controller; 
  
//    function startup( &$controller ) { 
//        $this->controller = &$controller; 
//    } 

    function image(){ 
         
        $imagesPath = realpath(APP . 'Vendor' . DS . 'Captcha').'/fonts/'; 
         
        $aFonts = array( 
            $imagesPath.'VeraBd.ttf', 
            $imagesPath.'VeraBl.ttf', 
            $imagesPath.'VeraMoBd.ttf' 
        ); 
         
        $oVisualCaptcha = new PhpCaptcha($aFonts, 200, 60); 
        $oVisualCaptcha->UseColour(false); 
        //$oVisualCaptcha->SetOwnerText('Source: '.FULL_BASE_URL); 
        $oVisualCaptcha->DisplayShadow(false);
        $oVisualCaptcha->SetNumChars(5); 
        $oVisualCaptcha->SetNumLines(2);
        
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
         
        if (!empty($_SESSION[CAPTCHA_SESSION_ID]) && $userCode == $_SESSION[CAPTCHA_SESSION_ID]) { 
            // clear to prevent re-use 
            unset($_SESSION[CAPTCHA_SESSION_ID]); 
             
            return true; 
        } 
        
        return false;
         
    } 
} 
?>