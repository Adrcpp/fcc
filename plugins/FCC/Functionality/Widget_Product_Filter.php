<?php

class Widget_Product_Filter extends \WP_Widget {


    public static function singleton()
    {
        static $single;
        return empty( $single ) ? $single = new self() : $single;
    }

	function __construct() {
		parent::__construct(

			// Base ID of your widget
			'Widget_Product_Filter',

			// Widget name will appear in UI
			__('Cheese Product Filter', 'wpb_widget_domain'),

			// Widget description
			array( 'description' => __( 'Filter cheese by texture and milk type', 'wpb_widget_domain' ), )
		);
	}

	// Creating widget front-end
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		// before and after widget arguments are defined by themes
		// echo $args['before_widget'];
		// if ( ! empty( $title ) )
		// echo $args['before_title'] . $title . $args['after_title'];

		// This is where you run the code and display the output
		// echo __( 'Hello, World!', 'wpb_widget_domain' );
		// echo $args['after_widget'];

		$orderby = 'name';
		$order = 'asc';
		$hide_empty = false ;
		$cat_args = array(
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $hide_empty,
			'parent'     => 24
		);

		$texture_cat = get_terms( 'product_cat', $cat_args );

		$cat_args["parent"] = 21;
		$milk_cat = get_terms( 'product_cat', $cat_args );
		//var_dump($milk_cat);
		$milk_options = "<option value='21'>Any</option>";
		$texture_options = "<option value='24'>Any</option>";

		foreach ($texture_cat as $key => $value) {
			$texture_options .= "<option value='". $value->term_id. "'>" . $value->name ."</option>";
		}

		foreach ($milk_cat as $key => $value) {
			$milk_options .= "<option value='". $value->term_id. "'>" . $value->name ."</option>";
		}

		echo '<div class="col-sm-12 product-filter parallax-window">
			<div id="select-filter" class="text-center p-4">
				Show me <select id="texture">'
				. $texture_options.
				'</select> cheese of

				<select id="milk">
				'. $milk_options .'
				</select> milk
			</div>
		</div>';
		$args = array();
		//$products = wc_get_products( $args );
		//var_dump($products[0]);

		$query = new WC_Product_Query();

		$products = $query->get_products();


		echo '<div class="container-fluid bg-black">
        <div id="cheese-count"></div>
        <div class="container">
		<div id="products" class="row">';


		foreach ($products as $key => $value) {

			echo '<div class="col-sm-4 text-center">';
			echo $value->get_image();
			echo '<div class="text-center">';
			echo '<h4 class="title">' .$value->get_name() .'</h4>';
			echo '<a class="show-more" href="' . $value->get_permalink() .'">Show more</a>';
			echo '</div>';
			echo '</div>';

		}

		echo '</div></div></div>';
        ?>
        <script>
            jQuery(document).ready(function( $ ) {

                $('.parallax-window').parallax({imageSrc: 'http://localhost/wordpress/wp-content/uploads/2018/07/shop-hero-img.png'});
                $('.parallax-window').parent().parent().css('padding-bottom', 0);
                
            });
        </script>
        <?php
	}

	// Widget Backend
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'wpb_widget_domain' );
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}

add_action( 'widgets_init',  'myplugin_register_widgets' );
function myplugin_register_widgets() {
    register_widget( 'Widget_Product_Filter' );
}


/*
*  Add the ajax call in the front end for filtering the products:
*/
add_action( 'wp_ajax_filter_product', 'ajax_filter_product' );
function ajax_filter_product() {

    $milk = sanitize_text_field($_POST['milk']);
    $texture = sanitize_text_field($_POST['texture']);

    $is_unique = false;
    $all = false;

    if ($texture == 24 && $milk == 21) {
        $all = true;
    }

    if ($texture == 24) {
        $is_unique = true;
        $texture = null;
    }

    if ($milk == 21) {
        $is_unique = true;
        $milk = null;
    }

    $query = new WC_Product_Query();
    $products = $query->get_products();
    $resp = "";
    $count = 0;

    foreach ($products as $key => $value) {
        $cat_ids = $value->get_category_ids();
        if ( isSelected($all, $cat_ids, $is_unique, $milk, $texture) ) {

            $resp .= '<div class="col-sm-4 text-center">';
            $resp .= $value->get_image();
            $resp .= '<div class="text-center">';
            $resp .= '<h4 class="title">' .$value->get_name() .'</h4>';
            $resp .= '<a class="show-more" href="' . $value->get_permalink() .'">Show more</a>';
            $resp .= '</div>';
            $resp .= '</div>';
            ++$count;
        }
    }

    header( "Content-Type: application/json" );
    echo json_encode(["result" => $resp, "count" => $count]);

    wp_die();
}

function isSelected($all, $cat_ids, $is_unique, $milk, $texture)
{
    if ($all == true)
    return true;

    if ($is_unique) {
        if ($milk != null) {
            return in_array($milk, $cat_ids);
        } else {
            return in_array($texture, $cat_ids);
        }
    }
    return (count(array_diff([$texture, $milk], $cat_ids)) == 0 );
}
