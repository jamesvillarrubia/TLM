<?php

class PeThemeReversal extends PeThemeController {

	public $preview = array();

	public function __construct() {
		// custom post types
		add_action("pe_theme_custom_post_type",array(&$this,"pe_theme_custom_post_type"));

		// google fonts
		add_filter("pe_theme_font_variants",array(&$this,"pe_theme_font_variants_filter"),10,2);

		// menu
		add_filter("pe_theme_menu_items_wrap_default",array(&$this,"pe_theme_menu_items_wrap_default_filter"));
		add_filter("wp_nav_menu_objects",array(&$this,"wp_nav_menu_objects_filter"),10,2);
		
		// social links
		add_filter("pe_theme_content_get_social_link",array(&$this,"pe_theme_content_get_social_link_filter"),10,4);

		// use prio 30 so gets executed after standard theme filter
		add_filter("the_content_more_link",array(&$this,"the_content_more_link_filter"),30);

		// gallery fields
		add_filter("pe_theme_gallery_image_fields",array(&$this,"pe_theme_gallery_image_fields_filter"));

		// metaboxes
		add_filter("pe_theme_metabox_gallery",array(&$this,"pe_theme_metabox_gallery_filter"));
		add_filter("pe_theme_metabox_video",array(&$this,"pe_theme_metabox_video_filter"));
		add_filter("pe_theme_metabox_page",array(&$this,"pe_theme_metabox_page_filter"));
		add_filter("pe_theme_metabox_service",array(&$this,"pe_theme_metabox_service_filter"));

		// shortcodes default values
		add_filter("pe_theme_shortcode_gallery_defaults",array(&$this,"pe_theme_shortcode_gallery_defaults_filter"),10,2);

		// custom password form
		add_filter("the_password_form",array(&$this,"the_password_form_filter"));
		
		// hide the admin bar (known to cause issues with the theme when enabled)
		show_admin_bar(false);
		
		// portfolio
		add_filter("pe_theme_project_filter_item",array(&$this,"pe_theme_project_filter_item_filter"),10,4);
		
		add_filter('the_content_more_link',array(&$this,'pe_theme_more_link_class_filter'),1000,2);

	}
	
	public function pe_theme_more_link_class_filter($link,$text) {
		return str_replace( 'more-link', 'button float-right active more-link', $link );
	}

	
	public function pe_theme_project_filter_item_filter($html,$aclass,$slug,$name) {
		return sprintf('<li><a href="#" data-filter="%s" class="%s">%s</a></li>',$slug === "" ? "*" : ".filter-$slug",$slug === "" ? "selected" : "",$name);
	}

	public function the_password_form_filter($form) {

		$replace = sprintf('<div class="control-group"><input name="post_password" type="password" /></div><button id="submit" class="btn btn-info" type="submit" name="submit">%s</button>',__pe("Submit"));
		$form = preg_replace("/<p>.+<\/p>/","",$form);
		$form = str_replace("</form>","$replace</form>",$form);
		return $form;
	}


	public function pe_theme_resized_img_filter($markup,$url,$w,$h) {

		return sprintf('<img class="peLazyLoading" src="%s" data-original="%s" width="%s" height="%s" alt="" />',
					   $this->image->blank($w,$h),
					   $url,
					   $w,
					   $h
					   );
	}


	public function pe_theme_font_variants_filter($variants,$font) {
		$variants="$font:300,400,600";
		/*
		if ($font === "Open Sans") {
			//$variants = "Open Sans:400,600,300&subset=latin,latin-ext";
			$variants = "Open Sans:400,600,300";
		}
		*/
		return $variants;
	}

	public function pe_theme_menu_items_wrap_default_filter($wrapper) {
		return '<ul id="nav" data-mobile="'.__pe('Go To').'">%3$s</ul>';
	}

	public function wp_nav_menu_objects_filter($items,$args) {
		if (is_array($items) && !empty($args->theme_location)) {
			$home = false;

			if (is_page()) {
				if ($this->content->pageTemplate() === "page-home.php") {
					$home = get_page_link(get_the_id());
				}
			}

			foreach ($items as $id => $item) {
				if (!empty($item->post_parent)) {
					if ($item->object === "page") {
						$page = get_page($item->object_id);
						if (!empty($page->post_name)) {
							$parent = get_page_link($item->post_parent);
							$slug = $page->post_name;
							$items[$id]->url = "{$parent}#{$slug}";
						}
					}
				} else if ($item->url === $home) {
					$items[$id]->url .= "#home";
				}
			}
		}
		return $items;
	}


