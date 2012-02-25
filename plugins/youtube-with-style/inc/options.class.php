<?php

class AdminPage {
	public $top;
	protected $args;
	private $boxes;
	private $table = false;
	
	public function addInput($args) {
		$default = array(
			'size' => 'regular',
		);
		$args = array_merge($default, $args);
		$args['type'] = 'input';
		$this->addField($args);
	}

	public function addColorPicker($args) {
		$default = array(
		);
		$args = array_merge($default, $args);
		$args['type'] = 'colorpicker';
		$args['size'] = 'small';
		$this->addField($args);
	}
	
	public function addTextarea($args) {
		$default = array(
			'rows' => 5,
			'cols' => 30,
			'width' => 500,
		);
		$args = array_merge($default, $args);
		$args['type'] = 'textarea';
		$this->addField($args);
	}
	
	public function addEditor($args) {
		$args['type'] = 'editor';
		$this->addField($args);
	}
	
	public function addTitle($label) {
		$args['type'] = 'title';
		$args['label'] = $label;
		$this->addField($args);
	}
	
	public function addSubtitle($label) {
		$args['type'] = 'subtitle';
		$args['label'] = $label;
		$this->addField($args);
	}
	
	public function addParagraph($text) {
		$args['type'] = 'paragraph';
		$args['text'] = $text;
		$this->addField($args);
	}
	
	public function addCheckbox($args) {
		$args['type'] = 'checkbox';
		$this->addField($args);
	}
	
	public function addRadiobuttons($args) {
		$args['type'] = 'radio';
		$this->addField($args);
	}
	
	public function addDropdown($args) {
		$args['type'] = 'dropdown';
		$this->addField($args);
	}
	
	public function addUpload($args) {
		$args['type'] = 'upload';
		$this->addField($args);
	}
	
	public function addSlider($args) {
		$default = array(
			'standard' => 0,
			'max' => 100,
			'min' => 0,
			'step' => 1,
		);
		$args = array_merge($default,$args);
		$args['type'] = 'slider';
		$this->addField($args);
	}
	
	public function addDate($args) {
		$args['type'] = 'date';
		$date = explode('/', $args['standard']);
		if(isset($date[2])) $args['standard'] = mktime(0,0,0,$date[0],$date[1],$date[2]);
		$this->addField($args);
	}
	
	private function addField($args) {
		$this->buildOptions($args);
		$this->boxes[] = $args;
	}
	
	private function buildOptions($args) {
		$default = array(
			'standard' => '',
		);
		$args = array_merge($default, $args);
		if(get_option($args['id']) === false) {
			update_option($args['id'], $args['standard']);
		}
	}
	
