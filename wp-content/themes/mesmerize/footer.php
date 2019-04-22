	<?php mesmerize_get_footer_content(); ?>
	</div>
<?php wp_footer(); ?>

<script>
	
	jQuery(document).ready(function ($) {
		
		function validateEmail(email) {
			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(email);
		}
		
		$('.button-vouch').click(function (e) { 
			e.preventDefault();

			var $this = $(this);
			$this.parent().next().toggle();
			$this.parent().next().next().toggle();
			
		});

		$('.button_send_vouch').click(function (e) { 
			e.preventDefault();
			
			var $this = $(this);

			var email_field = $('#email-vouch');

			if(validateEmail(email_field.val()) == false) {
				
				alert('<?= __('Email is invalid', 'mesmerize'); ?>');

			} else {

				$this.html("<?= __('Sending', 'mesmerize'); ?>... <div class='lds-ripple'><div></div><div></div></div>"); //.attr("disabled", "disabled");

				var ajaxurl = '/wp-admin/admin-ajax.php';

				var data = {
					action: "sending_invitation",
					email: email_field.val()
				};

				$.post(ajaxurl, data, function (response) {

					console.log(response);
					$this.html('sent');

				});


			}


			
		});



	});

	

</script>
<style>

.lds-ripple {
	display: inline-block;
    left: -47px;
    top: -19px;
    position: relative;
    width: 12px;
    height: 12px;
}
.lds-ripple div {
  position: absolute;
  border: 4px solid #fff;
  opacity: 1;
  border-radius: 50%;
  animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
}
.lds-ripple div:nth-child(2) {
  animation-delay: -0.5s;
}
@keyframes lds-ripple {
  0% {
    top: 28px;
    left: 28px;
    width: 0;
    height: 0;
    opacity: 1;
  }
  100% {
    top: -1px;
    left: -1px;
    width: 58px;
    height: 58px;
    opacity: 0;
  }
}

.vouches_table {
	width: 70% !important;

}

.vouches_table th {
	font-weight: bold !important;
}

</style>




<script>

	jQuery(document).ready(function ($) {

		$('[href="#Vouches"]').click(e => {

			e.preventDefault();

			let $this = $(e.currentTarget);
			
			console.log($this.parent().addClass('active current-menu-item').siblings().removeClass('active current-menu-item'));


			$('.cuar-page-content-main').html("<div style='text-align: center;'><img src='https://thumbs.gfycat.com/ShorttermUntidyHamadryas-max-1mb.gif' style='width: 100px;' ></div>");

			let ajaxurl = "<?= get_site_url(); ?>/" + 'wp-admin/admin-ajax.php';
			
			const data = {
				'action': 'get_vouches'
			}

			jQuery.ajax({
    		    type: 'POST',
    		    url: ajaxurl,
    		    data: data,
    		    success: response =>  {
					
					let main_content = $('.cuar-page-content-main');
					
					main_content.html('');

					$(response).appendTo( main_content );



    		    }

    		});

		});


	});

</script>


</body>
</html>
