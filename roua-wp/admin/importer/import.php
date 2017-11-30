<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class rouaImport
 *
 * Import the demo content & set the menu & homepage.
 *
 * @author Stylish Themes
 * @since 1.0.0
 */
class rouaImport {

	public $error	= '';
	public $urls	= array(
		'roua'		=> 'http://demo.stylishthemes.co/roua/',
	);
	
	
	/** ---------------------------------------------------------------------------
	 * Constructor
	 * ---------------------------------------------------------------------------- */
	function __construct() {
		add_action( 'admin_menu', array( &$this, 'init' ) );
	}
	
	
	/** ---------------------------------------------------------------------------
	 * Add theme Page
	 * ---------------------------------------------------------------------------- */
	function init() {
		
        add_menu_page(
            'ROUA Import Demo Data',
            'ROUA Demo Data',
            'administrator',
            'roua_import',
            array( &$this, 'import' )
        );
			
		wp_enqueue_style( 'roua.import', THEMEROOT. '/admin/importer/import.css', false, time(), 'all');
		wp_enqueue_script( 'roua.import', THEMEROOT. '/admin/importer/import.js', false, time(), true );

	}
	
	
	/** ---------------------------------------------------------------------------
	 * Import | Content
	 * ---------------------------------------------------------------------------- */
	function import_content( $file = 'roua.xml.gz' ){
		$import = new WP_Import();
		$xml = THEMEDIR . '/admin/importer/demo/'. $file;
// 		print_r($xml);
		
		$import->fetch_attachments = ( $_POST && key_exists('attachments', $_POST) && $_POST['attachments'] ) ? true : false;
		
		ob_start();
		$import->import( $xml );
		ob_end_clean();
	}
	
	
	/** ---------------------------------------------------------------------------
	 * Import | Menu - Locations 
	 * ---------------------------------------------------------------------------- */
	function import_menu_location( $file = 'menu.txt' ){
		$file_path 	= THEMEROOT . '/admin/importer/demo/'. $file;
		$file_data 	= wp_remote_get( $file_path );
		$data 		= unserialize( base64_decode( $file_data['body']));
		$menus 		= wp_get_nav_menus();
			
		foreach( $data as $key => $val ){
			foreach( $menus as $menu ){
				if( $menu->slug == $val ){
					$data[$key] = absint( $menu->term_id );
				}
			}
		}
// 		print_r($data);
		
		set_theme_mod( 'nav_menu_locations', $data );
	}
	

	/** ---------------------------------------------------------------------------
	 * Import
	 * ---------------------------------------------------------------------------- */
	function import(){
		global $wpdb;
		
		if( key_exists( 'mfn_import_nonce',$_POST ) ){
			if ( wp_verify_nonce( $_POST['mfn_import_nonce'], basename(__FILE__) ) ){
				
// 				print_r($_POST);
	
				// Importer classes
				if( ! defined( 'WP_LOAD_IMPORTERS' ) ) define( 'WP_LOAD_IMPORTERS', true );
				
				if( ! class_exists( 'WP_Importer' ) ){
					require_once ABSPATH . 'wp-admin/includes/class-wp-importer.php';
				}
				
				if( ! class_exists( 'WP_Import' ) ){
					require_once THEMEDIR . '/admin/importer/wordpress-importer.php';
				}
				
				if( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ){
					
					switch( $_POST['import'] ) {
						
						case 'all':
							// import content
							$this->import_content();

                            // set menu
							$this->import_menu_location();

							// set home
							$home = get_page_by_title( 'Portfolio' );
							if( $home->ID ) {
								update_option('show_on_front', 'page');
								update_option('page_on_front', $home->ID); // Front Page
							}
							break;

                        case 'shop':
                            // import content
                            $this->import_content('shop.xml.gz');

                            // set menu
                            $this->import_menu_location();

                            // set home
                            $home = get_page_by_title( 'Portfolio' );
                            if( $home->ID ) {
                                update_option('show_on_front', 'page');
                                update_option('page_on_front', $home->ID); // Front Page
                            }
                            break;
							
						default:
							// Empty select.import
							$this->error = __('Please select data to import.', LANGUAGE_ZONE);
							break;
					}
					
					// message box
					if( $this->error ){
						echo '<div class="error settings-error">';
							echo '<p><strong>'. $this->error .'</strong></p>';
						echo '</div>';
					} else {
						echo '<div class="updated settings-error">';
							echo '<p><strong>'. __('All done. Have fun!', LANGUAGE_ZONE) .'</strong></p>';
						echo '</div>';
					}

				}
	
			}
		}

		?>
		<div id="mfn-wrapper" class="mfn-import wrap">
		
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			
			<p><strong>Notice:</strong></p>
			<p>
				Before starting the import, you need to install all required plugins.<br />
			</p>
	
			<form action="" method="post">
				
				<input type="hidden" name="mfn_import_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />
				
				<table class="form-table">
				
					<tr class="row-import">
						<th scope="row">
							<label for="import">Import</label>
						</th>
						<td>
							<select name="import" class="import">
								<option value="">-- Select --</option>
								<option value="all">Without SHOP</option>
                                <option value="shop">With SHOP</option>
							</select>
						</td>
					</tr>
					
					<!--  TODO: !!!!! ADD NEW DEMOS TO $urls ARRAY !!!!! -->
					
					<tr class="row-attachments hide">
						<th scope="row">Attachments</th>
						<td>
							<fieldset>
								<label for="attachments"><input type="checkbox" value="1" id="attachments" name="attachments">Import attachments</label>
								<p class="description">Download all attachments from the demo may take a while. Please be patient.</p>
							</fieldset>
						</td>
					</tr>
				
				</table>
	
				<input type="submit" name="submit" class="button button-primary" value="Import demo data" />
					
			</form>
	
		</div>	
		<?php	
	}

    function create_menu_code(){

        $data = array('main-menu' => 'ROUA');

        echo base64_encode(serialize($data));

    }

}

$mfn_import = new rouaImport;
?>