<?php

class OS_Navigateur {
    
    private $agt;
    private $new_agt;
    private $lvc_agent_max_length = 300;
            
    function __construct($agt = null) {
        $this->agt = $agt;
    }
            
    function Analyse_agent() {
        
	$this->agt = strtr($this->agt, '+', ' ');
        
        // AOL Explorer
	if( strpos($this->agt, 'AOL') !== FALSE ){
            $this->Aol();
	}
	// Internet Explorer
	elseif(	strpos($this->agt, 'MSIE') !== FALSE && strpos($this->agt, 'Opera' ) === FALSE ){
            $this->IE();
	}
	// Opera
	elseif(	strpos($this->agt, 'Opera') !== FALSE ){
            $this->Opera();
	}
	// Netscape 4.x
	elseif(	strpos($this->agt, 'Mozilla/4.') !== FALSE ){
            $this->Netscape();
	}
	// Safari
	elseif(	strpos($this->agt, 'Safari') !== FALSE ){
            $this->Safari();
	}
	// Firefox
	elseif(	strpos($this->agt, 'Firefox') !== FALSE ){
            $this->Firefox();
	}
	// NS 6
	elseif(	strpos($this->agt, 'Netscape') !== FALSE && strpos($this->agt, 'Konqueror') === FALSE ){
            $this->NS6();
	}
	// MOZILLA
	elseif(	strpos($this->agt, 'Gecko') !== FALSE ){
            $this->Mozilla();
	}
	// others
	else{
		$this->new_agt = $this->agt;
		for (@reset($lvc_other_agt), $ok = false; (list($key, $value) = @each($lvc_other_agt)) && !$ok;)
		{
			if ($ok = strpos($this->agt, $key))
			$this->new_agt = $value;
		}
	}
	
	$this->new_agt = strip_tags($this->new_agt);
        
        $this->Robots();
        
        
	
	if (strlen($this->new_agt) > $this->lvc_agent_max_length)
	$this->new_agt = substr($this->new_agt, 0, $lvc_agent_max_length-4).' ...';
	
	return($this->new_agt);
    }
    