	public function pe_theme_content_get_social_link_filter($html,$link,$domain,$icon) {
		return sprintf('<li><a href="%s"><i class="icon-%s"></i></a></li>',$link,strtr($icon,array("linked"=>"linkedin")));
	}

	public function the_content_more_link_filter($link) {
		return sprintf('<div class="more-container"><a class="more-link" href="%s">%s</a></div>',get_permalink(),__pe("Continue Reading.."));
	}

	public function pe_theme_gallery_image_fields_filter($fields) {
		$save = $fields["save"];
		unset($fields["save"]);
		unset($fields["video"]);
		//unset($fields["ititle"]);
		$fields["link"] = 
			array(
				  "label"=>__pe("Link"),
				  "type"=>"Text",
				  "section"=>"main",
				  "description" => __pe("Optional image link."),
				  "default"=> ""
				  );
		$fields["save"] = $save;
		return $fields;
	}

	public function pe_theme_metabox_gallery_filter($mboxes) {
		$type =& $mboxes["settings"]["content"]["type"];
		$type["options"] = array(__pe("Slider") => "slider");
		$type["default"] = "slider";

		return $mboxes;
	}

	public function pe_theme_metabox_video_filter($mboxes) {
		$video =& $mboxes["video"]["content"];
		unset($video["fullscreen"]);
		unset($video["width"]);
		return $mboxes;
	}

	public function pe_theme_metabox_page_filter($mboxes) {
		$blog =& $mboxes["blog"]["content"];
		unset($blog["layout"]);
		unset($blog["media"]);
		return $mboxes;
	}
	
	public function pe_theme_metabox_service_filter($mboxes) {
		$service =& $mboxes["info"]["content"];
		$service["icon"]=PeGlobal::$const->data->fields->icon;
		unset($service["features"]);
		return $mboxes;
	}

	public function pe_theme_shortcode_gallery_defaults_filter($defaults,$atts) {
		extract(shortcode_atts(array("id" => false),$atts));

		switch ($this->gallery->type($id)) {
		case "slider":
			$defaults["size"] = "592x333";
			break;
		}

		return $defaults;
	}

	public function pe_theme_custom_post_type() {
		$this->gallery->cpt();
		$this->video->cpt();
		$this->project->cpt();
		$this->service->cpt();
	}

