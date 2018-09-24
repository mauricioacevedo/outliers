function notify(layout, text, type, dismiss, btnoktitle, oktext,btncanceltitle, canceltext) {
	var btn;
	if(btncanceltitle.length>0 && btnoktitle.length>0)
		{
			btn = [{
				addClass : 'btn btn-primary',
				text : btnoktitle,
				onClick : function($noty) {
					$noty.close();
					noty({
						dismissQueue : true,
						force : true,
						layout : layout,
						theme : 'defaultTheme',
						text : oktext,
						type : 'success'
					});
				}
			}, {
				addClass : 'btn btn-danger',
				text : btncanceltitle,
				onClick : function($noty) {
					$noty.close();
					noty({
						dismissQueue : true,
						force : true,
						layout : layout,
						theme : 'defaultTheme',
						text : canceltext,
						type : 'error'
					});
				}
			}];
		}
	else if(btncanceltitle.length>0)
	{
		btn = [{
			addClass : 'btn btn-danger',
			text : btncanceltitle,
			onClick : function($noty) {
				$noty.close();
				noty({
					dismissQueue : true,
					force : true,
					layout : layout,
					theme : 'defaultTheme',
					text : canceltext,
					type : 'error'
				});
			}
		}];
	}
	else if(btnoktitle.length>0)
	{
		btn = [{
			addClass : 'btn btn-primary',
			text : btnoktitle,
			onClick : function($noty) {
				$noty.close();
				noty({
					dismissQueue : true,
					force : true,
					layout : layout,
					theme : 'defaultTheme',
					text : oktext,
					type : 'success'
				});
			}
		}];
	}	
	var n = noty({
		text : text,
		type : type,
		dismissQueue : dismiss,
		layout : layout,
		theme : 'defaultTheme',
		buttons : btn
	});
}