    /**
     * Fonctions privées
     */
    
    
    private function Aol() {
        $this->new_agt = 'AOL Explorer';
        $this->agt = strtr($this->agt, '_', ' ');
        for ($cnt = 0, $ok = false; $cnt < sizeof($lvc_agent_versions['AOL']) && !$ok; $cnt++)
        {
                if ($ok = strpos($this->agt, $lvc_agent_versions['AOL'][$cnt]))
                {
                        $this->new_agt .= '-'.$lvc_agent_versions['AOL'][$cnt];
                        for (@reset($lvc_agent_os['AOL']), $ok = false; (list($key, $value) = @each($lvc_agent_os['AOL'])) && !$ok;)
                        {
                                if ($ok = ereg($key, $this->agt))
                                        $this->new_agt .= '  '.$value;
                        }
                }
        }
        if (!$ok) $this->new_agt = $this->agt;
    }
    private function IE() {
        $this->new_agt = 'IE';
        $this->new_agt .= '-'.preg_replace('`^.*MSIE ([0-9]*(\.[0-9]*)*).*$`si','$1',$this->agt);

        for (@reset($lvc_agent_os['IE']), $ok = false; (list($key, $value) = @each($lvc_agent_os['IE'])) && !$ok;)
        {
                if ($ok = ereg($key, $this->agt))
                        $this->new_agt .= '  '.$value;
        }
        
    }
    private function Opera() {
        $this->new_agt = 'Opera';
        $this->new_agt .= '-'.preg_replace('`^.*Version/([0-9]*(\.[0-9]*)*).*$`si','$1',$this->agt);

        for (@reset($lvc_agent_os['OP']), $ok = false; (list($key, $value) = @each($lvc_agent_os['OP'])) && !$ok;)
        {
                if ($ok = ereg($key, $this->agt))
                        $this->new_agt .= '  '.$value;
        }
    }
    private function Netscape() {
        $this->new_agt = 'NS';
        for ($cnt = 0, $ok = false; $cnt < sizeof($lvc_agent_versions['NS']) && !$ok; $cnt++)
        {
                if ($ok = strpos($this->agt, $lvc_agent_versions['NS'][$cnt]))
                {
                        $this->new_agt .= '-'.$lvc_agent_versions['NS'][$cnt];
                        for (@reset($lvc_agent_os['NS']), $ok = false; (list($key, $value) = @each($lvc_agent_os['NS'])) && !$ok;)
                        {
                                if ($ok = ereg($key, $this->agt))
                                        $this->new_agt .= '  '.$value;
                        }
                }
        }
        if (!$ok) $this->new_agt = $this->agt;
        
    }
    private function Safari() {
        $this->new_agt = 'Safari';
        $this->new_agt .= '-'.preg_replace('`^.*Version/([0-9]*(\.[0-9]*)*).*$`si','$1',$this->agt);

        for (@reset($lvc_agent_os['Safari']), $ok = false; (list($key, $value) = @each($lvc_agent_os['Safari'])) && !$ok;)
        {
                if ($ok = ereg($key, $this->agt))
                $this->new_agt .= '  '.$value;
        }
        
    }
    private function Firefox() {
        $this->new_agt = 'Firefox';
        $this->new_agt .= '-'.preg_replace('`^.*Firefox/([0-9]*(\.[0-9]*)*).*$`si','$1',$this->agt);

        for (@reset($lvc_agent_os['Firefox']); (list($key, $value) = @each($lvc_agent_os['Firefox'])) && !$ok;)
        {
                if ($ok = ereg($key, $this->agt))
                        $this->new_agt .= '  '.$value;
        }
        
    }
    private function NS6() {
        $this->new_agt = 'Netscape';
        for ($cnt = 0, $ok = false; $cnt < sizeof($lvc_agent_versions['NS6']) && !$ok; $cnt++)
        {
                if ($ok = strpos($this->agt, $lvc_agent_versions['NS6'][$cnt]))
                {
                        $this->new_agt .= '-'.$lvc_agent_versions['NS6'][$cnt];
                        for (@reset($lvc_agent_os['NS']), $ok = false; (list($key, $value) = @each($lvc_agent_os['NS'])) && !$ok;)
                        {
                                if ($ok = ereg($key, $this->agt))
                                        $this->new_agt .= '  '.$value;
                        }
                }
        }
        if (!$ok) $this->new_agt = $this->agt;
        
    }
    private function Mozilla() {
        $this->new_agt = 'Mozilla';
        for ($cnt = 0, $ok = false; $cnt < sizeof($lvc_agent_versions['Mozilla']) && !$ok; $cnt++)
        {
                if ($ok = strpos($this->agt, $lvc_agent_versions['Mozilla'][$cnt]))
                {
                        $this->new_agt .= '-'.$lvc_agent_versions['Mozilla'][$cnt];
                        for (@reset($lvc_agent_os['Mozilla']), $ok = false; (list($key, $value) = @each($lvc_agent_os['Mozilla'])) && !$ok;)
                        {
                                if ($ok = ereg($key, $this->agt))
                                        $this->new_agt .= '  '.$value;
                        }
                }
        }
        if (!$ok) $this->new_agt = $this->agt;
    }
    
