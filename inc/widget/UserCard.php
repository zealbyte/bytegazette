<?php
namespace ZealByte\Widget;

use WP_Widget;
/*-----------------------------------------------------------------------------------


-----------------------------------------------------------------------------------*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class UserCard extends WP_Widget
{
	public function __construct()
	{
		parent::__construct(
	 		'zealbyte_widget_usercard',
			esc_html__( '(ZealByte) User Card', 'zealbyte' ),
			[ 'description' => esc_html__( 'Show the current user card or a login form.', 'zealbyte' ) ]
		);
	}

	public function form( $instance )
	{
		$option_defaults = [
			'show_avatar'   => 1,
			'show_user'     => 1,
			'show_remember' => 1,
			'show_register' => 1,
			'show_forgot'   => 1,
			'show_dash'     => 1,
		];

		$option_labels = [
			'show_avatar'   => __( 'Show Avatar', BYTEGAZETTE_THEME_DOMAIN ),
			'show_user'     => __( 'Show Logged in User name', BYTEGAZETTE_THEME_DOMAIN ),
			'show_remember' => __( 'Show Remember me', BYTEGAZETTE_THEME_DOMAIN ),
			'show_register' => __( 'Show Register Link', BYTEGAZETTE_THEME_DOMAIN ),
			'show_forgot'   => __( 'Show Forgotten Password Link', BYTEGAZETTE_THEME_DOMAIN ),
			'show_dash'     => __( 'Show Dashboard Link', BYTEGAZETTE_THEME_DOMAIN ),
		];

		$title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : esc_html__( 'Login', BYTEGAZETTE_THEME_DOMAIN );
		$this->do_field_text( 'title', $title, __( 'Title', BYTEGAZETTE_THEME_DOMAIN ) );

		foreach ( $option_defaults as $option => $default ) {
			$value = isset( $instance[ $option ] ) ? esc_attr( $instance[ $option ] ) : $default;
			$label = $option_labels[ $option ];

			$this->do_field_checkbox( $option, esc_attr( $value ), esc_html( $label) );
		}
	}

	public function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['show_avatar'] = intval( $new_instance['show_avatar'] );
		$instance['show_user'] = intval( $new_instance['show_user'] );
		$instance['show_remember'] = intval( $new_instance['show_remember'] );
		$instance['show_register'] = intval( $new_instance['show_register'] );
		$instance['show_forgot'] = intval( $new_instance['show_forgot'] );
		$instance['show_dash'] = intval( $new_instance['show_dash']);

		return $instance;
	}

	public function widget( $args, $instance )
	{
		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;

		if ( !empty( $title ) ) {
			echo $before_title;
			echo $title;
			echo $after_title;
		}

		if ( is_user_logged_in() ) {
			// if the user is logged in we show the user card
			$this->do_card_user( $args, $instance );
		}
		else {
			// if the user is not logged in we show login form
			$this->do_card_login( $args, $instance );
		}

		echo $after_widget;
	}

	protected function do_card_login( $args, $instance )
	{
		$redirect = site_url();
		$show_remember = (int) $instance['show_remember'];
		$show_register = (int) $instance['show_register'];
		$show_forgot = (int) $instance['show_forgot'];

		$remember_val = ( $show_remember == 1 ) ? true : false;

		if ( isset( $_GET['login'] ) ) {
			$login = $_GET['login']; // This variable is used when login failure occurs
			$current_error = $_GET['errcode']; // This variable is used to display the type of error during login

			if ( $login == 'failed' ) {

				if ( $current_error == "empty_username" || $current_error == "empty_password" ){
					$error_msg = esc_html__( 'Enter both Username and Password', BYTEGAZETTE_THEME_DOMAIN );
				}
				elseif( $current_error == 'invalid_username' ){
					$error_msg = esc_html__( 'Username is not registered', BYTEGAZETTE_THEME_DOMAIN );
				}
				elseif( $current_error == 'incorrect_password' ){
					$error_msg = esc_html__( 'Incorrect Password', BYTEGAZETTE_THEME_DOMAIN );
				}

				echo "<div id='message' class='error fade'><p><strong>".$error_msg."</strong></p></div>";
			}
		}

		wp_login_form( [
			'value_remember' => 0,
			'redirect' => $redirect,
			'label_username' 	=> esc_html__( 'Username', BYTEGAZETTE_THEME_DOMAIN ),
			'label_password' 	=> esc_html__( 'Password', BYTEGAZETTE_THEME_DOMAIN ),
			'remember' 	=> $remember_val
		] );

		?>
			<ul class="uk-subnav uk-subnav-divider">
				<?php echo ( $show_register ? '<a href="' . wp_registration_url() . '" title="Register">'.esc_html__( 'Register', BYTEGAZETTE_THEME_DOMAIN ).'</a>' : '' ); ?>
				<?php echo ( $show_forgot ? '<a href="' . wp_lostpassword_url( $redirect ) . '?sli=lost" rel="nofollow" title="Forgot Password">' . esc_html__( 'Lost Password?', BYTEGAZETTE_THEME_DOMAIN ) . '</a>' : '' ); ?>
			</ul>
		<?php
	}

	protected function do_card_user( $args, $instance )
	{
		global $user_login;

		$show_avatar = (int) $instance['show_avatar'];
		$show_user = (int) $instance['show_user'];
		$show_dash = (int) $instance['show_dash'];

		$user_info = get_user_by( 'login', $user_login );
		$user_name = ( !empty( $user_info->first_name ) || !empty( $user_info->last_name) ) ? $user_info->first_name." ".$user_info->last_name :  $user_login;

		$redirect = site_url();

		?>
			<div class="uk-grid-collapse uk-flex-middle" uk-grid>
				<?php echo $show_avatar ? '<div class="avatar uk-width-auto">' . get_avatar( $user_info->ID, apply_filters( 'login_widget_avatar_size', 72 ) ) . '</div>' : '' ?>
				<?php echo $show_user ? '<div class="uk-width-expand"><strong>' . $user_name . '</strong><p class="uk-text-meta uk-margin-remove-top">' . ucfirst( implode(', ', $user_info->roles)) . '</p></div>' : '' ?>
			</div>

			<ul class="uk-subnav uk-subnav-divider">
				<?php echo ( $show_dash ? '<li><a href="' . admin_url() . '">' . esc_html( 'Dashboard' , BYTEGAZETTE_THEME_DOMAIN ) . '</a></li>' : '' ); ?>
				<li><a href="<?php echo wp_logout_url( $redirect ); ?>"><?php esc_html_e( 'Logout' , BYTEGAZETTE_THEME_DOMAIN ) ?></a></li>
			</ul>
		<?php
	}

	protected function do_field_text( $field_id, $value, $label = null )
	{
		$id = $this->get_field_id( $field_id );
		$name = $this->get_field_name( $field_id );
		$value = esc_attr( $value );

		?>
			<p>
				<label for="<?php echo $id; ?>"><?php esc_html_e( $label ?: $field_id ); ?></label>
				<input class="widefat" id="<?php echo $id; ?>" name="<?php echo $name; ?>" type="text" value="<?php echo $value; ?>" />
			</p>
		<?php
	}

	protected function do_field_checkbox( $field_id, $value, $label = null )
	{
		$id = $this->get_field_id( $field_id );
		$name = $this->get_field_name( $field_id );
		$ch = checked( 1, $value, false );

		?>
			<p>
				<label for="<?php echo $id; ?>">
					<input type="checkbox" class="checkbox" id="<?php echo $id; ?>" name="<?php echo $name; ?>" value="1" <?php echo $ch ?> />
					<?php esc_html_e( $label ?: $field_id ); ?>
				</label>
			</p>
		<?php
	}
}

// This method will handle the login failure process.
function handle_login_failure( $username )
{
	// check what page the login attempt is coming from
	global $current_error;
	$referrer = $_SERVER['HTTP_REFERER'];

	if ( !empty( $referrer ) && !strstr( $referrer, 'wp-login' ) && !strstr( $referrer, 'wp-admin' ) ) {
		wp_redirect( home_url() . '/?login=failed&errcode='.$current_error );
		exit;
	}
}
add_action( 'wp_login_failed', 'handle_login_failure' );
