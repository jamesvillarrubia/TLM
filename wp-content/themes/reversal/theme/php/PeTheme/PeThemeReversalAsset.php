<?php

class PeThemeReversalAsset extends PeThemeAsset  {

	public function __construct(&$master) {
		$this->minifiedJS = "theme/compressed/theme.min.js";
		$this->minifiedCSS = "theme/compressed/theme.min.css";
		parent::__construct($master);
	}

	public function registerAssets() {

		add_filter("pe_theme_minified_js_deps",array(&$this,"pe_theme_minified_js_deps_filter"));
		add_filter("pe_theme_flare_css_deps",array(&$this,"pe_theme_flare_css_deps_filter"));

		parent::registerAssets();

		$options =& $this->master->options->all();		

		// override projekktor skin
		wp_deregister_style("pe_theme_projekktor");
		$this->addStyle("framework/js/pe.flare/video/theme/style.css",array(),"pe_theme_projekktor");

		//$this->addStyle("css/dark_skin.css",array(),"pe_theme_hydra_dark_skin");		

		if ($this->minifyCSS) {
			$deps = 
				array(
					  "pe_theme_compressed"
					  );
		} else {

			// theme styles
			$this->addStyle("styles/bootstrap.min.css",array(),"pe_theme_reversal_bootstrap");
			$this->addStyle("styles/bootstrap-responsive.min.css",array(),"pe_theme_reversal_bootstrap_responsive");
			$this->addStyle("styles/font-awesome.min.css",array(),"pe_theme_reversal_font_awesome");
			$this->addStyle("styles/fancybox/jquery.fancybox.css",array(),"pe_theme_reversal_fancybox");
			$this->addStyle("styles/flexslider.css",array(),"pe_theme_reversal_flexslider");
			$this->addStyle("styles/style.css",array(),"pe_theme_reversal_main_stylesheet");
			$this->addStyle("styles/responsive.css",array(),"pe_theme_reversal_main_stylesheet_responsive");
			$this->addStyle("styles/custom.css",array(),"pe_theme_reversal_custom");
		
			$deps = 
				array(
					  "pe_theme_reversal_bootstrap",
					  "pe_theme_video",					  
					  "pe_theme_volo",
					  "pe_theme_reversal_bootstrap_responsive",
					  "pe_theme_reversal_font_awesome",
					  "pe_theme_reversal_fancybox",
					  "pe_theme_reversal_flexslider",
					  "pe_theme_reversal_main_stylesheet",
					  "pe_theme_reversal_main_stylesheet_responsive",
					  "pe_theme_reversal_custom"
					  );
		}

		$this->addStyle("style.css",$deps,"pe_theme_init");

		$this->addScript("js/modernizr.js",array(),"pe_theme_reversal_modernizr");
		$this->addScript("js/bootstrap.min.js",array(),"pe_theme_reversal_bootstrap");
		$this->addScript("js/jquery.easing.pack.js",array(),"pe_theme_reversal_easing");
		$this->addScript("js/jquery.mousewheel.pack.js",array(),"pe_theme_reversal_mousewheel");
		$this->addScript("js/jquery.fancybox.pack.js",array(),"pe_theme_reversal_fancybox");
		$this->addScript("js/jquery.flexslider.min.js",array(),"pe_theme_reversal_flexslider");
		$this->addScript("js/jquery.isotope.min.js",array(),"pe_theme_reversal_isotope");
		$this->addScript("js/jquery.validate.min.js",array(),"pe_theme_reversal_validate");
		$this->addScript("js/jquery.fitvids.js",array(),"pe_theme_reversal_fitvids");
		$this->addScript("js/jquery.touchswipe.min.js",array(),"pe_theme_reversal_touchswipe");
		$this->addScript("js/reversal.js",array(),"pe_theme_reversal_main_js");

		$this->addScript("theme/js/pe/pixelentity.controller.js",
						 array(
							   "pe_theme_reversal_modernizr",
							   "pe_theme_reversal_bootstrap",
							   "pe_theme_reversal_easing",
							   "pe_theme_reversal_mousewheel",
							   "pe_theme_reversal_fancybox",
							   "pe_theme_reversal_flexslider",
							   "pe_theme_reversal_isotope",
							   "pe_theme_reversal_validate",
							   "pe_theme_reversal_fitvids",
							   "pe_theme_reversal_touchswipe",
							   "pe_theme_reversal_main_js",
							   "pe_theme_utils",
							   "pe_theme_utils_browser",
							   "pe_theme_widgets_contact",
							   "pe_theme_widgets_gmap"

							   ),"pe_theme_controller");

		/*
		wp_localize_script("pe_theme_init", 'peThemeOptions',
						   array(
								 "backgroundMinWidth" => absint($options->backgroundMinWidth)
								 ));
		*/

	}

	public function localizeScripts() {
		//parent::localizeScripts();
		wp_localize_script($this->minifyJS ? "pe_theme_init" : "pe_theme_contactForm", 'peContactForm',array("url"=>urlencode(admin_url("admin-ajax.php"))));
	}
	
	public function pe_theme_minified_js_deps_filter($deps) {
		return array("jquery");
	}

	public function pe_theme_flare_css_deps_filter($deps) {
		return 	array(
					  "pe_theme_flare_common"
					  );
	}
	
	public function style() {
		bloginfo("stylesheet_url"); 
	}

	public function enqueueAssets() {
		$this->registerAssets();
		
		if ($this->minifyJS && file_exists(PE_THEME_PATH."/preview/init.js")) {
			$this->addScript("preview/init.js",array("jquery"),"pe_theme_preview_init");
			wp_localize_script("pe_theme_preview_init", 'o',
							   array(
									 "dark" => PE_THEME_URL."/css/dark_skin.css",
									 "css" => $this->master->color->customCSS(true,"color1")
									 ));
			wp_enqueue_script("pe_theme_preview_init");
		}	
		
		wp_enqueue_style("pe_theme_init");
		wp_enqueue_script("pe_theme_init");

		if ($this->minifyJS && file_exists(PE_THEME_PATH."/preview/preview.js")) {
			$this->addScript("preview/preview.js",array("pe_theme_init"),"pe_theme_skin_chooser");
			wp_localize_script("pe_theme_skin_chooser","pe_skin_chooser",array("url"=>urlencode(PE_THEME_URL."/")));
			wp_enqueue_script("pe_theme_skin_chooser");
		}
	}


}

?>