    private function Robots() {
        
	//===================================================
	if(	$this->new_agt=='Mediapartners-Google/2.1')
		$this->new_agt='<span class="robot">Mediapartners</span>';
		
	//===================================================
	elseif(	strpos($this->new_agt, 'Googlebot/2.1') )
		$this->new_agt='<span class="robot">Robot Googlebot 2.1</span>';
		
	//===================================================
	elseif(	strpos($this->new_agt, 'VoilaBot BETA 1.2') )
		$this->new_agt='<span class="robot">Robot VoilaBot BETA 1.2</span>';
		
	//===================================================
	elseif(	strpos($this->new_agt, 'Teoma')
		||	$this->new_agt=='Mozilla/2.0 (compatible; Ask Jeeves/Teoma; http://sp.ask.com/docs/about/tech_crawling.html)')
		$this->new_agt=='<span class="robot">Teoma Robot</span>';
		
	//===================================================
	elseif(	$this->new_agt=='Mozilla/4.0 compatible ZyBorg/1.0 (wn-12.zyborg@looksmart.net; http://www.WISEnutbot.com)'
		||	$this->new_agt=='Mozilla/4.0 compatible ZyBorg/1.0 (wn-14.zyborg@looksmart.net; http://www.WISEnutbot.com)'
		||	$this->new_agt=='Mozilla/4.0 compatible ZyBorg/1.0 Dead Link Checker (wn.dlc@looksmart.net; http://www.WISEnutbot.com)')
		$this->new_agt='<span class="robot">Robot Looksmart v1.0</span>';


	//===================================================
	elseif(	$this->new_agt=='Mozilla/4.0 (compatible; grub-client-2.6.1)'
		||	$this->new_agt=='Mozilla/4.0 (compatible; grub-client-2.6.0)')
		$this->new_agt='<span class="robot">Robot Looksmart</span>';
		
	//===================================================
	elseif(	$this->new_agt=='Mozilla/4.0 (compatible; Cerberian Drtrs Version-3.2-Build-0)')
		$this->new_agt='<span class="robot">Robot Cerberian</span>';
		
	//===================================================

	elseif(	$this->new_agt=='Mozilla/5.0 (compatible; BecomeBot/2.0.3; http://www.become.com/webmasters.html)')
		$this->new_agt='<span class="robot">Become Robot 2.0.3</span>';
		
	//===================================================
	elseif(	$this->new_agt=='Mozilla/5.0 (compatible; BecomeBot/3.0; MSIE 6.0 compatible; http://www.become.com/site owners.html)')
		$this->new_agt='<span class="robot">BecomeBot 3.0</span>';
		
	//===================================================

	elseif(	$this->new_agt=='Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)')
		$this->new_agt='<span class="robot">Robot Yahoo</span>';
		
	//===================================================
	elseif(	$this->new_agt=='Mozilla/5.0 (compatible; Yahoo! Slurp China; http://misc.yahoo.com.cn/help.html)')
		$this->new_agt='<span class="robot">Robot Yahoo China</span>';
		
	//===================================================
	elseif(	strpos($this->new_agt, 'Exabot/3.0') )
		$this->new_agt='<span class="robot">Exabot 3.0</span>';
		
	//===================================================
	elseif(	$this->new_agt=='TurnitinBot/2.0 http://www.turnitin.com/robot/crawlerinfo.html')
		$this->new_agt='<span class="robot">Robot Turnitin 2.0</span>';
		
	//===================================================
	elseif(	$this->new_agt=='ia_archiver')
		$this->new_agt='<span class="robot">Alexa Robot (ia_archiver)</span>';

	//===================================================
	elseif(	$this->new_agt=='appie 1.1 (www.walhello.com)')
		$this->new_agt='<span class="robot">Robot Walhello </span>';
		
	//===================================================
	elseif(	$this->new_agt=='ConveraCrawler/0.4')
		$this->new_agt='<span class="robot">Robot Convera 0.4</span>';
		
	//===================================================
	elseif(	$this->new_agt=='ConveraCrawler/0.8 ( http://www.authoritativeweb.com/crawl)')
		$this->new_agt='<span class="robot">Robot Convera 0.8</span>';
		
	//===================================================
	elseif(	$this->new_agt=='ConveraCrawler/0.9d ( http://www.authoritativeweb.com/crawl)')
		$this->new_agt='<span class="robot">Robot Convera 0.9</span>';
		
	//===================================================
	elseif(	$this->new_agt=='Iltrovatore-Setaccio/1.2 (It-bot; http://www.iltrovatore.it/bot.html; info@iltrovatore.it)')
		$this->new_agt='<span class="robot">Iltrovatore Robot Italien</span>';
		
	//===================================================
	elseif(	$this->new_agt=='Seekbot/1.0 (http://www.seekbot.net/bot.html) HTTPFetcher/0.3')
		$this->new_agt='<span class="robot">SEEKBOT Robot 3.0</span>';
		
	//===================================================
	elseif(	$this->new_agt=='NutchCVS/0.06-dev (Nutch; http://www.nutch.org/docs/en/bot.html; nutch-agent@lists.sourceforge.net)')
		$this->new_agt='<span class="robot">Robot Looksmart</span>';
		
	//===================================================
	elseif(	$this->new_agt=='NutchCVS/0.05 (Nutch; http://www.nutch.org/docs/en/bot.html; nutch-agent@lists.sourceforge.net)')
		$this->new_agt='<span class="robot">Robot Looksmart</span>';
		
	//===================================================
	elseif(	$this->new_agt=='sherlock/1.0')
		$this->new_agt=='<span class="robot">Robot Sherlock v1.0</span>';
		
	//===================================================
	elseif(	$this->new_agt=='Wotbox/0.7-alpha (bot@wotbox.com; http://www.wotbox.com)')
		$this->new_agt='<span class="robot">Robot Wotbox/0.7-alpha</span>';
		
	// Robot Almaden bc23 ===================================================
	elseif(	$this->new_agt=='http://www.almaden.ibm.com/cs/crawler [bc23]')
		$this->new_agt='<span class="robot">Robot Almaden bc23</span>';
		
	// Robot IRLbot v1.0 ===================================================
	elseif(	$this->new_agt=='IRLbot/1.0 ( http://irl.cs.tamu.edu/crawler)')
		$this->new_agt='<span class="robot">Robot IRLbot v1.0</span>';
		
	// Robot MSN 0.3 ===================================================
	elseif(	$this->new_agt=='msnbot/0.3 (+http://search.msn.com/msnbot.htm)')
		$this->new_agt='<span class="robot">Robot MSN 0.3</span>';
		
	// Robot MSN 0.9 ==================================================
	elseif(	$this->new_agt=='msnbot/0.9 ( http://search.msn.com/msnbot.htm)')
		$this->new_agt='<span class="robot">Robot MSN 0.9</span>';
		
	// Robot MSN 1.0 ===================================================
	elseif(	strpos($this->new_agt, 'msnbot/1.0') )
		$this->new_agt='<span class="robot">Robot MSN 1.0</span>';
		
	//===================================================
	elseif(	$this->new_agt=='aipbot/1.0 (aipbot; http://www.aipbot.com; aipbot@aipbot.com)')
	
		$this->new_agt='<span class="robot">Aipbot</span>';
		
	//===================================================
	elseif(	strpos($this->new_agt, 'Gigabot/2.0') )
		$this->new_agt='<span class="robot">Robot Gigabot</span>';
		
	//===================================================
	elseif(	$this->new_agt=='psbot/0.1 ( http://www.picsearch.com/bot.html)')
	
		$this->new_agt='<span class="robot">Robot Picsearch</span>';
		
	//===================================================
	elseif(	$this->new_agt=='InsurancoBot( http://www.insuranco.de/bot.html)')
	
		$this->new_agt='<span class="robot">InsurancoBot</span>';
		
	//==================================================
	elseif(	$this->new_agt=='IP*Works! V5 HTTP/S Component - by /n software - www.nsoftware.com')
	
		$this->new_agt='<span class=\"robot ip_protect\">IP prot&eacute;g&eacute;e</span>';
		
	//===================================================
	elseif(	$this->new_agt=='FAST MetaWeb Crawler (helpdesk at fastsearch dot com)')
	
		$this->new_agt='<span class="robot">FastSearch Bot</span>';
		
	//===================================================
	elseif(	$this->new_agt=='e-SocietyRobot(http://www.yama.info.waseda.ac.jp/~yamana/es/)')
	
		$this->new_agt='<span class="robot">e-SocietyRobot</span>';
		
	//===================================================
	elseif(	strpos($this->new_agt, 'Baiduspider') )
		$this->new_agt='<span class="robot">Robot Baiduspider</span>';
		
	//===================================================
	elseif(	strpos($this->new_agt, 'DotBot/1.1') )
		$this->new_agt='<span class="robot">Robot DotBot 1.1</span>';
		
	//===================================================
	elseif(	strpos($this->new_agt, 'BIGLOTRON') )
		$this->new_agt='<span class="robot">Robot Biglotron</span>';
		
	//===================================================
	elseif(	$this->new_agt=='SBIder/0.8-dev (SBIder; http://www.sitesell.com/sbider.html; http://support.sitesell.com/contact-support.html)')
	
		$this->new_agt='<span class="robot">Robot SBIder 0.8</span>';
		
	//===================================================
	elseif(	$this->new_agt=='Mozilla/5.0 (Twiceler-0.9 http://www.cuil.com/twiceler/robot.html)')
	
		$this->new_agt='<span class="robot">Robot Cuil.com</span>';
        
    }

}
?>