	public function boot() {
		parent::boot();

		PeGlobal::$config["content-width"] = 870;
		PeGlobal::$config["post-formats"] = array("video","gallery");
		PeGlobal::$config["post-formats-project"] = array("video","gallery");

		PeGlobal::$config["image-sizes"]["thumbnail"] = array(120,90,true);
		PeGlobal::$config["image-sizes"]["medium"] = array(472,266,true);
		PeGlobal::$config["image-sizes"]["large"] = array(870,490,true);
		PeGlobal::$config["image-sizes"]["post-thumbnail"] = PeGlobal::$config["image-sizes"]["medium"];
		

		//PeGlobal::$config["nav-menus"]["footer"] = __pe("Footer menu");

		// blog layouts
		PeGlobal::$config["blog"] =
			array(
				  __pe("Grid") => "grid",
				  __pe("List") => ""
				  );

		PeGlobal::$config["widgets"] = 
			array(
				  );

		PeGlobal::$config["shortcodes"] = 
			array(
				  "BS_Accordion",
				  "BS_Columns",
				  "BS_Icon",
				  "BS_Slider",
				  "BS_Video",
				  "ReversalFeature"
				  );

		PeGlobal::$config["sidebars"] =
			array(
				  "default" => __pe("Default post/page")
				  );

		PeGlobal::$config["colors"] = 
			array(
				  "color1" => 
				  array(
						"label" => __pe("Primary Color"),
						"selectors" => 
						array(
							  "hr.fancy-hr:before" => "background-color",
							  ".get-started" => "background-color",
							  "hr.fancy-hr-alt:before" => "background-color",
							  "::selection" => "background-color",
							  "::-moz-selection" => "background-color",
							  "::-webkit-selection" => "background-color",
							  ".progress:hover .bar" => "background-color",
							  "input:focus, textarea:focus, select:focus" => "background-color",
							  'input[type="submit"], button, a.button' => "background",
							  ".pager a:hover" => "background-color",
							  ".pagination .current" => "background-color",
							  ".pagination .current:hover" => "background-color",
							  ".tagcloud a:hover" => "background-color",
							  ".commentlist .reply a:hover" => "background-color",
							  ".form-horizontal button" => "background-color",
							  ".commentlist .reply a:hover" => "background-color",
							  
							  "a, a > *" => "color",
							  "nav#main-nav ul li a.active" => "color",
							  "nav#main-nav ul li a.current" => "color",
							  ".intro h1 span" => "color",
							  ".desktop .get-started:hover i" => "color",
							  ".features .feature-box .box-content .feature-icon" => "color",
							  ".features-list .feature-box .feature-text h3" => "color",
							  ".post .post-title h2 a:hover" => "color",
							  ".required" => "color",
							  ".post blockquote p" => "border-color",
							  ".commentlist .bypostauthor > .comment-body > .comment-author img" => "border-color"
							  ),
						"default" => "#d00355"
						)
				  );
		

		PeGlobal::$config["fonts"] = 
			array(
				  "fontHeading" => 
				  array(
						"label" => __pe("Primary Font"),
						"selectors" => 
						array(
								"body",
								"input",
								"select",
								"textarea"
								
							  ),
						"default" => "Open Sans"
						)
				  );

		

		$options = array();

		if (!defined('PE_HIDE_IMPORT_DEMO') || !PE_HIDE_IMPORT_DEMO) {
			$options["import_demo"] = $this->defaultOptions["import_demo"];
		}

		$options = array_merge($options,
			array(
				  "logo" => 
				  array(
						"label"=>__pe("Header Logo"),
						"type"=>"Upload",
						"section"=>__pe("General"),
						"description" => __pe("This is the main site logo image. The image should be a .png file."),
						"default"=> PE_THEME_URL."/images/logo.png"
						),
				  "favicon" => 
				  array(
						"label"=>__pe("Favicon"),
						"type"=>"Upload",
						"section"=>__pe("General"),
						"description" => __pe("This is the favicon for your site. The image can be a .jpg, .ico or .png with dimensions of 16x16px "),
						"default"=> PE_THEME_URL."/favicon.ico"
						),
				  "customCSS" => $this->defaultOptions["customCSS"],
				  "customJS" => $this->defaultOptions["customJS"],
				  "customColors" => 
				  array(
						"label"=>__pe("Custom Colors"),
						"type"=>"Help",
						"section"=>__pe("Colors"),
						"description" => __pe("In this page you can set alternative colors for the main colored elements in this theme. A primary color change option has been provided. To change the colors used on these primary elements simply write a new hex color reference number into the fields below or use the color picker which appears when the input field obtains focus. Once you have selected your desired colors make sure to save them by clicking the <b>Save All Changes</b> button at the bottom of the page. Then just refresh your page to see the changes.<br/><br/><b>Please Note:</b> Some of the colored elements in this theme may be made from images. It is not possible to change these elements via this page, instead such elements will need to be changed manually by opening the images/icons in an image editing program and manually changing their colors to match your theme's custom color scheme. <br/><br/>To return all colors to their default values at any time just hit the <b>Restore Default</b> link beneath each field."),
						),
				  "googleFonts" =>
				  array(
						"label"=>__pe("Custom Fonts"),
						"type"=>"Help",
						"section"=>__pe("Fonts"),
						"description" => __pe("In this page you can set the typefaces to be used throughout the theme. For each elements listed below you can choose any front from the Google Web Font library. Once you have chosen a font from the list, you will see a preview of this font immediately beneath the list box. The icons on the right hand side of the font preview, indicate what weights are available for that typeface.<br/><br/><strong>R</strong> -- Regular,<br/><strong>B</strong> -- Bold,<br/><strong>I</strong> -- Italics,<br/><strong>BI</strong> -- Bold Italics<br/><br/>When decideing what font to use, ensure that the chosen font contains the font weight required by the element. For example, main headings are bold, so you need to select a new font for these elements which supports a bold font weight. If you select a font which does not have a bold icon, the font will not be applied. <br/><br/>Browse the online <a href='http://www.google.com/webfonts'>Google Font Library</a><br/><br/><b>Custom fonts</b> (Advanced Users):<br/> Other then those available from Google fonts, custom fonts may also be applied to the elements listed below. To do this an additional field is provided below the google fonts list. Here you may enter the details of a font family, size, line-height etc. for a custom font. This information is entered in the form of the shorthand 'font:' CSS declaration, for example:<br/><br/><b>bold italic small-caps 1em/1.5em arial,sans-serif</b><br/><br/>If a font is specified in this field then the font listed in the Google font drop menu above will not be applied to the element in question. If you wish to use the Google font specified in the drop down list and just specify a new font size or line height, you can do so in this field also, however the name of the Google font <b>MUST</b> also be entered into this field. You may need to visit the Google fonts web page to find the exact CSS name for the font you have chosen." )
						),
				  "contactEmail" => $this->defaultOptions["contactEmail"],
				  "contactSubject" => $this->defaultOptions["contactSubject"],
				  "sidebars" => 
				  array(
						"label"=>__pe("Widget Areas"),
						"type"=>"Sidebars",
						"section"=>__pe("Widget Areas"),
						"description" => __pe("Create new widget areas by entering the area name and clicking the add button. The new widget area will appear in the table below. Once a widget area has been created, widgets may be added via the widgets page."),
						"default"=>""
						),
				  "404content" => 
				  array(
						"label"=>__pe("Content"),
						"type"=>"TextArea",
						"section"=>__pe("Custom 404"),
						"description" => __pe("Content of 404 (not found) page"),
						"wpml" => true,
						"default"=> '<strong>
The Page You Are Looking For Cannot Be Found
</strong>
'
						)

				  ));

		$options = array_merge($options,$this->color->options());
		$options = array_merge($options,$this->font->options());

		$options["minifyJS"] =& $this->defaultOptions["minifyJS"];
		$options["minifyCSS"] =& $this->defaultOptions["minifyCSS"];

		$options["adminThumbs"] =& $this->defaultOptions["adminThumbs"];
		$options["mediaQuick"] =& $this->defaultOptions["mediaQuick"];
		$options["mediaQuickDefault"] =& $this->defaultOptions["mediaQuickDefault"];

		$options["updateCheck"] =& $this->defaultOptions["updateCheck"];
		$options["updateUsername"] =& $this->defaultOptions["updateUsername"];
		$options["updateAPIKey"] =& $this->defaultOptions["updateAPIKey"];

		$options["adminLogo"] =& $this->defaultOptions["adminLogo"];
		$options["adminUrl"] =& $this->defaultOptions["adminUrl"];
		
		PeGlobal::$config["options"] =& apply_filters("pe_theme_options",$options);

		$galleryMbox = 
			array(
				  "title" => __pe("Slider"),
				  "type" => "GalleryPost",
				  "priority" => "core",
				  "where" =>
				  array(
						"post" => "gallery"
						),
				  "content" =>
				  array(
						"id" => PeGlobal::$const->gallery->id,
						"width" =>
						array(
							  "label"=>__pe("Width"),
							  "type"=>"Text",
							  "description" => __pe("Leave empty to use default width."),
							  "default"=> ""
							  ),
						"height" =>
						array(
							  "label"=>__pe("Height"),
							  "type"=>"Text",
							  "description" => __pe("Leave empty to avoid image cropping. When empty, all the (original) images must have the same size for the slider to work correctly."),
							  "default"=> "333"
							  ),
						)
				  );

		$bgMbox = 
			array(
				  "title" => __pe("Settings."),
				  "priority" => "core",
				  "where" =>
				  array(
						"post" => "page-home"
						),
				  "content" =>
				  array(
						"background" => 
						array(
							  "label"=>__pe("Background"),
							  "type"=>"Upload",
							  "description" => __pe("Background images."),
							  "default"=> PE_THEME_URL."/images/background.jpg"
							  ),
						"introtitle" => 
						array(
							  "label"=>__pe("Intro Title"),
							  "type"=>"Text",
							  "description" => __pe("Define intro page title."),
							  "default"=> __pe("Welcome to <span>Reversal</span>")
							  ),
						"intro" => 
						array(
							  "label"=>__pe("Intro Text"),
							  "type"=>"Text",
							  "description" => __pe("Leave empty to hide."),
							  "default"=> __pe("Fusce sollicitudin, dolor sed consectetur aliquet.<br>Lorem dolor viverra elit, quis interdum ligula turpis sit amet urna.")
							  ),
						"label" => 
						array(
							  "label"=>__pe("Label Text"),
							  "type"=>"Text",
							  "description" => __pe("If empty, hides the label."),
							  "default"=> __pe("Get Started <i class=\"icon-angle-right\"></i>")
							  ),
						"url" => 
						array(
							  "label"=>__pe("Label Url"),
							  "type"=>"Text",
							  "default"=> "#about"
							  )
						)
				  );
				  
		$aboutMbox = 
			array(
				  "type" =>"",
				  "title" =>__pe("About"),
				  "priority" => "core",
				  "where" => 
				  array(
						"page" => "page-about",
						),
				  "content"=>
				  array(
						"show" =>				
						array(
							  "label"=>__pe("Show Skills"),
							  "type"=>"RadioUI",
							  "description"=>__pe('If set to "NO", whole skills section will be hidden.'),
							  "options" => Array(__pe("Yes")=>"yes",__pe("No")=>"no"),
							  "default"=>"yes"
							  ),
						"skillstitle" => 	
						array(
							  "label"=>__pe("Skills Title"),
							  "type"=>"Text",
							  "description" => __pe("Heading displayed above skills, leave empty to hide."),
							  "default"=>"Our skills"
							  ),
						"skill1" => 	
						array(
							  "label"=>__pe("Skill 1"),
							  "type"=>"Text",
							  "description" => __pe("Skill 1 text"),
							  "default"=>""
							  ),
						"skill1amount" => 	
						array(
							  "label"=>__pe("Skill 1 amount"),
							  "type"=>"Text",
							  "description" => __pe("Skill 1 amount (min = 0, max = 100)"),
							  "default"=>""
							  ),
						"skill2" => 	
						array(
							  "label"=>__pe("Skill 2"),
							  "type"=>"Text",
							  "description" => __pe("Skill 2 text"),
							  "default"=>""
							  ),
						"skill2amount" => 	
						array(
							  "label"=>__pe("Skill 2 amount"),
							  "type"=>"Text",
							  "description" => __pe("Skill 2 amount (min = 0, max = 100)"),
							  "default"=>""
							  ),
						"skill3" => 	
						array(
							  "label"=>__pe("Skill 3"),
							  "type"=>"Text",
							  "description" => __pe("Skill 3 text"),
							  "default"=>""
							  ),
						"skill3amount" => 	
						array(
							  "label"=>__pe("Skill 3 amount"),
							  "type"=>"Text",
							  "description" => __pe("Skill 3 amount (min = 0, max = 100)"),
							  "default"=>""
							  ),
						"skill4" => 	
						array(
							  "label"=>__pe("Skill 4"),
							  "type"=>"Text",
							  "description" => __pe("Skill 4 text"),
							  "default"=>""
							  ),
						"skill4amount" => 	
						array(
							  "label"=>__pe("Skill 4 amount"),
							  "type"=>"Text",
							  "description" => __pe("Skill 4 amount (min = 0, max = 100)"),
							  "default"=>""
							  ),
						"skill5" => 	
						array(
							  "label"=>__pe("Skill 5"),
							  "type"=>"Text",
							  "description" => __pe("Skill 5 text"),
							  "default"=>""
							  ),
						"skill5amount" => 	
						array(
							  "label"=>__pe("Skill 5 amount"),
							  "type"=>"Text",
							  "description" => __pe("Skill 5 amount (min = 0, max = 100)"),
							  "default"=>""
							  )
						)
				  );
				  
		$servicesMbox = 
			array(
				  "type" =>"",
				  "title" =>__pe("Services"),
				  "priority" => "core",
				  "where" => 
				  array(
						"page" => "page-services",
						),
				  "content"=>
				  array(
						
						"introtxt" => 	
						array(
							  "label"=>__pe("Intro Text"),
							  "type"=>"TextArea",
							  "description" => __pe("Displayed above services. Leave empty to hide."),
							  "default"=>"Nunc commodo est eu tellus facilisis ut volutpat tortor gravida. In hac habitasse platea dictumst. Morbi nisi erat, congue vitae aliquam id, varius et risus. Nulla facilisi. Sed nec ipsum dolor. Etiam euismod lectus eu odio pulvinar quis porttitor nunc pretium."
							  ),
						"introbtn" => 	
						array(
							  "label"=>__pe("Intro Button Text"),
							  "type"=>"Text",
							  "description" => __pe("Text of the button in intro section. Leave empty to hide."),
							  "default"=>"Check our Works"
							  ),
						"introbtnlink" => 	
						array(
							  "label"=>__pe("Intro Button Link"),
							  "type"=>"Text",
							  "description" =>__pe("Url a button will link to."),
							  "default"=>home_url() . "#portfolio"
							  ),
						"services" => 
						array(
							  "label"=>__pe("Services"),
							  "type"=>"Links",
							  "options" => $this->service->option(),
							  "description" => __pe("Add one or more services."),
							  "sortable" => true,
							  "default"=> array()
							  )
						
						)
				  );

		$defaultInfo = <<<EOL
<h2 class="no-bottom-margin">Where we are</h2>
<hr class="fancy-hr">
<ul>
	<li>Reversal Corp.</li>
	<li>33 Street Name, City Name</li>
	<li class="bottom-margin">United States</li>
	<li><i class="icon-phone"></i>(345) 666-1289</li>
	<li><i class="icon-envelope-alt"></i><a href="mailto:">mail@reversal.com</a></li>
</ul>
<a href="" id="show-map" class="hidden-phone button top-margin">Toggle Map</a>
EOL;

		$contactMbox = 
			array(
				  "type" =>"",
				  "title" =>__pe("Contact Options"),
				  "priority" => "core",
				  "where" => 
				  array(
						"page" => "page-contact",
						),
				  "content"=>
				  array(
						"info" => 	
						array(
							  "label"=>__pe("Info"),
							  "type"=>"TextArea",
							  "description" => __pe("Contact Info."),
							  "default"=> $defaultInfo
							  ),
						"msgOK" => 	
						array(
							  "label"=>__pe("Mail Sent Message"),
							  "type"=>"TextArea",
							  "description" => __pe("Message shown when form message has been sent without errors"),
							  "default"=>'<strong>Yay!</strong> Message sent.'
							  ),
						"msgKO" => 	
						array(
							  "label"=>__pe("Form Error Message"),
							  "type"=>"TextArea",
							  "description" => __pe("Message shown when form message encountered errors"),
							  "default"=>'<strong>Error!</strong> Please validate your fields.'
							  ),
						"socialLinks" => 
						array(
							  "label"=>__pe("Social Profile Links"),
							  "type"=>"Links",
							  "description" => __pe("Add the link to your social media profiles. Paste links one at a time and click the 'Add New' button. The links will appear in a table below and an icons will be inserted automatically based on the domain in the url."),
							  "sortable" => true,
							  "default"=>""
							  )
						)
				  );

		
		$portfolioMbox =& PeGlobal::$const->portfolio->metabox;
		unset($portfolioMbox["content"]["pager"]);
		unset($portfolioMbox["content"]["filterable"]);
		unset($portfolioMbox["content"]["columns"]);

		PeGlobal::$config["metaboxes-post"] = 
			array(
				  "video" => PeGlobal::$const->video->metaboxPost,
				  "sidebar" => PeGlobal::$const->sidebar->metabox,
				  "gallery" => $galleryMbox
				  );

		PeGlobal::$config["metaboxes-page"] = 
			array(
				  
				  "bg" => $bgMbox,
				  "sidebar" => array_merge(PeGlobal::$const->sidebar->metabox,array("where"=>array("post"=>"page-blog, page-portfolio"))),
				  "blog" => array_merge(PeGlobal::$const->blog->metabox,array("where"=>array("post"=>"page-blog"))),
				  "about" => $aboutMbox,
				  "portfolio" => $portfolioMbox,
				  "services" => $servicesMbox,
				  "contact" => $contactMbox,
				  "gmap" => PeGlobal::$const->gmap->metabox
				  );


		PeGlobal::$config["metaboxes-project"] = 
			array(
				  "gallery" => $galleryMbox,
				  "video" => PeGlobal::$const->video->metaboxPost
				  );

	}

	public function pre_get_posts_filter($query) {
		if ($query->is_search) {
			$query->set('post_type',array('post'));
		}

		/*
		if (is_tax("prj-category") && !empty($query->query_vars["prj-category"])) {
			$query->set('posts_per_page',16);
		}
		*/

		return $query;
	}

	protected function init_asset() {
		return new PeThemeReversalAsset($this);
	}
	
	protected function init_template() {
		return new PeThemeReversalTemplate($this);
	}
}

?>