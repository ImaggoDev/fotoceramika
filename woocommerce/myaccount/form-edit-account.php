<?php
/**
 * Edit account form
 *
 * @version     3.5.0
 */

defined( 'ABSPATH' ) || exit;

$porto_woo_version = porto_get_woo_version_number();
if ( version_compare( $porto_woo_version, '2.6', '<' ) ) :
	wc_print_notices();
	?>
	<div class="featured-box align-left">
		<div class="box-content">
<?php endif; ?>

<?php do_action( 'woocommerce_before_edit_account_form' ); ?>
<div class="edit__account">
<h5 class="edit__account--title">Dane osobowe</h5>
<form action="" method="post" class="woocommerce-EditAccountForm edit-account" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>
<div class="row">
	<div class="col-lg-4">
		<p class="woocommerce-FormRow form-row">
			<label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text line-height-xl input-text" name="account_first_name" id="account_first_name"  placeholder="Wypełnij pole" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
		</p>
	</div>
	<div class="col-lg-4">
	<p class="woocommerce-FormRow form-row">
		<label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text line-height-xl input-text" name="account_last_name" id="account_last_name"  placeholder="Wypełnij pole" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
	</p>
	<div class="clear"></div>
	</div>
	<div class="col-lg-4">
	<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
		<label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="email" class="woocommerce-Input woocommerce-Input--email line-height-xl input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
	</p>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<h5 class="edit__account--title password">Zmiana hasła</h5>
	</div>
</div>
<div class="row">
	<div class="col-lg-4">
		<p class="woocommerce-FormRow form-row">
			<label for="password_current"><?php esc_html_e( 'Aktualne hasło', 'woocommerce' ); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password line-height-xl input-text" name="password_current" id="password_current" placeholder="****************" autocomplete="off" />
		</p>
	</div>
	<div class="col-lg-4">
		<p class="woocommerce-FormRow form-row">
			<label for="password_1"><?php esc_html_e( 'Nowe hasło', 'woocommerce' ); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password line-height-xl input-text" name="password_1" id="password_1" autocomplete="off" placeholder="Wypełnij pole" />
		</p>
	</div>
	<div class="col-lg-4">
		<p class="woocommerce-FormRow form-row">
			<label for="password_2"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password line-height-xl input-text" name="password_2" id="password_2" autocomplete="off" placeholder="Wypełnij pole" />
		</p>
	</div>
	<div class="clear"></div>
</div>
	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p class="clearfix text-center">
		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
		<button type="submit" class="woocommerce-Button button button-primary btn-go-shop mt-4" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?><i class="icon icon_btn_arrow white"></i></button>
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>

</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>

<?php if ( version_compare( $porto_woo_version, '2.6', '<' ) ) : ?>
		</div>
	</div>
	</div>
<?php endif; ?>
