"use strict";
var base_url = $('#brainpad_base_url').val();
console.log(base_url);

// (function( $ ) {

//     $.support.touch = typeof Touch === 'object';

//     if (!$.support.touch) {
//         return;
//     }

//     var proto =  $.ui.mouse.prototype,
//     _mouseInit = proto._mouseInit;

//     $.extend( proto, {
//         _mouseInit: function() {
//             this.element
//             .bind( "touchstart." + this.widgetName, $.proxy( this, "_touchStart" ) );
//             _mouseInit.apply( this, arguments );
//         },

//         _touchStart: function( event ) {
//             if ( event.originalEvent.targetTouches.length != 1 ) {
//                 return false;
//             }

//             this.element
//             .bind( "touchmove." + this.widgetName, $.proxy( this, "_touchMove" ) )
//             .bind( "touchend." + this.widgetName, $.proxy( this, "_touchEnd" ) );

//             this._modifyEvent( event );

//             $( document ).trigger($.Event("mouseup")); //reset mouseHandled flag in ui.mouse
//             this._mouseDown( event );

//             return false;           
//         },

//         _touchMove: function( event ) {
//             this._modifyEvent( event );
//             this._mouseMove( event );   
//         },

//         _touchEnd: function( event ) {
//             this.element
//             .unbind( "touchmove." + this.widgetName )
//             .unbind( "touchend." + this.widgetName );
//             this._mouseUp( event ); 
//         },

//         _modifyEvent: function( event ) {
//             event.which = 1;
//             var target = event.originalEvent.targetTouches[0];
//             event.pageX = target.clientX;
//             event.pageY = target.clientY;
//         }

//     });

// })( jQuery );

