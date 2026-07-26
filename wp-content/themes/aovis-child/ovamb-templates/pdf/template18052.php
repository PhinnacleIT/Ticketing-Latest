<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Get Info ticket
$ticket = $args['ticket'];

?>
<table class="pdf_content">
	<tbody>
	  <tr style="border: 3px solid <?php echo $ticket['color_border_ticket'] ?>;">
	  	<td class="left">
	  		<table style="width: 100%; border-collapse: collapse;" >
				<tr class="name_movie">
					<!-- Movie Name -->
					<td colspan="4">
						<span style="color: <?php echo $ticket['color_label_ticket']; ?>">
							<b><?php esc_html_e( 'Event: ', 'moviebooking' ); ?></b>
						</span>
						<br>
						<span style="color: <?php echo $ticket['color_content_ticket']; ?>">
							<?php echo esc_html( $ticket['movie_name'] ); ?>
						</span>
					</td>
				</tr>
				<tr class="date">
					<td class="time_content" style="border-right: 3px solid <?php echo $ticket['color_border_ticket'] ?>;">
						<div style="color: <?php echo $ticket['color_label_ticket']; ?>">
							<b><?php esc_html_e( 'Showtimes: ', 'moviebooking' ); ?></b>
						</div>
						<div style="color: <?php echo $ticket['color_content_ticket']; ?>">
							<?php echo esc_html( $ticket['date'] ); ?>
						</div>
					</td>
					<td class="address_content" colspan="3">
						<div style="color: <?php echo $ticket['color_label_ticket']; ?>">
							<b><?php esc_html_e( 'Address: ', 'moviebooking' ); ?></b>
						</div>
						<div style="color: <?php echo $ticket['color_content_ticket']; ?>">
							<?php echo esc_html( $ticket['address'] ); ?>
						</div>
					</td>
				</tr>
				<tr class="order_info">
					<td colspan="4">
						<div style="color: <?php echo $ticket['color_label_ticket']; ?>">
							<b><?php esc_html_e( 'Order Info: ', 'moviebooking' ); ?></b>
						</div>
						<div style="color: <?php echo $ticket['color_content_ticket']; ?>">
							<?php echo esc_html( $ticket['order_info'] ); ?>
						</div>
					</td>
				</tr>
				<tr class="ticket">
					<td colspan="4">
						<div style="color: <?php echo $ticket['color_label_ticket']; ?>">
							<b><?php esc_html_e( 'Ticket: ', 'moviebooking' ); ?></b>
						</div>
						<div style="color: <?php echo $ticket['color_content_ticket']; ?>">
							<!-- Ticket Number -->
							<?php echo sprintf( _x( '#%s - %s - %s', 'ticket', 'moviebooking' ), $ticket['ticket_id'], $ticket['room'], $ticket['seat'] ); ?>
						</div>
					</td>
				</tr>
				<tr class="ticket2">
					<td>
						<div style="color: <?php echo $ticket['color_label_ticket']; ?>">
							<b><?php esc_html_e( 'Class: ', 'moviebooking' ); ?></b>
						</div>
						<div style="color: <?php echo $ticket['color_content_ticket']; ?>">
							<?php if(substr($ticket['seat'],0,2)=='SV') {echo 'SVIP';} elseif(substr($ticket['seat'],0,2)=='VP') {echo 'VIP';} elseif(substr($ticket['seat'],0,2)=='SL') {echo 'Silver';} elseif(substr($ticket['seat'],0,2)=='GA') {echo 'Gen Ad';} elseif(substr($ticket['seat'],0,2)=='GD') {echo 'Gold';} elseif(substr($ticket['seat'],0,2)=='SL') {echo 'Silver';} elseif(substr($ticket['seat'],0,2)=='BL') {echo 'Balcony';} ?>
						</div>
					</td>
					<td>
						<div style="color: <?php echo $ticket['color_label_ticket']; ?>">
							<b><?php esc_html_e( 'Section: ', 'moviebooking' ); ?></b>
						</div>
						<div style="color: <?php echo $ticket['color_content_ticket']; ?>">
							<!-- Ticket Number -->
							<?php if(substr($ticket['seat'],3,(strrpos($ticket['seat'], '-')+1)-strpos($ticket['seat'], '-')-2)=='L') {echo 'Left';} elseif(substr($ticket['seat'],3,(strrpos($ticket['seat'], '-')+1)-strpos($ticket['seat'], '-')-2)=='R') {echo 'Right';} else { echo substr($ticket['seat'],3,(strrpos($ticket['seat'], '-')+1)-strpos($ticket['seat'], '-')-2);} ?>
						</div>
					</td>
					<td>
					<div style="color: <?php echo $ticket['color_label_ticket']; ?>">
							<b><?php esc_html_e( 'Row: ', 'moviebooking' ); ?></b>
						</div>
						<div style="color: <?php echo $ticket['color_content_ticket']; ?>">
							<!-- Ticket Number -->
							<?php echo substr(substr($ticket['seat'],strrpos($ticket['seat'], '-')+1),0,strcspn(substr($ticket['seat'],strrpos($ticket['seat'], '-')+1) , '0123456789' ))  ?>
						</div>
					</td>
					<td>
					<div style="color: <?php echo $ticket['color_label_ticket']; ?>">
							<b><?php esc_html_e( 'Seat #: ', 'moviebooking' ); ?></b>
						</div>
						<div style="color: <?php echo $ticket['color_content_ticket']; ?>">
							<!-- Ticket Number -->
							<?php echo substr(substr($ticket['seat'],strrpos($ticket['seat'], '-')+1),strcspn(substr($ticket['seat'],strrpos($ticket['seat'], '-')+1) , '0123456789' ))  ?>
						</div>
					</td>
				</tr>				
			</table>
	  	</td>
	  	<td class="right">
	  		<table style="border: none;" ertical-align="top">
				<tr>
					<td>
						<?php if ( $ticket['logo_url'] ) { ?>
							<img src="<?php echo esc_url( $ticket['logo_url'] ); ?>" width="150" />
						<?php } ?>
					</td>
				</tr>
			<br><br>
				<tr>
					<td>
						<barcode code="<?php echo esc_attr( $ticket['qrcode_str'] ); ?>" type="QR" disableborder="1" />
					</td>
				</tr>
			</table>
	  	</td>
	  </tr>
	</tbody>
