<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $post;

$room_id    = get_the_ID();
$room_url   = get_edit_post_link( $room_id ) ? get_edit_post_link( $room_id ) : '#';
$seats      = $this->get_mb_value( 'seats' );
$areas      = $this->get_mb_value( 'areas' );
$types      = MBC()->mb_get_taxonomies( 'room_type' );

$person_type    = $this->get_mb_value('person_type');
$extra_services = $this->get_mb_value('extra_service');

?>
<div class="mb_room_detail">
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Room ID:', 'moviebooking' ); ?></strong>
            <?php printf( _x( '%s', 'room link', 'moviebooking' ), '<a href="'.esc_url( $room_url ).'" target="_blank">#'.esc_html( $room_id ).'</a>' ); ?>
        </label>
        <br><br>
    </div>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Room Code*:', 'moviebooking' ); ?></strong>
            <input 
                type="text" 
                class="room_code" 
                value="<?php echo esc_attr( $this->get_mb_value( 'code' ) ); ?>" 
                placeholder="<?php esc_attr_e( 'room_1', 'moviebooking' ); ?>" 
                name="<?php echo esc_attr( $this->get_mb_name( 'code' ) ); ?>" 
                autocomplete="off" 
                autocorrect="off" 
                autocapitalize="none" 
                required
            />
        </label>
        <br><br>
    </div>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Type*:', 'moviebooking' ); ?></strong>
        </label>
        <select name="<?php echo esc_attr( $this->get_mb_name( 'type_id' ) ); ?>" class="room_type_id mb_select2" data-placeholder="<?php esc_html_e( 'Choose type', 'moviebooking' ); ?>" required>
            <?php if ( $types ): 
                $type_id    = $this->get_mb_value( 'type_id' );
                $selected   = '';

                foreach( $types as $type_item ):
                    if ( $type_id == $type_item->term_id ) {
                        $selected = ' selected';
                    } else {
                        $selected = '';
                    }
            ?>
                    <option value="<?php echo esc_attr( $type_item->term_id ); ?>"<?php echo esc_html( $selected ); ?>>
                        <?php echo esc_html( $type_item->name ); ?>
                    </option>
            <?php endforeach; endif; ?>
        </select>
        <br><br>
    </div>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Shortcode Image Map*:', 'moviebooking' ); ?></strong>
            <input 
                type="text" 
                class="room_shortcode_img_map" 
                value="<?php echo esc_attr( $this->get_mb_value( 'shortcode_img_map' ) ); ?>" 
                placeholder="<?php esc_attr_e( '[shortcode_seat_map]', 'moviebooking' ); ?>" 
                name="<?php echo esc_attr( $this->get_mb_name( 'shortcode_img_map' ) ); ?>" 
                autocomplete="off" 
                autocorrect="off" 
                autocapitalize="none" 
                required />
        </label>
    </div>
    <br/><hr/><br/>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Add Seat*', 'moviebooking' ); ?></strong>
            <div class="wrap_seat_map">
                <?php if ( ! empty( $seats ) && is_array( $seats ) ): ?>
                    <?php foreach( $seats as $k => $seat ): ?>
                        <div class="item-seat">
                            <div class="seat-id-field item-seat-field">
                                <label><?php esc_html_e( 'Seat*', 'moviebooking' ); ?></label>
                                <input 
                                    type="text" 
                                    class="seat-map-id" 
                                    value="<?php echo esc_attr( $seat['id'] ); ?>" 
                                    placeholder="<?php esc_attr_e( 'A1, A2, A3, ...', 'moviebooking' ); ?>" 
                                    name="<?php echo esc_attr( $this->get_mb_name( 'seats' ) ).'['.$k.']'.'[id]'; ?>" 
                                    autocomplete="off" 
                                    autocorrect="off" 
                                    autocapitalize="none" 
                                    required />
                            </div>
                            <div class="seat-price-field item-seat-field">
                                <label><?php printf( esc_html__( 'Price(%s)*', 'moviebooking' ), MBC()->mb_get_currency() ); ?></label>
                                <input 
                                    type="text" 
                                    class="seat-map-price" 
                                    value="<?php echo esc_attr( $seat['price'] ); ?>" 
                                    placeholder="<?php esc_attr_e( '10', 'moviebooking' ); ?>" 
                                    name="<?php echo esc_attr( $this->get_mb_name( 'seats' ) ).'['.$k.']'.'[price]'; ?>" 
                                    autocomplete="off" 
                                    autocorrect="off" 
                                    autocapitalize="none" 
                                    required />
                            </div>
                            <div class="seat-type-field item-seat-field">
                                <label><?php esc_html_e( 'Type', 'moviebooking' ); ?></label></label>
                                <input 
                                    type="text" 
                                    class="seat-map-type" 
                                    value="<?php echo esc_attr( $seat['type'] ); ?>" 
                                    placeholder="<?php esc_attr_e( 'Standard', 'moviebooking' ); ?>" 
                                    name="<?php echo esc_attr( $this->get_mb_name( 'seats' ) ).'['.$k.']'.'[type]'; ?>" 
                                    autocomplete="off" 
                                    autocorrect="off" 
                                    autocapitalize="none" />
                            </div>
                            <div class="item-seat-field seat-description-field">
                                <label><?php esc_html_e( 'Description', 'moviebooking' ); ?></label></label>
                                <input 
                                    type="text" 
                                    class="seat-map-description" 
                                    value="<?php echo esc_attr( $seat['description'] ); ?>" 
                                    placeholder="<?php esc_attr_e( 'Description of type seat', 'moviebooking' ); ?>" 
                                    name="<?php echo esc_attr( $this->get_mb_name( 'seats' ) ).'['.$k.']'.'[description]'; ?>" 
                                    autocomplete="off" 
                                    autocorrect="off" 
                                    autocapitalize="none" />
                            </div>
                            <div class="seat-color-field item-seat-field">
                                <label><?php esc_html_e( 'Color', 'moviebooking' ); ?></label></label>
                                <input 
                                    type="text" 
                                    class="seat-map-color mb-colorpicker" 
                                    value="<?php echo esc_attr( $seat['color'] ); ?>" 
                                    name="<?php echo esc_attr( $this->get_mb_name( 'seats' ) ).'['.$k.']'.'[color]'; ?>" 
                                    autocomplete="off" 
                                    autocorrect="off" 
                                    autocapitalize="none" />
                            </div>
                            <a href="javascript:void(0)" class="btn remove_seat_map">
                                <i class="dashicons-before dashicons-no-alt"></i>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </label>
    </div>
    <div class="btn_add_seat_map">
        <button class="button add_seat_map">
            <?php esc_html_e( 'Add new seat', 'moviebooking' ); ?>
        </button>
        <div class="mb-loading">
            <i class="dashicons-before dashicons-update-alt"></i>
        </div>
    </div>
    <br/><hr/><br/>
    <div class="ova_row">
        <label><strong><?php esc_html_e( 'Person Type', 'moviebooking' ); ?></strong></label>
        <ul class="list_person_type">
            <?php if ( ! empty( $person_type ) ): ?>
                <?php foreach ( $person_type as $key => $person ): ?>
                    <li class="person_type_item">
                        <input class="mb_person_type" name="<?php echo esc_attr( MB_PLUGIN_PREFIX_ROOM.'person_type'.'['.$key.']' ); ?>" type="text" value="<?php echo esc_attr( $person ); ?>" class="regular-text">
                        <button type="button" class="mb_remove_person_type button button-secondary"><span class="dashicons dashicons-no-alt"></span></button>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <button type="button" data-nonce="<?php echo esc_attr( wp_create_nonce( 'mb_add_person_type' ) ); ?>" class="mb_add_person_type button button-secondary">
            <?php esc_html_e( 'Add person type', 'moviebooking' ); ?>
        </button>
    </div>
    <br/><hr/><br/>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Add Area*', 'moviebooking' ); ?></strong>
            <div class="wrap_area_map">
                <?php if ( ! empty( $areas ) && is_array( $areas ) ): ?>
                    <?php foreach( $areas as $k => $area ): ?>
                        <div class="item-area">
                            <div class="area-id-field item-area-field">
                                <label><?php esc_html_e( 'Area*', 'moviebooking' ); ?></label>
                                <input 
                                    type="text" 
                                    class="area-map-id" 
                                    value="<?php echo esc_attr( $area['id'] ); ?>" 
                                    placeholder="<?php esc_attr_e( 'Insert only an Area', 'moviebooking' ); ?>" 
                                    name="<?php echo esc_attr( $this->get_mb_name( 'areas' ) ).'['.$k.']'.'[id]'; ?>" 
                                    autocomplete="off" 
                                    autocorrect="off" 
                                    autocapitalize="none" 
                                    required />
                            </div>
                            <?php if ( ! empty( $area['person_price'] ) ): ?>
                                <?php foreach ( $area['person_price'] as $key => $value ): ?>
                                    <div class="area-person-price-field item-area-field">
                                        <label><?php printf( esc_html__( '%1$s(%2$s)*', 'moviebooking' ), $person_type[$key] ,MBC()->mb_get_currency() ); ?></label>
                                        <input 
                                            type="text" 
                                            class="area-map-person-price" 
                                            value="<?php echo esc_attr( $value ); ?>" 
                                            placeholder="<?php esc_attr_e( '10', 'moviebooking' ); ?>" 
                                            name="<?php echo esc_attr( 'ova_mb_room_areas'.'['.$k.']'.'[person_price]'.'['.$key.']'); ?>" 
                                            autocomplete="off" 
                                            autocorrect="off" 
                                            autocapitalize="none" 
                                            required />
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <div class="area-price-field item-area-field">
                                <label><?php printf( esc_html__( 'Price(%s)*', 'moviebooking' ), MBC()->mb_get_currency() ); ?></label>
                                <input 
                                    type="text" 
                                    class="area-map-price" 
                                    value="<?php echo esc_attr( $area['price'] ); ?>" 
                                    placeholder="<?php esc_attr_e( '10', 'moviebooking' ); ?>" 
                                    name="<?php echo esc_attr( $this->get_mb_name( 'areas' ) ).'['.$k.']'.'[price]'; ?>" 
                                    autocomplete="off" 
                                    autocorrect="off" 
                                    autocapitalize="none" 
                                    required />
                            </div>
                            <div class="area-qty-field item-area-field">
                                <label><?php esc_html_e( 'Quantity*', 'moviebooking' ); ?></label>
                                <input
                                    type="number"
                                    class="area-map-qty"
                                    value="<?php echo esc_attr( $area['qty'] ); ?>"
                                    placeholder="<?php esc_attr_e( '100', 'moviebooking' ); ?>"
                                    name="<?php echo esc_attr( $this->get_mb_name( 'areas' ) ).'['.$k.']'.'[qty]'; ?>"
                                    min="0"
                                    autocomplete="off" 
                                    autocorrect="off" 
                                    autocapitalize="none" 
                                    required />
                            </div>
                            <div class="area-type-field item-area-field">
                                <label><?php esc_html_e( 'Type', 'moviebooking' ); ?></label></label>
                                <input 
                                    type="text" 
                                    class="area-map-type" 
                                    value="<?php echo esc_attr( $area['type'] ); ?>" 
                                    placeholder="<?php esc_attr_e( 'Standard', 'moviebooking' ); ?>" 
                                    name="<?php echo esc_attr( $this->get_mb_name( 'areas' ) ).'['.$k.']'.'[type]'; ?>" 
                                    autocomplete="off" 
                                    autocorrect="off" 
                                    autocapitalize="none" />
                            </div>
                            <div class="item-area-field area-description-field">
                                <label><?php esc_html_e( 'Description', 'moviebooking' ); ?></label></label>
                                <input 
                                    type="text" 
                                    class="area-map-description" 
                                    value="<?php echo esc_attr( $area['description'] ); ?>" 
                                    placeholder="<?php esc_attr_e( 'Description of type area', 'moviebooking' ); ?>" 
                                    name="<?php echo esc_attr( $this->get_mb_name( 'areas' ) ).'['.$k.']'.'[description]'; ?>" 
                                    autocomplete="off" 
                                    autocorrect="off" 
                                    autocapitalize="none" />
                            </div>
                            <div class="area-color-field item-area-field">
                                <label><?php esc_html_e( 'Color', 'moviebooking' ); ?></label></label>
                                <input 
                                    type="text" 
                                    class="area-map-color mb-colorpicker" 
                                    value="<?php echo esc_attr( $area['color'] ); ?>" 
                                    name="<?php echo esc_attr( $this->get_mb_name( 'areas' ) ).'['.$k.']'.'[color]'; ?>" 
                                    autocomplete="off" 
                                    autocorrect="off" 
                                    autocapitalize="none" />
                            </div>
                            <a href="javascript:void(0)" class="btn remove_area_map">
                                <i class="dashicons-before dashicons-no-alt"></i>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </label>
    </div>
    <div class="btn_add_area_map">
        <button class="button add_area_map">
            <?php esc_html_e( 'Add new area', 'moviebooking' ); ?>
        </button>
        <div class="mb-loading">
            <i class="dashicons-before dashicons-update-alt"></i>
        </div>
    </div>
    <br/><hr/><br/>
    <!-- Extra Services -->
    <div class="ova_row">
        <label><strong><?php esc_html_e( 'Extra Service', 'moviebooking' ); ?></strong></label>
        <ul class="el_extra_services">
            <?php if ( ! empty( $extra_services ) ): ?>
                <?php foreach ( $extra_services as $k => $val ): ?>
                    <li class="el_service_item">
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <th scope="row"><label for=""><?php esc_html_e( 'Service Name', 'moviebooking' ); ?></label></th>
                                    <td>
                                        <input name="<?php echo MB_PLUGIN_PREFIX_ROOM.'extra_service['.$k.'][name]'; ?>" type="text" value="<?php echo esc_attr( $val['name'] ); ?>" class="extra_service_name regular-text" placeholder="<?php esc_attr_e( 'Enter Name', 'moviebooking' ); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for=""><?php esc_html_e( 'Price', 'moviebooking' ); ?></label></th>
                                    <td><input name="<?php echo MB_PLUGIN_PREFIX_ROOM.'extra_service['.$k.'][price]'; ?>" type="number" min="0" step="0.1" value="<?php echo esc_attr( $val['price'] ); ?>" placeholder="<?php echo esc_attr_e( '10', 'moviebooking' ); ?>" class="extra_service_price regular-number"></td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for=""><?php esc_html_e( 'Max Quantity/Calendar', 'moviebooking' ); ?></label></th>
                                    <td><input name="<?php echo MB_PLUGIN_PREFIX_ROOM.'extra_service['.$k.'][qty]'; ?>" type="number" min="0" step="1" value="<?php echo esc_attr( $val['qty'] ); ?>" placeholder="<?php esc_attr_e( '100', 'moviebooking' ); ?>" required class="extra_service_qty regular-number"></td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for=""><?php esc_html_e( 'Max Quantity/Ticket', 'moviebooking' ); ?></label></th>
                                    <td><input name="<?php echo MB_PLUGIN_PREFIX_ROOM.'extra_service['.$k.'][max_qty]'; ?>" type="number" min="0" step="1" value="<?php echo esc_attr( $val['max_qty'] ); ?>" placeholder="<?php esc_attr_e( '10', 'moviebooking' ); ?>" class="extra_service_max_qty regular-number"></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="el_remove_service button button-small button-secondary">&#x2715;</button>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <a href="#" id="mb_add_services" data-nonce="<?php echo wp_create_nonce('mb_add_services'); ?>" class="button button-secondary"><?php esc_html_e( 'Add Extra Service', 'moviebooking' ); ?></a>
    </div>
    <br/><hr/><br/>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Description:', 'moviebooking' ); ?></strong>
        </label>
        <div class="content">
            <textarea name="<?php echo esc_attr( $this->get_mb_name( 'description' ) ); ?>" id="room_description" cols="100" rows="5" spellcheck="false"><?php echo esc_html( $this->get_mb_value( 'description' ) ); ?></textarea>
            <span class="note">
                <?php esc_html_e( 'Description display at frontend and PDF Ticket.', 'moviebooking' ); ?>
            </span>
            <span class="note">
                <?php esc_html_e( 'Description limited 230 character in ticket.', 'moviebooking' ); ?>
            </span>
        </div>
        <br><br>
    </div>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Private Description:', 'moviebooking' ); ?></strong>
        </label>
        <div class="content">
            <textarea name="<?php echo esc_attr( $this->get_mb_name( 'private_description' ) ); ?>" id="room_private_description" cols="100" rows="5" spellcheck="false"><?php echo esc_html( $this->get_mb_value( 'private_description' ) ); ?></textarea>
            <span class="note">
                <?php esc_html_e( 'Private Description in Ticket - Only see when bought ticket.', 'moviebooking' ); ?>
            </span>
            <span class="note">
                <?php esc_html_e( 'Description limited 230 character in ticket.', 'moviebooking' ); ?>
            </span>
        </div>
        <br><br>
    </div>
</div>