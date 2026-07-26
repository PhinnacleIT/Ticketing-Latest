<?php
if ( ! defined('ABSPATH') ) {
	exit();
}


if ( ! function_exists('mb_get_price_incl_tax') ) {
	
	function mb_get_price_incl_tax( $price = 0, $tax_type = null, $tax_fee = null ){
		$new_price = $price;
		if ( empty( $tax_type ) || empty( $tax_fee ) ) {
			return $new_price;
		}

		switch ( $tax_type ) {
			case 'percent':
                $regular_tax_rate   = ( 1 + $tax_fee ) / 100;
                $the_rate           = ( $regular_tax_rate / 100 ) / $regular_tax_rate * $tax_fee;
                $new_price          = $price - ( $the_rate * $price );
				break;
			case 'amount':
				$new_price = $price - (float)$tax_fee;
				break;
			default:
				break;
		}

		if ( $new_price < 0 ) {
			$new_price = 0;
		}

		return $new_price;
	}
}

if ( ! function_exists('mb_get_extra_service_html') ) {
	function mb_get_extra_service_html( $extra_service = array() ){
		$extra_service_html = [];
        $extra_item_name = [];
        $html_arr = [];
        foreach ( $extra_service as $k => $extra_item ) {
            foreach ( $extra_item as $_k => $item ) {
                $item_name = isset( $item['name'] ) ? $item['name'] : '';

                if ( empty( $item_name ) ) {
                    
                    if ( is_array( $item ) && count( $item ) > 0 ) {
                        foreach ( $item as $h => $val ) {
                            if ( absint( $val['qty'] > 0 ) ) {
                                if ( ! in_array( $val['name'], $extra_item_name ) ) {
                                    $extra_service_html[] = array( 'name' => $val['name'], 'qty' => absint( $val['qty'] ) );
                                    $extra_item_name[] = $val['name'];
                                } else {

                                    foreach ( $extra_service_html as $key => $jtem ) {
                                        if ( $jtem['name'] == $val['name'] ) {
                                            $extra_service_html[$key]['qty'] += absint( $val['qty'] );
                                        }
                                    }
                                }
                            }
                        }
                    }

                } else {
                    
                    if ( absint( $item['qty'] > 0 ) ) {
                        if ( ! in_array( $item['name'], $extra_item_name ) ) {
                            $extra_service_html[] = array( 'name' => $item['name'], 'qty' => absint( $item['qty'] ) );
                            $extra_item_name[] = $item['name'];
                        } else {

                            foreach ( $extra_service_html as $key => $jtem ) {
                                if ( $jtem['name'] == $item['name'] ) {
                                    $extra_service_html[$key]['qty'] += absint( $item['qty'] );
                                }
                            }
                        }
                    }
                }
            }
        }

        if ( ! empty( $extra_service_html ) ) {
            foreach ( $extra_service_html as $key => $value ) {
                $qty = isset( $value['qty'] ) ? absint( $value['qty'] ) : 0;
                if ( $qty > 0 ) {
                    $html_arr[] = $value['name'].' x '. $value['qty'];
                }
            }
        }
        return $html_arr;
	}
}


if ( ! function_exists('mb_ticket_get_extra_service') ) {
    function mb_ticket_get_extra_service( $extra_service = array() ){
        $html = [];

        foreach ( $extra_service as $key => $item ) {
            $qty = isset( $item['qty'] ) ? absint( $item['qty'] ) : 0;
            if ( $qty > 0 ) {
                $html[] = $item['name'].' x '.$item['qty'];
            }
            
        }

        return $html;
    }
}

if ( ! function_exists('mb_booking_get_person_type_name') ) {
    function mb_booking_get_person_type_name( $booking_person_type = array(), $seat_id = null ){
        $result = array();
        if ( empty( $booking_person_type ) || empty( $seat_id ) ) {
            return $result;
        }

        if ( ! empty( $booking_person_type[$seat_id] ) ) {
            foreach ( $booking_person_type[$seat_id] as $key => $value ) {
                $qty = isset( $value['qty'] ) ? absint( $value['qty'] ) : 0;
                if ( $qty > 0 ) {
                    for ($i=0; $i < $qty; $i++) { 
                        $result[] = $value['id'];
                    }
                }
                
            }
        }

        return $result;
    }
}