</table>
	<p style="text-align:center;">
		<img src="http://ticketing.phinnacleit.com/wp-content/uploads/2025/03/NA-poster_HAWAII-flat-Medium.jpg" class="center"/>
	</p>
<!-- Description Ticket -->
<p style="color: <?php echo apply_filters( 'mb_ft_desccription_ticket_pdf', '#333333' ); ?>">
	<?php esc_html_e( $ticket['description_ticket'] ); ?>
</p>

<!-- Private Ticket -->
<p style="color: <?php echo apply_filters( 'mb_ft_private_desc_ticket_pdf', '#333333' ); ?>">
	<?php esc_html_e( $ticket['private_desc_ticket'] ); ?>
</p>

<style>
	table.pdf_content {
		border-collapse: collapse;	
	}
	
	.left {
		width: 500px;
		border-right: 3px solid <?php echo $ticket['color_border_ticket']; ?>;	
		padding: 0px;

	}

	.right {
		width: 150px;
		padding: 15px;
	}

	
	
	.name_movie td,
	.date td,
	.order_info td {
		border: none;
		border-bottom: 3px solid <?php echo $ticket['color_border_ticket']; ?>;
		padding: 15px;
	}

	.ticket td {
		border-bottom: 3px solid <?php echo $ticket['color_border_ticket']; ?>;
		padding: 15px;	
	}
	.ticket2 td {
		padding: 15px;	
	}

	.center {
	display: block;
	margin-left: auto;
	margin-right: auto;
	width: 60%;
	height: 80%;
	}
</style>