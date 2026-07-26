<?php 

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$mb_settings = apply_filters( 'mb_admin_settings', array() );

?>

<?php if ( $mb_settings ): 
    $current_tab = isset( $_GET['tab'] ) && $_GET['tab'] ? $_GET['tab'] : current( array_keys( $mb_settings ) );
?>
    <form method="POST" name="ova_mb_options" action="options.php">
        <?php settings_fields( $this->options->_prefix ); ?>
        <div class="wrap ova_mb_settings_wrapper">
            <!--    Tabs    -->
            <h2 class="nav-tab-wrapper">
                <?php foreach( $mb_settings as $key => $title ): ?>
                    <a href="<?php echo esc_url( admin_url( 'admin.php?page=ova_mb_setting&tab=' . $key ) ); ?>" class="nav-tab<?php echo $current_tab === $key ? ' nav-tab-active' : ''; ?>" data-tab="<?php echo esc_attr( $key ); ?>">
                        <?php printf( '%s', $title ); ?>
                    </a>

                <?php endforeach; ?>
            </h2>
            <div class="ova_mb_wrapper_content" data-edit-url="<?php echo esc_attr( wp_unslash( $_SERVER['SCRIPT_NAME'] ) ); ?>">
                <?php foreach( $mb_settings as $key => $title ): ?>
                    <div id="<?php echo esc_attr( $key ) ?>" class="mb-tab<?php echo $current_tab === $key ? ' mb-tab-active' : ''; ?>">
                        <?php do_action( 'mb_admin_setting_' . $key . '_content' ); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php submit_button(); ?>
    </form>
<?php endif; ?>