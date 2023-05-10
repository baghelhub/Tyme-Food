<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php do_action( 'wpo_wcpdf_before_document', $this->get_type(), $this->order ); ?>
<table class="head container cus-invoice">
	<tr>
		<td class="header main-left" colspan="3">

		<?php
		if ( $this->has_header_logo() ) {
			do_action( 'wpo_wcpdf_before_shop_logo', $this->get_type(), $this->order );
			$this->header_logo();
			do_action( 'wpo_wcpdf_after_shop_logo', $this->get_type(), $this->order );
		} else {
			$this->title();
		}
		?>

		<h3 class="h3-cus"> INTERNATIONAL ASSOCIATION FOR SCIENTIFIC SPIRITUALISM </h3>
		<p class="pan-p"><span>PAN-</span> <?php $this->billing_pan(); ?></p>
		<p class="payment-p-tr"><b>Payment Receipt</b> <span> Transaction Reference: <?php $this->billing_payment(); ?> </span></h4>
		<p>This is a payment reciept for your transcation on Donation/Dashansh to IASS</p>
		<p class="amount-paid-rs"><b>AMOUNT PAID</b> <span> &#8377;<?php $this->billing_amount(); ?> </span></p>
		<div class="bottom-descrep">
		<div class="left-half">	
        <h4 class="issued"><b>ISSUED TO</b></h4>
        <p class="m-bp-0"><?php $this->billing_email(); ?></p>
        <p>+91<?php $this->billing_phone(); ?></p>
		</div>
		<div class="right-half">	
		<h4 class="dftsa"><b>PAID ON</b></h4>
		<P><?php $this->order_date(); ?></P>	
		</div>
	    </div>
		<p class="mtp"><b>Name</b></p>
		<p>Sharang Shrivastava</p>
		</td>
		<td class="shop-info rt-lo">
			<!-- add razorpay logo -->
			<p><img src="https://cdn.iconscout.com/icon/free/png-256/razorpay-1649771-1399875.png" alt="razorpay">
				<!-- <span class="slogan-raz">Invoicing and payments Powered by <a href="">Razorpay</a></span> -->
			</p>
			<!-- end -->
			<?php do_action( 'wpo_wcpdf_before_shop_name', $this->get_type(), $this->order ); ?>
			<div class="shop-name"><h3><?php $this->shop_name(); ?></h3></div>
			<?php do_action( 'wpo_wcpdf_after_shop_name', $this->get_type(), $this->order ); ?>
			<?php do_action( 'wpo_wcpdf_before_shop_address', $this->get_type(), $this->order ); ?>
			<div class="shop-address"><?php $this->shop_address(); ?></div>
			<?php do_action( 'wpo_wcpdf_after_shop_address', $this->get_type(), $this->order ); ?>
		</td>
	</tr>
</table>


<?php do_action( 'wpo_wcpdf_before_order_details', $this->get_type(), $this->order ); ?>

