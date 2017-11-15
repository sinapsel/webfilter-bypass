<style>
            ul.navdsklcbilsadhcldsuaclasd{
                margin-left: 0px;
                padding-left: 0px;
                list-style: none;
            }
            .navdsklcbilsadhcldsuaclasd li { 
                float: left;
            }
            ul.navdsklcbilsadhcldsuaclasd a, input{
                display: block;
                #width: 5em;
                padding:10px;
                margin: 0 5px;
                background-color: #f4f4f4;
                border: 1px dashed #333;
                text-decoration: none;
                color: #333;
                text-align: center;
            }
            ul.navdsklcbilsadhcldsuaclasd a:hover, input:hover{
                background-color: #333;
                color: #f4f4f4;
            }
 </style>
<div style = "position: fixed; top: 5%; left: 15%; ">
<ul class="navdsklcbilsadhcldsuaclasd">
	<li>
		<form action="#" method = "post">
		<input type="text" name="url" value="http://" size="100"/>
	</li>
	<li>
		<input type="button" name="submit" value="GO" />
		</form>
	</li>
	<li>
		<a href="/profile"> Profile</a>
	</li>
	<li>
		Free Internet: <b>
		<?php echo remainder(); ?>
		</b>
	</li>
</ul>
</div>

<?php
	if(isset($_POST['url']))
		$GLOBALS['page'] = connectsite(htmlspecialchars($_POST['url']));
?>
