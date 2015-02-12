<?php

class PeThemeShortcodeReversalFeature extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "feature";
		$this->group = __pe("UI");
		$this->name = __pe("Feature");
		$this->description = __pe("Add a feature");
		$this->fields = array(
							  "title"=> 
							   array(
									"label" => __pe("Title"),
									"type" => "Text",
									"description" => __pe("Enter a feature title."),
									"default" => __pe("Title")
									),
							  "content" =>
							  array(
									"label" => __pe("Description"),
									"type" => "TextArea",
									"description" => __pe("Enter feature description here."),
									"default" => __pe("Description")
									),
							  "icon" => PeGlobal::$const->data->fields->icon
							  );
		// add block level cleaning
		peTheme()->shortcode->blockLevel[] = $this->trigger;
	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		$title = $atts["title"];
		$icon = $atts["icon"];
		$content = $content ? $this->parseContent($content) : '';
		$html = <<< EOT
<div class="features-list">
	<div class="feature-box">
		<div class="feature-icon">
			<i class="$icon"></i>
		</div>
		<div class="feature-text">
			<h3>$title</h3>
			<p>$content</p>
		</div>
	</div>
</div>
EOT;
        return trim($html);
	}


}

?>