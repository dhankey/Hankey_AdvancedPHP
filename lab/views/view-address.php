<?php if(count($addresses) > 0) : ?>

	<h3>Addresses</h3>
	<ul>

	<?php foreach($addresses as $address => $addr) : ?>

		<li>
			<span style="font-weight: bold;">Name: </span>		<?php echo $addr['fullname']; ?>, 
			<span style="font-weight: bold;">Email: </span>		<?php echo $addr['email']; ?>, 
			<span style="font-weight: bold;">Address: </span>	<?php echo $addr['addressline1']; ?>, 
			<span style="font-weight: bold;">City: </span>		<?php echo $addr['city']; ?>, 
			<span style="font-weight: bold;">State: </span>		<?php echo $addr['state']; ?>, 
			<span style="font-weight: bold;">Zip: </span>		<?php echo $addr['zip']; ?>, 
			<span style="font-weight: bold;">DOB: </span>		<?php echo $addr['birthday']; ?>
		</li>

	<?php endforeach; ?>

	</ul>
<?php else : ?>

	<h3>Sorry there were no addresses stored.</h3>

<?php endif; ?>