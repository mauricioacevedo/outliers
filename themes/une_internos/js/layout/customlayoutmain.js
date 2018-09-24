// simple function to toggle all the panes
	function toggleAll () {
		$.each(["north","west","east","south"], function(i, pane){
			myLayout.center.children['outer-center'].toggle( pane );
		});
	};
	$(document).ready( function() {
		
		myLayout = $("body").layout({
			name:						"page-layout"
		,	contentSelector:			".ui-widget-content"
		,	west__size:					200
		,	north__size:				130
		,	spacing_open:				5 // ALL panes
		,	spacing_closed:				5 // ALL panes
		,	north__spacing_open:		0 // el panel es fijo
		,	south__spacing_open:		0// el panel es fijo
		,	east__initClosed:			true
		,	livePaneResizing:			true
		,	animatePaneSizing:			true	// changes in pane-sizes when resetting state will be animated
		,	stateManagement__enabled:	true	// enable stateManagement - automatic cookie load & save enabled by default
		,	stateManagement__includeChildren: true	// DEFAULT - include all child-layouts in state data & cookie (true = default)
		,	center__children: {
				name:					'outer-center'
			,	spacing_open:			0
			,	west__size:				150
			}
		});

	});