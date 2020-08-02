<?php 
//echo urldecode('%DC%9B%DC%9F');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Syriac Translator</title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://sedra.bethmardutho.org/bundles/sedra4homepage/css/dialogs.css" type="text/css" media="all" />
    <link rel="stylesheet" href="https://sedra.bethmardutho.org/bundles/sedra4homepage/css/keyboard.css" type="text/css" media="all" />
	<link rel="stylesheet" href="https://sedra.bethmardutho.org/bundles/sedra4homepage/css/keyboard-previewkeyset.css" type="text/css" media="all" />
	<link rel="stylesheet" href="https://sedra.bethmardutho.org/bundles/sonataadmin/vendor/jqueryui/themes/base/jquery-ui.css" type="text/css" media="all" />
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
	.tooltip {
	  position: relative;
	  display: inline-block;
	}

	.tooltip .tooltiptext {
	  visibility: hidden;
	  width: 140px;
	  background-color: #555;
	  color: #fff;
	  text-align: center;
	  border-radius: 6px;
	  padding: 5px;
	  position: absolute;
	  z-index: 1;
	  bottom: 150%;
	  left: 50%;
	  margin-left: -75px;
	  opacity: 0;
	  transition: opacity 0.3s;
	}

	.tooltip .tooltiptext::after {
	  content: "";
	  position: absolute;
	  top: 100%;
	  left: 50%;
	  margin-left: -5px;
	  border-width: 5px;
	  border-style: solid;
	  border-color: #555 transparent transparent transparent;
	}

	.tooltip:hover .tooltiptext {
	  visibility: visible;
	  opacity: 1;
	}
</style>
    <style type="text/css">
    	body{
    		font-family: 'League Spartan Bold', arial';overflow-x:hidden;overflow-y:hidden;
    	}
    	#logo{
    		margin: 10px auto;
    		margin-top: 20px;
    	}
    	#tabs
    	{
    		margin-top: 5em;
    	}
    	.nav-pills > li {
		    float:none;
		    display:inline-block;
		    zoom:1;
		    font-size: 20px;
		}

		.nav-pills {
		    text-align:center;
		}
		.tab-content{
			margin-top: 1em;
		}
	
		#name_check_div{
			display: block;
		    font-size: 18px;
		    line-height: 1.3333333;
		    border-radius: 6px;
		    color: #555;
		    background-color: #fff;
		    background-image: none;
		    border: 1px solid #ccc;
            margin-top: 50px;
		    margin-right: 0 auto;
		    margin-left: 0 auto;
		}
		/*
		#name_check_result strong{
			font-size: 20px;
		    padding: 5px;
		    border: 2px dashed #ccc;
		    border-radius: 10px;
		    margin: 10px;
		    display: inline-block;
		}
		*/
		#name_set_loader{
			width: 240px;
		    height: 240px;
		    margin: 0px auto;
		    display: none;
		}
		textarea {
		  resize: vertical;
		  overflow-y: scroll;
		}
		
		#copy_div
		{
			display: none;
			padding-top: 20px;
		    text-align: center;
		}

		#copy_img:hover
		{
			cursor: pointer;
		}

    </style>
  </head>
  <body>
  	<div class="container">
  		<div class="row">
	    	<div class="col-sm-12">
		      	<form action="translation.php" id="translation_form">
		      		<div class="row">
						<div style="margin-top: 20px;" class="col-sm-offset-3 col-sm-6 form-group">
							<textarea rows="5" id="lexeme" name="syriac_text" class="form-control input-lg" placeholder="Input Syriac text" font-size="12" dir="rtl" required="required"></textarea>
						</div>
						<div style="margin-top: 20px;padding-left: 0px !important;" class="col-sm-3 form-group">
							<img id="lexeme-keyboard" style="height:35px; width:35px; margin-bottom:10px;" src="https://sedra.bethmardutho.org/bundles/sedra4homepage/images/keyboard.svg">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-offset-3 col-sm-6">
							<button style="margin: 0px auto;display: inherit;margin-top: 5px;background-color:black;border-color:black;color:white" type="submit" class="btn btn-default">Gloss</button>
						</div>
					</div>
				</form>
				<div class="row">
					<div class="col-sm-offset-3 col-sm-6">
						<img src="images/loading.gif" id="name_set_loader">

					</div>
					<div class="col-sm-offset-3 col-sm-6"  id="name_check_result">
						
					</div>
					<div class="col-sm-offset-3 col-sm-6" id="copy_div">
						<img width="40" src="images/copy.png" title="Copy" data-clipboard-action="copy" data-clipboard-target="#name_check_result" id="copy_img">
					</div>
				</div>
			</div>
	    </div>
	</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="bootstrap/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="https://sedra.bethmardutho.org/bundles/sonatacore/vendor/jquery/dist/jquery.min.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonataadmin/vendor/jquery.scrollTo/jquery.scrollTo.min.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonatacore/vendor/moment/min/moment.min.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonataadmin/vendor/jqueryui/ui/minified/jquery-ui.min.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonataadmin/vendor/jqueryui/ui/minified/i18n/jquery-ui-i18n.min.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonatacore/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonatacore/vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonataadmin/vendor/jquery-form/jquery.form.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonataadmin/jquery/jquery.confirmExit.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonataadmin/vendor/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonatacore/vendor/select2/select2.min.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonataadmin/vendor/admin-lte/dist/js/app.min.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonataadmin/vendor/iCheck/icheck.min.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonataadmin/vendor/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonataadmin/vendor/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonataadmin/vendor/waypoints/lib/shortcuts/sticky.min.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonataadmin/vendor/readmore-js/readmore.min.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonataadmin/vendor/masonry/dist/masonry.pkgd.min.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonataadmin/Admin.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonataadmin/treeview.js"></script>
    <script src="https://sedra.bethmardutho.org/bundles/sonataadmin/sidebar.js"></script>


    <script src="https://sedra.bethmardutho.org/bundles/sedra4homepage/js/support.js"></script>
	<script src="https://sedra.bethmardutho.org/bundles/sedra4homepage/js/jquery.cookie.js"></script>
	<script src="https://sedra.bethmardutho.org/bundles/sedra4homepage/js/jquery.keyboard.js"></script>
	<script src="https://sedra.bethmardutho.org/bundles/sedra4homepage/js/jquery.keyboard.extension-mobile.js"></script>
	<script src="https://sedra.bethmardutho.org/bundles/sedra4homepage/js/jquery.keyboard.extension-navigation.js"></script>
	<script src="https://sedra.bethmardutho.org/bundles/sedra4homepage/js/jquery.keyboard.extension-autocomplete.js"></script>
	<script src="https://sedra.bethmardutho.org/bundles/sedra4homepage/js/jquery.keyboard.syriac.js"></script>
	<script src="https://sedra.bethmardutho.org/bundles/sedra4homepage/js/keyboardSupport.js"></script>
	<div class="right">	<script src="https://sedra.bethmardutho.org/bundles/fosjsrouting/js/router.js"></script>
	<script src="https://sedra.bethmardutho.org/js/routing?callback=fos.Router.setData"></script>
	<script src="clipboard.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(e){
    		$("#translation_form").submit(function(e) {
			    e.preventDefault(); // avoid to execute the actual submit of the form.
			    var form = $(this);
			    var url = form.attr('action');
			    $('#name_check_result').css({'display':'none'});
			    $('#name_check_result').html('');
			    $('#name_set_loader').css({'display':'block'});
			    $('div#copy_div').css({'display':'none'});
			    $.ajax({
			           type: "POST",
			           url: url,
			           data: form.serialize(), // serializes the form's elements.
			           success: function(data)
			           {
			               $('#name_check_result').html(data); // show response from the php script.
			               $('#name_check_result').css({'display':'block'});
			               $('#name_set_loader').css({'display':'none'});
			               $('div#copy_div').css({'display':'block'});
			           }
			         });
			});	
		})
	
	var clipboard = new ClipboardJS('#copy_img');
    clipboard.on('success', function(e) {
        console.log(e);
    });
    clipboard.on('error', function(e) {
        console.log(e);
    });

