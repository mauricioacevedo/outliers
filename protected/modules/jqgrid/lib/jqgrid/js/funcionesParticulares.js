/**
 * Función para mostrar un dialog a partir de un title de un objeto o de un div enviado
 * @param id
 * @param idToolTip
 * @param idDiv
 */
function verObs(id,idToolTip,height,width,parentId){ 	
	var objeto 		= $("."+id);
	var posicion 	= objeto.offset();
	var posicion2 	= objeto.position(); 
	var scrollTop	= $(document).scrollTop(); 
	var scrollLeft	= $(document).scrollLeft(); 
	$( "#"+idToolTip).html(objeto.attr('titleObs'));
	var heightF	= '200';
	var widthF 	= '350';
	if(height > 0){
		heightF = height;
	}
	if(width > 0){
		widthF = width;
	}

	
	var top = posicion.top+objeto.height()+1;
	var dialogOpts = {
			position: [((posicion2.left+5)-scrollLeft), (top-scrollTop)],
			show: "toggle",
			height: heightF,
			width: widthF,
			closeOnEscape: true
			
	};
	
	$( "#"+idToolTip).dialog(dialogOpts);
	/**
	 * Si envian el ID del elemento padre, el dialog se abre dentro del mismo, sirve cuando abro 
	 * elementos de un formulario en un dialog
	 */
	if(parentId != '' || parentId != undefined){
		$( "#"+idToolTip).parent().appendTo(jQuery("form:first"));
	} 
}