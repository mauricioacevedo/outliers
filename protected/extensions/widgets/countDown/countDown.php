<?php
/**
* Subdireccion Aplicaciones Corporativas
* @author Joan Harriman Navarro M - jnavarrm@asesor.une.com.co
* @copyright UNE TELECOMUNICACIONES
*/
class countDown extends CWidget {
	
	public $time;
	
	
	public function init() {
		
		//Recursos como del lado del cliente (CSS, JS, IMG)
		$assetFolder 			= Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.widgets.countDown'));
		Yii::app()->clientScript->registerCssFile($assetFolder.'/css/CountDown.css');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/jquery.js');
		Yii::app()->clientScript->registerScriptFile($assetFolder.'/js/jquery.countDown.js');
				
		$date					= explode(' ',$this->time);
		$splitTime				= explode(':',$date[1]);
		?>
				<script type="text/javascript" charset="utf-8">
					// Javascript
					$(function() {
						var date = new Date();
						date.setHours(<?php echo $splitTime[0]?>);		
						date.setMinutes(<?php echo $splitTime[1]?>);
						date.setSeconds(<?php echo $splitTime[2]?>); 		
					  $('.clock').countdown(date, function(event) {
					    if(event.type !== "seconds") return;
					    var timeLeft = [
					      event.lasting.hours + event.lasting.days * 24,
					      event.lasting.minutes,
					      event.lasting.seconds
					    ];
					    for(var i = 0; i < timeLeft.length; ++i) {
					      timeLeft[i] = (timeLeft[i] < 10 ? '0' : '') + timeLeft[i].toString();
					    }
					    $(this).html(timeLeft.join(':'));
					  });
					});
					</script>
					<div> 		   
				<?php		
				$HTMLCountDown			='<div class="clock"></div>';				
				echo $HTMLCountDown;
				?>
					</div>
				<?php 
	} 
	
}