function setHeights()
{
	var height = 0;

	$(this).closest('#entries > div, #details > div').each(function()
	{
		height = ($(this).outerHeight() > height ? $(this).outerHeight() : height);
	});

	$(this).closest('#entries > div, #details > div').css('height', height);
}

function setDetails(data)
{
	var eid = $('#entries > ul.ui-tabs-nav > li.ui-tabs-active > a').first().attr('href');
	var did = $('#details > ul.ui-tabs-nav > li.ui-tabs-active > a').first().attr('href');
	var sid = eid ? $(eid + " > div.tabs > ul.ui-tabs-nav > li.ui-tabs-active > a").first().attr('href') : false;

	$('#bottomPanel').empty();

	$(data).appendTo('#bottomPanel');

	$('.tabs').tabs();

	if (eid)
	{
		var index = $('#entries a[href="' + eid + '"]').parent().index();
		$("#entries").tabs("option", "active", index);

		if (sid)
		{
			var index = $(eid + ' > div.tabs a[href="' + sid + '"]').parent().index();
			$(eid + " > div.tabs").tabs("option", "active", index);
		}
	}
	
	if (did)
	{
		var index = $('#details a[href="' + did + '"]').parent().index();
		$("#details").tabs("option", "active", index);
	}

	$('img').load(setHeights);
};

$('.commentWindow').dialog
({
	autoOpen: false, 
	position: 'center', 
	height: 350, 
	width: 500, 
	modal: true,
	buttons:
	{
		"Comment": function()
		{
			var id = $(this).data('id');
			var url = null;

			url = Routing.generate('add_comment', { id: id });

			var comment = $(this, '.commentText').text();
			var commentDialog = $(this);

			jQuery.ajax
			({ 
				url: url, 
				type: 'post',
				dataType: 'html',
				data: { comment: comment }, 
				success: function()
				{
					commentDialog.dialog('close');
					alert('We have accepted your comments and will review them in the near future.');
				},
				error: function()
				{
					commentDialog.dialog('close');
					alert('There was an error saving your comments.');
				}
			});
		},
        "Cancel": function()
        {
        	$(this).dialog('close');
        }
	}
});

function addComment(id)
{
	$('.commentText').empty();
	$('.commentWindow').data('id', id).dialog('open');
};

function switchEntry(id)
{
	var url = Routing.generate('lexeme_detail_by_lexicon_id', { id: id });
	jQuery.ajax({ 
		url: url, 
		success: function (data) { 
			setDetails(data);
		} 
	});
};

function getKeyboardLayout() {
	return "syriac-phonetic";
};

function onSelection(event, ui) {
	var url = Routing.generate('lexeme_detail', { id: ui.item.term });
	jQuery.ajax({ 
		url: url, 
		success: function (data) { 
			setDetails(data);
		} 
	});

	var newPage = Routing.generate('sedra4_lexemepage', { id: ui.item.term });
	history.pushState(null, null, newPage);
}

$(function()
{
	$('.tabs').tabs();
	$('img').load(setHeights);
	initializeKeyboard('#lexeme', getKeyboardLayout, '#lexeme-keyboard', 'lexeme.php', onSelection);
	//initializeKeyboard('#lexeme', getKeyboardLayout, '#lexeme-keyboard', Routing.generate('listlexemes'), onSelection);
});
    </script>

  </body>
</html>