<table class="order-details">
	<thead>
		<tr class="bg-tr">
			<th class="product"><?php _e( 'Product', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
			<th class="price"><?php _e( 'Price', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
			<th class="quantity"><?php _e( 'Quantity', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ( $this->get_order_items() as $item_id => $item ) : ?>
			<tr class="<?php echo apply_filters( 'wpo_wcpdf_item_row_class', 'item-'.$item_id, esc_attr( $this->get_type() ), $this->order, $item_id ); ?>">
				<td class="product">
					<?php $description_label = __( 'Description', 'woocommerce-pdf-invoices-packing-slips' ); // registering alternate label translation ?>
					<span class="item-name"><?php echo $item['name']; ?></span>
					<?php do_action( 'wpo_wcpdf_before_item_meta', $this->get_type(), $item, $this->order  ); ?>
					<span class="item-meta"><?php echo $item['meta']; ?></span>
					<dl class="meta">
						<?php $description_label = __( 'SKU', 'woocommerce-pdf-invoices-packing-slips' ); // registering alternate label translation ?>
						<?php if ( ! empty( $item['sku'] ) ) : ?><dt class="sku"><?php _e( 'SKU:', 'woocommerce-pdf-invoices-packing-slips' ); ?></dt><dd class="sku"><?php echo esc_attr( $item['sku'] ); ?></dd><?php endif; ?>
						<?php if ( ! empty( $item['weight'] ) ) : ?><dt class="weight"><?php _e( 'Weight:', 'woocommerce-pdf-invoices-packing-slips' ); ?></dt><dd class="weight"><?php echo esc_attr( $item['weight'] ); ?><?php echo esc_attr( get_option( 'woocommerce_weight_unit' ) ); ?></dd><?php endif; ?>
					</dl>
					<?php do_action( 'wpo_wcpdf_after_item_meta', $this->get_type(), $item, $this->order  ); ?>
				</td>
				<td class="price"><?php echo $item['order_price']; ?></td>
				<td class="quantity"><?php echo $item['quantity']; ?></td>
				<td><?php echo $item['order_price']; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr class="no-borders">
			<td class="no-borders">
				<div class="document-notes">
					<?php do_action( 'wpo_wcpdf_before_document_notes', $this->get_type(), $this->order ); ?>
					<?php if ( $this->get_document_notes() ) : ?>
						<h3><?php _e( 'Notes', 'woocommerce-pdf-invoices-packing-slips' ); ?></h3>
						<?php $this->document_notes(); ?>
					<?php endif; ?>
					<?php do_action( 'wpo_wcpdf_after_document_notes', $this->get_type(), $this->order ); ?>
				</div>
				<div class="customer-notes">
					<?php do_action( 'wpo_wcpdf_before_customer_notes', $this->get_type(), $this->order ); ?>
					<?php if ( $this->get_shipping_notes() ) : ?>
						<h3><?php _e( 'Customer Notes', 'woocommerce-pdf-invoices-packing-slips' ); ?></h3>
						<?php $this->shipping_notes(); ?>
					<?php endif; ?>
					<?php do_action( 'wpo_wcpdf_after_customer_notes', $this->get_type(), $this->order ); ?>
				</div>				
			</td>
			<td class="no-borders" colspan="3">
				<table class="totals">
					<tfoot>
						<?php foreach ( $this->get_woocommerce_totals() as $key => $total ) : ?>
							<?php if($total['label']=='Total'){ ?>
							<tr class="<?php echo esc_attr( $key ); ?>">
								<th class="description"> <?php echo $total['label']; ?></th>
								<td class="price"><span class="totals-price"><?php echo $total['value']; ?></span></td>
							</tr>
						<?php }else{
							echo " ";
						} endforeach; ?>
						<tr class="ctse">
								<th class="description"> Amount Paid</th>
								<td class="price"><span class="totals-price"><?php echo $total['value']; ?></span></td>
						</tr>
					</tfoot>
				</table>
			</td>
		</tr>
	</tfoot>

</table>

<div class="bottom-spacer"></div>
<p class="mr-cd"> Thank You For Your Kindness! </p>
<p> Any request for cancellation and refund of online donation once duly placed. In case your order is combined with other active orders from your account and is shipped together as a single shipment under one common tracking number. </p>
	<hr/ class="hhr">
	<p>International Association for scientific spiritualism exempted u/s 80G of income tax.</p>
<?php do_action( 'wpo_wcpdf_after_order_details', $this->get_type(), $this->order ); ?>

<?php if ( $this->get_footer() ) : ?>
	<div id="footer">
		<!-- hook available: wpo_wcpdf_before_footer -->
		<?php $this->footer(); ?>
		<!-- hook available: wpo_wcpdf_after_footer -->
	</div><!-- #letter-footer -->
<?php endif; ?>

<?php do_action( 'wpo_wcpdf_after_document', $this->get_type(), $this->order ); ?>