$(document).ready(function(){

	var i=1;
	// var exv = document.getElementById("#Exval");
	var exv = $('#Exval').val();
	if(typeof exv !== 'undefined' || exv !== null || exv != "" || exv.length != 0) {
		if(exv == "")
		{
			var v =1;
		} else {
			// var v=exv;
			var v = 0;
		}
	} else {
		var v=1;
	}

	$("#Exval").val(v);

	//===================  Chapter Add and Remove Fields =============================================//

	$('#chapterBtn').click(function(){

		i++;

		$('.chapter_field').append(
			'<div class="row rm-pading" id="chrow' + i + '">'
			+ '<div class="col-12 col-sm-5">'
			+ '<label>Chapter</label>'
			+ '<div class="form-group">'
			+ '<input type="file" class="form-control" name="ch_img[]" id="ch_img" accept="image/*"  data-parsley-trigger="change" data-parsley-trigger="change" data-parsley-required="false" accept="image/jpg,image/jpeg,image/png,image/PNG,image/Png" data-parsley-fileextension="jpg, png, jpeg" data-parsley-max-file-size="1024">'
			+ '</div>'
			+ '</div>'

			+ '<div class="col-12 col-sm-5">'
			+ '<label> Code</label>'
			+ '<div class="form-group">'
			+ '<input type="text" class="form-control" name="ch_text[]" id="ch_text"  data-parsley-trigger="change" required >'
			+ '</div>'
			+ '</div>'

			+ '<div class="col-12 col-sm-2"><label>-</label ><div class="form-group"><a href="javascript:;" id="' + i + '" class="btn btn-danger removeBtn" name="remove"><i class="fa fa-times"></i></a></div></div></div>');

	});

	$(document).on('click', '.removeBtn', function(){

		var button_id = $(this).attr("id");

		$('#chrow'+button_id+'').remove();

	});


	//===================  Topics Add and Remove Fields =============================================//

	$('#topicBtn').click(function(){
		i++;
		$('.topic_field').append(
			'<div class="row rm-pading" id="tprow' + i + '">'
			+ '<div class="col-12 col-sm-5">'
			+ '<label>Topic</label>'
			+ '<div class="form-group">'
			+ '<input type="file" class="form-control" name="tp_img[]" required id="tp_img" accept="image/*" >'
			+ '</div>'
			+ '</div>'

			+ '<div class="col-12 col-sm-5">'
			+ '<label> Title</label>'
			+ '<div class="form-group">'
			+ '<input type="text" class="form-control" name="tp_text[]" id="tp_text" required>'
			+ '</div>'
			+ '</div>'

			+ '<div class="col-12 col-sm-2"><label>-</label ><div class="form-group"><a href="javascript:;" id="' + i + '" class="btn btn-danger removeBtn" name="remove"><i class="fa fa-times"></i></a></div></div></div>');
	});

	$(document).on('click', '.removeBtn', function(){
		var button_id = $(this).attr("id");
		$('#tprow'+button_id+'').remove();
	});

	

	//=================== Sub Topics Add and Remove Fields =============================================//

	$('#subtopicBtn').click(function () {
		i++;
		$('.subtopic_field').append(
			'<div class="row rm-pading" id="tprow' + i + '">'
			+ '<div class="col-12 col-sm-4">'
			+ '<label>Sub Topic</label>'
			+ '<div class="form-group">'
			+ '<input type="file" class="form-control" name="stp_img[]" id="stp_img" accept="image/*" data-parsley-trigger="change" data-parsley-trigger="change" data-parsley-required="false" accept="image/jpg,image/jpeg,image/png,image/PNG,image/Png" data-parsley-fileextension="jpg,png,jpeg" data-parsley-max-file-size="1024">'
			+ '</div>'
			+ '</div>'

			+ '<div class="col-12 col-sm-4">'
			+ '<label> Title</label>'
			+ '<div class="form-group">'
			+ '<input type="text" class="form-control" name="stp_text[]" id="stp_text" required>'
			+ '</div>'
			+ '</div>'

			+ '<div class="col-12 col-sm-1"><label>-</label ><div class="form-group"><a href="javascript:;" id="' + i + '" class="btn btn-danger removeBtn" name="remove"><i class="fa fa-times"></i></a></div></div></div>');

		getMethod($('#topic_list').val(),'mtd_list_'+i)
		$('#mtd_list_'+i).select2();
	});

	$(document).on('click', '.removeBtn', function(){
		var button_id = $(this).attr("id");
		$('#stprow'+button_id+'').remove();
	});


	$(document).on('click', '.removeLBtn', function(){
		v--;
		$("#Exval").val(v);
		var button_id = $(this).attr("id");
		$('#m2row'+button_id+'').remove();
	});

	$(document).on('click', '.removeBtn', function(){
		v--;
		$("#Exval").val(v);
		var button_id = $(this).attr("id");
		$('#learnrow'+button_id+'').remove();
	});

	$(document).on('click', '.removeBtn', function(){
		v--;
		$("#Exval").val(v);
		var button_id = $(this).attr("id");
		$('#learnrow'+button_id+'').remove();
	});

	//  ========================= Que ans Add and Remove =====================================================================//

	$(document).on('click', '#add-que', function (e) {
		e.preventDefault();
		if( $("#i_value").length === 0) {
			i++;
		}else{
			i = $("#i_value").val();
			$("#i_value").val(i+1);
		}
		let cat_id = $('#category').val();
		console.log(cat_id);
		let disable = '';
		let que_hide = '';
		// if(cat_id == 2){
		// 	disable = 'style="display:none"';
		// }
		// if(cat_id == 5 ){
		// 	que_hide = 'style="display:none"';
		// }
		// if(cat_id == 7){
		// 	que_hide = 'style="display:none"';
		// }
		
		var template =
			'<div class="que-ans">'
			+ '<div class="jumbotron">'

			+ '<div id="question">'

			+ '<div class="form-row">'
			+ '<div class="form-group col-3 mb-0 d-none q-audio">'
			+ '<label for="qm2img">Q.Image/Audio</label>'
			+ '</div>'
			+ '<div class="form-group col-3 mb-0">'
			+ '<label for="qm2text">Q.Text</label>'
			+ '</div>'
			+ '<div class="form-group col-3 mb-0 q-touch d-none">'
			+ '<label for="touch-audio">Q.Touch Audio</label>'
			+ '</div>'
			+ '<div class="form-group col-3 mb-0 q-true d-none">'
			+ '<label for="true-audio">Q.True Audio</label>'
			+ '</div>'
			+ '</div>'

			+ '<input type="hidden" value="0" name="ed_id['+ i +']"  class="ed_ids">'
			+ '<input type="hidden" value="' + i + '" name="hidden_value['+ i +']" id="hidden_value1">'

			+ '<div id="question-item-'+i+'">'
			+ '<div class="form-row">'
			+ '<div class="form-group col-3 d-none q-audio">'
			+ '<input type="file" class="form-control que-img" name="qm2files[' + i +'][]" id="qm2img' + i + '" data--disable="qm2text'+i+'">'
			+ '</div>'
			+ '<div class="form-group col-3 ">'
			+ '<input type="text" class="form-control qm2text'+i+'" name="qm2text['+ i +'][]" id="qm2text'+i+'" placeholder="Enter Question">'
			+ '</div>'
			+ '<div class="form-group col-3 q-touch d-none">'
			+ '<input type="file" class="form-control" name="touch_audio['+ i +'][]" id="touch-audio">'
			+ '</div>'
			+ '<div class="form-group col-3 q-true d-none">'
			+ '<input type="file" class="form-control" name="audio['+ i +'][]" id="true-audio">'
			+ '</div>'
			+ '<input type="hidden" name="total_que_item['+ i +'][]" value="'+ i +'">'
			+ '</div>'
			+ '</div>'

			+ '<div id="dynamic-rows-'+i+'"></div>'

			+ '<div class="form-row">'
			+ '<div class="form-group col-12">'
			+ '<button type="button" class="btn btn-primary btn-sm que-btn q-add d-none"  onclick="addNewRow(\'question-item-'+i+'\',\'dynamic-rows-'+i+'\')">Add Q.</button>'
			+ '<button type="button" class="btn btn-danger btn-sm que-btn q-remove d-none"  onclick="removeRow(\'dynamic-rows-'+i+'\',\'form-row\')">Remove Q.</button>'
			+ '</div>'
			+ '</div>'

			+ '</div>'

			+ '<hr '+ que_hide +'>'

			+ '<div class="form-row">'
			+ '<div class="form-group col-3 mb-0 a-audio d-none">'
			+ '<label for="am2img">A.Image/Audio</label>'
			+ '</div>'
			+ '<div class="form-group col-3 mb-0">'
			+ '<label for="am2text">Answer Text</label>'
			+ '</div>'
			+ '<div class="form-group col-3 mb-0 a-touch d-none">'
			+ '<label for="touch-audio">A.Touch Audio</label>'
			+ '</div>'
			+ '<div class="form-group col-3 mb-0 a-true d-none">'
			+ '<label for="touch-audio">A.True Audio</label>'
			+ '</div>'
			+ '</div>'

			+ '<input type="hidden" value="0" name="ed_id['+ i +']"  class="ed_ids">'
			+ '<input type="hidden" value="' + i + '" name="hidden_ans_value['+ i +']">'

			+ '<div id="answer-item-'+i+'">'
			+ '<div class="form-row">'
			+ '<div class="form-group col-3 a-audio d-none">'
			+ '<input type="file" class="form-control ans-img" name="ead_img[' + i +'][]"  data--disable="ead_text'+i+'">'
			+ '</div>'
			+ '<div class="form-group col-3 ">'
			+ '<input type="text" class="form-control ead_text'+i+'" name="ead_text['+ i +'][]" accept="image/*" id="ead_text'+i+'" placeholder="Enter Text Answer">'
			+ '</div>'
			+ '<div class="form-group col-3 a-touch d-none">'
			+ '<input type="file" class="form-control" name="ead_touch_audio['+ i +'][]">'
			+ '</div>'
			+ '<div class="form-group col-3 a-true d-none">'
			+ '<input type="file" class="form-control" name="ead_audio['+ i +'][]">'
			+ '</div>'
			+ '<input type="hidden" name="total_ans_item['+ i +'][]" value="'+ i +'">'
			+ '</div>'
			+ '</div>'

			+ '<div id="dynamic-ans-rows-'+i+'"></div>'

			+ '<div class="form-row">'
			+ '<div class="form-group col-12">'
			+ '<button type="button" class="btn btn-primary btn-sm a-add d-none" onclick="addNewRow(\'answer-item-'+i+'\',\'dynamic-ans-rows-'+i+'\')">Add A.</button>'
			+ '<button type="button" class="btn btn-danger btn-sm a-remove d-none"  onclick="removeRow(\'dynamic-ans-rows-'+i+'\',\'form-row\')">Remove A.</button>'
			+ '</div>'
			+ '</div>'

			+ '</div>'
			+ '</div>';

		var $target = $("#sorting_field");
		$target.append(template);
		// if(cat_id == 7 ){
		// 	$("#add-remove-card-btn").css("display", "none");
		// }

		var lay_id = $("#layout_id").val();
		$.ajax({
			url : base_url+'admin/extra/getLayoutDesign',
			method: 'POST',
			data:{lay_id:lay_id},
			success:function(msg){
				var data = JSON.parse(msg);
				
				setTimeout(() => {
					$(".q-audio").addClass('d-none')
					$(".q-touch").addClass('d-none')
					$(".q-true").addClass('d-none')
					$(".q-add").addClass('d-none')
					$(".q-remove").addClass('d-none')
					var qtype = data[0].question_type.split(',');
					$.each( qtype, function( key, value ) {
						if(value == 'image audio text'){
							$(".q-audio").removeClass('d-none')
						} 
	
						if(value == 'touch'){  
							$(".q-touch").removeClass('d-none')
						} 
	
						if(value == 'true'){ 
							$(".q-true").removeClass('d-none')
						} 
	
						if(value == 'add question'){ 
							$(".q-add").removeClass('d-none')
						} 
	
						if(value == 'remove question'){ 
							$(".q-remove").removeClass('d-none')
						} 
					});
	
					$(".a-audio").addClass('d-none');
					$(".a-touch").addClass('d-none');
					$(".a-true").addClass('d-none');
					$(".a-add").addClass('d-none');
					$(".a-remove").addClass('d-none');
					var atype = data[0].answer_type.split(',');
					$.each( atype, function( key1, value1 ) {
						if(value1 == 'image audio text'){
							$(".a-audio").removeClass('d-none')
						} 
	
						if(value1 == 'touch'){  
							$(".a-touch").removeClass('d-none')
						} 
	
						if(value1 == 'true'){
							$(".a-true").removeClass('d-none')
						}
	
						if(value1 == 'add answer'){
							$(".a-add").removeClass('d-none')
						} 
	
						if(value1 == 'remove answer'){
							$(".a-remove").removeClass('d-none')
						} 
					});
				
				}, 1000);
			},
		});
	});

	//  ==============================================================================================//

	$(document).on('click', '.removeBtn', function(){
		var button_id = $(this).attr("id");
		$('#row'+button_id+'').remove();
	});

	$(document).on('click', '.removeBtn', function(){
		var button_id = $(this).attr("id");
		$('#irow'+button_id+'').remove();
	});

	$(document).on('click', '.removeBtn', function(){
		var button_id = $(this).attr("id");
		$('#ctstrow'+button_id+'').remove();
	});


	//   edit topic get chapter list

	var lang_id = $("#language_id").val();

	var echid = $("#edChid").val();

	var edTpid = $("#edTpid").val();

	var edStpid = $("#edStpid").val();

	var method = $("#method").val();

	var cat_id = $("#category").val();

	var lay_id = $("#lay_id").val();

	var board_id = $("#board_id").val();

	var std_id = $("#estd_id").val();

	var sub_id = $("#esub_id").val();

	var chapter_id = $("#ch_id").val();

	// getLanguage(lang_id);
	
	getBoard(lang_id,board_id);

	getChapter(board_id,std_id,sub_id, echid);

	getEditTopics(echid, edTpid);

	getSubTopics(edTpid,edStpid);

	getEditMethod(edTpid, method, 'mtd_list');

	getLayout(cat_id, lay_id);

	getStandard(board_id,std_id);

	getSubject(std_id,sub_id)

	if(chapter_id){
		getTopics(chapter_id);
	}
	

});

