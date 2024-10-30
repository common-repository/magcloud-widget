<?php
/*
	Plugin Name: Magcloud Widget
	Plugin URI: http://galalaly.me
	Description: This widget will embed the magcloud published material with custom template.
	Author: Galal Aly
	Author URI: http://galalaly.me
	Version: 1.0
*/
class MagcloudWidget extends WP_Widget {

	public function __construct() {
		// widget actual processes
		parent::__construct(
	 		'issue_cover_widget', // Base ID
			'Magcloud Widget', // Name
			array( 'description' => 'Magcloud Widget', ) // Args
		);
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget
		extract( $args );
		$plugin_path = plugin_dir_path(__FILE__);
		echo file_get_contents($plugin_path.'/magcloud-output.html');
	}

 	public function form( $instance ) {
		// outputs the options form on admin
 		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = "Customize title from Dashboard";
		}
		if ( isset( $instance[ 'magcloud_html' ] ) ) {
			$html = $instance[ 'magcloud_html' ];
		}
		else {
			$html = <<<HTML
				<div style="width:615px;background-color:#F6F6F6;border:7px solid #F6F6F6;-moz-border-radius:4px;-webkit-border-radius:4px; color: #383131;">    <a href="#" class="test_navToIssue">      <img src="#" style="width:150px; float: left; margin-right:15px;border:0;" alt="New Publication" />    </a>    <div style="width:435px;float:left;">      <p style="margin:4px 0 0 0;font-family:'Trebuchet MS', Trebuchet, Sans-Serif">                <a href="#" style="color:#0E467D;font-size:16px;text-decoration:none;font-weight:bold;" class="test_navToIssue">New Publication</a>      </p>    <p style="margin:9px 0 0 0;font-size:14px;line-height:21px;">      30 pages of comparisons and applying the TLCC framework on Egyptian market. It shows that there is no attention at all given to Egyptian market from Foreign manufacturers.    </p>    <p style="margin:0;">      <a href="#" class="test_navToIssue">        <img src="#" alt="Find out more on MagCloud" style="margin:19px 0 6px 0;border:0;" />      </a>    </p></div><div style="clear:both;"></div></div>
HTML;
		}
		if ( isset( $instance[ 'template_html' ] ) ) {
			$template = $instance[ 'template_html' ];
		}
		else {
			$template = "Customize html from Dashboard";
		}
		if ( isset( $instance[ 'trim_desc' ] ) ) {
			$trim_desc = $instance[ 'trim_desc' ];
		}
		else {
			$trim_desc = 0;
		}
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title to display:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'magcloud_html' ); ?>"><?php _e( 'MagCloud Code:' ); ?></label> 
				<textarea class="widefat" id="<?php echo $this->get_field_id( 'magcloud_html' ); ?>" name="<?php echo $this->get_field_name( 'magcloud_html' ); ?>" ><?php echo $html; ?></textarea>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'template_html' ); ?>"><?php _e( 'Template Code:' ); ?></label> 
				<textarea class="widefat" id="<?php echo $this->get_field_id( 'template_html' ); ?>" name="<?php echo $this->get_field_name( 'template_html' ); ?>" ><?php echo $template; ?></textarea>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'trim_desc' ); ?>"><?php _e( 'Trim description after:' ); ?></label> 
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'trim_desc' ); ?>" name="<?php echo $this->get_field_name( 'trim_desc' ); ?>" value="<?php echo $trim_desc; ?>" />
			</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {

		// processes widget options to be saved
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['magcloud_html'] =  $new_instance['magcloud_html'];
		$instance['template_html'] = $new_instance['template_html'];
		$instance['trim_desc'] = intval(trim($new_instance['trim_desc']));

		// Process HTML
		$plugin_path = plugin_dir_path(__FILE__);
		// Load the library 
		require($plugin_path.'/html-parser.php');
		$html = str_get_html( $instance['magcloud_html'] );
		// Get the first a tag
		$parent_for_image_and_url = $html->find('div', 0)->find('a', 0);
		// Get the image
		$image = $parent_for_image_and_url->find('img', 0)->src;
		// Get the url for the magazine
		$url = $parent_for_image_and_url->href;
		$paragraphs = $html->find('div div p');
		// Get the Category
		$issue_category = $paragraphs[0]->find('span', 0)->plaintext;
		// Get the title
		$issue_title = $paragraphs[0]->find('a', 0)->plaintext;
		// Get the description
		$issue_description = $paragraphs[1]->plaintext;
		// Trim if enabled
		$issue_description = ($instance['trim_desc'] == 0)?$issue_description:MagcloudWidget::trim_string(trim($issue_description), $instance['trim_desc']);
		// We have all data now, let's output the HTML
		$output = $instance['template_html'];
		/**
		 * [widget_title]: The title entered by the user in the dashboard
		 * [magcloud_title]: Title returned by Magcloud
		 * [magcloud_description]: Description returned by Magcloud
		 * [magcloud_category]: Category in Magcloud
		 * [magcloud_url]: URL for the magazine in Magcloud
		 * [magcloud_image]: URL for the image
		 */
		$output = str_replace( '[widget_title]', $instance['title'], $output);
		$output = str_replace( '[magcloud_title]', $issue_title, $output);
		$output = str_replace( '[magcloud_description]', $issue_description, $output);
		$output = str_replace( '[magcloud_category]', $issue_category, $output);
		$output = str_replace( '[magcloud_url]', $url, $output);
		$output = str_replace( '[magcloud_image]', $image, $output);
		ob_start();
		echo $output;
		file_put_contents($plugin_path.'/magcloud-output.html', ob_get_contents());
		ob_end_flush();
		return $instance;
	}

	private static function trim_string($string, $length) {
		return (strlen($string) > $length) ? substr($string,0,$length).'...' : $string;
	}

}

// register widget
add_action( 'widgets_init', create_function( '', 'return register_widget( "MagcloudWidget" );' ) );

?>