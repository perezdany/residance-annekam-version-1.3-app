<?php
	//require"../php/confige.php";
    //require"../php/ChiffresEnLettres.php";

  	require '/vendor/autoload.php';

  	use Spipu\Html2Pdf\Html2Pdf;
  	ob_start();
?>

<style>
	

	/*//////////////////////////////////////////////////////////////////
	[ FONT ]*/


	/*@font-face {
	  font-family: Poppins-Regular;
	  src: url('../fonts/poppins/Poppins-Regular.ttf'); 
	}

	@font-face {
	  font-family: Poppins-Bold;
	  src: url('../fonts/poppins/Poppins-Bold.ttf'); 
	}*/

	/*//////////////////////////////////////////////////////////////////
	[ RESTYLE TAG ]*/
	* {
	  margin: 0px; 
	  padding: 0px; 
	  box-sizing: border-box;
	}

	body, html {
	  height: 100%;
	  font-family: sans-serif;
	}

	/* ------------------------------------ */
	a {
	  margin: 0px;
	  transition: all 0.4s;
	  -webkit-transition: all 0.4s;
	  -o-transition: all 0.4s;
	  -moz-transition: all 0.4s;
	}

	a:focus {
	  outline: none !important;
	}

	a:hover {
	  text-decoration: none;
	}

	/* ------------------------------------ */
	h1,h2,h3,h4,h5,h6 {margin: 0px;}

	p {margin: 0px;}

	ul, li {
	  margin: 0px;
	  list-style-type: none;
	}


	/* ------------------------------------ */
	input {
	  display: block;
	  outline: none;
	  border: none !important;
	}

	textarea {
	  display: block;
	  outline: none;
	}

	textarea:focus, input:focus {
	  border-color: transparent !important;
	}

	/* ------------------------------------ */
	button {
	  outline: none !important;
	  border: none;
	  background: transparent;
	}

	button:hover {
	  cursor: pointer;
	}

	iframe {
	  border: none !important;
	}


	/*//////////////////////////////////////////////////////////////////
	[ Table ]*/

	.limiter {
	  width: 100%;
	  margin: 0 auto;
	}

	.container-table100 {
	  width: 100%;
	  min-height: 100vh;
	  background: #c4d3f6;

	  display: -webkit-box;
	  display: -webkit-flex;
	  display: -moz-box;
	  display: -ms-flexbox;
	  display: flex;
	  align-items: center;
	  justify-content: center;
	  flex-wrap: wrap;
	  padding: 33px 30px;
	}

	.wrap-table100 {
	  width: 960px;
	  border-radius: 10px;
	  overflow: hidden;
	}

	.table {
	  width: 100%;
	  display: table;
	  margin: 0;
	  

	}



	@media screen and (max-width: 768px) {
	  .table {
	    display: block;
	  }
	}

	.row {
	  display: table-row;
	  background: #fff;
	}

	.row.header {
	  color: black;
	  background: grey;
	}

	@media screen and (max-width: 768px) {
	  .row {
	    display: block;
	  }

	  .row.header {
	    padding: 0;
	    height: 0px;
	  }

	  .row.header .cell {
	    display: none;
	  }

	  .row .cell:before {
	   
	    font-size: 12px;
	    color: #000000;
	    line-height: 1.2;
	    text-transform: uppercase;
	    font-weight: unset !important;

	    margin-bottom: 13px;
	    content: attr(data-title);
	    min-width: 98px;
	    display: block;
	  }
	}

	.cell {
	  display: table-cell;
	}

	@media screen and (max-width: 768px) {
	  .cell {
	    display: block;
	  }
	}

	.row .cell {
	 
	  font-size: 15px;
	  color: #808080;
	  line-height: 1.2;
	  font-weight: unset !important;

	  padding-top: 20px;
	  padding-bottom: 20px;
	  border-bottom: 1px solid #f2f2f2;
	}

	.row.header .cell {
	 
	  font-size: 18px;
	  color: #808080;
	  line-height: 1.2;
	  font-weight: unset !important;

	  padding-top: 19px;
	  padding-bottom: 19px;
	}

	.row .cell:nth-child(1) {
	  width: 360px;
	  padding-left: 40px;
	   color: #808080;
	}

	.row .cell:nth-child(2) {
	  width: 160px;
	   color: #808080;
	}

	.row .cell:nth-child(3) {
	  width: 250px;
	   color: #808080;
	}

	.row .cell:nth-child(4) {
	  width: 190px;
	}


	.table, .row {
	  width: 100% !important;
	   color: #808080;
	}

	.row:hover {
	  background-color: #ececff;
	}

	@media (max-width: 768px) {
	  .row {
	    border-bottom: 1px solid #f2f2f2;
	    padding-bottom: 18px;
	    padding-top: 30px;
	    padding-right: 15px;
	    margin: 0;
	  }
	  
	  .row .cell {
	    border: none;
	    padding-left: 30px;
	    padding-top: 16px;
	    padding-bottom: 16px;
	  }
	  .row .cell:nth-child(1) {
	    padding-left: 30px;
	     color: #808080;
	  }
	  
	  .row .cell {
	   
	    font-size: 18px;
	    color: #808080;
	    line-height: 1.2;
	    font-weight: unset !important;
	  }

	  .table, .row, .cell {
	    width: 100% !important;
	  }
	}
</style>

<page backtop="10mm" backleft="10mm" backright="10mm" backbottom="10mm" footer="page;">
	<page_header>	
	</page_header>
	<page_footer>
	</page_footer>
	<table class="table">

						<tr class="row header">
							<td class="cell">
								Full Name
							</td>
							<td class="cell">
								Age
							</td>
							<td class="cell">
								Job Title
							</td>
							<td class="cell">
								Location
							</td>
						</tr>

						<tr class="row">
							<td> class="cell" data-title="Full Name">
								Vincent Williamson
							</td>
							<td class="cell" data-title="Age">
								31
							</td>
							<td class="cell" data-title="Job Title">
								iOS Developer
							</td>
							<td class="cell" data-title="Location">
								Washington
							</td>
						</tr>

						

	</table>
</page>

<?php
	
	$content = ob_get_clean();
	try 
	{
		$pdf = new Html2Pdf("p","A4","fr");
		$pdf->writeHTML($content);
		$pdf->Output();
		// $pdf->Output('Devis.pdf', 'D');
	} 
	catch (HTML2PDF_exception $e) 
	{
		die($e);
	}

	 ob_end_clean();

?>