function close(){
	window.close()
}

function getLanguage(lang_id = 0){
	$.ajax({
		url : base_url+'admin/extra/getLanguag',
		method: 'POST',
		data:{ lang_id:lang_id },
		success:function(msg){
			$("#lng_list").html(msg);
		},
	});
}

function getBoard(lang_id,board_id = 0){ 
	$.ajax({
		url : base_url+'admin/extra/getBoard',
		method: 'POST',
		data:{ lang_id:lang_id,board_id:board_id },
		success:function(msg){
			$("#board_list").html(msg);
		},
	});
}

function changeSubject(sub_id){
	let board_id = $("#board_list").val();
	if(board_id == undefined){
	   board_id = $("#board_id").val();
	}
	let std_id = $("#std_list").val();
	getChapter(board_id,std_id,sub_id)
}


function getTopics(chapter_id){
	$.ajax({
		url : base_url+'admin/extra/getTopics',
		method: 'POST',
		data:{ chid:chapter_id },
		success:function(msg){
			$("#topic_list").html(msg);
		},
	});
}

function getChapter(board_id,std_id,sub_id,echid = 0)
{
	if(std_id == undefined){
		std_id = $("#std_list").val();
	}
	if(sub_id == undefined){
		sub_id = $("#sub_list").val();
	}
	
	$.ajax({
		url : base_url+'admin/extra/getChapter',
		method: 'POST',
		data:{board_id:board_id,std_id:std_id,sub_id:sub_id,echid:echid},
		success:function(msg){
			$("#chapter_list").html(msg);
			$("#chapter_list2").html(msg);
		},
	});
}