if ( ! function_exists('mb_booking_get_extra_service_remaining') ) {
    function mb_booking_get_extra_service_remaining( $room_id = null ){
        if ( empty( $room_id ) ) {
            return array();
        }
        $extra_service_sold = array();
        $extra_item_name = array();
        $extra_service_room = get_post_meta( $room_id, MB_PLUGIN_PREFIX_ROOM.'extra_service', true );
        
        $booking_args = array(
            'post_type'         => 'mb_booking',
            'post_status'       => 'publish',
            'meta_query' => array(
                array(
                    'key' => MB_PLUGIN_PREFIX_BOOKING.'room_id',
                    'value' => $room_id,
                ),
                array(
                    'key' => MB_PLUGIN_PREFIX_BOOKING.'status',
                    'value' => 'Completed',
                ),
            ),
            'posts_per_page'    => -1,
            'fields'            => 'ids',
        );

        $booking_ids = get_posts( $booking_args );

        if ( count( $booking_ids ) > 0 ) {
            foreach ( $booking_ids as $booking_id ) {
                $extra_service_booked = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING.'extra_service', true );
                if ( ! empty( $extra_service_booked ) ) {
                    foreach ( $extra_service_booked as $k => $extra_item ) {
                        foreach ( $extra_item as $_k => $item ) {
                            $item_name = isset( $item['name'] ) ? $item['name'] : '';

                            if ( empty( $item_name ) ) {
                                
                                if ( is_array( $item ) && count( $item ) > 0 ) {
                                    foreach ( $item as $h => $val ) {
                                        if ( absint( $val['qty'] > 0 ) ) {
                                            if ( ! in_array( $val['name'], $extra_item_name ) ) {
                                                $extra_service_sold[] = array( 'name' => $val['name'], 'qty' => absint( $val['qty'] ) );
                                                $extra_item_name[] = $val['name'];
                                            } else {

                                                foreach ( $extra_service_sold as $key => $jtem ) {
                                                    if ( $jtem['name'] == $val['name'] ) {
                                                        $extra_service_sold[$key]['qty'] += absint( $val['qty'] );
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                            } else {
                                
                                if ( absint( $item['qty'] > 0 ) ) {
                                    if ( ! in_array( $item['name'], $extra_item_name ) ) {
                                        $extra_service_sold[] = array( 'name' => $item['name'], 'qty' => absint( $item['qty'] ) );
                                        $extra_item_name[] = $item['name'];
                                    } else {

                                        foreach ( $extra_service_sold as $key => $jtem ) {
                                            if ( $jtem['name'] == $item['name'] ) {
                                                $extra_service_sold[$key]['qty'] += absint( $item['qty'] );
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $holding_args = array(
            'post_type'         => 'holding_ticket',
            'post_status'       => 'publish',
            'meta_key'          => MB_PLUGIN_PREFIX_BOOKING.'room_id',
            'meta_value'        => $room_id,
            'posts_per_page'    => -1,
            'fields'            => 'ids',
        );
        $holding_tickets = get_posts( $holding_args );

        if ( count( $holding_tickets ) > 0 ) {
            foreach ( $holding_tickets as $post_id ) {
                $extra_service_holding = get_post_meta( $post_id, MB_PLUGIN_PREFIX_BOOKING.'extra_service', true );
                if ( ! empty( $extra_service_holding ) ) {
                    foreach ( $extra_service_holding as $k => $extra_item ) {
                        foreach ( $extra_item as $_k => $item ) {
                            $item_name = isset( $item['name'] ) ? $item['name'] : '';

                            if ( empty( $item_name ) ) {
                                
                                if ( is_array( $item ) && count( $item ) > 0 ) {
                                    foreach ( $item as $h => $val ) {
                                        if ( absint( $val['qty'] > 0 ) ) {
                                            if ( ! in_array( $val['name'], $extra_item_name ) ) {
                                                $extra_service_sold[] = array( 'name' => $val['name'], 'qty' => absint( $val['qty'] ) );
                                                $extra_item_name[] = $val['name'];
                                            } else {

                                                foreach ( $extra_service_sold as $key => $jtem ) {
                                                    if ( $jtem['name'] == $val['name'] ) {
                                                        $extra_service_sold[$key]['qty'] += absint( $val['qty'] );
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                            } else {
                                
                                if ( absint( $item['qty'] > 0 ) ) {
                                    if ( ! in_array( $item['name'], $extra_item_name ) ) {
                                        $extra_service_sold[] = array( 'name' => $item['name'], 'qty' => absint( $item['qty'] ) );
                                        $extra_item_name[] = $item['name'];
                                    } else {

                                        foreach ( $extra_service_sold as $key => $jtem ) {
                                            if ( $jtem['name'] == $item['name'] ) {
                                                $extra_service_sold[$key]['qty'] += absint( $item['qty'] );
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if ( ! empty( $extra_service_room ) && ! empty( $extra_service_sold ) ) {
            foreach ( $extra_service_room as $key => $item ) {
                $name = isset( $item['name'] ) ? $item['name'] : '';
                $qty = isset( $item['qty'] ) ? absint( $item['qty'] ) : 0;
                foreach ( $extra_service_sold as $k => $val ) {
                    if ( $val['name'] === $name ) {
                        $qty = $qty - absint( $val['qty'] );
                        if ( $qty < 0 ) {
                            $qty = 0;
                        }
                    }
                }
                $extra_service_room[$key]['qty'] = $qty;
            }
        }

        return $extra_service_room;

    }
}