	public function outputHTML() {
		echo '<div class="wrap">';
		echo '<h2>'.$this->args['page_title'].'</h2>';
		echo '<form method="post" action="" enctype="multipart/form-data">';

		$action = isset($_POST['action']) ? $_POST['action'] : '';
		if($action == 'save') {
			echo '<div class="updated settings-error"><p><strong>'.__('Settings saved.').'</strong></p></div>';
			$this->save();
		}
		echo '<style>.editorcontainer { -webkit-border-radius:6px; border:1px solid #DEDEDE;}</style>';
		echo '<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/base/jquery-ui.css" rel="stylesheet" />';
		echo '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>';
		echo '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>';
		echo '<script type="text/javascript" src="http://jscolor.com/jscolor/jscolor.js"></script>';
		foreach($this->boxes as $box) {
			if($box['type'] != 'title' AND $box['type'] != 'paragraph' AND $box['type'] != 'subtitle') {
				if(!$this->table) {
					echo '<table class="form-table">';
					$this->table = true;
				}
				echo '<tr valign="top">';
				echo '<th><label for="'.$box['id'].'">'.$box['label'].':</label></th>';
			} else {
				if($this->table) {
					echo '</table>';
					$this->table = false;
				}
			}
			
			$data = get_option($box['id']);
			switch($box['type']) {
				case 'title':
					echo '<h3>'.$box['label'].'</h3>';
					break;
				case 'subtitle':
					echo '<h4>'.$box['label'].'</h4>';
					break;
				case 'paragraph':
					echo '<p>'.$box['text'].'</p>';
					break;
				case 'input':
					$data = htmlspecialchars(stripslashes($data));
					echo '<td><input type="text" class="'.$box['size'].'-text" name="'.$box['id'].'" id="'.$box['id'].'" value="'.$data.'" /> <span class="description">'.$box['desc'].'</span></td>';
					break;
				case 'colorpicker':
					$data = htmlspecialchars(stripslashes($data));
					echo '<td><input type="text" class="'.$box['size'].'-text color" name="'.$box['id'].'" id="'.$box['id'].'" value="'.$data.'" style="width:60px;" /> <span class="description">'.$box['desc'].'</span></td>';
					break;
				case 'textarea':
					$data = stripslashes($data);
					echo '<td><textarea rows="'.$box['rows'].'" cols="'.$box['cols'].'" style="width:'.$box['width'].'px" name="'.$box['id'].'" id="'.$box['id'].'">'.$data.'</textarea> <br><span class="description">'.$box['desc'].'</span></td>';
					break;
					
				case 'editor':
					wp_tiny_mce();
					echo '<td><div class="editorcontainer"><textarea class="theEditor" id="'.$box['id'].'" name="'.$box['id'].'">'.$data.'</textarea></div><span class="description">'.$box['desc'].'</span></td>';
					break;
				
				case 'checkbox':
					if($data == 'true') {
						$checked = 'checked="checked"';
					} else {
						$checked = '';
					}
					echo '<td><input type="checkbox" name="'.$box['id'].'" id="'.$box['id'].'" value="true" '.$checked.' /> <label for="'.$box['id'].'">'.$box['desc'].'</label></td>';
					break;
					
				case 'radio':
					echo '<td>';
					foreach($box['options'] as $label=>$value) {
						if($data == $value) {
							$checked = 'checked="checked"';
						} else {
							$checked = '';
						}
						echo '<input type="radio" name="'.$box['id'].'" id="'.$box['id'].'_'.$value.'" value="'.$value.'" '.$checked.' /> <label for="'.$box['id'].'_'.$value.'">'.$label.'</label><br>';
					}
					echo '</td>';
					break;
					
				case 'dropdown':
					echo '<td>';
					echo '<select name="'.$box['id'].'" id="'.$box['id'].'">';
					foreach($box['options'] as $label=>$value) {
						if($data == $value) {
							$selected = 'selected="selected"';
						} else {
							$selected = '';
						}
						echo '<option value="'.$value.'" '.$selected.'>'.$label.'</option>';
					}
					echo '</select> <span class="description">'.$box['desc'].'</span>';
					echo '</td>';
					break;
					
				case 'upload':
					echo '<td>';
					echo '<div style="-webkit-border-radius:6px; border:1px solid #DEDEDE; padding:10px; position:relative; background:#FFF;">';
					echo '<div style="float:left"><input type="file" name="'.$box['id'].'" id="'.$box['id'].'" /> <span class="description">'.$box['desc'].'</span>';
					if(isset($box['title'])) echo '<br><br><input type="text" class="regular-text" name="'.$box['id'].'_title" id="'.$box['id'].'_title" value="'.$data['title'].'" /> <span class="description">'.$box['title'].'</span>';
					echo '</div>';
					if(strpos($data['type'], 'image') !== false) {
						echo '<img height="75" src="'.$data['url'].'" style="float:right" />';
					} else {
						echo '<p style="float:right"><strong>'.__('Current').':</strong> '.$data['url'].'</p>';
					}
					echo '<div style="clear:both"></div>';
					echo '</div>';
					echo '</td>';
					break;
					
				case 'slider':
					$show = $data;
					if(is_array($show)) $show = implode('-',$show);
					echo '<td>';
					echo '<div style="width:30%" id="'.$box['id'].'-slider" class="ui-slider"></div>';
					echo '<div id="'.$box['id'].'-handle">'.$show.'</div>';
					echo '<input type="hidden" name="'.$box['id'].'" id="'.$box['id'].'" value="'.$show.'" />';
					echo '<script type="text/javascript">jQuery("#'.$box['id'].'-slider").slider({';
					if(!is_array($data)) {
						echo 'value: '.$data.',';
					} else {
						echo 'range: true,';
						echo 'values: ['.implode(',',$data).'],';
					}
					echo 'step:' .$box['step'].',';
					echo 'max: '.$box['max'].',';
					echo 'min: '.$box['min'].',';
					if(!is_array($data)) {
						echo 'slide: function(e,ui) { jQuery("#'.$box['id'].'-handle").text(ui.value); jQuery("#'.$box['id'].'").val(ui.value); },';
					} else {
						echo 'slide: function(e,ui) { jQuery("#'.$box['id'].'-handle").text(ui.values[0]+"-"+ui.values[1]); jQuery("#'.$box['id'].'").val(ui.values[0]+"-"+ui.values[1]); },';
					}
					echo '}); </script>';
					echo '</td>';
					break;
					
				case 'date':
					if(strlen($data) > 0) $data = date('m/d/Y',$data);
					echo '<td><input type="text" name="'.$box['id'].'" id="'.$box['id'].'" value="'.$data.'" /> <span class="description">'.$box['desc'].'</span></td>';
					echo '<script type="text/javascript">jQuery("#'.$box['id'].'").datepicker();</script>';
					break;
			}
			if($box['type'] != 'title' AND $box['type'] != 'paragraph' AND $box['type'] != 'subtitle') echo '</tr>';
		}
		if($this->table = true) echo '</table>';
		echo '<p class="submit"><input type="submit" name="Submit" class="button-primary" value="'.esc_attr(__('Save Changes')).'" /></p>';
		echo '<input type="hidden" name="action" value="save" />';
		echo '</form></div>';
	}
	