function getChapter_syllabus(board_id,std_id,sub_id,id)
{
	$.ajax({
		url : base_url+'admin/extra/getChapter',
		method: 'POST',
		data:{board_id:board_id,std_id:std_id,sub_id:sub_id},
		success:function(msg){
			$("#chapter_list_"+id).html(msg);
		},
	});
}

function getLayout(cat_id,lay_id = 0)
{
	// console.log(cat_id);
	// if(cat_id != '') {
	// 	$('#add-que').removeClass('d-none')
	// 	$('#remove-card').removeClass('d-none')
	// 	$('#que-ans').removeClass('d-none')
	// }
	// if(cat_id == 3 || cat_id == 4 ){
	// 	$("#answer").css("display", "none");
	// }else{
	// 	$("#answer").css("display", "");
	// }

	// if(cat_id == 4 ){
	// 	$("#add-remove-card-btn").css("display", "none");
	// }else{
	// 	$("#add-remove-card-btn").css("display", "");
	// }

	// if(cat_id == 2 || cat_id == 7){
	// 	$(".que-btn").css("display", "none");
	// }else{
	// 	$(".que-btn").css("display", "");
	// }

	// if(cat_id == 7){
	// 	$(".ans-btn").css("display", "none");
	// }else{
	// 	$(".ans-btn").css("display", "");
	// }



	$.ajax({
		url : base_url+'admin/extra/getLayout',
		method: 'POST',
		data:{cat_id:cat_id,lay_id:lay_id},
		success:function(msg){
			$("#layout_id").html(msg);
		},
	});
}

