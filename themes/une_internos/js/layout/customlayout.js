// simple function to toggle all the panes
function toggleAll() {
    $.each(["north", "west", "east", "south"], function(i, pane) {
        myLayout.center.children['outer-center'].toggle(pane);
    });
}
;
$(document).ready(function() {

    myLayout = $("body").layout({
        name: "page-layout"
        , contentSelector: ".ui-widget-content"
        , west__size: 200
        , north__size: 130
        , spacing_open: 10 // ALL panes
        , spacing_closed: 10 // ALL panes
        , north__spacing_open: 10 // el panel es fijo
        , south__spacing_open: 10// el panel es fijo
        , togglerContent_open: "<span style='line-height: 10px; margin-top:0px; color:white; font-size:8px;'><b>CERRAR PANEL</b></span>"
        , togglerContent_closed: "<span style='line-height: 10px; margin-top:0px; color:white; font-size:8px;'><b>ABRIR PANEL</b></span>"
        , togglerLength_open: 100			// Length = WIDTH of toggler button on north/south sides - HEIGHT on east/west sides
        , togglerLength_closed: 100
        , east__initClosed: true
        , livePaneResizing: true
        , animatePaneSizing: true	// changes in pane-sizes when resetting state will be animated
        , stateManagement__enabled: true	// enable stateManagement - automatic cookie load & save enabled by default
        , stateManagement__includeChildren: true	// DEFAULT - include all child-layouts in state data & cookie (true = default)
        , center__children: {
            name: 'outer-center'
            , spacing_open: 0
            , west__size: 150
        }
    });

});