	private function save() {
		foreach($this->boxes as $box) {
			$data = isset($_POST[$box['id']]) ? $_POST[$box['id']] : '';
			if($box['type'] == 'editor') {
				$data = wptexturize(wpautop($data));
			}
			if($box['type'] == 'checkbox') {
				if($data != 'true') {
					$data = 'false';
				}
			}
			if($box['type'] == 'upload') {
				if($_FILES[$box['id']]['size'] > 0) {
					$data = wp_handle_upload($_FILES[$box['id']], array('test_form' => false));
				} else {
					$data = get_option($box['id']);
				}
				$data['title'] = $_POST[$box['id'].'_title'];
			}
			if($box['type'] == 'slider') {
				if(strpos($data, '-') !== false) {
					$data = explode('-',$data);
				}
			}
			if($box['type'] == 'date') {
				$date = explode('/', $data);
				if(isset($date[2])) $data = mktime(0,0,0,$date[0],$date[1],$date[2]);
			}
			update_option($box['id'], $data);
		}
	}
	
	public function loadScripts() {
		wp_enqueue_script('common');
		wp_enqueue_script('jquery-color');
		wp_admin_css('thickbox');
		wp_print_scripts('post');
		wp_print_scripts('media-upload');
		wp_print_scripts('jquery');
		wp_print_scripts('jquery-ui-core');
		wp_print_scripts('jquery-ui-tabs');
		wp_print_scripts('tiny_mce');
		wp_print_scripts('editor');
		wp_print_scripts('editor-functions');
		add_thickbox();
		wp_admin_css();
		wp_enqueue_script('utils');
		do_action("admin_print_styles-post-php");
		do_action('admin_print_styles');
		remove_all_filters('mce_external_plugins');
	}
}

class TopPage extends AdminPage {

	public function __construct($args) {
		$this->args = $args;
		$this->top = $this->args['menu_slug'];
		add_action('admin_menu', array($this, 'renderTopPage'));
		add_action('admin_head', array($this, 'loadScripts'));
	}
	
	public function renderTopPage() {
		$default = array(
			'capability' => 'edit_themes',
		);
		$this->args = array_merge($default, $this->args);
		add_menu_page($this->args['page_title'], $this->args['menu_title'], $this->args['capability'], $this->args['menu_slug'], array($this, 'outputHTML'), $this->args['icon_url']);
		add_submenu_page($this->args['menu_slug'], $this->args['page_title'], $this->args['page_title'], $this->args['capability'], $this->args['menu_slug'], array($this, 'outputHTML'));
	}
}

class SubPager extends AdminPage {

	public function __construct($top, $args) {
		if(is_object($top)) {
			$this->top = $top->top;
		} else {
			switch($top) {
				case 'posts':
					$this->top = 'edit.php';
					break;
				
				case 'dashboard':
					$this->top = 'index.php';
					break;
				
				case 'media':
					$this->top = 'upload.php';
					break;
				
				case 'links':
					$this->top = 'link-manager.php';
					break;
				
				case 'pages':
					$this->top = 'edit.php?post_type=page';
					break;
				
				case 'comments':
					$this->top = 'edit-comments.php';
					break;
				
				case 'theme':
					$this->top = 'themes.php';
					break;
				
				case 'plugins':
					$this->top = 'plugins.php';
					break;
				
				case 'users':
					$this->top = 'users.php';
					break;
				
				case 'tools':
					$this->top = 'tools.php';
					break;
				
				case 'settings':
					$this->top = 'options-general.php';
					break;
			
				default:
					if(post_type_exists($top)) {
						$this->top = 'edit.php?post_type='.$top;
					} else {
						$this->top = $top;
					}
			}
		}
		if(is_array($args)) {
			$this->args = $args;
		} else {
			$array['page_title'] = $args;
			$this->args = $array;
		}
		add_action('admin_menu', array($this, 'renderSubPager'));
		add_action('admin_head', array($this, 'loadScripts'));
	}
	
	public function renderSubPager() {
		$default = array(
			'capability' => 'edit_themes',
		);
		$this->args = array_merge($default, $this->args);
		add_submenu_page($this->top, $this->args['page_title'], $this->args['page_title'], $this->args['capability'], $this->createSlug(), array($this, 'outputHTML'));
	}
	
	private function createSlug() {
		$slug = $this->args['page_title'];
		$slug = strtolower($slug);
		$slug = str_replace(' ','_',$slug);
		return $this->top.'_'.$slug;
	}
}