function getLayoutDesign(lay_id){ 
	$('#que-ans').removeClass('d-none')
	$.ajax({
		url : base_url+'admin/extra/getLayoutDesign',
		method: 'POST',
		data:{lay_id:lay_id},
		success:function(msg){ 
			var data = JSON.parse(msg);
			setTimeout(() => {
				$(".q-audio").addClass('d-none')
				$(".q-touch").addClass('d-none')
				$(".q-true").addClass('d-none')
				$(".q-add").addClass('d-none')
				$(".q-remove").addClass('d-none')
				
				var qtype = data[0].question_type.split(','); 
				$.each( qtype, function( key, value ) {
					if(value == 'image audio text'){
						$(".q-audio").removeClass('d-none')
					} 

					if(value == 'touch'){  
						$(".q-touch").removeClass('d-none')
					} 

					if(value == 'true'){ 
						$(".q-true").removeClass('d-none')
					} 

					if(value == 'add question'){ 
						$(".q-add").removeClass('d-none')
					} 

					if(value == 'remove question'){ 
						$(".q-remove").removeClass('d-none')
					} 
				});

			
				$(".a-audio").addClass('d-none');
				$(".a-touch").addClass('d-none');
				$(".a-true").addClass('d-none');
				$(".a-add").addClass('d-none');
				$(".a-remove").addClass('d-none');
				var atype = data[0].answer_type.split(',');
				$.each( atype, function( key1, value1 ) {
					if(value1 == 'image audio text'){
						$(".a-audio").removeClass('d-none')
					} 

					if(value1 == 'touch'){  
						$(".a-touch").removeClass('d-none')
					} 

					if(value1 == 'true'){
						$(".a-true").removeClass('d-none')
					}

					if(value1 == 'add answer'){
						$(".a-add").removeClass('d-none')
					} 

					if(value1 == 'remove answer'){
						$(".a-remove").removeClass('d-none')
					} 
				});
			
				$('.add-card').addClass('d-none');
				$('.remove-card').addClass('d-none');
				var extra = data[0].extras.split(',');
				$.each( extra, function( key2, value2 ) {
					if(value2 == 'add card'){ 
						$('.add-card').removeClass('d-none')
					} 

					if(value2 == 'remove card'){
						$('.remove-card').removeClass('d-none')
					} 
				});

				$('.exp').addClass('d-none')
				var explaination = data[0].explaination; 
				if(explaination == 'explanation'){ 
					$('.exp').removeClass('d-none')
				}
			}, 500);
		},
	});
}

function getEditChapter(bssid, chid)
{
	$.ajax({
		url : base_url+'admin/extra/getEditChapter',
		method: 'POST',
		data:{bssid:bssid,chid:chid},
		success:function(msg){
			$("#chapter_list").html(msg);
		},
	});
}

function getTopics(chid)
{
	$.ajax({
		url : base_url+'admin/extra/getTopics',
		method: 'POST',
		data:{chid:chid},
		success:function(msg){
			$("#topic_list").html(msg);$("#topic_list2").html(msg);
		},
	});
}

function getEditTopics(chid, tpid)
{
	$.ajax({
		url : base_url+'admin/extra/getEditTopics',
		method: 'POST',
		data:{chid : chid, tpid : tpid},
		success:function(msg){
			$("#topic_list").html(msg);
		},
	});
}

function getSubTopics(topicid,stpid = 0)
{
	$.ajax({
		url : base_url+'admin/extra/getSubTopics',
		method: 'POST',
		data:{topic_id:topicid,sub_topic_id:stpid},
		success:function(msg){
			$("#subtopic_list").html(msg);$("#subtopic_list2").html(msg);
		},
	});
}

function getStandard(board_id,std_id = 0) 
{ 
	if(board_id !== '') {
		$.ajax({
			url: base_url + 'admin/extra/getStandard',
			method: 'POST',
			data: {board_id: board_id, std_id: std_id},
			success: function (msg) {
				$("#std_list").html(msg);
				$("#std_list1").html(msg);$("#std_list2").html(msg);
			},
		});
	}
}

function getSubject(std_id,sub_id = 0)
{
	if(std_id !== '') {
		$.ajax({
			url: base_url + 'admin/extra/getSubject',
			method: 'POST',
			data: {std_id: std_id, sub_id: sub_id},
			success: function (msg) {
				$("#sub_list").html(msg);
				$("#sub_list1").html(msg);$("#sub_list2").html(msg);
			},
		});
	}
}


function getExample(id) {
	$.ajax({
		url : base_url+'admin/method_mapping/getExample',
		method: 'POST',
		data:{catid:id},
		success:function(msg){
			$("#exp_list").html(msg);
		},
	});
}

function getMethod(id,element) {
	$.ajax({
		url : base_url+'admin/method_mapping/getMethod',
		method: 'POST',
		data:{tpid:id},
		success:function(msg){
			$("#"+element).html(msg);
		},
	});
}

function getEditMethod(id,selected_val,element) {
	$.ajax({
		url : base_url+'admin/extra/getEditMethod',
		method: 'POST',
		data: { tpid:id, selected_val:selected_val },
		success:function(msg){
			$("#"+element).html(msg);
		},
	});
}

