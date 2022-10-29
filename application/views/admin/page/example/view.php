<section class="section">
	<div class="row">
			<div class="col-12">
				<div class="card">
					<?php if(count($example) > 0) { ?>
						<div class="card-header">
							<h4><?= $example[0]['bd_name'] .' > '. $example[0]['std_name'].' > '. $example[0]['sub_name'].' > '.
								$example[0]['chapter_text'].' > '. $example[0]['topic_text'].' > '. $example[0]['subtopic_text'] ?></h4>
						</div>
						<div class="card-body">
							<div id="accordion" class="sortable-collapse" data--url="<?=base_url('backend/re-ordering/example/ex_id');?>">
								<?php
								foreach($example as $key => $e) { ?>
									<div class="accordion" id="<?= $e['ex_id'] ?>">
										<div class="accordion-header d-flex" role="button" data-toggle="collapse" data-target="#panel-body-<?= $key ?>" aria-controls="panel-body-<?= $key ?>">
											<i class="fas fa-align-justify pt-2"></i>
											<h4 class="pl-3 pt-2">Example -  <?=  $key + 1 ?>  ( <?= $e['ex_id'] ?> )
												<span class="badge badge-primary"><?= $e['ex_heading']. ($e['ex_title'] != '' ? ' - '.$e['ex_title'] : '')?></span>
											</h4>
											<div class="ml-auto">
												<button class="btn btn-sm btn-outline-dark" data--toggle="edit" data--url="<?=base_url('backend/example/edit/'.$e['ex_id']);?>"><i class="fa fa-edit"></i></button>
												<button class="btn btn-sm btn-outline-info" data--toggle="copy" data--url="<?=base_url('backend/example/copy/'.$e['ex_id']);?>"><i class="fa fa-copy"></i></button>
												<button class="btn btn-sm btn-outline-danger ml-5" data--toggle="delete-ajax" data--url="<?=base_url('backend/example/remove/'.$e['ex_id']);?>"><i class="fa fa-trash"></i></button>
											</div>
										</div>
										<div class="accordion-body collapse" id="panel-body-<?= $key ?>" data-parent="#accordion">
											<?php $this->load->view('admin/page/example/show',['e'=>$e]); ?>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } else { ?>
						<div class="card-header">
							<h4>Examples</h4>
							<div class="card-header-action">
								<a href="<?=base_url('backend/example');?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
							</div>
						</div>
						<div class="card-body text-center">
							<div class="p-5">
								<h1> No Result Found</h1>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
</section>

<script>
	/*
 * Content-Type:text/javascript
 *
 * A bridge between iPad and iPhone touch events and jquery draggable, 
 * sortable etc. mouse interactions.
 * @author Oleg Slobodskoi  
 * 
 * modified by John Hardy to use with any touch device
 * fixed breakage caused by jquery.ui so that mouseHandled internal flag is reset 
 * before each touchStart event
 * 
 */
(function( $ ) {

$.support.touch = typeof Touch === 'object';

if (!$.support.touch) {
	return;
}

var proto =  $.ui.mouse.prototype,
_mouseInit = proto._mouseInit;

$.extend( proto, { 
	_mouseInit: function() {
		this.element
		.bind( "touchstart." + this.widgetName, $.proxy( this, "_touchStart" ) );
		_mouseInit.apply( this, arguments );
	},

	_touchStart: function( event ) {
		if ( event.originalEvent.targetTouches.length != 1 ) {
			return false;
		}

		this.element
		.bind( "touchmove." + this.widgetName, $.proxy( this, "_touchMove" ) )
		.bind( "touchend." + this.widgetName, $.proxy( this, "_touchEnd" ) );

		this._modifyEvent( event );

		$( document ).trigger($.Event("mouseup")); //reset mouseHandled flag in ui.mouse
		this._mouseDown( event );

		return false;           
	},

	_touchMove: function( event ) {
		this._modifyEvent( event );
		this._mouseMove( event );   
	},

	_touchEnd: function( event ) {
		this.element
		.unbind( "touchmove." + this.widgetName )
		.unbind( "touchend." + this.widgetName );
		this._mouseUp( event ); 
	},

	_modifyEvent: function( event ) {
		event.which = 1;
		var target = event.originalEvent.targetTouches[0];
		event.pageX = target.clientX;
		event.pageY = target.clientY;
	}

});

});
</script>