function editBSS(id)
{
	var res = confirm('Are you sure? you want to edit');
	if(res)
	{
		$("#Mbssid").val(id);
		$("#bssModal").modal("show");
	}
}

$(document).on('click', '[data--toggle="delete"]', function (e) {
	e.preventDefault();
	let url = $(this).attr('data--url');

	if (url !== undefined) {
		swal({
			title: 'Entire tree will be deleted, Sure?',
			text: "Once deleted, you will not be able to recover this!",
			icon: 'warning',
			buttons: true,
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			console.log(result)
			if (result) {
				window.location.replace(url);
			}
		})
	}
});

$(document).on('click', '[data--toggle="edit"]', function (e) {
	e.preventDefault();
	let url = $(this).attr('data--url');

	if (url !== undefined) {
		swal({
			title: 'Are you sure you want to Edit?',
			icon: 'warning',
			buttons: true,
		}).then((result) => {
			if (result) {
				window.location.replace(url);
			}
		})
	}
});



$(document).on('click', '[data--toggle="languagechange"]', function (e) {
	e.preventDefault();
	let url = $(this).attr('data--url');

	if (url !== undefined) {
		swal({
			title: 'Do you want to change language?',
			icon: 'warning',
			buttons: true,
		}).then((result) => {
			if (result) {
				$('#selectpop').modal('show');
			} else {
				$.ajax({
					url : url,
					method: 'GET',
					success:function(msg){
						// location.reload()
					},
				});
			}
		})
	}
});

$(document).on('click', '[data--toggle="copy"]', function (e) {
	e.preventDefault();
	let url = $(this).attr('data--url');

	if (url !== undefined) {
		swal({
			title: 'Are you sure you want to Duplicate?',
			icon: 'warning',
			buttons: true,
		}).then((result) => {
			if (result) {
				$.ajax({
					url : url,
					method: 'GET',
					success:function(msg){ 
						if($("#subtopics_filter").length > 0){ 
							$("#subtopics_filter").click();
						}
						if($("#topic_filter").length > 0){ 
							$("#topic_filter").click();
						}
					},
				});
			}
		})
	}
});

$(document).on('click', '[data--toggle="delete-ajax"]', function (e) {
	e.preventDefault();
	let url = $(this).attr('data--url');

	if (url !== undefined) {
		swal({
			title: 'Entire tree will be deleted, Sure?',
			text: "Once deleted, you will not be able to recover this!",
			icon: 'warning',
			buttons: true,
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			console.log(result)
			if (result) {
				$.ajax({
					url : url,
					method: 'GET',
					success:function(msg){
						location.reload()
					},
				});
			}
		})
	}
});

$(document).on('click', '.que-item', function (e) {
	e.preventDefault();
	var template = $("#question-item").html();
	var $target = $(".dynamic-rows");
	$target.append(template);
});

$(document).on('click', '.remove-que-item', function (e) {
	e.preventDefault();
	var $target = $(".dynamic-rows");
	$target.find('.form-row').last().remove();
});

$(document).on('click', '.remove-que', function (e) {
	e.preventDefault();
	var $target = $(".sorting_field");
	$target.find('.jumbotron').last().remove();
});

function addNewRow(template,target){
	var temp = $("#"+template).html();
	var $target = $("#"+target);
	$target.append(temp);
	// if(target == 'dynamic-rows-1'){
	// 	$('#dynamic-rows-1').find('.form-row').last().find('#eqd_text').prop('readonly', false)
	// }
	// if(target == 'dynamic-ans-rows-1'){
	// 	$('#dynamic-ans-rows-1').find('.form-row').last().find('#ead_text').prop('readonly', false)
	// }

}

function removeRow(target,template,id = '',type=''){
	var $target = $("#"+target);
	if(id !== ''){
		var url = '';
		var p_id = $target.find('.'+id).last().val();
		switch(type) {
			case 'eqd':
				url = base_url+'admin/example/removeQuestionItem/';
				break;
			case 'ead':
				url = base_url+'admin/example/removeAnswerItem/';
				break;
			case 'ed':
				url = base_url+'admin/example/removeQuestion/';
				break;
			default:
		}
		console.log(p_id);

		$.ajax({
			url : url+p_id,
			method: 'GET',
			success:function(msg){
				console.log('success');
			},
		});

	}
	$target.find('.'+template).last().remove();
}

$('.sortable').sortable({
	placeholder : "ui-state-highlight",
	update : function(event, ui)
	{
		let url = $(this).attr('data--url');
		console.log(url);
		var data = [];
		$('.sortable tr').each(function(){ 
			if($(this).attr('id') != undefined){
			   data.push($(this).attr('id'));
			}
		});

		$.ajax({
			url:url,
			method:"POST",
			data:{ data:data },
			success:function()
			{
				console.log('done')
			}
		})
	}
});

$('.sortable-collapse').sortable({
	placeholder : "ui-state-highlight",
	update : function(event, ui)
	{
		let url = $(this).attr('data--url');
		var data = [];
		$('.sortable-collapse .accordion').each(function(){
			if($(this).attr('id') != undefined){
			   data.push($(this).attr('id'));
			}
		});

		$.ajax({
			url:url,
			method:"POST",
			data:{ data:data },
			success:function()
			{
				console.log('done')
			}
		})
	}
});

$(function() {

	var pageURL = $(location).attr("href");
	var last_part = pageURL.substr(pageURL.lastIndexOf('/') + 1); 

	if(last_part == 'syllabus'){ 
		setTimeout(function(){
			$("#syllabus_filter").click(); 
		},3000);
	}

	$("#exampleForm").on('submit', function(e) {
		e.preventDefault();
		$("#save-btn").attr("disabled", true);
		$("#save-btn").text('Saving...');
		var contactForm = $(this);

		$.ajax({
			url: contactForm.attr('action'),
			enctype: 'multipart/form-data',
			type: 'post',
			data : new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			dataType: "json",
			success: function(response){
				if(response.status === 'success') {
					$("#save-btn").attr("disabled", false);
					$("#save-btn").html('<i class="fa fa-file"></i> Save');
					swal({
						title: 'Success!',
						icon: 'success',
						text: response.message,
						timer: 2000,
					});
					$('#sorting_field').find('.que-ans').remove();
					$('#dynamic-rows-1').find('.form-row').remove();
					$('#dynamic-ans-rows-1').find('.form-row').remove();
					$('#eqd_img').val('');
					$('#eqd_text').val('');
					$('#eqd_touch_audio').val('');
					$('#eqd_audio').val('');
					$('#ead_img').val('');
					$('#ead_text').val('');
					$('#ead_audio').val('');
					$('#ead_touch_audio').val('');
					getExampleData(response.stp_id)

				}else{
					$("#save-btn").attr("disabled", false);
					$("#save-btn").html('<i class="fa fa-file"></i> Save');
					swal({
						title: 'Error!',
						icon: 'error',
						text: response.message,
						timer: 2000,
					});
				}

				if($('#category').val() == 7 ){
					$("#add-remove-card-btn").css("display", "block");
				}
			}
		});
	});
});

function getExampleData($id)
{
	if ( $.fn.DataTable.isDataTable( '#item-list' ) ) {
		$('#item-list').DataTable().destroy();
	}
	$('#item-list').DataTable({
		"paging": false,
		"ordering": false,
		"info":false,
		"search":false,
		"ajax": {
			url: base_url + 'admin/example/getData/'+$id,
			type: 'GET'
		},
	});
	$('#panel-body-1').addClass('show');
}

function removeAudio(className,id,field){
	$("."+className).remove();
	
	$("#"+field).val(id);
}

$(".langSubmit").on('submit', function(e) {
	e.preventDefault();

	$.ajax({
		url : base_url+'admin/extra/setLanguage',
		type: 'post',
		data : new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		dataType: "json",
		success: function(response) {
			if (response.status === 'success') {
				$('#languageModal').modal('hide');
				swal({
					title: 'Success!',
					icon: 'success',
					text: 'language set successfully',
					timer: 2000,
				});
			}
		}
	})
})

$(function() {
	//If check_all checked then check all table rows
	$("#check_all").on("click", function () {
		if ($("input:checkbox").prop("checked")) {
			$("input:checkbox[name='row-check']").prop("checked", true);
		} else {
			$("input:checkbox[name='row-check']").prop("checked", false);
		}
	});

	// Check each table row checkbox
	$("input:checkbox[name='row-check']").on("change", function () {
		var total_check_boxes = $("input:checkbox[name='row-check']").length;
		var total_checked_boxes = $("input:checkbox[name='row-check']:checked").length;

		// If all checked manually then check check_all checkbox
		if (total_check_boxes === total_checked_boxes) {
			$("#check_all").prop("checked", true);
		}
		else {
			$("#check_all").prop("checked", false);
		}
	});

	$(document).on('click', '[data--toggle="delete_selected"]', function (e) {
		e.preventDefault();

		var ids = '';
		var comma = '';
		$("input:checkbox[name='row-check']:checked").each(function() {
			ids = ids + comma + this.value;
			comma = ',';
		});

		if(ids.length > 0) {
			swal({
				title: 'Entire tree will be deleted of all selected records, Sure?',
				text:  "Once deleted, you will not be able to recover this!",
				icon: 'warning',
				buttons: true,
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				let url = $(this).attr('data--url');

				$.ajax({
					type: "POST",
					url: url,
					data: {'ids': ids},
					dataType: "html",
					cache: false,
					success: function(msg) {
						swal({
							title: 'Success!',
							icon: 'success',
							text: "All Records Deleted Successfully",
							timer: 3000,
						});
						location.reload()
					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.log(errorThrown)
					}
				});
			});
		} else {
			$("#msg").html('<span style="color:red;">You must select at least one product for deletion</span>');
		}
	});
});

$("#example_filter").click(function(){

	let board_id = $('#board_id').val();
	let std_id = $('#std_list').val();
	let sub_id = $('#sub_list').val();
	let chapter_id = $('#chapter_list').val();
	let topic_id = $("#topic_list").val();
	$.ajax({
		url: base_url + 'admin/example/index_api',
		method: 'POST',
		data:{ board_id:board_id, std_id:std_id, sub_id:sub_id, chapter_id:chapter_id, topic_id:topic_id },
		success:function(msg){
			$("#table").html(msg);
		},
	});
	if ( $.fn.DataTable.isDataTable( '#item-list' ) ) {
		$('#item-list').DataTable().destroy();
	}

});

$("#subtopics_filter").click(function(){
	let board_id = $('#board_id').val();
	let std_id = $('#std_list').val();
	let sub_id = $('#sub_list').val();
	let chapter_id = $('#chapter_list').val();
	let topic_id = $("#topic_list").val();
	$.ajax({
		url: base_url + 'admin/subtopic/index_api',
		method: 'POST',
		data:{ board_id:board_id, std_id:std_id, sub_id:sub_id, chapter_id:chapter_id, topic_id:topic_id },
		success:function(msg){
			$("#table").html(msg);
		},
	});
	if ( $.fn.DataTable.isDataTable( '#item-list' ) ) {
		$('#item-list').DataTable().destroy();
	}
});

$("#syllabus_filter").click(function(){
	let board_id = $('#board_id').val();
	let std_id = $('#std_list').val();
	let sub_id = $('#sub_list').val();
	let chapter_id = $('#chapter_list').val();
	let topic_id = $("#topic_list").val();
	let subtopic_id = $("#subtopic_list").val();
	$.ajax({
		url: base_url + 'admin/syllabus/index_api',
		method: 'POST',
		data:{ board_id:board_id, std_id:std_id, sub_id:sub_id, chapter_id:chapter_id, topic_id:topic_id,subtopic_id:subtopic_id },
		success:function(msg){
			msg = JSON.parse(msg);
			$("#table").html(msg.tabledata);
			$(".noex").html(msg.no);
			$(".noexample").css('display','block');
		},
	});
	if ( $.fn.DataTable.isDataTable( '#item-list' ) ) {
		$('#item-list').DataTable().destroy();
	}
});

$("#subject_filter").click(function(){
	let std_id = $('#std_list1').val();
	let board_id = $('#board_id').val();
	$.ajax({
		url: base_url + 'admin/subject/index_api',
		method: 'POST',
		data:{ board_id:board_id,std_id:std_id },
		success:function(msg){
			msg = JSON.parse(msg);
			$("#table").html(msg);
		},
	});
	if ( $.fn.DataTable.isDataTable( '#item-list' ) ) {
		$('#item-list').DataTable().destroy();
	}
});

$("#chapter_filter").click(function(){
	let std_id = $('#std_list1').val();
	let sub_id = $("#sub_list1").val();
	let board_id = $('#board_id').val();
	$.ajax({
		url: base_url + 'admin/chapter/index_api',
		method: 'POST',
		data:{ board_id:board_id,std_id:std_id,sub_id:sub_id },
		success:function(msg){
			msg = JSON.parse(msg);
			$("#table").html(msg);
		},
	});
	if ( $.fn.DataTable.isDataTable( '#item-list' ) ) {
		$('#item-list').DataTable().destroy();
	}
});

$("#topic_filter").click(function(){
	let std_id = $('#std_list').val();
	let sub_id = $("#sub_list").val();
	let board_id = $('#board_id').val();
	let ch_id = $("#chapter_list").val();
	$.ajax({
		url: base_url + 'admin/topic/index_api',
		method: 'POST',
		data:{ board_id:board_id,std_id:std_id,sub_id:sub_id,ch_id:ch_id},
		success:function(msg){
			msg = JSON.parse(msg);
			$("#table").html(msg);
		},
	});
	if ( $.fn.DataTable.isDataTable( '#item-list' ) ) {
		$('#item-list').DataTable().destroy();
	}
});

// $(".que-img").change(function(){
// 	 let id = $(this).attr('data--disable')
// 	if($(this).val() != ''){
// 	 	$('.'+id).prop('readonly', true);
// 	}else{
// 		$('.'+id).prop('readonly', false);
// 	}
// });
//
// $(".ans-img").change(function(){
// 	let id = $(this).attr('data--disable')
// 	if($(this).val() != ''){
// 		$('.'+id).prop('readonly', true);
// 	}else{
// 		$('.'+id).prop('readonly', false);
// 	}
// });


function get_plan_type(val){
	$.ajax({
		url: base_url + 'admin/subscription_plans/get_plan_type',
		method: 'POST',
		data:{ user_type:val },
		success:function(result){
			$('#plan_type').find('option').not(':first').remove();
			var data = JSON.parse(result); 
			$.each(data,function(index,d){
				$('#plan_type').append('<option value="'+d.plan_type_id+'">'+d.type_name+'</option>');
			 });
		},
	});	
}


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


